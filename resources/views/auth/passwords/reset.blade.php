@extends('layouts.parent')

@section('title', __('store.pages.auth.reset_title'))

@section('content')
    <section class="section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="login-card">

                        <h3 class="mb-4 text-center">{{ __('store.pages.auth.reset_title') }}</h3>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="mb-3">
                                <label>{{ __('store.pages.auth.verification_code') }}</label>
                                <input type="text" name="code" class="form-control" placeholder="{{ __('store.pages.auth.enter_code') }}"
                                    maxlength="6" required />
                            </div>

                            <div class="mb-3">
                                <label>{{ __('store.pages.auth.new_password') }}</label>
                                <input type="password" name="password" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label>{{ __('store.pages.auth.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" class="form-control" required />
                            </div>

                            <button type="submit" class="main_btn w-100">
                                {{ __('store.pages.auth.reset_title') }}
                            </button>
                        </form>
                        <p class="text-center mt-3">
                            {{ __('store.pages.auth.remember_me') }}
                            <a href="{{ route('login') }}">{{ __('store.pages.auth.back_to_login') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
