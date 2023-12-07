<?php

namespace App\Services\Match;

use App\Services\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MatchServiceInterface extends BaseServiceInterface
{
    public function generateFixture($tournamentId): array;
    public function getMatchListGroupedByWeek($tournamentId): array;
    public function getStatsByTeams($tournamentId, $week): array;
    public function playMatch(int $matchId, $week): array;
    public function playWeek(int $tournamentId, $week): bool;
    public function playAll(int $tournamentId): bool;
    public function winEstimation(int $tournamentId, $week): array;
}
