<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Services\Team\TeamServiceInterface;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected TeamServiceInterface $service;
    public function __construct(TeamServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(int $tournamentId)
    {
        $result = $this->service->allBy(['tournament_id' => $tournamentId]);

        return TeamResource::collection($result);
    }
}
