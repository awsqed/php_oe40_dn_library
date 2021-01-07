<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt nav-icon"></i>
        <p>{{ trans('dashboard.dashboard') }}</p>
    </a>
</li>

@canany([
    'read-user',
    'read-permission',
])
    <li class="nav-item has-treeview {{ Request::routeIs('users.*', 'permissions.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
                {{ trans('dashboard.users') }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('read-user')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-search nav-icon"></i>
                        <p>{{ trans('dashboard.search') }}</p>
                    </a>
                </li>
            @endcan

            @can('read-permission')
                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::routeIs('permissions.*') ? 'active' : '' }}">
                        <i class="fas fa-unlock-alt nav-icon"></i>
                        <p>{{ trans('dashboard.permissions') }}</p>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

@canany([
    'read-category',
    'read-author',
    'read-publisher',
    'read-books',
])
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
                {{ trans('dashboard.sidebar.book.books') }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('read-books')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-search"></i>
                        <p>{{ trans('dashboard.search') }}</p>
                    </a>
                </li>
            @endcan

            @can('read-category')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>{{ trans('dashboard.sidebar.book.categories') }}</p>
                    </a>
                </li>
            @endcan

            @can('read-author')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>{{ trans('dashboard.sidebar.book.authors') }}</p>
                    </a>
                </li>
            @endcan

            @can('read-publisher')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>{{ trans('dashboard.sidebar.book.publishers') }}</p>
                    </a>
                </li>
            @endcan

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>{{ trans('dashboard.sidebar.book.borrow-requests') }}</p>
                </a>
            </li>
        </ul>
    </li>
@endcan
