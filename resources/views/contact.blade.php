@extends('layouts.parent')

@section('title', __('store.pages.contact.title') . ' - ' . __('store.app_name'))

@section('content')

    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>{{ __('store.pages.contact.title') }}</h2>
                        <p>{{ __('store.pages.contact.subtitle') }}</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                        <a href="{{ route('contact') }}">{{ __('store.nav.contact') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section_gap">
        <div class="container">
            <div class="row justify-content-center mb-40">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>{{ __('store.pages.contact.get_in_touch') }}</span></h2>
                        <p>{{ __('store.pages.contact.subtitle') }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="single-feature text-center">
                        <a href="#" target="_blank" class="title">
                            <i class="ti-facebook"></i>
                            <h3>Facebook</h3>
                        </a>
                        <p><a href="#" target="_blank">{{ __('store.pages.contact.follow_us') }}</a></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="single-feature text-center">
                        <a href="#" target="_blank" class="title">
                            <i class="ti-instagram"></i>
                            <h3>Instagram</h3>
                        </a>
                        <p><a href="#" target="_blank">{{ __('store.pages.contact.follow_us') }}</a></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="single-feature text-center">
                        <a href="#" target="_blank" class="title">
                            <span class="ti-tiktok-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16.6 0h-3.3v15.4c0 1.63-1.32 2.96-2.96 2.96s-2.96-1.33-2.96-2.96 1.32-2.96 2.96-2.96c.31 0 .6.05.88.13V9.2c-.29-.04-.58-.06-.88-.06-3.4 0-6.16 2.76-6.16 6.16S6.99 21.46 10.4 21.46s6.16-2.76 6.16-6.16V8.05c1.27.91 2.83 1.45 4.5 1.45V6.2c-2.53 0-4.58-2.05-4.46-4.58V0h0Z"/></svg>
                            </span>
                            <h3>TikTok</h3>
                        </a>
                        <p><a href="#" target="_blank">{{ __('store.pages.contact.follow_us') }}</a></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="single-feature text-center">
                        <a href="https://wa.me/201040522867" target="_blank" class="title">
                            <i class="ti-mobile"></i>
                            <h3>WhatsApp</h3>
                        </a>
                        <p><a href="https://wa.me/201040522867" target="_blank">+20 104 052 2867</a></p>
                    </div>
                </div>
            </div>

            <style>
                .single-feature .ti-tiktok-icon{display:inline-block;line-height:1;}
            </style>

        </div>
    </section>

@endsection