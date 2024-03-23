<?php

namespace App\Services\FixtureGeneration;

use App\Exceptions\TeamCountIsNotEvenException;
use App\Interfaces\FixtureGeneratorInterface;
use App\Models\Team;

class BasicFixtureGenerator implements FixtureGeneratorInterface
{
    /**
     * @param Team[] $teams
     * @throws TeamCountIsNotEvenException
     */
    public function generate(array $teams): array
    {
        if (count($teams) % 2 !== 0) {
            throw new TeamCountIsNotEvenException('Total team count must be even.');
        }
        $theTeam = array_pop($teams);
        $teamCount = count($teams);

        $roundsFirstHalf = [];
        $roundsSecondHalf = [];
        for ($i = 0; $i < $teamCount; $i++) {
            $roundsFirstHalf[$i][] = $this->getHomeAwayFormatted($theTeam, $teams[0]);
            $roundsSecondHalf[$i][] = $this->getHomeAwayFormatted($teams[0], $theTeam);
            for ($j = 0; $j < ($teamCount - 1) / 2; $j++) {
                $roundsFirstHalf[$i][] = $this->getHomeAwayFormatted($teams[$j + 1], $teams[$teamCount - $j-1]);
                $roundsSecondHalf[$i][] = $this->getHomeAwayFormatted($teams[$teamCount - $j-1], $teams[$j + 1]);
            }

            $teams = array_merge(array_splice($teams, -1), $teams);
        }

        return array_merge($roundsFirstHalf, $roundsSecondHalf);
    }

    private function getHomeAwayFormatted($homeTeam, $awayTeam): array
    {
        return [
            'home' => $homeTeam['id'],
            'away' => $awayTeam['id'],
        ];
    }
}
