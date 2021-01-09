<li class="nav-item dropdown">
    <a href="" class="nav-link dropdown text-uppercase" data-toggle="dropdown">
        {{ App::getLocale() }}
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ url('/locale/en') }}">{{ trans('general.locale.en') }}</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('/locale/vi') }}">{{ trans('general.locale.vi') }}</a>
    </div>
</li>
