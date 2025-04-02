<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // No truncate, use updateOrCreate instead

        // Only create roles if they don't exist
        Role::updateOrCreate(
            ['name' => 'Docent'],
            ['name' => 'Docent']
        );

        Role::updateOrCreate(
            ['name' => 'Student'],
            ['name' => 'Student']
        );

        // Only create users if they don't already exist
        $kyanu = User::updateOrCreate(
            ['identifier' => 'kyanu'],
            [
                'full_name' => 'Kyanu Docent',
                'email' => 'kyanudocent@test',
                'password' => bcrypt('password'),
                'role_id' => 1,
                'identifier' => 'kyanu',
            ]
        );

        $leonid = User::updateOrCreate(
            ['identifier' => 'leonid'],
            [
                'full_name' => 'Leonid Docent',
                'email' => 'leoniddocent@test',
                'password' => bcrypt('password'),
                'role_id' => 1,
                'identifier' => 'leonid',
            ]
        );

        $kyanuStudent = User::updateOrCreate(
            ['identifier' => '97105847'],
            [
                'full_name' => 'Kyanu Student',
                'email' => 'kyanustudent@test',
                'password' => bcrypt('password'),
                'role_id' => 2,
                'identifier' => '97105847',
            ]
        );

        $leonidStudent = User::updateOrCreate(
            ['identifier' => '97108289'],
            [
                'full_name' => 'Leonid Student',
                'email' => 'leonidstudent@test',
                'password' => bcrypt('password'),
                'role_id' => 2,
            ]
        );

        // Add roles to users
        $studentRole = Role::where('name', 'Student')->first();
        $docentRole = Role::where('name', 'Docent')->first();

        $kyanuStudent->role_id = $studentRole->id;
        $kyanuStudent->save();
        $kyanu->role_id = $docentRole->id;
        $kyanu->save();
        $leonidStudent->role_id = $studentRole->id;
        $leonidStudent->save();
        $leonid->role_id = $docentRole->id;
        $leonid->save();

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

        // Icons
        DB::table('icons')->insert([
            // Programming Languages & Frameworks
            ['icon' => 'fa-solid fa-globe'],
            ['icon' => 'fa-solid fa-puzzle-piece'],
            ['icon' => 'fa-solid fa-briefcase'],
            ['icon' => 'fa-solid fa-laptop-code'],
            ['icon' => 'fa-solid fa-book'],
            ['icon' => 'fa-solid fa-graduation-cap'],
            ['icon' => 'fa-solid fa-chart-line'],
            ['icon' => 'fa-solid fa-flask'],
            ['icon' => 'fa-solid fa-palette'],
            ['icon' => 'fa-solid fa-microchip'],
            ['icon' => 'fa-solid fa-code'],
            ['icon' => 'fa-solid fa-network-wired'],
            ['icon' => 'fa-solid fa-database'],
            ['icon' => 'fa-solid fa-mobile-alt'],
            ['icon' => 'fa-solid fa-server'],
            // Development Tools & Technologies
            ['icon' => 'fa-solid fa-bug'],
            ['icon' => 'fa-solid fa-terminal'],
            ['icon' => 'fa-solid fa-code-branch'],
            ['icon' => 'fa-brands fa-git-alt'],
            ['icon' => 'fa-brands fa-github'],
            ['icon' => 'fa-solid fa-sitemap'],
            ['icon' => 'fa-solid fa-cloud'],
            ['icon' => 'fa-solid fa-cloud-upload-alt'],
            ['icon' => 'fa-solid fa-cloud-download-alt'],
            ['icon' => 'fa-brands fa-docker'],
            ['icon' => 'fa-brands fa-java'],
            ['icon' => 'fa-brands fa-python'],
            ['icon' => 'fa-brands fa-js'],
            ['icon' => 'fa-brands fa-php'],
            ['icon' => 'fa-brands fa-html5'],
            ['icon' => 'fa-brands fa-css3'],
            ['icon' => 'fa-brands fa-react'],
            ['icon' => 'fa-brands fa-angular'],
            ['icon' => 'fa-brands fa-node'],
            ['icon' => 'fa-brands fa-npm'],
            // Project Management & Collaboration
            ['icon' => 'fa-solid fa-tasks'],
            ['icon' => 'fa-solid fa-users'],
            ['icon' => 'fa-solid fa-comments'],
            ['icon' => 'fa-solid fa-comment-dots'],
            ['icon' => 'fa-solid fa-trophy'],
            ['icon' => 'fa-solid fa-bullseye'],
            ['icon' => 'fa-solid fa-calendar'],
            ['icon' => 'fa-solid fa-calendar-alt'],
            ['icon' => 'fa-solid fa-clipboard'],
            ['icon' => 'fa-solid fa-clipboard-list'],
            ['icon' => 'fa-solid fa-clipboard-check'],
            ['icon' => 'fa-solid fa-chart-bar'],
            ['icon' => 'fa-solid fa-chart-pie'],
            ['icon' => 'fa-solid fa-chart-area'],
            ['icon' => 'fa-solid fa-project-diagram'],
            // Hardware & Devices
            ['icon' => 'fa-solid fa-desktop'],
            ['icon' => 'fa-solid fa-laptop'],
            ['icon' => 'fa-solid fa-tablet'],
            ['icon' => 'fa-solid fa-keyboard'],
            ['icon' => 'fa-solid fa-mouse'],
            ['icon' => 'fa-solid fa-memory'],
            ['icon' => 'fa-solid fa-hdd'],
            ['icon' => 'fa-solid fa-usb'],
            ['icon' => 'fa-solid fa-wifi'],
            ['icon' => 'fa-brands fa-bluetooth'],
            ['icon' => 'fa-solid fa-gamepad'],
            ['icon' => 'fa-solid fa-robot'],
            // Security & Protection
            ['icon' => 'fa-solid fa-shield-alt'],
            ['icon' => 'fa-solid fa-lock'],
            ['icon' => 'fa-solid fa-unlock'],
            ['icon' => 'fa-solid fa-user-shield'],
            ['icon' => 'fa-solid fa-key'],
            ['icon' => 'fa-solid fa-fingerprint'],
            ['icon' => 'fa-solid fa-eye'],
            ['icon' => 'fa-solid fa-eye-slash'],
            // AI & Advanced Technologies
            ['icon' => 'fa-solid fa-brain'],
            ['icon' => 'fa-solid fa-cogs'],
            ['icon' => 'fa-solid fa-tools'],
            ['icon' => 'fa-solid fa-rocket'],
            ['icon' => 'fa-solid fa-satellite'],
            ['icon' => 'fa-solid fa-vr-cardboard'],
            ['icon' => 'fa-solid fa-lightbulb'],
            ['icon' => 'fa-solid fa-search'],
            // Social & Communication
            ['icon' => 'fa-solid fa-share-alt'],
            ['icon' => 'fa-solid fa-envelope'],
            ['icon' => 'fa-solid fa-video'],
            ['icon' => 'fa-solid fa-phone'],
            ['icon' => 'fa-solid fa-headset'],
            ['icon' => 'fa-solid fa-hashtag'],
            ['icon' => 'fa-solid fa-at'],
            // Media & Content
            ['icon' => 'fa-solid fa-file-code'],
            ['icon' => 'fa-solid fa-file-alt'],
            ['icon' => 'fa-solid fa-file-image'],
            ['icon' => 'fa-solid fa-file-video'],
            ['icon' => 'fa-solid fa-file-audio'],
            ['icon' => 'fa-solid fa-images'],
            ['icon' => 'fa-solid fa-photo-video'],
            ['icon' => 'fa-solid fa-camera'],
            ['icon' => 'fa-solid fa-play'],
            ['icon' => 'fa-solid fa-music'],
            // Utilities & General
            ['icon' => 'fa-solid fa-wrench'],
            ['icon' => 'fa-solid fa-sync'],
            ['icon' => 'fa-solid fa-cog'],
            ['icon' => 'fa-solid fa-sliders-h'],
            ['icon' => 'fa-solid fa-tachometer-alt'],
            ['icon' => 'fa-solid fa-star'],
            ['icon' => 'fa-solid fa-filter'],
            ['icon' => 'fa-solid fa-bolt'],
            ['icon' => 'fa-solid fa-power-off'],
            ['icon' => 'fa-solid fa-save']
        ]);

        // Backgrounds
        DB::table('backgrounds')->insert([
            // Dark Red
            ['background_color' => '#800000'], // Maroon
            ['background_color' => '#800020'], // Burgundy
            ['background_color' => '#4A0000'], // Oxblood
            
            // Dark Orange
            ['background_color' => '#CC5500'], // Burnt Orange
            ['background_color' => '#8B3103'], // Rust
            ['background_color' => '#A52A2A'], // Auburn
            
            // Dark Yellow
            ['background_color' => '#B38B00'], // Mustard
            ['background_color' => '#DAA520'], // Goldenrod
            ['background_color' => '#808000'], // Olive
            
            // Dark Green
            ['background_color' => '#228B22'], // Forest Green
            ['background_color' => '#355E3B'], // Hunter Green
            ['background_color' => '#01796F'], // Pine
            
            // Dark Blue
            ['background_color' => '#000080'], // Navy
            ['background_color' => '#191970'], // Midnight Blue
            ['background_color' => '#003153'], // Prussian Blue
            
            // Dark Purple
            ['background_color' => '#701C1C'], // Plum
            ['background_color' => '#311432'], // Eggplant
            ['background_color' => '#5D3FD3'], // Deep Violet
            
            // Dark Pink
            ['background_color' => '#722F37'], // Wine
            ['background_color' => '#C85A72'], // Deep Rose
            ['background_color' => '#872657'], // Raspberry
            
            // Dark Brown
            ['background_color' => '#5D4037'], // Chocolate
            ['background_color' => '#3D2B1F'], // Espresso
            ['background_color' => '#635147'], // Umber
            
            // Dark Gray
            ['background_color' => '#36454F'], // Charcoal
            ['background_color' => '#2A3439'], // Gunmetal
            ['background_color' => '#708090'], // Slate
            
            // Dark Cyan
            ['background_color' => '#008080'], // Teal
            ['background_color' => '#005F5F'], // Deep Turquoise
            ['background_color' => '#045D5D'], // Dark Aqua
            
            // Dark Magenta
            ['background_color' => '#C154C1'], // Deep Fuchsia
            ['background_color' => '#872657'], // Dark Raspberry
            ['background_color' => '#BD33A4'], // Byzantine
            
            // Dark Gold
            ['background_color' => '#CD7F32'], // Bronze
            ['background_color' => '#8B7500'], // Antique Gold
            ['background_color' => '#9F6000'], // Deep Amber
            
            // Dark Silver
            ['background_color' => '#ADB0B2'], // Pewter
            ['background_color' => '#53565A'], // Graphite
            ['background_color' => '#757575']  // Dark Platinum
        ]);

        // Create some sample projects
        // Project for Kyanu Student
        DB::table('projects')->updateOrInsert(
            ['id' => 1],
            [
                'user_id' => $kyanuStudent->id,
                'title' => 'Student Project 1',
                'date_start' => now(),
                'date_end' => now()->addMonths(3),
                'status_id' => ProjectStatus::where('name', 'Concept')->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'icon_id' => 28,
                'background_id' => 1,
                'project_by_student' => '1'
            ]
        );

        // Project for Leonid Student
        DB::table('projects')->updateOrInsert(
            ['id' => 2],
            [
                'user_id' => $leonidStudent->id,
                'title' => 'Student Project 2',
                'date_start' => now()->subDays(5),
                'date_end' => now()->addMonths(2),
                'status_id' => ProjectStatus::where('name', 'In behandeling')->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'icon_id' => 29,
                'background_id' => 4,
                'project_by_student' => '1'
            ]
        );

        // Another project for Kyanu Student
        DB::table('projects')->updateOrInsert(
            ['id' => 3],
            [
                'user_id' => $kyanuStudent->id,
                'title' => 'Another Project',
                'date_start' => now()->subDays(10),
                'date_end' => now()->addMonths(1),
                'status_id' => ProjectStatus::where('name', 'In behandeling')->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'icon_id' => 30,
                'background_id' => 7,
                'project_by_student' => '2'
            ]
        );

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
    }
}
