<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimulationResource;
use App\Interfaces\PredictionGeneratorInterface;
use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\StandingsRepositoryInterface;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    protected FixtureRepositoryInterface $fixtureRepository;
    protected GameRepositoryInterface $gameRepository;
    protected StandingsRepositoryInterface $standingsRepository;
    protected PredictionGeneratorInterface $predictionGenerator;

    public function __construct(
        FixtureRepositoryInterface $fixtureRepository,
        GameRepositoryInterface $gameRepository,
        StandingsRepositoryInterface $standingsRepository,
        PredictionGeneratorInterface $predictionGenerator
    )
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->gameRepository = $gameRepository;
        $this->standingsRepository = $standingsRepository;
        $this->predictionGenerator = $predictionGenerator;
    }

    public function index(Request $request)
    {
        $activeFixture = $this->fixtureRepository->getActiveFixture();
        $standings = $this->standingsRepository->get($activeFixture);
        $games = $this->gameRepository->getGamesForFixtureWeek($activeFixture);
        $predictions = $this->predictionGenerator->getPredictions($activeFixture);

        return SimulationResource::make([
            'week' => $activeFixture->week,
            'standings' => $standings,
            'schedule' => $games,
            'predictions' => $predictions,
        ]);
    }
}
