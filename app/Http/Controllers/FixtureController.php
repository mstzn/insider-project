<?php

namespace App\Http\Controllers;

use App\Http\Resources\FixtureResource;
use App\Interfaces\FixtureGeneratorInterface;
use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\StandingsRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;
use App\Models\Fixture;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    protected FixtureGeneratorInterface $fixtureGenerator;
    protected TeamRepositoryInterface $teamRepository;
    protected StandingsRepositoryInterface $standingsRepository;
    protected FixtureRepositoryInterface $fixtureRepository;

    public function __construct(
        FixtureGeneratorInterface            $fixtureGenerator,
        TeamRepositoryInterface    $teamRepository,
        StandingsRepositoryInterface $standingsRepository,
        FixtureRepositoryInterface $fixtureRepository
    )
    {
        $this->fixtureGenerator = $fixtureGenerator;
        $this->teamRepository = $teamRepository;
        $this->standingsRepository = $standingsRepository;
        $this->fixtureRepository = $fixtureRepository;
    }

    public function generate(Request $request): FixtureResource
    {
        $teams = $this->teamRepository->all();
        $generatedFixture = $this->fixtureGenerator->generate($teams->toArray());
        $fixture = $this->fixtureRepository->add($generatedFixture);
        $this->standingsRepository->add($fixture, $teams->toArray());

        return FixtureResource::make($fixture);
    }

    public function show(Request $request, Fixture $fixture): FixtureResource
    {
        return FixtureResource::make($fixture);
    }
}
