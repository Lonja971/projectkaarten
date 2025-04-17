<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\ApiKey;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Project::query()->orderBy('id', 'asc')->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $current_user_id = ApiKey::getUserId($data['api_key']);

        if (!$current_user_id) {
            return ApiResponse::accessDenied();
        }
        $data['user_id'] = $current_user_id;
        unset($data['api_key']);
        
        //---Set-data-for-project---
        $data['project_by_student'] = User::incrementProjectIndex($current_user_id);
        $data['date_start'] = now();

        $new_project = Project::create($data);

        return ApiResponse::successWithMessage(
            'Project has been successfully created',
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
            'raiting',
            'feedback',
            'denial_reason',
            'status_id',
        ];
        $data = $request->validated();
        $project = Project::find($id);
        $current_user_id = ApiKey::getUserId($data['api_key']);
        $isTeacher = User::isTeacher($current_user_id);
        $isOwner = Project::getUserIdByProjectId($project->id) == $current_user_id;
        
        if (!$isTeacher && !$isOwner) {
            return ApiResponse::accessDenied();
        }
        
        if (!$isTeacher) {
            $data = array_diff_key($data, array_flip($teacher_fields));
        }

        if (!$project) {
            return ApiResponse::notFound();
        }

        if (empty($data)) {
            return ApiResponse::noDataToUpdate();
        }
        unset($data['api_key']);

        $unchanged = true;
        foreach ($data as $key => $value) {
            if ($project->$key !== $value) {
                $unchanged = false;
                break;
            }
        }

        if ($unchanged) {
            return ApiResponse::noChangesDetected();
        }

        $project->update($data);

        return ApiResponse::successWithMessage(
            'Project updated successfully',
            new ProjectResource($project)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return ApiResponse::notFound();
        }
        $project->delete($id);

        return ApiResponse::successWithMessage(
            'Project successfully deleted'
        );
    }
}
