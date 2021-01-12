@auth
    @if (App\Models\BorrowRequest::getLatestProcessing($user, $book))
        <a href="{{ route('library.borrow.history') }}" class="text-center text-uppercase text-primary font-weight-bold mt-3">
            {{ trans('library.borrow.under-process') }}
        </a>
    @elseif ($borrowRequest = App\Models\BorrowRequest::getCurrentBorrowing($user, $book))
        <table class="table text-center text-uppercase">
            <tr class="font-weight-bold">
                <td colspan="2">
                    @if ($borrowRequest->status_text == trans('library.borrow.overdue'))
                        <a href="{{ route('library.borrow.history') }}" class="text-danger">
                            {{ trans('library.borrow.overdue-book') }}
                    @else
                        <a href="{{ route('library.borrow.history') }}" class="text-success">
                            {{ trans('library.borrow.are-borrowing') }}
                    @endif
                        </a>
                </td>
            </tr>
            <tr>
                <th><strong>{{ trans('library.borrow.return-date') }}</strong></th>
                <td>{{ $borrowRequest->to }}</td>
            </tr>
        </table>
    @else
        <button class="btn btn-block btn-lg btn-outline-dark mt-2" data-toggle="modal" data-target="#borrow-modal">
            {{ trans('library.borrow.borrow-this-book') }}
        </button>
        @include('layouts.home.borrow-modal')
    @endif
@endauth
