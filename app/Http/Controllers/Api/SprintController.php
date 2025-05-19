<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\ProjectIdRequest;
use App\Http\Requests\Sprints\StoreSprintRequest;
use App\Http\Requests\Sprints\UpdateSprintRequest;
use App\Http\Resources\SprintResource;
use App\Http\Resources\SprintWithGoalsResource;
use App\Models\ApiKey;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\SprintGoalAndRetrospective;
use App\Models\SprintWorkprocess;
use App\Models\User;
use App\Models\Workprocess;
use App\Services\Sprint\SprintGoalService;
use App\Services\Sprint\SprintService;
use App\Services\Sprint\SprintWorkprocessService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SprintController extends Controller
{
    protected SprintService $sprintService;
    protected SprintGoalService $goalService;
    protected SprintWorkprocessService $workprocessService;

    public function __construct(
        SprintService $sprintService,
        SprintGoalService $goalService,
        SprintWorkprocessService $workprocessService
    ) {
        $this->sprintService = $sprintService;
        $this->goalService = $goalService;
        $this->workprocessService = $workprocessService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Sprint::query()->orderBy('id', 'asc')->paginate(env('PAGINATION_LIMIT'))
        ]);
    }

    /**
     * Show the list of project sprints
     */
    public function byProject(ProjectIdRequest $request)
    {
        $api_key = $request['api_key'];
        $data = $request->validated();
        $current_user_id = ApiKey::getUserId($api_key);
        $is_teacher = User::isTeacher($current_user_id);
        $is_owner = Project::getUserIdByProjectId($data['project_id']) == $current_user_id;

        if (!$is_teacher && !$is_owner) return ApiResponse::accessDenied();
    
        $sprints = Sprint::where('project_id', $data['project_id'])
            ->orderBy('id', 'asc')
            ->paginate(env('PAGINATION_LIMIT'));
    
        return response()->json(['data' => $sprints]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSprintRequest $request)
    {
        $api_key = $request['api_key'];
        $data = $request->validated();

        $current_user_id = ApiKey::getUserId($api_key);

        if (!$current_user_id) return ApiResponse::accessDenied();
        
        if (!Project::userHasAccess($current_user_id, $data['project_id'])){
            return ApiResponse::accessDenied();
        }

        if (Sprint::isDateAvailableForProject($data['project_id'], $data['date_start'], $data['date_end'])) {
            return ApiResponse::errorWithMessage(
                'This date range overlaps with an existing sprint.',
                null,
                422
            );
        }

        //---Set-data-for-sprint---
        $data['sprint_nr'] = Sprint::getLastSprintNumberForProject($data['project_id']) + 1;

        $new_sprint = Sprint::create($data);

        //---Set-all-goals-and-workprocesses---
        if (isset($data['goals']) && !empty($data['goals'])) {
            $created_goals = $this->goalService->createGoalsWithWorkprocesses($new_sprint, $data['goals']);
            $new_sprint['goals'] = $created_goals;
        }
        $resource = !empty($new_sprint->goals)
            ? new SprintWithGoalsResource($new_sprint)
            : new SprintResource($new_sprint);

        return ApiResponse::successWithMessage(
            'Sprint has been successfully created',
            $resource
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sprint = Sprint::with(['status'])->find($id);

        if (!$sprint) return ApiResponse::notFound();

        $sprint['goals'] = SprintGoalAndRetrospective::with('workprocesses')
            ->where('sprint_id', $sprint->id)
            ->get();

        return ApiResponse::successWithoutMessage(
            new SprintWithGoalsResource($sprint)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSprintRequest $request, string $id)
    {
        $teacher_fields = [
            'feedback',
        ];
        $sprint_fields = [
            'reflection',
            'feedback',
        ];
        $api_key = $request['api_key'];
        $data = $request->validated();
        $user_id = ApiKey::getUserId($api_key);
        $sprint = Sprint::find($id);
    
        if (!$user_id) return ApiResponse::accessDenied();
        if (!$sprint) return ApiResponse::notFound();
        if (!Project::userHasAccess($user_id, $sprint->project_id)) return ApiResponse::accessDenied();
    
        if (
            empty($data['reflection']) &&
            empty($data['feedback']) &&
            empty($data['goals']['create']) &&
            empty($data['goals']['update']) &&
            empty($data['goals']['delete'])
        ) {
            return ApiResponse::noDataToUpdate();
        }
        
        if (!User::isTeacher($user_id)) {
            $data = array_diff_key($data ?? [], array_flip($teacher_fields));
        }
        $sprint_data = Arr::only($data, $sprint_fields);
        $has_changes = false;

        if (!empty($sprint_data)) {
            if ($this->sprintService->updateSprintInfo($sprint, $sprint_data)) {
                $has_changes = true;
            }
        }
    
        if (!empty($data['goals'])) {
            if ($this->goalService->handle($sprint, $data['goals'])) {
                $has_changes = true;
            }
        }
    
        if (!$has_changes) {
            return ApiResponse::noChangesDetected();
        }
    
        $sprint['goals'] = SprintGoalAndRetrospective::with('workprocesses')->where('sprint_id', $sprint->id)->get();
    
        return ApiResponse::successWithMessage(
            'Sprint updated successfully',
            new SprintWithGoalsResource($sprint)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $sprint = Sprint::find($id);

        if (!$sprint) return ApiResponse::notFound();

        $current_user_id = ApiKey::getUserId($request->api_key);
        
        if (!Project::userHasAccess($current_user_id, $sprint->project_id)){
            return ApiResponse::accessDenied();
        }
        
        $sprint->delete($id);

        return ApiResponse::successWithMessage(
            'Sprint successfully deleted'
        );
    }
}
