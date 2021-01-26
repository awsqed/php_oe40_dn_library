<?php

namespace App\Repositories\Interfaces;

interface PublisherRepositoryInterface extends RepositoryInterface
{

    public function createPublisher($request);

    public function updatePublisher($publisherId, $request);

}
