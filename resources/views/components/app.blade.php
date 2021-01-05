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
                <li class="nav-item {{ Request::routeIs('home') ? 'active bg-light' : '' }}">
                    <a class="nav-link" href="#">{{ trans('app.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ trans('app.books') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ trans('app.about-us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ trans('app.contact-us') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase" href="#" id="navbarLocale" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ App::getLocale() }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarLocale">
                        <a class="dropdown-item" href="{{ url('/locale/en') }}">{{ trans('general.locale.en') }}</a>
                        <a class="dropdown-item" href="{{ url('/locale/vi') }}">{{ trans('general.locale.vi') }}</a>
                    </div>
                </li>
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
