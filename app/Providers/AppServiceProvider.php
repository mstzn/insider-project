<?php

namespace App\Providers;

use App\Interfaces\FixtureGeneratorInterface;
use App\Services\FixtureGeneration\CircleFixtureGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FixtureGeneratorInterface::class, function () {
            return new CircleFixtureGenerator();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
