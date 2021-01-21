@forelse ($reviews as $review)
    <li class="media mb-2 border p-3 bg-light">
        <img src="{{ $review->avatar }}" class="img-thumbnail rounded-circle rounded-sm align-self-start mr-3 reviewer-avatar">
        <div class="media-body">
            <h5 class="mt-0">
                <a href="{{ route('library.profile', $review) }}" class="text-reset text-decoration-none font-weight-bold">
                    {{ Str::title(trim($review->fullname)) ?: $review->username }}
                </a>
                {{ trans('library.rated-it') }}
                <span class="text-danger">{!! $review->pivot->rating_text !!}</span>
                <small class="float-right text-muted">{{ $review->pivot->reviewed_at }}</small>
            </h5>
            <p class="text-justify">{!! nl2br(e($review->pivot->comment)) !!}</p>
        </div>
    </li>

    @if ($loop->last)
        <x-pagination :data="$reviews"/>
    @endif
@empty
    <li class="h5 text-center text-uppercase">
        @guest
            {{ trans('library.guest.no-reviews') }}
        @else
            {{ trans('library.no-reviews') }}
        @endguest
    </li>
@endforelse
