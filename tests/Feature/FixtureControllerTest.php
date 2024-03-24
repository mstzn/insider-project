<?php

use App\Repositories\FixtureRepositoryMysqlImplementation;
use App\Repositories\GameRepositoryMysqlImplementation;
use Illuminate\Http\JsonResponse;


it('fixtures/generate endpoint generates new fixture and returns success response', function () {

    $fixtureRepo = createSut();

    $response = $this->get('/api/fixtures/generate');

    $response->assertStatus(201);

    $newFixture = $fixtureRepo->getActiveFixture();

    $this->assertEquals(1, $newFixture->is_active);

});

it('fixtures/generate endpoint generates new fixture, set old fixtures passive and returns success response', function () {

    $fixtureRepo = createSut();

    $this->get('/api/fixtures/generate');

    $activeFixture = $fixtureRepo->getActiveFixture();

    $response = $this->get('/api/fixtures/generate');

    $response->assertStatus(201);

    $newFixture = $fixtureRepo->getActiveFixture();

    $activeFixture->refresh();

    $this->assertNotEquals($newFixture->id, $activeFixture->id);
    $this->assertEquals(1, $newFixture->is_active);

    $this->assertEquals(0, $activeFixture->is_active);

});

it('fixture show endpoint returns success response', closure: function () {

    $fixtureRepo = createSut();

    $this->get('/api/fixtures/generate');

    $activeFixture = $fixtureRepo->getActiveFixture();

    $response = $this->get('/api/fixtures/show/' . $activeFixture->id);

    $response->assertStatus(200);

    $jsonResponse = $response->json()['data'];

    $this->assertEquals($activeFixture->id, $jsonResponse['id']);

});


function createSut(): FixtureRepositoryMysqlImplementation
{
    $gameRepository = Mockery::mock(GameRepositoryMysqlImplementation::class);
    return new FixtureRepositoryMysqlImplementation($gameRepository);
}
