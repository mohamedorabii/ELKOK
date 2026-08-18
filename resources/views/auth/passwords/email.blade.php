@extends('layouts.parent')

@section('title', __('store.pages.auth.forgot_title') . ' - ' . __('store.app_name'))

@section('content')

<section class="section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="login-card">

                    <h3 class="text-center mb-2">{{ __('store.pages.auth.forgot_title') }}</h3>
                    <p class="text-center mb-4">{{ __('store.pages.auth.forgot_hint') }}</p>

                    @if(session('status'))
                        <div class="alert alert-success mb-4">{{ session('status') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label>{{ __('store.pages.auth.email') }}</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="main_btn w-100">
                            {{ __('store.pages.auth.send_code') }}
                        </button>

                    </form>

                    <p class="register-link mt-3 text-center">
                        {{ __('store.pages.auth.remember_me') }}
                        <a href="{{ route('login') }}">{{ __('store.pages.auth.back_to_login') }}</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection