<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepoInterface
{
    public function findById(int $modelId): ?Model;

    public function create(array $payload): ?Model;

    public function update(int $modelId, array $payload): ?Model;

    public function get();
}
