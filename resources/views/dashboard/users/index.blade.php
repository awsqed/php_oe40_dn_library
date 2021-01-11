<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('users.index') }}
    </x-slot>

    @if (Route::has('users.create') && Gate::allows('create-user'))
        <a class="btn btn-success mb-3" href="{{ route('users.create') }}">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('users.new') }}
        </a>
    @endif

    <x-table>
        <x-slot name="thead">
            <tr>
                <th>{{ trans('users.id') }}</th>
                <th>{{ trans('users.username') }}</th>
                <th>{{ trans('users.email') }}</th>
                <th>{{ trans('users.fullname') }}</th>
                <th>{{ trans('users.phone') }}</th>
                <th>{{ trans('users.address') }}</th>
                @canany([
                    'update-user-info',
                    'delete-user',
                ])
                    <th>{{ trans('general.action') }}</th>
                @endcan
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($users as $user)
                <tr>
                    <th class="align-middle">{{ $user->id }}</th>
                    <td class="align-middle">{{ $user->username }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->fullname }}</td>
                    <td class="align-middle">{{ $user->phone }}</td>
                    <td class="align-middle">{{ $user->address }}</td>
                    @canany([
                        'update-user-info',
                        'delete-user',
                    ])
                        <td><x-action-buttons action="edit,destroy" route="users" :target="$user->id" /></td>
                    @endcan
                </tr>
            @endforeach
        </x-slot>

        <x-pagination :data="$users"/>
    </x-table>
</x-dashboard>
