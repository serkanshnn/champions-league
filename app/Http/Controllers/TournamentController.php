<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentStoreRequest;
use App\Services\Tournament\TournamentServiceInterface;
use Inertia\Inertia;

class TournamentController extends Controller
{
    protected TournamentServiceInterface $service;

    public function __construct(TournamentServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $result = $this->service->all();

        return Inertia::render('Tournaments', [
            'tournaments' => $result
        ]);
    }

    public function store(TournamentStoreRequest $request)
    {
        $parameters = $request->validationData();

        $result = $this->service->create($parameters);

        return redirect()->route('matches.getMatchListGroupedByWeek', ['tournamentId' => $result->id]);
    }
}
