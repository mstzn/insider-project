<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $week
 * @property int $home_team_id
 * @property int $home_team_score
 * @property int $away_team_id
 * @property int $away_team_score
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Fixture extends Model
{
    use HasFactory;
}
