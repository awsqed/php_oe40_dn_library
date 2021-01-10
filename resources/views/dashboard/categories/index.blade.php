<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('categories.index') }}
    </x-slot>

    @if (Route::has('categories.create') && Gate::allows('create-category'))
        <a class="btn btn-success mb-3" href="{{ route('categories.create') }}">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('categories.new') }}
        </a>
    @endif

    <x-table>
        <x-slot name="thead">
            <tr>
                <th>{{ trans('categories.id') }}</th>
                <th>{{ trans('categories.name') }}</th>
                <th>{{ trans('categories.description') }}</th>
                @canany([
                    'update-category',
                    'delete-category',
                ])
                    <th>{{ trans('general.action') }}</th>
                @endcan
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($categories as $category)
                <tr>
                    <th class="align-middle">{{ $category->id }}</th>
                    <td class="align-middle">{{ $category->name }}</td>
                    <td class="align-middle">{{ Str::words($category->description, 7) }}</td>
                    @canany([
                        'update-category',
                        'delete-category',
                    ])
                        <td>
                            <x-action-buttons action="edit{{ $category->id == config('app.fallback-category') ? '' : ',destroy' }}" route="categories" :target="$category->id" />
                        </td>
                    @endcan
                </tr>
            @endforeach
        </x-slot>

        <x-pagination :data="$categories"/>
    </x-table>
</x-dashboard>
