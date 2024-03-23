<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property boolean $is_active
 * @property int $week
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Fixture extends Model
{
    use HasFactory;

    public function games(): HasMany {
        return $this->hasMany(Game::class);
    }

    public function teams(): HasManyThrough
    {
        return $this->hasManyThrough(Team::class, Game::class, 'fixture_id', 'id', 'id', 'home_team_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

}
