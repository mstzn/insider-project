<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Fixture;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;

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

    public function getGamesForSpecificFixtureWeek(Fixture $fixture, int $week)
    {
        return Game::where('fixture_id', $fixture->id)->where('week', $week)->get()->all();
    }

    public function getPlayedGamesForFixture(Fixture $fixture)
    {
        return Game::where('fixture_id', $fixture->id)->where('is_played', true)->get()->all();
    }

    public function getPlayedTeamGamesForFixture(Fixture $fixture, Team $team)
    {
        return Game::where('fixture_id', $fixture->id)
            ->where('is_played', true)
            ->where(function (Builder $query) use ($team) {
                $query->where('home_team_id', $team->id)
                    ->orWhere('away_team_id', $team->id);
            })
            ->get()->all();
    }

    public function clearAll()
    {
        Game::truncate();
    }
}
