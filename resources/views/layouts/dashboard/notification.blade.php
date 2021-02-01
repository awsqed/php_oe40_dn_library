@php
    $unread = $unreadNotifications->count();
@endphp
<a href="" class="nav-link dropdown d-inline-flex align-items-center" data-toggle="dropdown">
    <button class="btn btn-default rounded-circle">
        <i class="fas fa-bell"></i>
    </button>
    @if ($unread)
        <span class="badge badge-pill badge-danger notification-badge">
            {{ $unread }}
        </span>
    @endif
</a>
<ul class="dropdown-menu dropdown-menu-right rounded rounded-sm p-0 notification-dropdown">
    <li class="h5 font-weight-bold m-0 p-2 bg-dark">
        {{ trans_choice('notifications.title', $unread) }}
    </li>
    <li @if ($unread) class="notification-body" @endif>
        <table class="table table-borderless table-hover m-0">
            @forelse ($unreadNotifications as $notification)
                <tr>
                    <td>
                        <div class="h6 m-0 pl-2 border-primary notification-row">
                            <a href="{{ route('borrows.index') }}" class="text-reset text-decoration-none">
                                {!! $notification->data['message'] !!}
                            </a>
                            <br>
                            <small class="text-primary font-weight-bold">
                                {{ (new Carbon\Carbon($notification->created_at))->diffForHumans(now()) }}
                            </small>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="text-center"><td>{{ trans('notifications.empty') }}</td></tr>
            @endforelse
        </table>
    </li>
    @if ($unread)
        <div class="dropdown-divider m-0"></div>
        <li class="h6 text-right m-0 p-2">
            <a href="{{ route('notifications.mark-as-read') }}">
                <i class="fas fa-check"></i>
                {{ trans('notifications.mark-as-read') }}
            </a>
        </li>
    @endif
</ul>
