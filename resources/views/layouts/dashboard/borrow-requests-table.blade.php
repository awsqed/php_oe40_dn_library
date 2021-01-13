<x-table>
    <x-slot name="thead">
        <tr class="text-center">
            <th>{{ trans('users.fullname') }}</th>
            <th>{{ trans('books.title') }}</th>
            <th>{{ trans('library.borrow.from') }}</th>
            <th>{{ trans('library.borrow.to') }}</th>
            <th>{{ trans('library.borrow.return-date') }}</th>
            <th>{{ trans('library.borrow.status') }}</th>
            <th>{{ trans('library.borrow.note') }}</th>
            @can('update-borrow-request')
                <th class="text-left">{{ trans('general.action') }}</th>
            @endcan
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @forelse ($borrowRequests as $record)
            @include('layouts.dashboard.borrow-request-row')
        @empty
            <tr class="text-center"><td colspan="8">{{ trans('general.no-result') }}</td></tr>
        @endforelse
    </x-slot>

    @if ($borrowRequests->count())
        <x-pagination :data="$borrowRequests"/>
    @endif
</x-table>
