<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSprintRequest;
use App\Http\Requests\UpdateSprintRequest;
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

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Sprint::query()->orderBy('id', 'asc')->paginate(10)
        ]);
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
            $created_goals = [];

            foreach ($data['goals'] as $goal) {
                $goal['sprint_id'] = $new_sprint->id;
                $created_goal = SprintGoalAndRetrospective::create($goal);

                if (isset($goal['workprocess_ids']) && !empty($goal['workprocess_ids'])) {
                    $goal['workprocess_ids'] = array_unique($goal['workprocess_ids']);
                    $all_workprocesses = [];

                    foreach ($goal['workprocess_ids'] as $workprocess_id) {
                        $is_workprocess = Workprocess::where('id', $workprocess_id)->exists();
                        if (!$is_workprocess) {
                            continue;
                        }
                        $workprocess['sprint_goal_id'] = $created_goal->id;
                        $workprocess['workprocess_id'] = $workprocess_id;
                        $all_workprocesses[] = SprintWorkprocess::create($workprocess);
                    }
                }
                $created_goal['workprocesses'] = $all_workprocesses;
                $created_goals[] = $created_goal;
            }
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
        $data = $request->validated();
        $api_key = $request['api_key'];
        $user_id = ApiKey::getUserId($api_key);
        $sprint = Sprint::find($id);
    
        if (!$user_id) return ApiResponse::accessDenied();
        if (!$sprint) return ApiResponse::notFound();
    
        $sprintService = app(SprintService::class);
        $goalService = app(SprintGoalService::class);
        $wpService = app(SprintWorkprocessService::class);
    
        if (!Project::userHasAccess($user_id, $sprint->project_id)) {
            return ApiResponse::accessDenied();
        }
    
        if (
            empty($data['sprint']) &&
            empty($data['goals']['create']) &&
            empty($data['goals']['update']) &&
            empty($data['goals']['delete']) &&
            empty($data['workprocesses']['create']) &&
            empty($data['workprocesses']['delete'])
        ) {
            return ApiResponse::noDataToUpdate();
        }
        
        if (!User::isTeacher($user_id)) {
            $data['sprint'] = array_diff_key($data['sprint'] ?? [], array_flip($teacher_fields));
        }
    
        $unchanged = true;
        if (!empty($data['sprint'])) {
            $unchanged = !$sprintService->updateSprintInfo($sprint, $data['sprint']);
        }
    
        if (!empty($data['goals'])) {
            if ($goalService->updateGoals($sprint, $data['goals'])) {
                $unchanged = false;
            }
        }
    
        if (!empty($data['workprocesses'])) {
            if ($wpService->handle($sprint, $data['workprocesses'])) {
                $unchanged = false;
            }
        }
    
        if ($unchanged) {
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

        foreach ($sprint->goals as $goal) {
            $goal->workprocesses()->delete();
            $goal->delete();
        }
        $sprint->delete($id);

        return ApiResponse::successWithMessage(
            'Sprint successfully deleted'
        );
    }
}
