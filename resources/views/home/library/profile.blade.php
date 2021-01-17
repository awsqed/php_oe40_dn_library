<x-app :title="Str::title(trim($pUser->fullname)) ?: $pUser->username">
    @php $user = Auth::user() @endphp
    <div class="col-9 mx-auto my-5 bg-white border p-4">
        <div class="text-center mb-5">
            <img src="{{ $pUser->avatar }}" class="img-thumbnail rounded-circle rounded-sm" width="256" height="256">

            <h2 class="my-4">{{ Str::title(trim($pUser->fullname)) ?: $pUser->username }}</h2>

            @if ($pUser->id != Auth::id())
                <div class="fl-button">
                    @include('layouts.home.follow-button', [
                        'followable' => $pUser,
                    ])
                </div>
            @endif
        </div>

        <div class="mt-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="likes-tab" data-toggle="tab" href="#likes" role="tab" aria-controls="likes" aria-selected="true">
                        {{ trans('profile.recent-likes') }}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="follows-tab" data-toggle="tab" href="#follows" role="tab" aria-controls="follows" aria-selected="false">
                        {{ trans('profile.followers') }}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="following-tab" data-toggle="tab" href="#following" role="tab" aria-controls="following" aria-selected="false">
                        {{ trans('profile.following') }}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">
                        {{ trans('profile.reviews') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                @include('layouts.home.profile-content')
            </div>
        </div>
    </div>

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-app>
