<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property array games
 */
class FixtureResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $weekGroupedGames = [];
        foreach ($this->games as $game) {
            $weekGroupedGames[$game->week][] = $game;
        }

        $fixtureGames = [];
        foreach ($weekGroupedGames as $week => $games) {
            $fixtureGames[] = [
                "week" => $week,
                "games" => GamesResource::collection($games),
            ];
        }

        return [
            'id' => $this->id,
            'fixture' => $fixtureGames,
        ];
    }
}
