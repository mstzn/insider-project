<?php

it('adds new game to database', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createFixtureRepositorySut();
    $fixture = $fixtureRepo->add([]);

    $repo = createGameRepositorySut();

    $game = new \App\Models\Game();
    $game->fixture_id = $fixture->id;
    $game->home_team_id = \App\Models\Team::where('id', 1)->first()['id'];
    $game->away_team_id = \App\Models\Team::where('id', 2)->first()['id'];
    $game->week = 1;

    $repo->add($game);
    $game->refresh();

    $this->assertEquals(\App\Models\Game::first()['id'], $game->id);

});

it('gets games for fixture week', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createFixtureRepositorySut();
    $fixture = $fixtureRepo->add(generateFixture());

    $fixture->refresh();

    $repo = createGameRepositorySut();

    $games = $repo->getGamesForFixtureWeek($fixture);

    foreach ($games as $game) {
        $this->assertEquals($game->week, $fixture->week);
    }

});

it('gets games for specific fixture week', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createFixtureRepositorySut();
    $fixture = $fixtureRepo->add(generateFixture());

    $fixture->refresh();

    $week = 2;

    $repo = createGameRepositorySut();

    $games = $repo->getGamesForSpecificFixtureWeek($fixture, $week);

    foreach ($games as $game) {
        $this->assertEquals($game->week, $week);
    }

});

it('gets played games for fixture', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createFixtureRepositorySut();
    $fixture = $fixtureRepo->add(generateFixture());

    $fixture->refresh();

    $repo = createGameRepositorySut();


    $games = $repo->getGamesForFixtureWeek($fixture);
    foreach ($games as $game) {
        $game->is_played = true;
        $game->update();
    }

    $games = $repo->getPlayedGamesForFixture($fixture);

    foreach ($games as $game) {
        $this->assertTrue((bool)$game->is_played);
    }

});

it('gets played team games for fixture', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createFixtureRepositorySut();
    $fixture = $fixtureRepo->add(generateFixture());

    $fixture->refresh();

    $repo = createGameRepositorySut();


    $games = $repo->getGamesForFixtureWeek($fixture);
    foreach ($games as $game) {
        $game->is_played = true;
        $game->update();
    }

    $team = \App\Models\Team::first();
    $games = $repo->getPlayedTeamGamesForFixture($fixture, $team);

    foreach ($games as $game) {
        $this->assertContains($team->id, [$game->home_team_id, $game->away_team_id]);
    }

});

it('clears all games', function () {

    $this->seed(\Database\Seeders\TeamSeeder::class);

    $fixtureRepo = createFixtureRepositorySut();
    $fixture = $fixtureRepo->add(generateFixture());

    $fixture->refresh();

    $repo = createGameRepositorySut();

    $repo->clearAll();

    $this->assertEquals(0, count(\App\Models\Game::all()));

});

function createGameRepositorySut()
{
    return new \App\Repositories\GameRepositoryMysqlImplementation();
}

function generateFixture()
{
    $gen = app()->get(\App\Interfaces\FixtureGeneratorInterface::class);
    $teams = \App\Models\Team::all();
    return $gen->generate($teams->toArray());
}
