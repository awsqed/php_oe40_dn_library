<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\BorrowRequest;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BorrowRequestController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('read-borrow-request');

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

        return view('dashboard.borrows.index', [
            'borrowRequests' => BorrowRequest::with('user', 'book')
                                ->search($request->search, $request->filter)->defaultSort()
                                ->paginate(config('app.num-rows'))->withQueryString(),
            'statusCode' => $statusCode,
            'selection' => $selection,
        ]);
    }

    public function update(Request $request, BorrowRequest $borrowRequest, $action)
    {
        $this->authorize('update-borrow-request');

        switch ($action) {
            case 'accept':
                $statusCode = config('app.borrow-request.status-code.accepted');
                $borrowRequest->processed_at = now();
                break;
            case 'reject':
                $statusCode = config('app.borrow-request.status-code.rejected');
                $borrowRequest->processed_at = now();
                break;
            case 'return':
                $statusCode = date('Y-m-d') > $borrowRequest->to
                                ? config('app.borrow-request.status-code.returned-late')
                                : config('app.borrow-request.status-code.returned');
                $borrowRequest->returned_at = now();
                break;
            default:
                return;
        }

        $borrowRequest->status = $statusCode;
        $borrowRequest->save();

        return view('layouts.dashboard.borrow-requests-table', [
            'borrowRequests' => BorrowRequest::with('user', 'book')
                                ->search($request->search, $request->filter)->defaultSort()
                                ->paginate(config('app.num-rows'))->withQueryString(),
        ])->render();
    }

}
