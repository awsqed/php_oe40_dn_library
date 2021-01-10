<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('publishers.index') }}
    </x-slot>

    @if (Route::has('publishers.create') && Gate::allows('create-publisher'))
        <a class="btn btn-success mb-3" href="{{ route('publishers.create') }}">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('publishers.new') }}
        </a>
    @endif

    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="col-1">{{ trans('publishers.id') }}</th>
                <th>{{ trans('publishers.name') }}</th>
                @canany([
                    'update-publisher',
                    'delete-publisher',
                ])
                    <th class="col-1">{{ trans('general.action') }}</th>
                @endcan
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($publishers as $publisher)
                <tr>
                    <th class="align-middle">{{ $publisher->id }}</th>
                    <td class="align-middle">{{ $publisher->name }}</td>
                    @canany([
                        'update-publisher',
                        'delete-publisher',
                    ])
                        <td>
                            <x-action-buttons action="edit,destroy" route="publishers" :target="$publisher->id" />
                        </td>
                    @endcan
                </tr>
            @endforeach
        </x-slot>

        <x-pagination :data="$publishers"/>
    </x-table>
</x-dashboard>
