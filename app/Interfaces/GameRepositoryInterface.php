<?php

namespace App\Interfaces;

use App\Models\Fixture;
use App\Models\Game;

interface GameRepositoryInterface {

    public function add(Game $game): bool;
    public function getGamesForFixtureWeek(Fixture $fixture);
}
