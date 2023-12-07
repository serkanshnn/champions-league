<?php

namespace App\Repositories\Match;


use App\Models\BaseMatch;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MatchRepository extends BaseRepository implements MatchRepositoryInterface {

    public function __construct()
    {
        parent::__construct(BaseMatch::class);
    }

    public function allMatchesPlayedBy($teamId, $tournamentId, $week): Collection
    {
        return $this->model::where(function ($query) use ($teamId) {
            $query->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId);
        })->where('tournament_id', $tournamentId)
            ->where('week', '<=', $week)
            ->where('is_match_played', true)
            ->get();
    }
}
