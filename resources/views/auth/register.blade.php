<x-app title="{{ trans('auth.register') }}">
    <div class="card col-4 mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header text-center text-uppercase h5">{{ trans('auth.register') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="input-username" class="col-4 col-form-label text-right">
                        {{ trans('users.username') }}
                    </label>
                    <div class="col-6">
                        <input id="input-username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-email" class="col-4 col-form-label text-right">{{ trans('users.email') }}</label>
                    <div class="col-6">
                        <input id="input-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                        <input id="input-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-password-confirm" class="col-4 col-form-label text-right">{{ trans('general.confirm-password') }}</label>
                    <div class="col-6">
                        <input id="input-password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-6 offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('auth.register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app>
