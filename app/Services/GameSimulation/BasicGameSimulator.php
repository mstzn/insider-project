<?php

namespace App\Services\GameSimulation;

use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\GameSimulatorInterface;
use App\Interfaces\StandingsRepositoryInterface;
use App\Models\Team;
use App\ValueObjects\Score;

class BasicGameSimulator implements GameSimulatorInterface
{

    protected int $maxGoalPerMatch = 5;

    protected FixtureRepositoryInterface $fixtureRepository;
    protected StandingsRepositoryInterface $standingsRepository;

    public function __construct(
        FixtureRepositoryInterface   $fixtureRepository,
        StandingsRepositoryInterface $standingsRepository
    )
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->standingsRepository = $standingsRepository;

        $this->maxGoalPerMatch = config('app.max_goal_per_match');
    }

    public function playGame(Team $homeTeam, Team $awayTeam): Score
    {
        $activeFixture = $this->fixtureRepository->getActiveFixture();
        $standingForHome = $this->standingsRepository->getTeam($activeFixture, $homeTeam);
        $standingForAway = $this->standingsRepository->getTeam($activeFixture, $awayTeam);

        $chanceFactorForHome = 1 / (rand(1, 100));
        $chanceFactorForAway = 1 / (rand(1, 100));
        $playingAtHomeMultiplier = 0.02;
        $homeStandingMultiplier = $standingForHome->points > $standingForAway->points ? 0.04 : 0;
        $awayStandingMultiplier = $standingForAway->points > $standingForHome->points ? 0.04 : 0;

        $homeTotal = $chanceFactorForHome + $playingAtHomeMultiplier + $homeStandingMultiplier;
        $awayTotal = $chanceFactorForAway + $awayStandingMultiplier;

        $score1 = random_int(1, $this->maxGoalPerMatch);
        $score2 = random_int(1, $score1);

        if ($homeTotal === $awayTotal) {
            $homeScore = $awayScore = $score2;
        } else {
            $homeScore = $homeTotal > $awayTotal ? $score1 : $score2;
            $awayScore = $homeTotal < $awayTotal ? $score1 : $score2;
        }

        $identifier = $homeScore > $awayScore ? 1 : ($awayScore > $homeScore ? 2 : 0);

        return new Score($homeScore, $awayScore, $identifier);
    }
}
