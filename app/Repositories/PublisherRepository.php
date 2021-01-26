<?php

namespace App\Repositories;

use App\Models\Publisher;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\PublisherRepositoryInterface;

class PublisherRepository extends BaseRepository implements PublisherRepositoryInterface
{

    public function getModel()
    {
        return Publisher::class;
    }

    public function createPublisher($request)
    {
        $publisher = $this->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $publisher->image = $request->has('image')
                            ? $request->file('image')->store('images/publishers', 'public')
                            : config('app.default-image.publisher');

        return $publisher;
    }

    public function updatePublisher($publisherId, $request)
    {
        $this->update($publisherId, [
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $publisher = $this->find($publisherId);
        $publisher->image = $request->has('image')
                            ? $request->file('image')->store('images/publishers', 'public')
                            : config('app.default-image.publisher');
    }

}
