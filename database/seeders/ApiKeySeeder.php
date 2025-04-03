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

        // API key for Kyanu
        DB::table('api_key')->updateOrInsert(
            ['user_id' => $kyanu->id],
            [
                'api_key' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // API key for Leonid
        DB::table('api_key')->updateOrInsert(
            ['user_id' => $leonid->id],
            [
                'api_key' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
