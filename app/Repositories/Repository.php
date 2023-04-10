<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $eloquent;

    public function model(): Model
    {
        if (!$this->eloquent) {
            throw new Exception('No eloquent set for ' . get_class($this));
        }
        return new $this->eloquent;
    }

    public function all(): Collection
    {
        return $this->model()->all();
    }


    public function findOrFail(int $id)
    {
        return $this->model()->findOrFail($id);
    }


    public function find(int $id)
    {
        return $this->model()->find($id);
    }

    public function create(array $params)
    {
        return $this->model()->create($params);
    }

    public function update(array $params): bool
    {
        return $this->find($params['id'])->update($params);
    }

    public function findAndDelete(int $id): bool|null
    {
        return $this->find($id)?->delete();
    }

    public function delete($model): bool|null
    {
        return $model->delete();
    }
}
