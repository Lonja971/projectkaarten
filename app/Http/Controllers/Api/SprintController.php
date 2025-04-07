<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
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
     * Update the specified resource in storage.
     */
    public function update(UpdateSprintRequest $request, string $id)
    {
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

            unset($data['feedback']);
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
