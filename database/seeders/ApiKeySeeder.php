<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiKeySeeder extends Seeder
{
    /**
     * Seed the api_key table.
     */
    public function run(): void
    {
        // Get user references
        $kyanu = User::where('identifier', 'kyanu')->first();
        $leonid = User::where('identifier', 'leonid')->first();
        $kyanuStudent = User::where('identifier', '97105847')->first();
        $leonidStudent = User::where('identifier', '97108289')->first();

        // API key for Kyanu
        DB::table('api_keys')->updateOrInsert(
            ['user_id' => $kyanu->id],
            [
                'api_key' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // API key for Leonid
        DB::table('api_keys')->updateOrInsert(
            ['user_id' => $leonid->id],
            [
                'api_key' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // API key for Kyanu Student
        DB::table('api_keys')->updateOrInsert(
            ['user_id' => $kyanuStudent->id],
            [
                'api_key' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // API key for Leonid Student
        DB::table('api_keys')->updateOrInsert(
            ['user_id' => $leonidStudent->id],
            [
                'api_key' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
