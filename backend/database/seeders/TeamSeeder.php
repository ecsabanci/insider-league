<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Manchester City', 'strength' => 90],
            ['name' => 'Liverpool', 'strength' => 85],
            ['name' => 'Arsenal', 'strength' => 80],
            ['name' => 'Chelsea', 'strength' => 75],
        ];

        foreach ($teams as $team) {
            // to prevent team creation after build is run for every deploy
            \App\Models\Team::firstOrCreate(
                ['name' => $team['name']],
                ['strength' => $team['strength']]
            );
        }
    }
}
