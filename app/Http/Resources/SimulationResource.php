<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimulationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $predictions = [];
        foreach ($this['predictions'] as $prediction) {
            $predictions[] = [
                'prediction' => $prediction['prediction'],
                'team' => TeamResource::make($prediction['team'])
            ];
        }

        usort($predictions, function ($a, $b) {
            return $a['prediction'] < $b['prediction'];
        });

        return [
            'week' => $this['week'],
            'standings' => StandingsResource::collection($this['standings']),
            'schedule' => GamesResource::collection($this['schedule']),
            'predictions' => $predictions
        ];
    }
}
