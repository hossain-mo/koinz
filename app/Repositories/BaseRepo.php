<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepo implements EloquentRepoInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseService constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findById(int $modelId): ?Model
    {
        return $this->model->findOrFail($modelId);
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    public function update(int $modelId, array $payload): ?Model
    {
        $model = $this->findById($modelId);

        $model->update($payload);

        return $model->fresh();
    }

    public function get()
    {
        return $this->model->get();
    }

}
