<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table.
     */
    public function run(): void
    {
        // Create faker instance
        $faker = Faker::create('nl_NL');
        
        // Get roles
        $studentRole = Role::where('name', 'Student')->first();
        $docentRole = Role::where('name', 'Docent')->first();
        
        // Create teachers (docenten)
        $kyanu = User::updateOrCreate(
            ['identifier' => 'kyanu'],
            [
                'full_name' => 'Kyanu Docent',
                'email' => 'kyanudocent@test',
                'password' => bcrypt('password'),
                'role_id' => $docentRole->id,
                'identifier' => 'kyanu',
            ]
        );

        $leonid = User::updateOrCreate(
            ['identifier' => 'leonid'],
            [
                'full_name' => 'Leonid Docent',
                'email' => 'leoniddocent@test',
                'password' => bcrypt('password'),
                'role_id' => $docentRole->id,
                'identifier' => 'leonid',
            ]
        );

        // Keep original student accounts for backward compatibility
        $kyanuStudent = User::updateOrCreate(
            ['identifier' => '97105847'],
            [
                'full_name' => 'Kyanu Student',
                'email' => 'kyanustudent@test',
                'password' => bcrypt('password'),
                'role_id' => $studentRole->id,
                'identifier' => '97105847',
            ]
        );

        $leonidStudent = User::updateOrCreate(
            ['identifier' => '97108289'],
            [
                'full_name' => 'Leonid Student',
                'email' => 'leonidstudent@test',
                'password' => bcrypt('password'),
                'role_id' => $studentRole->id,
                'identifier' => '97108289',
            ]
        );
        
        // Create 100 additional students with unique names and identifiers
        for ($i = 1; $i <= 100; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $fullName = $firstName . ' ' . $lastName;
            
            // Create a unique student number (identifier) starting from 97200000
            $identifier = '972' . str_pad($i + 10000, 5, '0', STR_PAD_LEFT);
            
            User::updateOrCreate(
                ['identifier' => $identifier],
                [
                    'full_name' => $fullName,
                    'email' => strtolower($firstName) . '.' . strtolower($lastName) . '@student.test',
                    'password' => bcrypt('password'),
                    'role_id' => $studentRole->id,
                    'identifier' => $identifier,
                ]
            );
        }
    }
}
