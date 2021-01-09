<x-app>
    <div class="col-9 mx-auto my-5">
        <div class="mb-3 d-flex">
            <h2 class="col-2 text-break">{{ trans('home.random-books') }}</h2>
            <div class="align-self-end ml-auto"><a class="text-uppercase" href="">{{ trans('home.browse-books') }}</a></div>
        </div>
        <div class="card-deck">
            @for($i = 1; $i < 5; $i++)
                <div class="card text-center">
                    <img src="https://picsum.photos/seed/{{ $i }}/320/512" class="card-img-top" alt="Title">
                    <div class="card-body">
                        <p class="card-text">
                            <p class="text-muted">Author {{ $i }}</p>
                            <h5><strong>Book Title {{ $i }}</strong></h5>
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="col-9 mx-auto my-5">
        <div class="mb-3 d-flex">
            <h2 class="col-2 text-break">{{ trans('home.random-categories') }}</h2>
            <div class="align-self-end ml-auto"><a class="text-uppercase" href="">{{ trans('home.browse-categories') }}</a></div>
        </div>
        <div class="card-deck">
            @for($i = 1; $i < 5; $i++)
                <div class="card text-center">
                    <div class="card-body">
                        <p class="card-text text-uppercase">
                            <strong>Category Name</strong>
                        </p>
                    </div>
                    <img src="https://picsum.photos/seed/{{ $i }}/150/100" class="card-img-bottom" alt="Title">
                </div>
            @endfor
        </div>
    </div>
</x-app>
