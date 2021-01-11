<x-app title="{{ trans('auth.login') }}">
    <div class="card col-4 mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header text-center text-uppercase h5">{{ trans('auth.login') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <label for="input-email" class="col-4 col-form-label text-right">{{ trans('users.email') }}</label>
                    <div class="col-6">
                        <input id="input-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-password" class="col-4 col-form-label text-right">
                        {{ trans('users.password') }}
                    </label>
                    <div class="col-6">
                        <input id="input-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-6 offset-4">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="input-remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="input-remember">
                                {{ trans('auth.remember-me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-8 offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('auth.login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app>
