<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('authors.create') }}
    </x-slot>

    <form action="{{ route('authors.store') }}" enctype="multipart/form-data" method="POST" class="d-flex">
        @csrf

        <div class="form-group col-2 mr-3">
            @php
                $imgSrc = asset('storage/'. config('app.default-image.author'));
                $imgW = config('app.image-size.author.width');
                $imgH = config('app.image-size.author.height');
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
                    <i class="fas fa-plus-circle mr-1"></i>
                    {{ trans('authors.new') }}
                </h5>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-fname">{{ trans('users.first-name') }}</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="input-fname" name="first_name" value="{{ old('first_name') }}" maxlength="254">
                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-lname">{{ trans('users.last-name') }}</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="input-lname" name="last_name" value="{{ old('last_name') }}" maxlength="254">
                            @error('last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-gender">{{ trans('users.gender') }}</label>
                            <select id="input-gender" class="form-control @error('gender') is-invalid @enderror" name="gender">
                                <option value="0" {{ old('gender') ? '' : 'selected' }}>
                                    {{ trans('users.male') }}
                                </option>
                                <option value="1" {{ old('gender') ? 'selected' : '' }}>
                                    {{ trans('users.female') }}
                                </option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-birthday">{{ trans('users.birthday') }}</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="input-birthday" name="birthday" value="{{ old('birthday') }}">
                            @error('birthday')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
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
