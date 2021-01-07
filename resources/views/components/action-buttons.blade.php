@if (strpos($action, 'show') !== false)
    <a class="mr-1" href="{{ route($route .'.show', $target) }}">
        <i class="fas fa-eye"></i>
    </a>
@endif

@if (strpos($action, 'edit') !== false)
    <a class="mr-1" href="{{ route($route .'.edit', $target) }}">
        <i class="fas fa-edit"></i>
    </a>
@endif

@if (strpos($action, 'destroy') !== false)
    <a class="mr-1" href="{{ route($route .'.destroy', $target) }}">
        <i class="fas fa-trash"></i>
    </a>
@endif
