<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IconSeeder extends Seeder
{
    /**
     * Seed the icons table.
     */
    public function run(): void
    {
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
    }
}
