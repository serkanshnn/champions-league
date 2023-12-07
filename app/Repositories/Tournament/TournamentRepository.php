<?php

namespace App\Repositories\Tournament;


use App\Models\Tournament;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TournamentRepository extends BaseRepository implements TournamentRepositoryInterface {

    public function __construct()
    {
        parent::__construct(Tournament::class);
    }

    public function all(): Collection
    {
        return $this->model::orderBy('id', 'DESC')->get();
    }
}
