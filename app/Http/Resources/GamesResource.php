<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GamesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fixture_id' => $this->fixture_id,
            'home_team' => TeamResource::make($this->homeTeam),
            'away_team' => TeamResource::make($this->awayTeam),
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
        ];
    }
}
