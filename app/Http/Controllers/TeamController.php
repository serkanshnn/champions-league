<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Services\Team\TeamServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    protected TeamServiceInterface $service;
    public function __construct(TeamServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $result = $this->service->all();

        $teams = TeamResource::collection($result);

        return Inertia::render('Teams', [
            'teams' => $teams
        ]);
    }
}
