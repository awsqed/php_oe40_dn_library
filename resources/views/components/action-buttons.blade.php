<div class="d-inline-flex d-flex-row align-items-center h-25">
    @if (strpos($action, 'show') !== false && Gate::allows('read-'. rtrim($route, 's')))
        <a class="mr-1 order-0" href="{{ route($route .'.show', $target) }}">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    @if (
        strpos($action, 'edit') !== false &&
        Gate::allows('update-'. str_replace('user', 'user-info', rtrim($route, 's')))
    )
        <a class="mr-1 order-1" href="{{ route($route .'.edit', $target) }}">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if (strpos($action, 'destroy') !== false && Gate::allows('delete-'. rtrim($route, 's')))
        <form class="order-2" action="{{ route($route .'.destroy', $target) }}" method="POST">
            @csrf
            @method('DELETE')

            <button class="btn btn-link text-danger" type="submit">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endif
</div>
