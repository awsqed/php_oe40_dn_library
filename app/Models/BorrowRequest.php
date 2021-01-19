<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BorrowRequest extends Pivot
{

    public $table = 'borrow_requests';

    public $incrementing = true;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

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

    public function scopeDefaultSort($query)
    {
        return $query->latest('created_at', 'from', 'to', 'returned_at');
    }

    public function scopeSearch($query, $search, $filter)
    {
        $configKey = 'app.borrow-request.status-code';

        if (!isset($filter) || $filter === '') {
            $filter = config("{$configKey}.new");
        }
        switch ($filter) {
            case 'all':
                break;

            case config("{$configKey}.accepted"):
            case config("{$configKey}.rejected"):
            case config("{$configKey}.returned"):
            case config("{$configKey}.returned-late"):
                $query->where('status', $filter);
                break;

            case config("{$configKey}.new"):
                $query->where('status', null);
                break;

            case config("{$configKey}.overdue"):
                $query->where('status', config("{$configKey}.accepted"))
                    ->where('returned_at', null)
                    ->where('to', '<', date('Y-m-d'));
                break;
        }

        if (!empty($search)) {
            $search = '%'. str_replace(' ', '%', $search ?: '') .'%';
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function (Builder $query) use ($search) {
                    $query->whereRaw('LOWER(first_name) like ?', "{$search}")
                            ->orWhereRaw('LOWER(last_name) like ?', "{$search}");
                })->orWhereHas('book', function (Builder $query) use ($search) {
                    $query->whereRaw('LOWER(title) like ?', "{$search}");
                });
            });
        }

        return $query;
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
