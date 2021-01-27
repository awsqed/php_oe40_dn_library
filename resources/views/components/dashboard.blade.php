@props([
    'title' => trans('dashboard.dashboard'),
])

@php
    $currentUser = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title }} - {{ trans('dashboard.'. ($currentUser->hasPermission('admin') ? 'admin' : 'user') .'-panel') }}
    </title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar sticky-top navbar-expand navbar-white navbar-light bg-info">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu mr-1">
                    <a href="" class="nav-link dropdown d-inline-flex align-items-center" data-toggle="dropdown">
                        <img src="{{ $currentUser->avatar }}" class="rounded-circle dashboard-avatar">
                        <span class="d-inline mx-2">
                            {{ $currentUser->fullname }}
                        </span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <img src="{{ $currentUser->avatar }}" class="rounded-circle">
                            <p>
                                {{ $currentUser->fullname }}
                                <small>
                                    {{
                                        trans('dashboard.member-since', [
                                            'year' => $currentUser->created_at->format('Y'),
                                        ])
                                    }}
                                </small>
                            </p>
                        </li>

                        <li class="user-footer w-100 d-inline-flex justify-content-center align-items-center">
                            <a class="btn btn-outline-primary mx-1" href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                            </a>
                            <form class="mx-1" action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown ml-2 notification">
                    @php
                        $unreadNotifications = $currentUser->unreadNotifications;
                    @endphp
                    @include('layouts.dashboard.notification', [
                        'unreadNotifications' => $unreadNotifications,
                    ])
                </li>

                <x-localization/>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link text-center text-uppercase">
                <span class="brand-text font-weight-bold">
                    @if ($currentUser->hasPermission('admin'))
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

        <div class="content-wrapper">
            {{ $breadcrumbs }}
            <section class="content">
                {{ $slot }}
            </section>
        </div>

        <footer class="main-footer"><strong>&copy; 2020</strong></footer>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript">
        window.Echo.private('App.Models.User.{{ Auth::id() }}')
            .notification((notification) => {
                window.axios.get('/notifications/unread/{{ Auth::id() }}?view=dashboard', )
                            .then(function (response) {
                                $('.notification').html(response.data);
                            });
            });
    </script>
    @yield('third_party_scripts')
    @stack('page_scripts')
</body>
</html>
