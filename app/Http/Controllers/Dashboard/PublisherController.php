<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Publisher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PublisherRequest;

class PublisherController extends Controller
{

    public function index()
    {
        $this->authorize('read-publisher');

        return view('dashboard.publishers.index', [
            'publishers' => Publisher::paginate(config('app.num-rows')),
        ]);
    }

    public function create()
    {
        $this->authorize('create-publisher');

        return view('dashboard.publishers.create');
    }

    public function store(PublisherRequest $request)
    {
        $publisher = Publisher::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/publishers', 'public')
                        : config('app.default-image.publisher');
        $publisher->image()->create([
            'path' => $imagePath,
        ]);

        return back()->with('success', trans('publishers.messages.publisher-created'));
    }

    public function edit(Publisher $publisher)
    {
        $this->authorize('update-publisher');

        return view('dashboard.publishers.edit', [
            'publisher' => $publisher,
        ]);
    }

    public function update(PublisherRequest $request, Publisher $publisher)
    {
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->save();

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/publishers', 'public')
                        : config('app.default-image.publisher');

        $image = $publisher->image();
        if ($publisher->image) {
            if ($imagePath != config('app.default-image.publisher')) {
                $image->update([
                    'path' => $imagePath,
                ]);
            }
        } else {
            $image->create([
                'path' => $imagePath,
            ]);
        }
        Cache::forget("publisher-{$publisher->id}-logo");

        return back()->with('success', trans('publishers.messages.publisher-edited'));
    }

    public function destroy(Publisher $publisher)
    {
        $this->authorize('delete-publisher');

        $publisher->delete();

        return back();
    }

}
