<?php

namespace App\Repositories;

use App\Models\Fixture;
use App\Models\Game;

class FixtureRepository
{
    public function store(array $fixtures): Fixture
    {
        $fixture = new Fixture();
        $fixture->save();


        foreach ($fixtures as $week => $schedule) {
            foreach ($schedule as $match) {
                $game = new Game();
                $game->home_team_id = $match['home'];
                $game->away_team_id = $match['away'];
                $game->fixture_id = $fixture->id;
                $game->week = $week + 1;
                $game->save();
            }
        }

        return $fixture;
    }
}
