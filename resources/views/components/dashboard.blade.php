<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        {{-- TODO: Image URL --}}
                        <img src="https://i.picsum.photos/id/866/300/300.jpg?hmac=9qmLpcaT9TgKd6PD37aZJZ_7QvgrVFMcvI3JQKWVUIQ"
                             class="user-image img-circle elevation-2" />
                        <span class="d-none d-md-inline">{{-- TODO: Username --}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            {{-- TODO: Image URL --}}
                            <img src="https://i.picsum.photos/id/866/300/300.jpg?hmac=9qmLpcaT9TgKd6PD37aZJZ_7QvgrVFMcvI3JQKWVUIQ"
                                 class="img-circle elevation-2" />
                            <p>
                                {{-- TODO: Username --}}
                                <small>{{-- TODO: created_at --}}</small>
                            </p>
                        </li>

                        <li class="user-footer">
                            {{-- TODO: Logout Button --}}
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-none d-md-inline text-uppercase">{{ App::getLocale() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url('/locale/en') }}">{{ trans('general.locale.en') }}</a>
                        <a class="dropdown-item" href="{{ url('/locale/vi') }}">{{ trans('general.locale.vi') }}</a>
                    </div>
                </li>
            </ul>
        </nav>

        @include('layouts.sidebar')

        <div class="content-wrapper">
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
