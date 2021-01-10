<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('categories.create') }}
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow p-3 mb-5 bg-white rounded">
        <h5 class="card-header">
            <i class="fas fa-folder-plus mr-1"></i>
            {{ trans('categories.new') }}
        </h5>

        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="input-name">{{ trans('categories.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="input-name" name="name" value="{{ old('name') }}" maxlength="254" required autofocus>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="input-parent">{{ trans('categories.parent') }}</label>
                    <select id="input-parent" class="form-control @error('parent') is-invalid @enderror" name="parent">
                        <option value="" @empty(old('parent')) selected @endempty>
                            {{ trans('categories.no-parent') }}
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('parent') ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="input-description">{{ trans('categories.description') }}</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="input-description" name="description" placeholder="{{ trans('categories.input-desc-placeholder') }}" value="{{ old('description') }}" maxlength="254">
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg float-right">{{ trans('general.save') }}</button>
            </form>
        </div>
    </div>
</x-dashboard>
