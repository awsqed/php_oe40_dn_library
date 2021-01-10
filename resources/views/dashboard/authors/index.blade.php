<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('authors.index') }}
    </x-slot>

    @if (Route::has('authors.create') && Gate::allows('create-author'))
        <a class="btn btn-success mb-3" href="{{ route('authors.create') }}">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('authors.new') }}
        </a>
    @endif

    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="col-1">{{ trans('authors.id') }}</th>
                <th>{{ trans('users.fullname') }}</th>
                @canany([
                    'update-author',
                    'delete-author',
                ])
                    <th class="col-1">{{ trans('general.action') }}</th>
                @endcan
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($authors as $author)
                <tr>
                    <th class="align-middle">{{ $author->id }}</th>
                    <td class="align-middle">{{ $author->fullname }}</td>
                    @canany([
                        'update-author',
                        'delete-author',
                    ])
                        <td>
                            <x-action-buttons action="edit{{ $author->id == config('app.fallback-author') ? '' : ',destroy' }}" route="authors" :target="$author->id" />
                        </td>
                    @endcan
                </tr>
            @endforeach
        </x-slot>

        <x-pagination :data="$authors"/>
    </x-table>
</x-dashboard>
