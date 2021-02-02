@inject('repository', 'App\Repositories\Interfaces\FollowRepositoryInterface')
@php
    $followed = $repository->check(Auth::id(), $followableType, $followableId)
@endphp
<button class="btn {{ $btnClasses ?? '' }} @if ($followed) btn-outline-danger @else btn-outline-primary @endif btn-follow" value="{{ $followableId }}" followable-type="{{ $followableType }}">
    <i class="fas @if ($followed) fa-bell-slash @else fa-bell @endif mr-1"></i>
    @if ($followed)
        {{ trans('library.unfollow') }}
    @else
        {{ trans('library.follow') }}
    @endif
</button>
