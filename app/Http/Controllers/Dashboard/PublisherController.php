<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherRequest;
use App\Repositories\Interfaces\PublisherRepositoryInterface;

class PublisherController extends Controller
{

    public function __construct(PublisherRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->authorize('read-publisher');

        $publishers = $this->repository->paginate();

        return view('dashboard.publishers.index', compact('publishers'));
    }

    public function create()
    {
        $this->authorize('create-publisher');

        return view('dashboard.publishers.create');
    }

    public function store(PublisherRequest $request)
    {
        $this->repository->createPublisher($request);

        return redirect()
                ->route('publishers.index')
                ->with('success', trans('publishers.messages.publisher-created'));
    }

    public function edit($publisherId)
    {
        $this->authorize('update-publisher');

        $publisher = $this->repository->find($publisherId);

        return view('dashboard.publishers.edit', compact('publisher'));
    }

    public function update(PublisherRequest $request, $publisherId)
    {
        $this->repository->updatePublisher($publisherId, $request);

        return redirect()
                ->route('publishers.index')
                ->with('success', trans('publishers.messages.publisher-edited'));
    }

    public function destroy($publisherId)
    {
        $this->authorize('delete-publisher');

        $this->repository->delete($publisherId);

        return back();
    }

}
