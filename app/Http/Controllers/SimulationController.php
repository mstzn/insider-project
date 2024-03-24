<?php

namespace App\Http\Controllers;

use App\Exceptions\AllWeeksPlayedException;
use App\Exceptions\NoActiveFixtureFoundException;
use App\Http\Resources\SimulationResource;
use App\Interfaces\GameSimulatorInterface;
use App\Interfaces\PredictionGeneratorInterface;
use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\StandingsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class SimulationController extends Controller
{
    protected FixtureRepositoryInterface $fixtureRepository;
    protected GameRepositoryInterface $gameRepository;
    protected StandingsRepositoryInterface $standingsRepository;
    protected PredictionGeneratorInterface $predictionGenerator;
    protected GameSimulatorInterface $gameSimulator;

    public function __construct(
        FixtureRepositoryInterface   $fixtureRepository,
        GameRepositoryInterface      $gameRepository,
        StandingsRepositoryInterface $standingsRepository,
        PredictionGeneratorInterface $predictionGenerator,
        GameSimulatorInterface       $gameSimulator,
    )
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->gameRepository = $gameRepository;
        $this->standingsRepository = $standingsRepository;
        $this->predictionGenerator = $predictionGenerator;
        $this->gameSimulator = $gameSimulator;
    }

    public function index(Request $request): SimulationResource
    {
        $activeFixture = $this->fixtureRepository->getActiveFixture();

        if (empty($activeFixture)) {
            throw new NoActiveFixtureFoundException('No fixture generated yet!');
        }

        $week = $activeFixture->week;
        if ($activeFixture->week > 1 &&
            $activeFixture->week <= $activeFixture->total_weeks &&
            !$activeFixture->all_weeks_played) {
            $week = $activeFixture->week - 1;
        }

        $standings = $this->standingsRepository->get($activeFixture);
        $games = $this->gameRepository->getGamesForLastPlayedFixtureWeek($activeFixture, $week);
        $predictions = $this->predictionGenerator->getPredictions($activeFixture);

        return SimulationResource::make([
            'week' => $week,
            'standings' => $standings,
            'schedule' => $games,
            'predictions' => $predictions,
        ]);
    }

    public function playNextWeek(Request $request): SimulationResource
    {
        $activeFixture = $this->fixtureRepository->getActiveFixture();
        if ($activeFixture->all_weeks_played) {
            throw new AllWeeksPlayedException('All games for this fixture already played.');
        }

        $this->playCurrentWeekGamesForFixture();

        return $this->index($request);

    }

    public function playAllWeeks(Request $request): SimulationResource
    {
        $activeFixture = $this->fixtureRepository->getActiveFixture();
        if ($activeFixture->all_weeks_played) {
            throw new AllWeeksPlayedException('All games for this fixture already played.');
        }

        for ($i = $activeFixture->week; $i <= $activeFixture->total_weeks; $i++) {
            $this->playCurrentWeekGamesForFixture();
        }

        return $this->index($request);
    }

    private function playCurrentWeekGamesForFixture(): void
    {
        $activeFixture = $this->fixtureRepository->getActiveFixture();
        $games = $this->gameRepository->getGamesForFixtureWeek($activeFixture);

        foreach ($games as $game) {
            $score = $this->gameSimulator->playGame($game->homeTeam, $game->awayTeam);
            $game->home_team_score = $score->getHomeTeamScore();
            $game->away_team_score = $score->getAwayTeamScore();
            $game->is_played = true;
            $game->update();
        }

        $this->fixtureRepository->markWeekAsCompleted();

        $this->standingsRepository->update($activeFixture);
    }

    public function resetData(Request $request): JsonResponse
    {
        $this->fixtureRepository->clearAll();
        $this->gameRepository->clearAll();
        $this->standingsRepository->clearAll();

        return response()->json([], Response::HTTP_OK);
    }
}
