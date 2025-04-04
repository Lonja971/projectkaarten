<?php

namespace App\Http\Controllers\Api;

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
            return response()->json([
                'error' => 'Sprint Not Found'
            ], 404);
        }
        return response()->json([
            'data' => new SprintResource($sprint)
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSprintRequest $request, string $id)
    {
        $data = $request->validated();
        $sprint = Sprint::find($id);

        if (!$data){
            return response()->json(['error' => 'There is no data to update.'], 400);
        }

        if (!$sprint){
            return response()->json(['error' => 'Sprint with this ID does not exist'], 404);
        }

        $current_user_id = ApiKey::getUserId($data['api_key']);

        if (!User::isTeacher($current_user_id)){
            //---is-owner---
            if (Project::getUserIdByProjectId($sprint->project_id) != $current_user_id){
                return response()->json(['error' => 'Access is denied'], 403);
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
            return response()->json(['error' => 'No changes detected'], 200);
        }

        $sprint->update($data);

        return response()->json([
            'message' => 'Sprint updated successfully',
            'data' => new SprintResource($sprint)
        ], 200);
    }
}
