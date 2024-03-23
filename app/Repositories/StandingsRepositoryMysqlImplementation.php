<?php

namespace App\Repositories;

use App\Interfaces\StandingsRepositoryInterface;
use App\Models\Fixture;
use App\Models\Standing;

class StandingsRepositoryMysqlImplementation implements StandingsRepositoryInterface
{
    public function get(Fixture $fixture)
    {
        return Standing::where('fixture_id', $fixture->id)->orderBy('points', 'desc')->get();
    }

    public function add(Fixture $fixture, array $teams)
    {
        foreach ($teams as $team) {
            $standing = new Standing();
            $standing->team_id = $team['id'];
            $standing->fixture_id = $fixture->id;
            $standing->save();
        }
    }
}
