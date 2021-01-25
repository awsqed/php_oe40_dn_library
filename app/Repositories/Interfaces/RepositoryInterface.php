<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{

    public function all();

    public function find($id);

    public function create($attributes);

    public function update($id, $attributes);

    public function delete($id);

    public function paginate($perPage = null, $columns = ['*']);

}
