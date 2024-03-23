<?php

namespace App\Http\Controllers;

use App\Http\Resources\FixtureResource;
use App\Interfaces\FixtureGeneratorInterface;
use App\Models\Fixture;
use App\Repositories\FixtureRepository;
use App\Repositories\TeamRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixtureController extends Controller
{
    protected FixtureGeneratorInterface $fixtureGenerator;
    protected TeamRepository $teamRepository;
    protected FixtureRepository $fixtureRepository;

    public function __construct(
        FixtureGeneratorInterface $fixtureGenerator,
        TeamRepository $teamRepository,
        FixtureRepository $fixtureRepository
    )
    {
        $this->fixtureGenerator = $fixtureGenerator;
        $this->teamRepository = $teamRepository;
        $this->fixtureRepository = $fixtureRepository;
    }

    public function generate(Request $request): FixtureResource
    {
        $teams = $this->teamRepository->all();
        $generatedFixture = $this->fixtureGenerator->generate($teams->toArray());
        $fixture = $this->fixtureRepository->store($generatedFixture);

        return FixtureResource::make($fixture);
    }

    public function show(Request $request, Fixture $fixture): FixtureResource
    {
        return FixtureResource::make($fixture);
    }
}
