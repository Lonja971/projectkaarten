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
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sprint = Sprint::with(['status'])->find($id);
        if (!$sprint) {
            return ApiResponse::notFound();
        }
        $sprint['goals'] = SprintGoalAndRetrospective::with('workprocesses')
            ->where('sprint_id', $sprint->id)
            ->get();
        return ApiResponse::successWithoutMessage(
            new SprintWithGoalsResource($sprint)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSprintRequest $request)
    {
        $api_key = $request['api_key'];
        $data = $request->validated();

        $current_user_id = ApiKey::getUserId($api_key);

        if (!$current_user_id) {
            return ApiResponse::accessDenied();
        }

        $is_teacher = User::isTeacher($current_user_id);
        $project_owner_id = Project::getUserIdByProjectId($data['project_id']);

        if (!$is_teacher && $project_owner_id != $current_user_id) {
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
     * Update the specified resource in storage.
     */
    public function update(UpdateSprintRequest $request, string $id)
    {
        $teacher_fields = [
            'feedback',
        ];
        $api_key = $request['api_key'];
        $data = $request->validated();
        $has_data =
            !empty($data['sprint']) ||
            !empty($data['goals']['create']) ||
            !empty($data['goals']['update']) ||
            !empty($data['goals']['delete']) ||
            !empty($data['workprocesses']['create']) ||
            !empty($data['workprocesses']['delete']);

        $sprint = Sprint::find($id);

        $current_user_id = ApiKey::getUserId($api_key);

        if (!$current_user_id) {
            return ApiResponse::accessDenied();
        }
        if (!$sprint) {
            return ApiResponse::notFound();
        }
        if (!$has_data) {
            return ApiResponse::noDataToUpdate();
        }

        if (!User::isTeacher($current_user_id)) {
            //---is-owner---
            if (Project::getUserIdByProjectId($sprint->project_id) != $current_user_id) {
                return ApiResponse::accessDenied();
            }
            if (!empty($data['sprint'])) {
                $data['sprint'] = array_diff_key($data['sprint'], array_flip($teacher_fields));
            }
        }

        $unchanged = true;

        //---Update-Sprint-info---
        if (!empty($data['sprint'])) {
            foreach ($data['sprint'] as $key => $value) {
                if ($sprint->$key !== $value) {
                    $unchanged = false;
                    break;
                }
            }
        }

        //---Update-sprint-goals-info---
        if (!empty($data['goals'])) {
            if (isset($data['goals']['update']) && !empty($data['goals']['update'])) {
                foreach ($data['goals']['update'] as $goal_id => $goal_data) {
                    $goal = SprintGoalAndRetrospective::find($goal_id);

                    if (!$goal || $id != $goal->sprint_id) {
                        continue;
                    }

                    $goal->fill($goal_data);
                    if ($goal->isDirty) {
                        $goal->update($goal_data);
                        $unchanged = false;
                    }
                }
            }
            if (isset($data['goals']['delete']) && !empty($data['goals']['delete'])) {
                foreach ($data['goals']['delete'] as $goal_id) {
                    $goal = SprintGoalAndRetrospective::find($goal_id);
                    if (!$goal || $id != $goal->sprint_id) {
                        continue;
                    }
                    $goal->delete($goal_id);
                    $unchanged = false;
                }
            }
            if (isset($data['goals']['create']) && !empty($data['goals']['create'])) {
                foreach ($data['goals']['create'] as $goal_data) {
                    $goal_data['sprint_id'] = $id;
                    SprintGoalAndRetrospective::create($goal_data);
                    $unchanged = false;
                }
            }
        }

        //---Update-sprint-workprocesses-info---
        if (!empty($data['workprocesses'])) {
            if (isset($data['workprocesses']['delete']) && !empty($data['workprocesses']['delete'])) {
                foreach ($data['workprocesses']['delete'] as $sprint_workprocess_id) {
                    $sprint_workprocess = SprintWorkprocess::find($sprint_workprocess_id);
                    if (!$sprint_workprocess) {
                        continue;
                    }
                    $sprint_id = SprintGoalAndRetrospective::where('id', $sprint_workprocess->sprint_goal_id)->pluck('sprint_id')->first();
                    if ($sprint_id != $id) {
                        continue;
                    }
                    $sprint_workprocess->delete();
                    $unchanged = false;
                }
            }
            if (isset($data['workprocesses']['create']) && !empty($data['workprocesses']['create'])) {
                foreach ($data['workprocesses']['create'] as $sprint_workprocess_data) {
                    $sprint_id = SprintGoalAndRetrospective::where('id', $sprint_workprocess_data['sprint_goal_id'])->pluck('sprint_id')->first();
                    $is_workprocess = Workprocess::where('id', $sprint_workprocess_data['workprocess_id'])->exists();

                    if ($sprint_id != $id || !$is_workprocess) {
                        continue;
                    }
                    $exists = SprintWorkprocess::where('sprint_goal_id', $sprint_workprocess_data['sprint_goal_id'])
                        ->where('workprocess_id', $sprint_workprocess_data['workprocess_id'])
                        ->exists();

                    if ($exists) {
                        continue;
                    }

                    $sprint_workprocess = SprintWorkprocess::create($sprint_workprocess_data);
                    $unchanged = false;
                }
            }
        }

        if ($unchanged) {
            return ApiResponse::noChangesDetected();
        }

        if (!empty($data['sprint'])){
            $sprint->update($data['sprint']);
        }
        $sprint['goals'] = SprintGoalAndRetrospective::with('workprocesses')
            ->where('sprint_id', $sprint->id)
            ->get();

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

        if (!$sprint) {
            return ApiResponse::notFound();
        }

        $current_user_id = ApiKey::getUserId($request->api_key);
        $is_teacher = User::isTeacher($current_user_id);
        $projects_user_id = Project::where('id', $sprint->project_id)->pluck('user_id')->first();

        if ($projects_user_id != $current_user_id && !$is_teacher) {
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
