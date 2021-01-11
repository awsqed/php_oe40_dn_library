<x-dashboard title="{{ Breadcrumbs::current()->title }}">
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('users.edit', $user) }}
    </x-slot>

    <form action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" method="POST" class="d-flex">
        @csrf
        @method('PUT')

        <div class="form-group col-2 mr-3">
            <img id="imageHolder" class="img-thumbnail" src="{{ $user->avatar() }}" width="{{ config('app.image-size.user.width') }}" height="{{ config('app.image-size.user.width') }}">
            <div class="custom-file my-3">
                <input id="input-image" name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror">
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
                    <i class="fas fa-user-edit fa-fw mr-1"></i>
                    <strong>{{ trans('users.editing') }}:</strong>
                    <i class="user-select-all">{{ $user->username }}</i>
                </h5>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="input-username">{{ trans('users.username') }}</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="input-username" name="username" value="{{ old('username') ?: $user->username }}">
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-email">{{ trans('users.email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="input-email" name="email" value="{{ old('email') ?: $user->email }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-password">{{ trans('users.password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="input-password" name="password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-fname">{{ trans('users.first-name') }}</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="input-fname" name="first_name" value="{{ old('first_name') ?: $user->first_name }}">
                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-lname">{{ trans('users.last-name') }}</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="input-lname" name="last_name" value="{{ old('last_name') ?: $user->last_name }}">
                            @error('last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-gender">{{ trans('users.gender') }}</label>
                            <select id="input-gender" class="custom-select @error('gender') is-invalid @enderror" name="gender">
                                <option value="0" {{ (old('gender') ?: $user->gender) ? '' : 'selected' }}>
                                    {{ trans('users.male') }}
                                </option>
                                <option value="1" {{ (old('gender') ?: $user->gender) ? 'selected' : '' }}>
                                    {{ trans('users.female') }}
                                </option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-birthday">{{ trans('users.birthday') }}</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="input-birthday" name="birthday" value="{{ old('birthday') ?: $user->date_of_birth }}">
                            @error('birthday')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="input-phone">{{ trans('users.phone') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="input-phone" name="phone" value="{{ old('phone') ?: $user->phone }}">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="input-address">{{ trans('users.address') }}</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="input-address" name="address" value="{{ old('address') ?: $user->address }}">
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @can('update-user-permission')
                        <div class="card">
                            <div class="card-header">{{ trans('users.assign-permissions') }}</div>
                            <div class="card-body row row-cols-1 row-cols-md-2 row-cols-xl-4 px-5">
                                @foreach ($permissions as $permission)
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="input-{{ $permission->name }}" name="permissions[]" value="{{ $permission->id }}" {{ $user->hasPermission($permission->name, false) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="input-{{ $permission->name }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endcan

                    <button type="submit" class="btn btn-primary btn-lg float-right">{{ trans('general.save') }}</button>
                </div>
            </div>
        </div>
    </form>

    @push('page_scripts')
        <script src="{{ mix('js/all.js') }}"></script>
    @endpush
</x-dashboard>
