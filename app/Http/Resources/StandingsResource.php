<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $team_id
 * @property int $points
 * @property int $won
 * @property int $drawn
 * @property int $lost
 * @property int $goal_difference
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property Team team
 */
class StandingsResource extends JsonResource
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
            'team' => TeamResource::make($this->team),
            'points' => $this->points,
            'won' => $this->won,
            'drawn' => $this->drawn,
            'lost' => $this->lost,
            'goal_difference' => $this->goal_difference,
        ];
    }
}
