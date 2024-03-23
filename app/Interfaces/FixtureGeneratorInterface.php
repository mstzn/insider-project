<?php

namespace App\Interfaces;

interface FixtureGeneratorInterface {

    public function generate(array $teams): array;

}
