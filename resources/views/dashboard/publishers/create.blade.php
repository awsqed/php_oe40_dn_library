<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('publishers.create') }}
    </x-slot>

    <form action="{{ route('publishers.store') }}" enctype="multipart/form-data" method="POST" class="d-flex">
        @csrf

        <div class="form-group col-2 mr-3">
            @php
                $imgSrc = asset('storage/'. config('app.default-image.publisher'));
                $imgW = config('app.image-size.publisher.width');
                $imgH = config('app.image-size.publisher.height');
            @endphp
            <img id="imageHolder" class="img-thumbnail" src="{{ $imgSrc }}" width="{{ $imgW }}" height="{{ $imgH }}">
            <div class="custom-file my-3">
                <input id="input-image" name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" accept="image/*">
                <label class="custom-file-label" for="input-image"></label>
            </div>
            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex-fill">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow p-3 mb-5 bg-white rounded">
                <h5 class="card-header">
                    <i class="fas fa-edit mr-1"></i>
                    {{ trans('publishers.new') }}
                </h5>

                <div class="card-body">
                    <div class="form-group">
                        <label for="input-name">{{ trans('publishers.name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="input-fname" name="name" value="{{ old('name') }}" maxlength="254" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="input-description">{{ trans('publishers.description') }}</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="input-lname" name="description" value="{{ old('description') }}" maxlength="254">
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg float-right">{{ trans('general.save') }}</button>
                </div>
            </div>
        </div>
    </form>

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-dashboard>
