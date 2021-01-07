<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center text-uppercase">
        {{-- TODO: Permission Check --}}
        <span class="brand-text font-weight-bold">{{ trans('dashboard.admin-panel') }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
