<?php

namespace App\Services\Tournament;


use App\Models\Tournament;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Tournament\TournamentRepositoryInterface;
use App\Services\BaseService;
use App\Services\Match\MatchServiceInterface;
use App\Services\Team\TeamServiceInterface;
use Illuminate\Database\Eloquent\Model;

class TournamentService extends BaseService implements TournamentServiceInterface {
    protected MatchServiceInterface $matchService;
    protected TeamServiceInterface $teamService;
    public function __construct(TournamentRepositoryInterface $repository, MatchServiceInterface $matchService, TeamServiceInterface $teamService)
    {
        parent::__construct($repository);
        $this->repository = $repository;
        $this->matchService = $matchService;
        $this->teamService = $teamService;
    }

    public function create($data): Model
    {
        /** @var Tournament $result */
        $result = $this->repository->create($data);

        // Generate Fixture
        $this->matchService->generateFixture($result->id);

        return $result;
    }
}
