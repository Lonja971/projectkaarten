<?php

namespace App\Services\Sprint;

use App\Models\Sprint;
use App\Models\SprintGoalAndRetrospective;

class SprintGoalService
{
   public function updateGoals(Sprint $sprint, array $goalsData): array
   {
      $changes = [];

      //---Update---
      foreach ($goalsData['update'] ?? [] as $goal_id => $goal_data) {
          $goal = SprintGoalAndRetrospective::find($goal_id);

          if (!$goal || $goal->sprint_id !== $sprint->id) {
              continue;
          }

          if ($goal->fill($goal_data)->isDirty()) {
              $goal->save();
              $changes[] = "goal_updated:$goal_id";
          }
      }

      //---Delete---
      foreach ($goalsData['delete'] ?? [] as $goal_id) {
          $goal = SprintGoalAndRetrospective::find($goal_id);

          if ($goal && $goal->sprint_id === $sprint->id) {
              $goal->delete();
              $changes[] = "goal_deleted:$goal_id";
          }
      }

      //---Create---
      foreach ($goalsData['create'] ?? [] as $goal_data) {
          $goal_data['sprint_id'] = $sprint->id;
          SprintGoalAndRetrospective::create($goal_data);
          $changes[] = "goal_created";
      }

      return $changes;
   }
}