<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('borrows.index') }}
    </x-slot>

    <form class="form-inline mb-3" action="{{ route('borrows.index') }}" method="GET">
        <input class="form-control flex-fill" type="text" name="search" placeholder="{{ trans('borrows.search-placeholder') }}">

        <select class="custom-select mx-2" name="filter">
            <option value="{{ $statusCode['new'] }}" hidden disabled {{ empty(Request::input('filter')) ? 'selected' : '' }}>
                {{ trans('borrows.filter-by') }}
            </option>
            <option value="all" {{ Request::input('filter') == 'all' ? 'selected' : '' }}>
                {{ trans('borrows.filter-all') }}
            </option>
            <option value="{{ $statusCode['new'] }}" {{ $selection['new'] }}>
                {{ trans('borrows.filter-new') }}
            </option>
            <option value="{{ $statusCode['accepted'] }}" {{ $selection['accepted'] }}>
                {{ trans('borrows.filter-accepted') }}
            </option>
            <option value="{{ $statusCode['overdue'] }}" {{ $selection['overdue'] }}>
                {{ trans('library.borrow.overdue') }}
            </option>
            <option value="{{ $statusCode['rejected'] }}" {{ $selection['rejected'] }}>
                {{ trans('library.borrow.rejected') }}
            </option>
            <option value="{{ $statusCode['returned'] }}" {{ $selection['returned'] }}>
                {{ trans('library.borrow.returned') }}
            </option>
            <option value="{{ $statusCode['returned-late'] }}" {{ $selection['returned-late'] }}>
                {{ trans('library.borrow.returned-late') }}
            </option>
        </select>

        <button class="btn btn-primary" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>

    <div class="borrow-table">
        @include('layouts.dashboard.borrow-requests-table')
    </div>

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-dashboard>
