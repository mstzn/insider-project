<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int fixture_id
 * @property Team homeTeam
 * @property Team awayTeam
 * @property int home_team_score
 * @property int away_team_score
 * @property int week
 * @property boolean is_played
 */
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
            'week' => $this->week,
            'is_played' => $this->is_played,
        ];
    }
}
