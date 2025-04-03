<?php

namespace App\Http\Controllers\Api;

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
            ProjectResource::collection(Project::query()->orderBy('id', 'desc')->paginate(10))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $current_user_id = ApiKey::getUserId($data['api_key']);
        if ($current_user_id){
            $data['user_id'] = $current_user_id;
            unset($data['api_key']);
        }
        $data['status_id'] = env('DEFAULT_PROJECT_STATUS_ID');
        $data['project_by_student'] = User::incrementProjectIndex($current_user_id);
        $data['date_start'] = now();

        $new_project = Project::create($data);

        Sprint::setSprintsForProject($new_project->id, $new_project->date_start, $new_project->date_end);
        
        return response()->json([
            'data' => new ProjectResource($new_project)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => new ProjectResource(Project::with(['sprints.status', 'status'])->find($id))
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $data = $request->validated();
    
        $project = Project::find($id);
    
        if (!$project) {
            return response()->json(['error' => 'Project with this ID does not exist'], 404);
        }
    
        if (empty($data)) {
            return response()->json(['error' => 'There is no data to update.'], 400);
        }
    
        $unchanged = true;
        foreach ($data as $key => $value) {
            if ($project->$key !== $value) {
                $unchanged = false;
                break;
            }
        }
    
        if ($unchanged) {
            return response()->json(['error' => 'No changes detected'], 200);
        }
    
        $project->update($data);
    
        return response()->json([
            'message' => 'User updated successfully',
            'data' => new ProjectResource($project)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        if (!$project){
            return response()->json([
                'error' => 'Project with this id does not exist'
            ], 404);
        }
        $project->delete($id);

        return response()->json([
            'data' => true
        ]);
    }
}
