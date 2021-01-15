@foreach ($categories as $category)
    @php
        $href = route('library.index', [
            'category' => $category->id,
            'search' => $search,
        ]);
    @endphp
    <a href="{{ $href }}" class="list-group-item h6 text-uppercase">
        {{ $category->name }}
    </a>
    @if (count($category->childs))
        <li class="list-group-item">
            <ul class="list-group list-group-flush">
                @include('layouts.home.subcategories', [
                    'categories' => $category->childs()->with('childs')->get(),
                ])
            </ul>
        </li>
    @endif
@endforeach
