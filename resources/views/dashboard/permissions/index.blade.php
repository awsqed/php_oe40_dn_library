<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('permissions.index') }}
    </x-slot>

    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="col-1">{{ trans('permissions.id') }}</th>
                <th>{{ trans('permissions.name') }}</th>
                @can('update-permission')
                    <th class="col-1">{{ trans('general.action') }}</th>
                @endcan
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($permissions as $permission)
                <tr>
                    <th>{{ $permission->id }}</th>
                    <td>{{ $permission->name }}</td>
                    @can('update-permission')
                        <td><x-action-buttons action="edit" route="permissions" :target="$permission->id" /></td>
                    @endcan
                </tr>
            @endforeach
        </x-slot>

        <x-pagination :data="$permissions"/>
    </x-table>
</x-dashboard>
