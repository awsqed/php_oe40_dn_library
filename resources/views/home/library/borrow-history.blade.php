<x-app>
    <div class="col-9 mx-auto my-5 bg-white border p-4">
        <h2 class="font-weight-bold text-uppercase">
            {{ trans('library.borrow.history') }}
        </h2>
        <hr>

        <x-table>
            <x-slot name="thead">
                <tr class="text-center">
                    <th class="text-left">{{ trans('books.title') }}</th>
                    <th>{{ trans('library.borrow.from') }}</th>
                    <th>{{ trans('library.borrow.to') }}</th>
                    <th>{{ trans('library.borrow.returned-at') }}</th>
                    <th>{{ trans('library.borrow.status') }}</th>
                    <th>{{ trans('library.borrow.note') }}</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($history as $book)
                    @php
                        $pivot = $book->pivot;
                        switch ($pivot->status_text) {
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
                    <tr class="text-center align-middle {{ $context }}">
                        <th class="text-left">
                            <a href="{{ route('library.book', $book) }}" class="text-reset text-decoration-none">
                                {{ Str::title($book->title) }}
                            </a>
                        </th>
                        <td>{{ $pivot->from }}</td>
                        <td>{{ $pivot->to }}</td>
                        <td>{{ $pivot->returned_at }}</td>
                        <td>{{ $pivot->status_text }}</td>
                        <td>{{ $pivot->note_text }}</td>
                    </tr>
                @empty
                    <tr class="text-center"><td colspan="6">{{ trans('general.no-result') }}</td></tr>
                @endforelse
            </x-slot>

            @if ($history->count())
                <x-pagination :data="$history"/>
            @endif
        </x-table>
    </div>
</x-app>
