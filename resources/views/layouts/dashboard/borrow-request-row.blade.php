@php
    switch ($record->status_text) {
        case trans('library.borrow.processing'):
            $context = 'table-default';
            break;
        case trans('library.borrow.rejected'):
            $context = 'table-secondary';
            break;
        case trans('library.borrow.overdue'):
            $context = 'table-danger';
            break;
        case trans('library.borrow.returned-late'):
            $context = 'table-warning';
            break;
        case trans('library.borrow.returned'):
            $context = 'table-success';
            break;
        default;
            $context = 'table-primary';
    }
@endphp
<tr id="row-{{ $record->id }}" class="text-center {{ $context }}">
    <td class="align-middle">{{ $record->user->fullname }}</td>
    <td class="align-middle">
        <a href="{{ route('library.book', $record->book) }}" class="text-reset text-decoration-none">
            {{ Str::title($record->book->title) }}
        </a>
    </td>
    <td class="align-middle">{{ $record->from }}</td>
    <td class="align-middle">{{ $record->to }}</td>
    <td class="align-middle">{{ $record->returned_at }}</td>
    <td class="align-middle">{{ $record->status_text }}</td>
    <td class="align-middle">{{ $record->note_text }}</td>
    @can('update-borrow-request')
        <td class="align-middle text-left">
            @if ($record->status === null)
                <button class="btn btn-link btn-accept p-0 text-success text-uppercase font-weight-bold" value="{{ $record->id }}">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ trans('borrows.accept') }}
                </button>
                <br/>
                <button class="btn btn-link btn-reject p-0 text-danger text-uppercase font-weight-bold" value="{{ $record->id }}">
                    <i class="fas fa-times-circle mr-1"></i>
                    {{ trans('borrows.reject') }}
                </button>
            @endif

            @if ($record->status === config('app.borrow-request.status-code.accepted'))
                <button class="btn btn-link btn-return p-0 text-primary text-uppercase font-weight-bold" value="{{ $record->id }}">
                    <i class="fas fa-clipboard-check mr-1"></i>
                    {{ trans('borrows.return') }}
                </button>
            @endif
        </td>
    @endcan
</tr>
