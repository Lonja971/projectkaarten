<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSprintRequest;
use App\Http\Requests\UpdateSprintRequest;
use App\Http\Resources\SprintResource;
use App\Models\ApiKey;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\User;

class SprintController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sprint = Sprint::with(['status'])->find($id);
        if (!$sprint){
            return ApiResponse::notFound();
        }
        return ApiResponse::successWithoutMessage(
            new SprintResource($sprint)
        );
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(StoreSprintRequest $request)
    {

        $data = $request->validated();

        $current_user_id = ApiKey::getUserId($data['api_key']);

        if (!$current_user_id) {
            return ApiResponse::accessDenied();
        }

        $is_teacher = User::isTeacher($current_user_id);
        $project_owner_id = Project::getUserIdByProjectId($data['project_id']);

        if (!$is_teacher && $project_owner_id != $current_user_id){
            return ApiResponse::accessDenied();
        }

        if (Sprint::isDateAvailableForProject($data['project_id'], $data['date_start'], $data['date_end'])) {
            return ApiResponse::errorWithMessage(
                'This date range overlaps with an existing sprint.',
                null,
                422
            );
        }
        
        //---Set-data-for-project---
        $data['sprint_nr'] = Sprint::getNewSprintNr($data['project_id']);
        unset($data['api_key']);

        $new_sprint = Sprint::create($data);

        return ApiResponse::successWithMessage(
            'Sprint has been successfully created',
            new SprintResource($new_sprint)
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
        $sprint = Sprint::find($id);

        if (!$data){
            return ApiResponse::noDataToUpdate();
        }

        if (!$sprint){
            return ApiResponse::notFound();
        }

        $current_user_id = ApiKey::getUserId($data['api_key']);

        if (!User::isTeacher($current_user_id)){
            //---is-owner---
            if (Project::getUserIdByProjectId($sprint->project_id) != $current_user_id){
                return ApiResponse::accessDenied();
            }

            $data = array_diff_key($data, array_flip($teacher_fields));
        }
        unset($data['api_key']);
        
        $unchanged = true;
        foreach ($data as $key => $value) {
            if ($sprint->$key !== $value) {
                $unchanged = false;
                break;
            }
        }

        if ($unchanged) {
            return ApiResponse::noChangesDetected();
        }

        $sprint->update($data);

        return ApiResponse::successWithMessage(
            'Sprint updated successfully',
            new SprintResource($sprint)
        );
    }
}
