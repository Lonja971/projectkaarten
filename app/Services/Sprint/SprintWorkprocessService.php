<?php

namespace App\Services\Sprint;

use App\Models\Sprint;
use App\Models\SprintGoalAndRetrospective;
use App\Models\SprintWorkprocess;
use App\Models\Workprocess;

class SprintWorkprocessService
{
    /**
     * Attach workprocesses to a specific goal.
     *
     * For each valid workprocess ID, creates a SprintWorkprocess record linking it to the provided goal.
     * Skips invalid or duplicate workprocesses.
     *
     * @param int $goal_id The goal id to which workprocesses should be attached.
     * @param array $workprocess_ids List of workprocess IDs to attach.
     * @return array List of created SprintWorkprocess entries.
     */
    public function attachWorkprocessesToGoal(int $goal_id, array $workprocess_ids): array
    {
        $created_workprocesses = [];

        foreach (array_unique($workprocess_ids) as $id) {
            if (!Workprocess::where('id', $id)->exists()) continue;

            $is_already_exists = SprintWorkprocess::where('sprint_goal_id', $goal_id)
                ->where('workprocess_id', $id)
                ->exists();

            if ($is_already_exists) continue;

            $created_workprocesses[] = SprintWorkprocess::create([
                'sprint_goal_id' => $goal_id,
                'workprocess_id' => $id,
            ]);
        }

        return $created_workprocesses;
    }

    /**
     * Deletes workprocess associations from a sprint goal if they belong to the given sprint.
     *
     * @param int   $sprint_id          The ID of the sprint to validate against.
     * @param int   $goal_id            The ID of the sprint goal from which to delete workprocesses.
     * @param array $workprocesses_ids  An array of workprocess IDs to be removed.
     *
     * @return bool Returns true if any deletions were made, otherwise false.
     */
    public function deleteWorkprocesses(int $sprint_id, int $goal_id, array $workprocesses_ids): bool
    {
        $has_changes = false;

        foreach ($workprocesses_ids as $workprocess_id) {
            $workprocess = SprintWorkprocess::findByGoalAndProcess($goal_id, $workprocess_id);

            if (!$workprocess) continue;

            $goal_sprint_id = SprintGoalAndRetrospective::where('id', $workprocess->sprint_goal_id)->pluck('sprint_id')->first();

            if ($goal_sprint_id === $sprint_id) {
                $workprocess->delete();
                $has_changes = true;
            }
        }

        return $has_changes;
    }

    /**
     * Handles attaching and detaching work processes to/from a sprint goal.
     *
     * @param int   $sprint_id   The ID of the sprint the goal belongs to.
     * @param int   $goal_id     The ID of the sprint goal to update.
     * @param array $data        The data array containing 'add' and/or 'remove' keys with work process IDs.
     *                           Example:
     *                           [
     *                               'add' => [1, 2, 3],     // optional
     *                               'remove' => [4, 5]      // optional
     *                           ]
     *
     * @return bool Returns true if any changes (additions or deletions) were made, otherwise false.
     */
    public function handle(int $sprint_id, int $goal_id, array $data): bool
    {
        $has_changes = false;

        if (!empty($data['add'])){
            if($this->attachWorkprocessesToGoal($goal_id, $data['add'])){
                $has_changes = true;
            }
        }

        if (!empty($data['remove'])){
            if($this->deleteWorkprocesses($sprint_id, $goal_id, $data['remove'])){
                $has_changes = true;
            }
        }

        return $has_changes;
    }
}