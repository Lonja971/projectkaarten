<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Http\Requests\Users\UserIdRequest;
use App\Http\Resources\ProjectResource;
use App\Models\ApiKey;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Project::query()
                ->orderBy('id', 'asc')
                ->paginate(env('PAGINATION_LIMIT'))
        ]);
    }

    /**
     * Show the list of user projects
     */
    public function byUser(Request $request)
    {
        $api_key = $request['api_key'];
        $current_user_id = ApiKey::getUserId($api_key);
        $is_teacher = User::isTeacher($current_user_id);
        $user_id = $is_teacher ? $request->input('user_id') : $current_user_id;

        if ($is_teacher && !$user_id) {
            return ApiResponse::notFound();
        }

        $projects = Project::where('user_id', $user_id)
            ->orderBy('id', 'asc')
            ->paginate(env('PAGINATION_LIMIT'));

        return response()->json(['data' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $api_key = $request['api_key'];
        $data = $request->validated();

        $current_user_id = ApiKey::getUserId($api_key);

        if (!$current_user_id) {
            return ApiResponse::accessDenied();
        }

        //---Set-data-for-project---
        $is_teacher = User::isTeacher($current_user_id);
        if ($is_teacher && empty($data['user_id']) || !$is_teacher) {
            $data['user_id'] = $current_user_id;
        }
        $data['project_by_student'] = User::incrementProjectIndex($data['user_id']);
        $data['date_start'] = now();


        $new_project = Project::create($data);

        return ApiResponse::successWithMessage(
            'Project is succesvol aangemaakt',
            new ProjectResource($new_project)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with(['sprints.status', 'status'])->find($id);

        if (!$project) {
            return ApiResponse::notFound();
        }
        return ApiResponse::successWithoutMessage(
            new ProjectResource($project)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $teacher_fields = [
            'reflection',
            'rating',
            'feedback',
            'denial_reason',
            'status_id',
        ];
        $api_key = $request['api_key'];
        $data = $request->validated();
        $project = Project::find($id);
        $current_user_id = ApiKey::getUserId($api_key);
        $is_teacher = User::isTeacher($current_user_id);
        $is_owner = Project::getUserIdByProjectId($project->id) == $current_user_id;

        if (!$is_teacher && !$is_owner) return ApiResponse::accessDenied();
        if (!$project) return ApiResponse::notFound();

        if (!$is_teacher) {
            $data = array_diff_key($data, array_flip($teacher_fields));
        }

        if (empty($data)) {
            return ApiResponse::noDataToUpdate();
        }

        $unchanged = true;
        foreach ($data as $key => $value) {
            if ($project->$key !== $value) {
                $unchanged = false;
                break;
            }
        }

        if ($unchanged) return ApiResponse::noChangesDetected();

        $project->update($data);

        return ApiResponse::successWithMessage(
            'Project succesvol bijgewerkt',
            new ProjectResource($project)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $current_user_id = ApiKey::getUserId($request->api_key);
        $is_teacher = User::isTeacher($current_user_id);
        $project = Project::find($id);

        if (!$project) {
            return ApiResponse::notFound();
        }
        if ($project->user_id != $current_user_id && !$is_teacher) {
            return ApiResponse::accessDenied();
        }

        $project->delete($id);

        return ApiResponse::successWithMessage(
            'Project succesvol verwijderd'
        );
    }
}
