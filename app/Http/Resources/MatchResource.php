<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
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
            'week' => $this->week,
            'tournament_id' => $this->tournament_id,
            'home_team' => $this->homeTeam->name,
            'away_team' => $this->awayTeam->name,
            'home_team_goals' => $this->home_team_goals,
            'away_team_goals' => $this->away_team_goals,
            'is_match_played' => $this->is_match_played
        ];
    }
}
