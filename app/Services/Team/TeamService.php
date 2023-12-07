<?php

namespace App\Services\Team;


use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Services\BaseService;
use App\Services\Match\MatchServiceInterface;
use Illuminate\Support\Collection;

class TeamService extends BaseService implements TeamServiceInterface {
    protected MatchServiceInterface $matchService;
    public function __construct(TeamRepositoryInterface $repository, MatchServiceInterface $matchService)
    {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->matchService = $matchService;
    }

    public function allBy($parameters): Collection
    {
        $teams = $this->repository->all();

        foreach ($teams as &$team) {
            $team = $this->matchService->getStatsByTeam($team, $parameters['tournament_id']);
        }

        return $teams;
    }
}
