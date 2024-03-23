<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Fixture;
use App\Models\Game;

class GameRepositoryMysqlImplementation implements GameRepositoryInterface
{
    public function add(Game $game): bool
    {
        return $game->save();
    }

    public function getGamesForFixtureWeek(Fixture $fixture)
    {
        return Game::where('fixture_id', $fixture->id)->where('week', $fixture->week)->get()->all();
    }
}
