@extends('layouts.parent')

@section('title', __('store.pages.auth.create_account') . ' - ' . __('store.app_name'))

@section('content')

<section class="section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="login-card">

                    <h3 class="text-center mb-2">{{ __('store.pages.auth.create_account') }}</h3>
                    <p class="text-center mb-4">{{ __('store.pages.auth.register_to_continue') }}</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label>{{ __('store.pages.auth.name') }}</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>{{ __('store.pages.auth.email') }}</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
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

                        <div class="form-group mb-4">
                            <label>{{ __('store.pages.auth.confirm_password') }}</label>
                            <input type="password" name="password_confirmation"
                                class="form-control" required>
                        </div>

                        <button type="submit" class="main_btn">{{ strtoupper(__('store.pages.auth.register')) }}</button>
                    </form>

                    <div class="divider">─── {{ strtoupper(__('store.common.or')) }} ───</div>

                    <a href="{{ url('/auth/google/redirect') }}" class="google-btn">
                        <i class="fa fa-google"></i> {{ __('store.pages.auth.register_with_google') }}
                    </a>

                    @if(Route::has('login'))
                    <p class="register-link">
                        {{ __('store.pages.auth.already_have_account') }}
                        <a href="{{ route('login') }}">{{ __('store.pages.auth.login') }}</a>
                    </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@endsection