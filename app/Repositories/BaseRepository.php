<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = app()->make($this->getModel());
    }

    abstract public function getModel();

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function paginate($perPage = null, $columns = ['*'])
    {
        $perPage = $perPage ?? config('app.num-rows');

        return $this->model->paginate($perPage, $columns);
    }

}
