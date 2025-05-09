<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\SprintStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class SprintSeeder extends Seeder
{
    /**
     * Seed the sprints table.
     * Each project will have 2-6 sprints with non-overlapping dates.
     */
    public function run(): void
    {
        // Create faker instance
        $faker = Faker::create('nl_NL');
        
        // Get all sprint statuses
        $conceptStatus = SprintStatus::where('name', 'Concept')->first()->id;
        $activeStatus = SprintStatus::where('name', 'Actief')->first()->id;
        $completedStatus = SprintStatus::where('name', 'Afgerond')->first()->id;
        
        // Get all projects
        $projects = Project::all();
        
        // Clear existing sprints and related data before seeding - disable foreign key checks first
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('sprint_goals_and_retrospectives')->truncate();
        DB::table('sprint_workprocesses')->truncate();
        DB::table('sprints')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        foreach ($projects as $project) {
            // Determine number of sprints for this project (2-6)
            $sprintCount = rand(2, 6);
            
            // Get project start and end dates
            $projectStartDate = Carbon::parse($project->date_start);
            $projectEndDate = Carbon::parse($project->date_end);
            
            // Calculate total project duration in days
            $projectDurationDays = $projectStartDate->diffInDays($projectEndDate);
            
            // If project is too short for multiple sprints, make it longer
            if ($projectDurationDays < $sprintCount * 7) {
                $projectEndDate = $projectStartDate->copy()->addDays($sprintCount * 14);
                $projectDurationDays = $projectStartDate->diffInDays($projectEndDate);
                
                // Update project end date
                $project->date_end = $projectEndDate;
                $project->save();
            }
            
            // Calculate average sprint duration
            $avgSprintDuration = floor($projectDurationDays / $sprintCount);
            
            // Set minimum sprint duration to 7 days
            $minSprintDuration = max(7, floor($avgSprintDuration * 0.7));
            
            // Current date pointer starts at project start date
            $currentDate = $projectStartDate->copy();
            
            // Generate sprints
            for ($sprintNumber = 1; $sprintNumber <= $sprintCount; $sprintNumber++) {
                // For last sprint, end date is project end date
                if ($sprintNumber == $sprintCount) {
                    $sprintEndDate = $projectEndDate->copy();
                } else {
                    // Calculate random duration for this sprint, ensuring we don't exceed project end date
                    $remainingDays = $currentDate->diffInDays($projectEndDate);
                    $remainingSprints = $sprintCount - $sprintNumber + 1;
                    
                    // Ensure each remaining sprint has at least minimum duration
                    $maxAllowedDuration = $remainingDays - (($remainingSprints - 1) * $minSprintDuration);
                    $maxAllowedDuration = max($minSprintDuration, $maxAllowedDuration);
                    
                    // Random duration between min and max
                    $sprintDuration = rand($minSprintDuration, $maxAllowedDuration);
                    
                    // Set sprint end date
                    $sprintEndDate = $currentDate->copy()->addDays($sprintDuration);
                }
                
                // Determine sprint status based on current date
                $now = Carbon::now();
                $statusId = $conceptStatus; // Default to concept
                
                if ($currentDate->lt($now) && $sprintEndDate->gt($now)) {
                    // Sprint is currently active
                    $statusId = $activeStatus;
                } elseif ($sprintEndDate->lt($now)) {
                    // Sprint is in the past
                    $statusId = $completedStatus;
                }
                
                // Generate random reflection and feedback (only for completed sprints)
                $reflection = null;
                $feedback = null;
                
                if ($statusId == $completedStatus) {
                    // 80% chance to have reflection and feedback for completed sprints
                    if ($faker->boolean(80)) {
                        // Limit text to 250 characters to fit in string field
                        $reflection = substr($faker->paragraph(1), 0, 250);
                        $feedback = substr($faker->paragraph(1), 0, 250);
                    }
                }
                
                // Create sprint
                $sprintId = DB::table('sprints')->insertGetId([
                    'sprint_nr' => $sprintNumber,
                    'project_id' => $project->id,
                    'date_start' => $currentDate->format('Y-m-d'),
                    'date_end' => $sprintEndDate->format('Y-m-d'),
                    'status_id' => $statusId,
                    'reflection' => $reflection,
                    'feedback' => $feedback,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s')
                ]);
                
                // Add 1-4 goals for this sprint
                $goalCount = rand(1, 4);
                for ($g = 0; $g < $goalCount; $g++) {
                    DB::table('sprint_goals_and_retrospectives')->insert([
                        'sprint_id' => $sprintId,
                        'description' => $faker->sentence(rand(6, 12)),
                        'is_retrospective' => false,
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s')
                    ]);
                }
                
                // Add 0-3 retrospective items for completed sprints
                if ($statusId == $completedStatus) {
                    $retroCount = rand(0, 3);
                    for ($r = 0; $r < $retroCount; $r++) {
                        DB::table('sprint_goals_and_retrospectives')->insert([
                            'sprint_id' => $sprintId,
                            'description' => $faker->sentence(rand(6, 12)),
                            'is_retrospective' => true,
                            'created_at' => now()->format('Y-m-d H:i:s'),
                            'updated_at' => now()->format('Y-m-d H:i:s')
                        ]);
                    }
                }
                
                // Move current date pointer to one day after this sprint ends
                $currentDate = $sprintEndDate->copy()->addDay();
            }
        }
    }
}
