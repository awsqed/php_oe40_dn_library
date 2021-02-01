<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{

    public function paginate($perPage = null, $columns = ['*']);

    public function createUser($request);

    public function updateUser($userId, $request);

    public function deleteUser($userId);

    public function whereHasPermissions($permissions);

}
