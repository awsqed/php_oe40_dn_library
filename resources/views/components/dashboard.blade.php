<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title }} - {{ trans('dashboard.'. (Auth::user()->hasPermission('admin') ? 'admin' : 'user') .'-panel') }}
    </title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar sticky-top navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu mr-1">
                    <a href="" class="nav-link dropdown-toggle d-inline-flex align-items-center" data-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar() }}" class="rounded-circle elevation-2" width="32">
                        <span class="d-inline pl-2">{{ Auth::user()->fullname ?: Auth::user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <img src="{{ Auth::user()->avatar() }}" class="rounded-circle elevation-2">
                            <p>
                                {{ Auth::user()->fullname }}
                                <small>
                                    {{ trans('dashboard.member-since', ['year' => Auth::user()->created_at->format('Y')]) }}
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

                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle text-uppercase" data-toggle="dropdown">
                        {{ App::getLocale() }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url('/locale/en') }}">{{ trans('general.locale.en') }}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/locale/vi') }}">{{ trans('general.locale.vi') }}</a>
                    </div>
                </li>
            </ul>
        </nav>

        @include('layouts.dashboard.sidebar')

        <div class="content-wrapper">
            {{ $breadcrumbs }}
            <section class="content">
                {{ $slot }}
            </section>
        </div>

        <footer class="main-footer">
            {{-- TODO: Footer --}}
            <!--
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0.5
            </div>
            <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
            -->
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('third_party_scripts')
    @stack('page_scripts')
</body>
</html>
