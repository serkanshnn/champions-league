<?php

namespace App\Services\Match;

use App\Services\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MatchServiceInterface extends BaseServiceInterface
{
    public function generateFixture($teams, $tournamentId): array;
    public function getMatchListGroupedByWeek($tournamentId): array;
    public function getStatsByTeam($team, $tournamentId): Model;
    public function playMatch(int $matchId): array;
    public function winEstimation(array $teamIds, int $tournamentId): array;
}
