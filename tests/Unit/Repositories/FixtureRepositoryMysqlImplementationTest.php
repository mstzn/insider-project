<?php

it('adds new fixture and set old ones passive', function () {
    $repo = createFixtureRepositorySut();
    $oldFixture = $repo->add([]);

    $newFixture = $repo->add([]);

    $oldFixture->refresh();

    $this->assertFalse((bool)$oldFixture->is_active);
    $this->assertTrue((bool)$newFixture->is_active);
});

it('gets active fixture', function () {
    $repo = createFixtureRepositorySut();
    $someFixture1 = $repo->add([]);
    $someFixture2 = $repo->add([]);
    $activeFixture = $repo->add([]);

    $actual = $repo->getActiveFixture();

    $this->assertEquals($activeFixture->id, $actual->id);
});

it('marks week of fixture is completed', function () {
    $repo = createFixtureRepositorySut();
    $addedFixture = $repo->add([]);

    $repo->markWeekAsCompleted();

    $actual = $repo->getActiveFixture();

    $this->assertNotEquals($addedFixture->week, $actual->week);
    $this->assertEquals($addedFixture->id, $actual->id);
});

it('clear all the fixture data', function () {
    $repo = createFixtureRepositorySut();
    $addedFixture = $repo->add([]);
    $addedFixture = $repo->add([]);
    $addedFixture = $repo->add([]);
    $addedFixture = $repo->add([]);
    $addedFixture = $repo->add([]);

    $repo->clearAll();

    $this->assertEquals(0, count(\App\Models\Fixture::all()));
});

function createFixtureRepositorySut()
{
    $gameRepo = app()->get(\App\Interfaces\GameRepositoryInterface::class);
    return new \App\Repositories\FixtureRepositoryMysqlImplementation($gameRepo);
}
