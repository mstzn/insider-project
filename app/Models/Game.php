<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $week
 * @property int $fixture_id
 * @property int $home_team_id
 * @property int $home_team_score
 * @property int $away_team_id
 * @property int $away_team_score
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Game extends Model
{
    use HasFactory;

    public function homeTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }

    public function awayTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'away_team_id');
    }
}
