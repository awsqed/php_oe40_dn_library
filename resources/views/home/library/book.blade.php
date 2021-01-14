<x-app :title="Str::title($book->title)">
    @php
        $user = Auth::user();

        $reviewCount = $book->reviews()->count();
        $likeCount = $book->likes()->count();
    @endphp
    <div class="col-9 mx-auto my-5 bg-white border p-4">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <div>
            <div class="float-left mr-4 d-flex flex-column align-items-center">
                <a href="{{ route('library.book', $book) }}">
                    <img src="{{ $book->cover }}" class="img-thumbnail book-cover">
                </a>

                @auth
                    @include('layouts.home.borrow-button')
                    <div class="col-12 p-0 like-button">
                        @include('layouts.home.like-button')
                    </div>
                    <div class="col-12 p-0 fl-button mt-2">
                        @include('layouts.home.follow-button', [
                            'followable' => $book,
                            'btnClasses' => 'btn-lg btn-block',
                        ])
                    </div>
                @endauth
            </div>

            <div>
                <h2 class="font-weight-bold">
                    <a href="{{ route('library.book', $book) }}" class="text-reset text-decoration-none">
                        {{ Str::title($book->title) }}
                    </a>
                    <br/>
                    <small>{{ Str::title($book->author->fullname) }}</small>
                </h2>
                <ul class="list-group list-group-horizontal">
                    <li class="list-group-item">
                        {!! $book->printAvgRatingText() !!}
                        <span>{{ $book->avg_rating }} / 5</span>
                    </li>
                    <li class="list-group-item">
                        {{ $reviewCount }}
                        {{ trans_choice('library.reviews', $reviewCount) }}
                    </li>
                    <li class="list-group-item like-count">
                        {{ $likeCount }}
                        {{ trans_choice('library.likes', $likeCount) }}
                    </li>
                </ul>
                <p class="mt-4 h5 lead text-justify">{{ $book->description }}</p>
                <hr>
                <div class="text-muted d-flex flex-column">
                    <a href="{{ route('library.index', ['category' => $book->category->id]) }}" class="text-reset text-decoration-none">
                        {{ $book->category->name }}
                    </a>
                    <span>
                        <strong>{{ $book->page_count }}</strong>
                        {{ trans_choice('library.pages', $book->page_count) }}
                    </span>
                    <span>{{ trans('library.published-by') }} <strong>{{ $book->publisher->name }}</strong></span>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="mt-5">
            <h2 class="font-weight-bold text-uppercase">
                {{ trans_choice('library.reviews', $reviewCount) }}
                @if ($reviewCount)
                    ({{ $reviewCount }})
                @endif
            </h2>
            <hr>

            @guest
                <div class="alert alert-warning">
                    {{ trans('library.guest.review-message') }}
                </div>
            @else
                <form>
                    <div class="mb-3">
                        <h5 class="font-weight-bold">{{ trans('library.rating') }}</h5>
                        <div class="rating h4">
                            ☆☆☆☆☆
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="h5" for="input-comment">{{ trans('library.comment') }}</label>
                        <textarea class="form-control" id="input-comment" rows="3"></textarea>
                    </div>
                    <button class="btn btn-outline-dark">{{ trans('library.submit') }}</button>
                </form>
            @endguest

            <ul class="list-unstyled mt-5 mb-0">
                @forelse ($book->reviews as $review)
                    <li class="media mt-2 border p-3">
                        <img src="{{ $review->avatar() }}" class="img-thumbnail rounded-circle rounded-sm align-self-start mr-3" width="75" height="75">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <strong>{{ Str::title($review->fullname) }} </strong>
                                {{ trans('library.rated-it') }}
                                <span class="text-danger">{!! $review->pivot->rating_text !!}</span>
                                <small class="float-right text-muted">{{ $review->pivot->reviewed_at }}</small>
                            </h5>
                            <p class="text-justify">{{ $review->pivot->comment }}</p>
                        </div>
                    </li>
                @empty
                    <li class="h5 text-center text-uppercase">
                        @guest
                            {{ trans('library.guest.no-reviews') }}
                        @else
                            {{ trans('library.no-reviews') }}
                        @endguest
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-app>
