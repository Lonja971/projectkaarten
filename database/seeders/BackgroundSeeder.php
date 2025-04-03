<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackgroundSeeder extends Seeder
{
    /**
     * Seed the backgrounds table.
     */
    public function run(): void
    {
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
    }
}
