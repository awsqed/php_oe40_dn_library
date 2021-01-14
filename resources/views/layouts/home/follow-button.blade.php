@php $followed = App\Models\Follow::check($user, $followable) @endphp
<button class="btn {{ $btnClasses ?? '' }} @if ($followed) btn-outline-danger @else btn-outline-primary @endif btn-follow" value="{{ $followable->id }}" followable-type="{{ $followable->getMorphClass() }}">
    <i class="fas @if ($followed) fa-bell-slash @else fa-bell @endif mr-1"></i>
    @if ($followed)
        {{ trans('library.unfollow') }}
    @else
        {{ trans('library.follow') }}
    @endif
</button>
