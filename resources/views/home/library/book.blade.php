<x-app :title="$book->title">
    @php
        $currentUserId = Auth::id();

        $reviewCount = $reviews->total();
        $likeCount = $book->likes->count();
    @endphp
    <div class="col-9 mx-auto my-5 bg-white border p-4">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <div class="d-flex">
            <div class="col-3 mr-3 px-4 d-flex flex-column align-items-center">
                <a href="{{ route('library.book', $book) }}">
                    <img src="{{ $book->cover }}" class="img-thumbnail book-cover">
                </a>

                @auth
                    <div class="align-self-stretch px-3 text-center mt-2">
                        @include('layouts.home.borrow-button')
                    </div>
                    <div class="align-self-stretch px-3 like-button">
                        @include('layouts.home.like-button')
                    </div>
                    <div class="align-self-stretch px-3 mt-2 fl-button">
                        @include('layouts.home.follow-button', [
                            'followableType' => 'book',
                            'followableId' => $book->id,
                            'btnClasses' => 'btn-lg btn-block',
                        ])
                    </div>
                @endauth
            </div>

            <div class="flex-fill">
                <h2 class="font-weight-bold">
                    <a href="{{ route('library.book', $book) }}" class="text-reset text-decoration-none">
                        {{ $book->title }}
                    </a>
                    <br/>
                    <a href="{{ route('library.author', $book->author) }}" class="text-reset text-decoration-none">
                        <small>{{ $book->author->fullname }}</small>
                    </a>
                </h2>
                <ul class="list-group list-group-horizontal">
                    <li class="list-group-item avg-rating">
                        {!! $book->printAvgRatingText() !!}
                        {{ $book->avg_rating }} / 5
                    </li>
                    <li class="list-group-item review-count">
                        {{ $reviewCount }}
                        {{ trans_choice('library.reviews', $reviewCount) }}
                    </li>
                    <li class="list-group-item like-count">
                        {{ $likeCount }}
                        {{ trans_choice('library.likes', $likeCount) }}
                    </li>
                </ul>
                <p class="mt-4 h5 lead text-justify">{!! nl2br(e($book->description)) !!}</p>
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
                @inject('repository', 'App\Repositories\Interfaces\ReviewRepositoryInterface')
                @if (!$repository->check($currentUserId, $book->id))
                    <div class="review-form">
                        <div class="form-group">
                            <label for="input-rating" class="h5">{{ trans('library.rating') }}</label>
                            <select id="input-rating" class="custom-select" name="rating" required>
                                <option selected hidden disabled></option>
                                <option value="5">★★★★★</option>
                                <option value="4">★★★★</option>
                                <option value="3">★★★</option>
                                <option value="2">★★</option>
                                <option value="1">★</option>
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label for="input-comment" class="h5">{{ trans('library.comment') }}</label>
                            <textarea id="input-comment" class="form-control" rows="3" name="comment"></textarea>
                            <span class="invalid-feedback"></span>
                        </div>

                        <button class="btn btn-outline-dark btn-rate" value="{{ $book->id }}">
                            {{ trans('library.submit') }}
                        </button>
                    </div>
                @endif
            @endguest

            <ul class="list-unstyled mt-4 review-list">
                @include('layouts.home.reviews')
            </ul>
        </div>
    </div>

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-app>
