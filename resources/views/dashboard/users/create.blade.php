<x-dashboard :title="Breadcrumbs::current()->title">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('users.create') }}
    </x-slot>

    <form action="{{ route('users.store') }}" enctype="multipart/form-data" method="POST" class="d-flex">
        @csrf

        <div class="form-group col-2 mr-3">
            @php
                $imgSrc = asset('storage/'. config('app.default-image.user'));
                $imgW = config('app.image-size.user.width');
                $imgH = config('app.image-size.user.height');
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

        <div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card flex-fill shadow p-3 mb-5 bg-white rounded">
                <h5 class="card-header">
                    <i class="fas fa-user-plus mr-1"></i>
                    {{ trans('users.new') }}
                </h5>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-username">{{ trans('users.username') }}</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="input-username" name="username" value="{{ old('username') }}" minlength="8" maxlength="254" required>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @else
                                <small class="form-text text-muted">
                                    {{ trans('users.messages.input-username-help') }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-email">{{ trans('users.email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="input-email" name="email" value="{{ old('email') }}" maxlength="254" autofocus required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

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
                                <option value="0" {{ old('gender') == 0 ? 'selected' : '' }}>
                                    {{ trans('users.male') }}
                                </option>
                                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>
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

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-phone">{{ trans('users.phone') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="input-phone" name="phone" value="{{ old('phone') }}" maxlength="254">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-address">{{ trans('users.address') }}</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="input-address" name="address" value="{{ old('address') }}" maxlength="254">
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">{{ trans('users.assign-permissions') }}</div>

                        <div class="card-body row">
                            @foreach ($permissions as $permission)
                                <div class="custom-control custom-switch col-3">
                                    <input type="checkbox" class="custom-control-input" id="input-{{ $permission->name }}" name="permissions[]" value="{{ $permission->id }}">
                                    <label class="custom-control-label" for="input-{{ $permission->name }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
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
