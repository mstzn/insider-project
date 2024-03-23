<?php

namespace App\Repositories;

use App\Interfaces\FixtureRepositoryInterface;
use App\Models\Fixture;
use App\Models\Game;

class FixtureRepositoryMysqlImplementation implements FixtureRepositoryInterface
{
    protected GameRepositoryMysqlImplementation $gameRepository;
    public function __construct(GameRepositoryMysqlImplementation $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function add(array $fixtures): Fixture
    {
        /* Set existing fixtures inactive */
        Fixture::where('is_active', true)->update(['is_active' => false]);

        $fixture = new Fixture();
        $fixture->is_active = true;
        $fixture->save();

        foreach ($fixtures as $week => $schedule) {
            foreach ($schedule as $match) {
                $game = new Game();
                $game->home_team_id = $match['home'];
                $game->away_team_id = $match['away'];
                $game->fixture_id = $fixture->id;
                $game->week = $week + 1;
                $this->gameRepository->add($game);
            }
        }

        return $fixture;
    }

    public function getActiveFixture(): Fixture
    {
        return Fixture::active()->get()->first();
    }
}
