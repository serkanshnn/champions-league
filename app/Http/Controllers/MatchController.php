<?php

namespace App\Http\Controllers;

use App\Services\Match\MatchServiceInterface;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    protected MatchServiceInterface $service;
    public function __construct(MatchServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getMatchListGroupedByWeek(int $tournamentId)
    {
        $result = $this->service->getMatchListGroupedByWeek($tournamentId);

        return response()->json(['data' => $result]);
    }

    public function playMatch(int $matchId)
    {
        $result = $this->service->playMatch($matchId);

        return response()->json(['data' => $result]);
    }
}
