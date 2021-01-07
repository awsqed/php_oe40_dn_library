{{-- TODO: Permission Check --}}
<x-dashboard title="{{ trans('dashboard.admin-panel') }}">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('permissions.index') }}
    </x-slot>

    <x-table>
        <x-slot name="thead">
            <tr>
                <th class="col-1" scope="col">{{ trans('permissions.id') }}</th>
                <th scope="col">{{ trans('permissions.name') }}</th>
                <th class="col-1" scope="col">{{ trans('general.action') }}</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($permissions as $permission)
                <tr>
                    <th scope="row">{{ $permission->id }}</th>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <x-action-buttons action="edit" route="permissions" target="{{ $permission->id }}" />
                    </td>
                </tr>
            @endforeach
        </x-slot>

        <x-slot name="pagination">
            <div class="float-left">
                {{ trans('general.result-count', [
                    'from' => $permissions->firstItem(),
                    'to' => $permissions->firstItem() + $permissions->count() - 1,
                ]) }}
            </div>
            <div class="float-right">
                {{ $permissions->links('vendor.pagination.bootstrap-4') }}
            </div>
        </x-slot>
    </x-table>
</x-dashboard>
