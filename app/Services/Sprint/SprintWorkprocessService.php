<?php

namespace App\Services\Sprint;

use App\Models\Sprint;
use App\Models\SprintGoalAndRetrospective;
use App\Models\SprintWorkprocess;
use App\Models\Workprocess;

class SprintWorkprocessService
{
    public function handle(Sprint $sprint, array $data): bool
    {
        $changed = false;

        // Delete
        foreach ($data['delete'] ?? [] as $id) {
            $wp = SprintWorkprocess::find($id);
            if (!$wp) {
                continue;
            }
            $goal_sprint_id = SprintGoalAndRetrospective::where('id', $wp->sprint_goal_id)->pluck('sprint_id')->first();

            if ($wp && $goal_sprint_id === $sprint->id) {
                $wp->delete();
                $changed = true;
            }
        }

        // Create
        foreach ($data['create'] ?? [] as $row) {
            $goal_sprint_id = SprintGoalAndRetrospective::where('id', $row['sprint_goal_id'])->pluck('sprint_id')->first();
            $exists = SprintWorkprocess::where('sprint_goal_id', $row['sprint_goal_id'])
                ->where('workprocess_id', $row['workprocess_id'])
                ->exists();

            if ($goal_sprint_id === $sprint->id && !$exists && Workprocess::where('id', $row['workprocess_id'])->exists()) {
                SprintWorkprocess::create($row);
                $changed = true;
            }
        }

        return $changed;
    }
}