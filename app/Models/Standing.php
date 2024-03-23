<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $fixture_id
 * @property int $team_id
 * @property int $points
 * @property int $won
 * @property int $drawn
 * @property int $lost
 * @property int $goal_difference
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Standing extends Model
{
    use HasFactory;

    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

}
