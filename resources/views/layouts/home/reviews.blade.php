@forelse ($reviews as $review)
    <li class="media mb-2 border p-3 bg-light">
        <img src="{{ $review->user->avatar }}" class="img-thumbnail rounded-circle rounded-sm align-self-start mr-3 reviewer-avatar">
        <div class="media-body">
            <h5 class="mt-0">
                <a href="{{ route('library.profile', $review->user) }}" class="text-reset text-decoration-none font-weight-bold">
                    {{ $review->user->fullname }}
                </a>
                {{ trans('library.rated-it') }}
                <span class="text-danger">{!! $review->rating_text !!}</span>
                <small class="float-right text-muted">{{ $review->reviewed_at }}</small>
            </h5>
            <p class="text-justify">{!! nl2br(e($review->comment)) !!}</p>
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
