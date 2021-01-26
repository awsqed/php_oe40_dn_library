<x-dashboard :title="trans('categories.editing') .': '. $category->name">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('categories.edit', $category) }}
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow p-3 mb-5 bg-white rounded">
        <h5 class="card-header">
            <i class="fas fa-edit mr-1"></i>
            <strong>{{ trans('categories.editing') }}:</strong>
            <i class="user-select-all">{{ $category->name }}</i>
        </h5>

        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="input-name">{{ trans('categories.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="input-name" name="name" value="{{ old('name') ?: $category->name }}" maxlength="254" required autofocus>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                @if ($category->id != config('app.fallback-category'))
                    <div class="form-group">
                        <label for="input-parent">{{ trans('categories.parent') }}</label>
                        <select id="input-parent" class="form-control @error('parent') is-invalid @enderror" name="parent">
                            <option value="" @empty(old('parent') ?: $category->id) selected @endempty>
                                {{ trans('categories.no-parent') }}
                            </option>
                            @foreach ($categories as $category2)
                                <option value="{{ $category2->id }}" {{ (old('parent') ?: $category->parent_id) == $category2->id ? 'selected' : '' }}>
                                    {{ $category2->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                 <div class="form-group">
                    <label for="input-description">{{ trans('categories.description') }}</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="input-description" name="description" placeholder="{{ trans('categories.input-desc-placeholder') }}" value="{{ old('description') ?: $category->description }}" maxlength="254">
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg float-right">{{ trans('general.save') }}</button>
            </form>
        </div>
    </div>
</x-dashboard>
