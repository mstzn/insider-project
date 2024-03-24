<?php

namespace App\Providers;

use App\Interfaces\FixtureGeneratorInterface;
use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\GameSimulatorInterface;
use App\Interfaces\PredictionGeneratorInterface;
use App\Interfaces\StandingsRepositoryInterface;
use App\Interfaces\TeamRepositoryInterface;
use App\Repositories\FixtureRepositoryMysqlImplementation;
use App\Repositories\GameRepositoryMysqlImplementation;
use App\Repositories\StandingsRepositoryMysqlImplementation;
use App\Repositories\TeamRepositoryMysqlImplementation;
use App\Services\FixtureGeneration\BasicFixtureGenerator;
use App\Services\GameSimulation\BasicGameSimulator;
use App\Services\PredictionGeneration\BasicPredictionGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FixtureGeneratorInterface::class, function (): FixtureGeneratorInterface {
            return new BasicFixtureGenerator();
        });

        $this->app->singleton(GameRepositoryInterface::class, function (): GameRepositoryInterface {
            return new GameRepositoryMysqlImplementation();
        });

        $this->app->singleton(TeamRepositoryInterface::class, function (): TeamRepositoryInterface {
            return new TeamRepositoryMysqlImplementation();
        });

        $this->app->singleton(FixtureRepositoryInterface::class, function (): FixtureRepositoryInterface {
            return new FixtureRepositoryMysqlImplementation(
                $this->app->get(GameRepositoryInterface::class)
            );
        });

        $this->app->singleton(StandingsRepositoryInterface::class, function (): StandingsRepositoryInterface {
            return new StandingsRepositoryMysqlImplementation(
                $this->app->get(GameRepositoryInterface::class)
            );
        });

        $this->app->singleton(GameSimulatorInterface::class, function (): GameSimulatorInterface {
            return new BasicGameSimulator(
                $this->app->get(FixtureRepositoryInterface::class),
                $this->app->get(StandingsRepositoryInterface::class),
            );
        });

        $this->app->singleton(PredictionGeneratorInterface::class, function (): PredictionGeneratorInterface {
            return new BasicPredictionGenerator(
                $this->app->get(StandingsRepositoryInterface::class)
            );
        });
    }
}
