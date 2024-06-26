<?php

namespace App\Interfaces;

use App\Models\Fixture;

interface FixtureRepositoryInterface
{
    public function add(array $fixtures): Fixture;

    public function getActiveFixture(): ?Fixture;

    public function markWeekAsCompleted(): void;

    public function clearAll();
}
