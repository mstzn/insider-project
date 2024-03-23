<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Interfaces\TeamRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TeamController extends Controller
{
    protected TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $teams = $this->teamRepository->all();

        return TeamResource::collection($teams);
    }
}
