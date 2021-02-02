@inject('repository', 'App\Repositories\Interfaces\LikeRepositoryInterface')
@php
    $liked = $repository->check($currentUserId, $book->id)
@endphp
<button class="btn btn-block btn-lg @if ($liked) btn-outline-danger @else btn-outline-primary @endif mt-2 btn-like" value="{{ $book->id }}">
    <i class="fas @if ($liked) fa-thumbs-down @else fa-thumbs-up @endif mr-1"></i>
    @if ($liked)
        {{ trans('library.unlike') }}
    @else
        {{ trans('library.like') }}
    @endif
</button>
