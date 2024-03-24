<?php

namespace App\ValueObjects;

class Score
{
    protected int $homeTeamScore = 0;
    protected int $awayTeamScore = 0;

    protected int $resultIdentifier = 0;

    public function __construct($homeTeamScore = 0, $awayTeamScore = 0, $resultIdentifier = 0)
    {
        $this->homeTeamScore = $homeTeamScore;
        $this->awayTeamScore = $awayTeamScore;
        $this->resultIdentifier = $resultIdentifier;
    }

    public function getHomeTeamScore(): int
    {
        return $this->homeTeamScore;
    }

    public function getAwayTeamScore(): int
    {
        return $this->awayTeamScore;
    }

    public function __toString(): string
    {
        return json_encode([
            'home' => $this->homeTeamScore,
            'away' =>  $this->awayTeamScore,
        ]);
    }

    public function getResultIdentifier(): int
    {
        return $this->resultIdentifier;
    }

}
