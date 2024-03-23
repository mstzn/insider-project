<?php

namespace App\Interfaces;

use App\Models\Fixture;

interface PredictionGeneratorInterface {
    public function getPredictions(Fixture $fixture): array;
}
