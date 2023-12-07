<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentStoreRequest;
use App\Http\Resources\TournamentResource;
use App\Services\Tournament\TournamentServiceInterface;

class TournamentController extends Controller
{
    protected TournamentServiceInterface $service;

    public function __construct(TournamentServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(TournamentStoreRequest $request)
    {
        $parameters = $request->validationData();

        $result = $this->service->create($parameters);

        return new TournamentResource($result);
    }
}
