<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Seed the project_statuses table.
     */
    public function run(): void
    {
        // Create project statuses
        ProjectStatus::updateOrCreate(
            ['name' => 'Concept'],
            [
                'name' => 'Concept',
                'color' => '#808080',
                'filled' => false,
            ]
        );

        ProjectStatus::updateOrCreate(
            ['name' => 'Actief'],
            [
                'name' => 'Actief',
                'color' => '#0000FF',
                'filled' => true,
            ]
        );
        
        ProjectStatus::updateOrCreate(
            ['name' => 'Afgerond'],
            [
                'name' => 'Afgerond',
                'color' => '#008000',
                'filled' => true,
            ]
        );
    }
}
