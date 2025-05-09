<?php

namespace Database\Seeders;

use App\Models\SprintStatus;
use Illuminate\Database\Seeder;

class SprintStatusSeeder extends Seeder
{
    /**
     * Seed the project_statuses table.
     */
    public function run(): void
    {
        // Create project statuses
        SprintStatus::updateOrCreate(
            ['name' => 'Concept'],
            [
                'name' => 'Concept',
                'color' => '#808080',
                'filled' => false,
            ]
        );

        SprintStatus::updateOrCreate(
            ['name' => 'Actief'],
            [
                'name' => 'Actief',
                'color' => '#0000FF',
                'filled' => true,
            ]
        );

        SprintStatus::updateOrCreate(
            ['name' => 'Afgerond'],
            [
                'name' => 'Afgerond',
                'color' => '#008000',
                'filled' => true,
            ]
        );
    }
}
