<?php

namespace App\Services;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseService implements BaseServiceInterface
{
    protected BaseRepositoryInterface $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function allBy($parameters): Collection
    {
        return $this->repository->allBy($parameters);
    }

    public function create($data): Model
    {
        return $this->repository->create($data);
    }
}
