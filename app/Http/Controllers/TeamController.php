<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index(Request $request)
    {
        $teams = $this->teamRepository->all();

        return TeamResource::collection($teams);
    }
}
