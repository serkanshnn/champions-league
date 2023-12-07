<?php

namespace App\Services\Team;


use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Services\BaseService;
use App\Services\Match\MatchServiceInterface;
use Illuminate\Support\Collection;

class TeamService extends BaseService implements TeamServiceInterface {
    public function __construct(TeamRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
}
