<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders in the correct order
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProjectStatusSeeder::class,
            IconSeeder::class,
            BackgroundSeeder::class,
            ProjectSeeder::class,
            ApiKeySeeder::class,
            SprintStatusSeeder::class,
        ]);
    }
}
