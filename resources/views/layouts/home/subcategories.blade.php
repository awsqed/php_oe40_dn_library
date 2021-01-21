@foreach ($categories as $category)
    @php
        $href = route('library.index', [
            'category' => $category->id,
            'search' => $search,
        ]);
    @endphp
    <li class="list-group-item">
        @if ($category->childs->count())
            <a data-toggle="collapse" href="#childs-{{ $category->id }}" aria-expanded="true" aria-controls="childs-{{ $category->id }}">
                <i class="fas fa-angle-right mr-1"></i>
            </a>
        @endif
        <a href="{{ $href }}" class="h6 text-uppercase">
            {{ $category->name }}
        </a>
    </li>

    @if ($category->childs->count())
        <li class="list-group-item collapse show" id="childs-{{ $category->id }}">
            <ul class="list-group list-group-flush">
                @include('layouts.home.subcategories', [
                    'categories' => $category->childs()->with('childs')->get(),
                ])
            </ul>
        </li>
    @endif
@endforeach
