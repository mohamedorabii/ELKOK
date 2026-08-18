@extends('layouts.parent')

@section('title', __('store.pages.auth.login') . ' - ' . __('store.app_name'))

@section('content')

<section class="section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="login-card">

                    <h3 class="text-center mb-2">{{ __('store.pages.auth.welcome_back') }}</h3>
                    <p class="text-center mb-4">{{ __('store.pages.auth.login_to_continue') }}</p>

                    @if(session('error'))
                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label>{{ __('store.pages.auth.email') }}</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>{{ __('store.pages.auth.password') }}</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required>
                            @error('password')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('store.pages.auth.remember_me') }}</label>
                            </div>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}">{{ __('store.pages.auth.forgot_password') }}</a>
                            @endif
                        </div>

                        <button type="submit" class="main_btn">{{ strtoupper(__('store.pages.auth.login')) }}</button>
                    </form>

                    <div class="divider">─── {{ strtoupper(__('store.common.or')) }} ───</div>

                    <a href="{{ url('/auth/google/redirect') }}" class="google-btn">
                        <i class="fa fa-google"></i> {{ __('store.pages.auth.login_with_google') }}
                    </a>

                    @if(Route::has('register'))
                    <p class="register-link">
                        {{ __('store.pages.auth.no_account') }}
                        <a href="{{ route('register') }}">{{ __('store.pages.auth.create_one') }}</a>
                    </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@endsection