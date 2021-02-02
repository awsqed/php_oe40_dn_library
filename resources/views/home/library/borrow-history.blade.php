<x-app :title="trans('library.borrow.history')">
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
                    <th>{{ trans('general.action') }}</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @forelse ($history as $record)
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
                    <tr class="text-center align-middle {{ $context }}">
                        <th class="text-left">
                            <a href="{{ route('library.book', $record->book) }}" class="text-reset text-decoration-none">
                                {{ $record->book->title }}
                            </a>
                        </th>
                        <td>{{ $record->from }}</td>
                        <td>{{ $record->to }}</td>
                        <td>{{ $record->returned_at }}</td>
                        <td>{{ $record->status_text }}</td>
                        <td>{{ $record->note_text }}</td>
                        <td>
                            @if ($record->status_text == trans('library.borrow.processing'))
                                <a href="" class="text-danger delete-borrow" borrow-id="{{ $record->id }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif
                        </td>
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

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-app>
