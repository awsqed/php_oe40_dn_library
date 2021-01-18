<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BorrowRequest extends Pivot
{

    public $table = 'borrow_requests';

    public $incrementing = true;

    protected $guarded = [];

    public function getStatusTextAttribute()
    {
        switch ($this->status ?? -1) {
            case config('app.borrow-request.status-code.rejected'):
                return trans('library.borrow.rejected');

            case config('app.borrow-request.status-code.accepted'):
                return date('Y-m-d') > $this->to
                        ? trans('library.borrow.overdue')
                        : trans('library.borrow.borrowing');

            case config('app.borrow-request.status-code.returned'):
                return trans('library.borrow.returned');

            case config('app.borrow-request.status-code.returned-late'):
                return trans('library.borrow.returned-late');

            default:
                return trans('library.borrow.processing');
        }
    }

    public function getNoteTextAttribute()
    {
        Carbon::setLocale(app()->getLocale());
        $to = new Carbon($this->to);

        $status = $this->status ?? -1;
        if ($status == config('app.borrow-request.status-code.accepted') && $to->isPast(now())) {
            return trans('library.borrow.overdue') .' ('. trans_choice('library.borrow.days-late', $to->diffInDays(now())) .')';
        }

        if ($status == config('app.borrow-request.status-code.returned-late')) {
            $returnedAt = new Carbon($this->returned_at);
            return $this->note .' ('. trans_choice('library.borrow.days-late', $to->diffInDays($returnedAt)) .')';
        }

        return $this->note;
    }

    static public function getLatestProcessing(User $user, Book $book)
    {
        $borrowRequest = $user->bookBorrowRequests()
                                ->where('book_id', $book->id)
                                ->where('status', null)
                                ->latest()
                                ->first();

        return optional($borrowRequest)->pivot;
    }

    static public function getCurrentBorrowing(User $user, Book $book)
    {
        $borrowRequest = $user->bookBorrowRequests()
                                ->where('book_id', $book->id)
                                ->where('status', config('app.borrow-request.status-code.accepted'))
                                ->where('returned_at', null)
                                ->latest()
                                ->first();

        return optional($borrowRequest)->pivot;
    }

}
