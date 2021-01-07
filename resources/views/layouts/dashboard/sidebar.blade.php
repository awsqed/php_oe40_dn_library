<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center text-uppercase">
        <span class="brand-text font-weight-bold">
            @if (Auth::user()->hasPermission('admin'))
                {{ trans('dashboard.admin-panel') }}
            @else
                {{ trans('dashboard.user-panel') }}
            @endif
        </span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">
                @include('layouts.dashboard.menu')
            </ul>
        </nav>
    </div>
</aside>
