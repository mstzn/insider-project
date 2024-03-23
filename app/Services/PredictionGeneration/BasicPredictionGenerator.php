<?php

namespace App\Services\PredictionGeneration;

use App\Interfaces\PredictionGeneratorInterface;
use App\Interfaces\StandingsRepositoryInterface;
use App\Models\Fixture;

class BasicPredictionGenerator implements PredictionGeneratorInterface
{
    protected StandingsRepositoryInterface $standingsRepository;

    public function __construct(StandingsRepositoryInterface $standingsRepository)
    {
        $this->standingsRepository = $standingsRepository;
    }

    public function getPredictions(Fixture $fixture): array
    {
        $currentWeek = $fixture->week;
        $totalPoints = $currentWeek * 3;

        $standings = $this->standingsRepository->get($fixture);

        $predictions = [];
        foreach ($standings as $standing) {
            $teamPoint = $standing->points;
            $predictions[] = [
                'team' => $standing->team,
                'prediction' => round(100 / $totalPoints) * $teamPoint,
            ];
        }

        return $predictions;
    }
}
