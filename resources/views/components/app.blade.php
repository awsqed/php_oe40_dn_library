@props([
    'title' => trans('app.home'),
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

    <title>{{ $title }} - {{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand text-uppercase font-weight-bold" href="{{ route('home') }}">
            {{ trans('app.library') }}
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBar" aria-controls="navBar" aria-expanded="false" aria-label="{{ trans('app.toggle-navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navBar">
            <ul class="navbar-nav">
                <li class="nav-item mr-2 {{ Request::routeIs('home') ? 'active bg-light' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">{{ trans('app.home') }}</a>
                </li>

                <li class="nav-item mr-2 {{ Request::routeIs('library.index') ? 'active bg-light' : '' }}">
                    <a class="nav-link" href="{{ route('library.index') }}">{{ trans('app.books') }}</a>
                </li>

                @guest
                    <li class="nav-item mr-2 dropdown {{ Request::routeIs('login', 'register') ? 'active bg-light' : '' }}">
                        <a href="" class="nav-link dropdown" data-toggle="dropdown">
                            {{ trans('app.guest') }}
                            <i class="fas fa-angle-down ml-2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item {{ Request::routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                {{ trans('auth.login') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                {{ trans('auth.register') }}
                            </a>
                        </div>
                    </li>
                @else
                    <li class="nav-item dropdown mr-2">
                        <a href="" class="nav-link dropdown" data-toggle="dropdown">
                            {{ trim($currentUser->fullname) ?: $currentUser->username }}
                            <i class="fas fa-angle-down ml-2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                {{ trans('dashboard.dashboard') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <form class="dropdown-item" action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button class="btn btn-link text-danger p-0" type="submit">
                                    {{ trans('dashboard.logout') }}
                                </button>
                            </form>
                        </div>
                    </li>
                @endguest

                <x-localization/>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        {{ $slot }}
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('third_party_scripts')
    @stack('page_scripts')
</body>
</html>
