@props([
    'action',
    'route',
    'target',
])

<div class="d-inline-flex d-flex-row align-items-center h-25">
    @if (strpos($action, 'show') !== false && Gate::allows('read-'. rtrim($route, 's')))
        <a class="mr-1 order-0" href="{{ route($route .'.show', $target) }}">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    @php
        $edit = '';
        $delete = '';
        switch ($route) {
            case 'users':
                $edit = 'update-user-info';
                $delete = 'delete-user';
                break;
            case 'categories':
                $edit = 'update-category';
                $delete = 'delete-category';
                break;
            default:
                $edit = 'update-'. rtrim($route, 's');
                $delete = 'delete-'. rtrim($route, 's');
        }
    @endphp

    @if (strpos($action, 'edit') !== false)
        @can($edit)
            <a class="mr-1 order-1" href="{{ route($route .'.edit', $target) }}">
                <i class="fas fa-edit"></i>
            </a>
        @endcan
    @endif

    @if (strpos($action, 'destroy'))
        @can($delete)
            <form class="order-2" action="{{ route($route .'.destroy', $target) }}" method="POST">
                @csrf
                @method('DELETE')

                <button class="btn btn-link text-danger" type="submit">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @endcan

    @endif
</div>
