<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\Icon;
use App\Models\Background;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Seed the projects table.
     */
    public function run(): void
    {
        // Create faker instance
        $faker = Faker::create('nl_NL');
        
        // Get all student users
        $students = User::where('role_id', 2)->get();
        
        // Get all icons, backgrounds, and statuses
        $icons = Icon::all();
        $backgrounds = Background::all();
        $statuses = ProjectStatus::all();
        
        // Project topic templates for more realistic project names
        $projectTopics = [
            'Web Development met %s',
            '%s Applicatie',
            '%s Platform',
            'Mobile %s App',
            'IoT Systeem voor %s',
            'Data Analyse van %s',
            '%s Dashboard',
            'AI-gestuurd %s',
            '%s Prototype',
            'Interactieve %s',
            '%s Management Systeem',
            '%s Visualisatie Tool',
            'Smart %s',
            '%s Database Systeem',
            '%s Game Development',
            'Social Media %s',
            'E-commerce %s',
            '%s Automatisering',
            'Cloud-based %s',
            '%s Netwerk',
        ];
        
        $technologies = [
            'React', 'Angular', 'Vue.js', 'Laravel', 'Django', 
            'Spring Boot', 'Express.js', 'Flask', 'Node.js', 
            'TensorFlow', 'PyTorch', 'WordPress', 'Shopify', 
            'PHP', 'Python', 'JavaScript', 'Java', 'C#', 
            'Azure', 'AWS', 'Google Cloud', 'Kubernetes', 
            'Docker', 'GraphQL', 'REST API', 'MongoDB', 
            'PostgreSQL', 'MySQL', 'Redis', 'Blockchain',
            'Unity', 'Unreal Engine', 'Swift', 'Kotlin',
            'Flutter', 'React Native', 'Xamarin', 'Bootstrap',
            'Tailwind CSS', 'Material UI', 'WebRTC', 'Socket.io'
        ];
        
        $domains = [
            'Gezondheidszorg', 'Onderwijs', 'Transport', 'Retail', 
            'Financiën', 'Vastgoed', 'Energie', 'Overheid', 
            'Media', 'Entertainment', 'Sport', 'Voedsel', 
            'Landbouw', 'Mode', 'Reizen', 'Huisdieren', 
            'Kunst', 'Muziek', 'Gaming', 'E-sports',
            'Smart Home', 'Duurzaamheid', 'Logistiek', 'HR',
            'Marketing', 'Beveiliging', 'Communicatie', 'Social Media'
        ];
        
        // Keep existing projects for backward compatibility
        $kyanuStudent = User::where('identifier', '97105847')->first();
        $leonidStudent = User::where('identifier', '97108289')->first();

        // Project for Kyanu Student
        DB::table('projects')->updateOrInsert(
            ['id' => 1],
            [
                'user_id' => $kyanuStudent->id,
                'title' => 'Student Project 1',
                'date_start' => now()->format('Y-m-d H:i:s'),
                'date_end' => now()->addMonths(3)->format('Y-m-d H:i:s'),
                'status_id' => ProjectStatus::where('name', 'Concept')->first()->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
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
                'date_start' => now()->subDays(5)->format('Y-m-d H:i:s'),
                'date_end' => now()->addMonths(2)->format('Y-m-d H:i:s'),
                'status_id' => ProjectStatus::where('name', 'Actief')->first()->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
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
                'date_start' => now()->subDays(10)->format('Y-m-d H:i:s'),
                'date_end' => now()->addMonths(1)->format('Y-m-d H:i:s'),
                'status_id' => ProjectStatus::where('name', 'Afgerond')->first()->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'icon_id' => 30,
                'background_id' => 7,
                'project_by_student' => '2'
            ]
        );
        
        // Create 500 new projects with random attributes
        for ($i = 4; $i <= 503; $i++) {
            // Generate a realistic project title
            $topic = $faker->randomElement($projectTopics);
            $tech = $faker->randomElement($technologies);
            $domain = $faker->randomElement($domains);
            
            // 50% chance to use tech in title, 50% to use domain
            $titleContent = $faker->boolean(50) ? $tech : $domain;
            $title = sprintf($topic, $titleContent);
            
            // Random student assignment
            $student = $faker->randomElement($students);
            
            // Generate dates between 2022 and 2027
            $startYear = rand(2022, 2026); // End year can be up to 2027
            $startMonth = rand(1, 12);
            $startDay = rand(1, 28); // Using 28 to avoid date issues
            
            $startDate = \Carbon\Carbon::create($startYear, $startMonth, $startDay);
            
            // Generate end date (between 1 month and 2 years after start date)
            $monthsAhead = rand(1, 24);
            $endDate = $startDate->copy()->addMonths($monthsAhead);
            
            // Cap end date at 2027-12-31 if it exceeds
            if ($endDate->year > 2027) {
                $endDate = \Carbon\Carbon::create(2027, 12, 31);
            }
            
            // Random icon, background, and status
            $icon = $faker->randomElement($icons);
            $background = $faker->randomElement($backgrounds);
            $status = $faker->randomElement($statuses);
            
            // Random project_by_student value (mostly 1, but sometimes 2)
            $projectByStudent = $faker->boolean(80) ? '1' : '2';
            
            // Fixed timestamp for created_at and updated_at - avoid reusing now() which might cause issues
            $createdAt = now()->format('Y-m-d H:i:s');
            
            DB::table('projects')->updateOrInsert(
                ['id' => $i],
                [
                    'user_id' => $student->id,
                    'title' => $title,
                    'date_start' => $startDate->format('Y-m-d H:i:s'),
                    'date_end' => $endDate->format('Y-m-d H:i:s'),
                    'status_id' => $status->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                    'icon_id' => $icon->id,
                    'background_id' => $background->id,
                    'project_by_student' => $projectByStudent
                ]
            );
        }
    }
}
