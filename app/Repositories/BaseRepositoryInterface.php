<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface {
    public function all(): Collection;
    public function allBy($parameters): Collection;
    public function find($id): Model;
    public function create($data): Model;
    public function update($id, $data): bool;
}
