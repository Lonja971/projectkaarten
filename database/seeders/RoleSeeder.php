<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the roles table.
     */
    public function run(): void
    {
        // Only create roles if they don't exist
        Role::updateOrCreate(
            ['name' => 'Docent'],
            ['name' => 'Docent']
        );

        Role::updateOrCreate(
            ['name' => 'Student'],
            ['name' => 'Student']
        );
    }
}
