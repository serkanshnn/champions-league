<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseServiceInterface
{
    public function all(): Collection;
    public function allBy($parameters): Collection;
    public function create($data): Model;
}
