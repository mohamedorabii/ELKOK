@extends('layouts.parent')

@section('title', __('store.pages.auth.confirm_password') . ' - ' . __('store.app_name'))

@section('content')

<section class="section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="login-card">

                    <h3 class="text-center mb-2">{{ __('store.pages.auth.confirm_password') }}</h3>
                    <p class="text-center mb-4">{{ __('store.pages.auth.confirm_password_hint') ?? __('store.pages.auth.forgot_hint') }}</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label>{{ __('store.pages.auth.password') }}</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="main_btn">
                            {{ __('store.pages.auth.confirm_password') }}
                        </button>

                    </form>

                    @if(Route::has('password.request'))
                    <p class="register-link">
                        <a href="{{ route('password.request') }}">{{ __('store.pages.auth.forgot_password') }}</a>
                    </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@endsection