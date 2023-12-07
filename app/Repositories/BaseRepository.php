<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model::all();
    }
    public function allBy($parameters): Collection
    {
        return $this->model::where($parameters)->get();
    }

    public function find($id): Model
    {
        return $this->model::find($id);
    }

    public function create($data): Model
    {
        return $this->model::create($data);
    }

    public function update($id, $data): bool
    {
        $model = $this->find($id);

        return $model->update($data);
    }
}
