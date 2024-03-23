<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepositoryMysqlImplementation implements TeamRepositoryInterface
{
    public function all(): Collection
    {
        return Team::all();
    }
}
