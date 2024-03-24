<?php

use App\Exceptions\NoActiveFixtureFoundException;
use App\Repositories\FixtureRepositoryMysqlImplementation;
use App\Repositories\GameRepositoryMysqlImplementation;
use Illuminate\Http\JsonResponse;


it('simulation endpoint throw 404 response if no fixture generated', function () {

    $response = $this->get('/api/simulation');

    $response->assertStatus(404);

});

it('simulation endpoint return success response if a fixture generated', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createSimulationControllerSut();

    $this->get('/api/fixtures/generate');

    $activeFixture = $fixtureRepo->getActiveFixture();

    $response = $this->get('/api/simulation');

    $response->assertStatus(200);

    $jsonResponse = $response->json()['data'];

    $this->assertEquals($activeFixture->week, $jsonResponse['week']);

});

it('playNextWeek endpoint return success response if a fixture generated', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createSimulationControllerSut();

    $this->get('/api/fixtures/generate');

    $activeFixture = $fixtureRepo->getActiveFixture();

    $response = $this->get('/api/simulation/play-next-week');

    $response->assertStatus(200);

    $jsonResponse = $response->json()['data'];

    $activeFixture->refresh();

    $this->assertNotEquals($activeFixture->week, $jsonResponse['week']);

});

it('playAllWeeks endpoint return success response if a fixture generated', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createSimulationControllerSut();

    $this->get('/api/fixtures/generate');

    $activeFixture = $fixtureRepo->getActiveFixture();

    $response = $this->get('/api/simulation/play-all-weeks');

    $response->assertStatus(200);

    $jsonResponse = $response->json()['data'];

    $activeFixture->refresh();

    $this->assertEquals($activeFixture->week, $jsonResponse['week']);


    $this->assertTrue((bool)$activeFixture->all_weeks_played);

});

it('resetData endpoint return success response and clear all data', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createSimulationControllerSut();

    $this->get('/api/fixtures/generate');

    $response = $this->get('/api/simulation/reset-data');

    $response->assertStatus(200);

    $this->assertEquals(0, count(\App\Models\Game::all()));
    $this->assertEquals(0, count(\App\Models\Standing::all()));
    $this->assertEquals(0, count(\App\Models\Fixture::all()));

});

function createSimulationControllerSut(): FixtureRepositoryMysqlImplementation
{
    $gameRepository = Mockery::mock(GameRepositoryMysqlImplementation::class);
    return new FixtureRepositoryMysqlImplementation($gameRepository);
}
