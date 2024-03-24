<?php

namespace App\Interfaces;

use App\Models\Fixture;
use App\Models\Game;
use App\Models\Team;

interface GameRepositoryInterface {

    public function add(Game $game): bool;
    public function getGamesForFixtureWeek(Fixture $fixture);
    public function getPlayedGamesForFixture(Fixture $fixture);
    public function getPlayedTeamGamesForFixture(Fixture $fixture, Team $team);
}
