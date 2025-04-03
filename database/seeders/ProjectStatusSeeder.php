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
            ['name' => 'In behandeling'],
            [
                'name' => 'In behandeling',
                'color' => '#808080',
                'filled' => true,
            ]
        );

        ProjectStatus::updateOrCreate(
            ['name' => 'Afgekeurd'],
            [
                'name' => 'Afgekeurd',
                'color' => '#FF0000',
                'filled' => true,
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
            ['name' => 'Feedback'],
            [
                'name' => 'Feedback',
                'color' => '#800080',
                'filled' => true,
            ]
        );

        ProjectStatus::updateOrCreate(
            ['name' => 'Beoordeling'],
            [
                'name' => 'Beoordeling',
                'color' => '#008000',
                'filled' => false,
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
