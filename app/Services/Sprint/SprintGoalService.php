<?php

namespace App\Services\Sprint;

use App\Models\Sprint;
use App\Models\SprintGoalAndRetrospective;
use Illuminate\Support\Arr;

class SprintGoalService
{
    protected SprintWorkprocessService $workprocessService;

    public function __construct(SprintWorkprocessService $workprocessService)
    {
        $this->workprocessService = $workprocessService;
    }

    /**
     * Create sprint goals and attach related workprocesses.
     *
     * This method creates new SprintGoalAndRetrospective entries for the given sprint,
     * and optionally links each goal with one or more workprocesses.
     *
     * @param Sprint $sprint The sprint to which the goals belong.
     * @param array $goals_data An array of goal data, each containing goal info and optional workprocess IDs.
     * @return array List of created goals with attached workprocesses.
     */
    public function createGoalsWithWorkprocesses(Sprint $sprint, array $goals_data): array
    {
        $created_goals = [];

        foreach ($goals_data as $goal) {
            $goal['sprint_id'] = $sprint->id;
            $created_goal = SprintGoalAndRetrospective::create($goal);

            $workprocesses = [];

            if (!empty($goal['workprocess_ids'])) {
                $workprocesses = $this->workprocessService->attachWorkprocessesToGoal($created_goal->id, $goal['workprocess_ids']);
            }
            $created_goal['workprocesses'] = $workprocesses;
            $created_goals[] = $created_goal;
        }

        return $created_goals;
    }

    /**
     * Updates goals and associated work processes for a specific sprint.
     *
     * This method updates the goals associated with the given sprint. For each goal, it filters 
     * the input data based on the model's fillable attributes and checks if any fields have been 
     * changed. If any changes are detected, the goal is saved. Additionally, if work processes 
     * are provided for a goal, the method delegates the work process updates to a separate service.
     * 
     * @param int   $sprint_id  The ID of the sprint to which the goals belong.
     * @param array $goals     An array of goals with their updated data, including optional work processes.
     *
     * @return bool  Returns true if any goal or work process was updated, otherwise false.
     */
    public function updateGoalsWithWorkprocesses(int $sprint_id, array $goals): bool
    {
        $has_changes = false;

        foreach ($goals ?? [] as $goal_data) {
            $goal = SprintGoalAndRetrospective::find($goal_data['id']);

            if (!$goal || $goal->sprint_id !== $sprint_id) {
                continue;
            }

            $fillable = $goal->getFillable();
            $goal_data_filtered = Arr::only($goal_data, $fillable);

            if ($goal->fill($goal_data_filtered)->isDirty()) {
                $goal->save();

                $has_changes = true;
            }

            if (!empty($goal_data['workprocesses'])){
                if($this->workprocessService->handle($sprint_id, $goal->id, $goal_data['workprocesses'])){
                    $has_changes = true;
                }
            }
        }

        return $has_changes;
    }

    /**
     * Deletes goals associated with a specific sprint based on the provided goal IDs.
     *
     * This method checks each goal ID in the provided array, verifies that the goal belongs to
     * the specified sprint, and deletes the goal if conditions are met. Returns a boolean flag
     * indicating if any goals were successfully deleted.
     *
     * @param int   $sprint_id  The ID of the sprint from which the goals should be deleted.
     * @param array $goal_ids   An array of goal IDs to be deleted.
     *
     * @return bool  Returns true if at least one goal was deleted, otherwise false.
     */
    public function deleteGoals(int $sprint_id, array $goal_ids): bool
    {
        $has_changes = false;

        foreach ($goal_ids ?? [] as $goal_id) {
            $goal = SprintGoalAndRetrospective::find($goal_id);

            if ($goal && $goal->sprint_id === $sprint_id) {
                $goal->delete();
                $has_changes = true;
            }
        }

        return $has_changes;
    }

    /**
     * Handles creation, update, and deletion of goals for a given sprint.
     *
     * This method processes the `create`, `update`, and `delete` keys from the provided data array.
     * It manages related workprocesses where necessary and returns a boolean flag indicating if
     * any changes were made.
     *
     * @param Sprint $sprint      The sprint entity to which the goals belong.
     * @param array  $goals_data  An associative array containing goal data under keys:
     *                            - 'create': array of goals to create
     *                            - 'update': array of goals to update
     *                            - 'delete': array of goal IDs to delete
     *
     * @return bool Returns true if any goal was created, updated, or deleted; otherwise false.
     */
    public function handle(Sprint $sprint, array $goals_data): bool
    {
        $has_changes = false;
        $goals_to_create = $goals_data['create'] ?? [];
        $goals_to_update = $goals_data['update'] ?? [];
        $goals_to_delete = $goals_data['delete'] ?? [];

        //---Update---
        if (!empty($goals_to_update) && $this->updateGoalsWithWorkprocesses($sprint->id, $goals_to_update)) {
            $has_changes = true;
        }

        //---Delete---
        if (!empty($goals_to_delete) && $this->deleteGoals($sprint->id, $goals_data['delete'])){
            $has_changes = true;
        }

        //---Create---
        if (isset($goals_to_create) && !empty($goals_to_create)){
            $created_goals = $this->createGoalsWithWorkprocesses($sprint, $goals_to_create);
            if (!empty($created_goals)) {
                $has_changes = true;
            }
        }

        return $has_changes;
    }
}