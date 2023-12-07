<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatchResource;
use App\Services\Match\MatchServiceInterface;
use Inertia\Inertia;

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

        return Inertia::render('MatchList', [
            'weekMatches' => $result
        ]);
    }

    public function getMatchListByWeek(int $tournamentId, $week)
    {
        $matches = $this->service->allBy(['tournament_id' => $tournamentId, 'week' => $week]);

        $stats = $this->service->getStatsByTeams($tournamentId, $week);

        $estimations = $this->service->winEstimation($tournamentId, $week);

        return Inertia::render('Week', [
            'matches' => MatchResource::collection($matches),
            'stats' => $stats,
            'estimations' => $estimations
        ]);
    }

    public function playWeek(int $tournamentId, $week)
    {
        $this->service->playWeek($tournamentId, $week);

        return redirect()->route('tournaments.match.getMatchListByWeek', ['tournamentId' => $tournamentId, 'week' => $week]);
    }

    public function playAll(int $tournamentId)
    {
        $this->service->playAll($tournamentId);

        return redirect()->route('matches.getMatchListGroupedByWeek', ['tournamentId' => $tournamentId]);
    }
}
