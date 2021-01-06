<li class="nav-item">
    <a href="#" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt nav-icon"></i>
        <p>{{ trans('dashboard.dashboard') }}</p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            {{ trans('dashboard.sidebar.user.users') }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-search nav-icon"></i>
                <p>{{ trans('dashboard.search') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-unlock-alt nav-icon"></i>
                <p>{{ trans('dashboard.sidebar.user.permissions') }}</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
            {{ trans('dashboard.sidebar.book.books') }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>{{ trans('dashboard.search') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-folder"></i>
                <p>{{ trans('dashboard.sidebar.book.categories') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book-reader"></i>
                <p>{{ trans('dashboard.sidebar.book.authors') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>{{ trans('dashboard.sidebar.book.publishers') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>{{ trans('dashboard.sidebar.book.borrow-requests') }}</p>
            </a>
        </li>
    </ul>
</li>
