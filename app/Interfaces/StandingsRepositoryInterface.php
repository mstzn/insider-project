<?php

namespace App\Interfaces;


use App\Models\Fixture;

interface StandingsRepositoryInterface {
    public function get(Fixture $fixture);
    public function add(Fixture $fixture, array $teams);
}
