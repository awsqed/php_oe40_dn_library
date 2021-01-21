<div class="tab-pane bg-light border fade show active" id="likes" role="tabpanel" aria-labelledby="likes-tab">
    <div class="row row-cols-5 mt-3">
        @foreach ($likedBooks as $like)
            <figure class="figure col">
                <a href="{{ route('library.book', $like->book) }}">
                    <img src="{{ $like->book->cover }}" class="figure-img img-fluid img-thumbnail book-cover">
                    <figcaption class="figure-caption text-center">
                        {{ Str::title($like->book->title) }}
                    </figcaption>
                </a>
            </figure>
        @endforeach
    </div>
</div>

<div class="tab-pane bg-light border fade" id="follows" role="tabpanel" aria-labelledby="follows-tab">
    <div class="row row-cols-6 mt-3">
        @foreach ($followers as $follow)
            <figure class="figure col text-center">
                <a href="{{ route('library.profile', $follow->user) }}">
                    <img src="{{ $follow->user->avatar }}" class="figure-img img-fluid img-thumbnail" width="128" height="128">
                    <figcaption class="figure-caption">
                        {{ Str::title(trim($follow->user->fullname)) ?: $follow->user->username }}
                    </figcaption>
                </a>
            </figure>
        @endforeach
    </div>
</div>

<div class="tab-pane bg-light border fade" id="following" role="tabpanel" aria-labelledby="following-tab">
    <div class="row">
        <div class="col-2">
            <div class="nav nav-tabs flex-column" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="following-users-tab" data-toggle="tab" href="#following-users" role="tab" aria-controls="following-users" aria-selected="true">
                    {{ trans('profile.users') }}
                </a>

                <a class="nav-link" id="following-authors-tab" data-toggle="tab" href="#following-authors" role="tab" aria-controls="following-authors" aria-selected="false">
                    {{ trans('dashboard.authors') }}
                </a>

                <a class="nav-link" id="following-books-tab" data-toggle="tab" href="#following-books" role="tab" aria-controls="following-books" aria-selected="false">
                    {{ trans('dashboard.books') }}
                </a>
            </div>
        </div>

        <div class="col-10 mt-3">
            <div class="tab-content">
                @include('layouts.home.profile-followings')
            </div>
        </div>
    </div>
</div>

<div class="tab-pane bg-light border fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
    <ul class="list-unstyled mb-0">
        @foreach ($reviews as $review)
            <li class="media mb-2 border p-3 bg-light">
                <img src="{{ $review->cover }}" class="img-thumbnail book-cover align-self-start mr-3">
                <div class="media-body">
                    <h5 class="mt-0">
                        <div class="float-left">
                            <a href="{{ route('library.book', $review) }}" class="h4 font-weight-bold text-reset text-decoration-none">
                                {{ Str::title($review->title) }}
                            </a>
                            <br />
                            <a href="{{ route('library.author', $review->author) }}" class="text-reset text-decoration-none text-uppercase">
                                <small>{{ $review->author->fullname }}</small>
                            </a>
                            <br />
                            <small>{!! $review->pivot->rating_text !!}</small>
                        </div>
                        <small class="float-right text-muted">{{ $review->pivot->reviewed_at }}</small>

                        <div class="clearfix"></div>
                    </h5>
                    <p class="text-justify">{!! nl2br(e($review->pivot->comment)) !!}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
