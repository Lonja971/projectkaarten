<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with initial data.
     * This includes roles, users, projects, sprints, and related metadata.
     * Ensures the database is populated in a specific order to maintain data integrity.
     */
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders in the correct order
        $this->call([
            RoleSeeder::class,
            WorkprocessesSeeder::class,
            UserSeeder::class,
            ProjectStatusSeeder::class,
            IconSeeder::class,
            BackgroundSeeder::class,
            ProjectSeeder::class,
            ApiKeySeeder::class,
            SprintStatusSeeder::class,
            SprintSeeder::class,
        ]);
    }
}
