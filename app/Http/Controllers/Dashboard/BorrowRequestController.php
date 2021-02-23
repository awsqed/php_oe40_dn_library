<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class BorrowRequestController extends Controller
{

    public function __construct(BorrowRequestRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('read-borrow-request');

        $borrowRequests = $this->repository->search($request->search, $request->filter);

        $filter = $request->filter ?? '';
        $statusCode = [];
        $selection = [];
        foreach (config('app.borrow-request.status-code') as $key => $value) {
            $statusCode[$key] = $value;
            if ((empty($filter) || $filter == 'all') && $filter !== '0') {
                $selection[$key] = '';
            } else {
                $selection[$key] = $filter == $value ? 'selected' : '';
            }
        }

        return view('dashboard.borrows.index', compact('borrowRequests', 'statusCode', 'selection'));
    }

    public function update(Request $request, $borrowRequestId)
    {
        $this->authorize('update-borrow-request');

        $this->repository->updateBorrowRequest($borrowRequestId, $request->action);
        $borrowRequests = $this->repository->search($request->search, $request->filter);

        return view('layouts.dashboard.borrow-requests-table', compact('borrowRequests'))->render();
    }

    public function destroy($borrowRequestId)
    {
        $borrowRequest = $this->repository->find($borrowRequestId);
        if (!$borrowRequest->user()->is(Auth::user())) {
            abort(403);
        }

        if (!is_null($borrowRequest->status)) {
            abort(403);
        }

        $this->repository->delete($borrowRequestId);
    }

}
