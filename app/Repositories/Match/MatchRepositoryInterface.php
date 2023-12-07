<?php

namespace App\Repositories\Match;

use Illuminate\Support\Collection;

interface MatchRepositoryInterface {
    public function allMatchesPlayedBy($teamId, $tournamentId, $week): Collection;
}
