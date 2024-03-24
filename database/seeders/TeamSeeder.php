<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamNames = [
            'Arsenal',
            'Aston Villa',
            'Bournemouth',
            'Brentford',
            'Brighton',
            'Burnley',
            'Chelsea',
            'Crystal Palace',
            'Everton',
            'Fulham',
            'Liverpool',
            'Luton Town',
            'Man. City',
            'Manchester Utd',
            'Newcastle',
            'Nottingham',
            'Sheffield Utd',
            'Tottenham',
            'West Ham',
            'Wolves',
        ];

        foreach ($teamNames as $index => $teamName) {
            Team::factory()->create([
                'name' => $teamName,
                'short_name' => $this->getShortName($teamName),
            ]);

            if ($index == min(config('app.total_number_of_teams'), count($teamNames)) - 1) {
                break;
            }
        }
    }

    private function getShortName(string $name): string
    {
        if (str_contains($name, ' ')) {
            $shortName = substr($name, 0, 2) . substr($name, strpos($name, ' ') + 1, 1);
        } else {
            $shortName = substr($name, 0, 3);
        }

        return strtoupper($shortName);
    }
}
