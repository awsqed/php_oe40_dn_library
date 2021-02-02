<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BorrowRequest extends Pivot
{

    protected $table = 'borrow_requests';

    public $incrementing = true;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status ?? -1) {
            case config('app.borrow-request.status-code.rejected'):
                return trans('library.borrow.rejected');

            case config('app.borrow-request.status-code.accepted'):
                return now()->toDateString() > $this->to
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

    public function scopeDefaultSort($query)
    {
        return $query->latest('created_at', 'from', 'to', 'returned_at');
    }

}
