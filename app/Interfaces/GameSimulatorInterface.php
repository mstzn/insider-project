<?php

namespace App\Interfaces;

use App\Models\Team;
use App\ValueObjects\Score;

interface GameSimulatorInterface {

    public function playGame(Team $homeTeam, Team $awayTeam): Score;

}
