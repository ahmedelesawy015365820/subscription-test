<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?Model;

    public function create(array $data): Model;

    public function update($id, array $data): bool;

    public function delete($id): bool;
}
