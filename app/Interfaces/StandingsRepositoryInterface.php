<?php

namespace App\Interfaces;


use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

interface StandingsRepositoryInterface {
    public function get(Fixture $fixture): Collection;
    public function getTeam(Fixture $fixture, Team $team);
    public function add(Fixture $fixture, array $teams);
    public function update(Fixture $fixture): void;
    public function clearAll();
}
