@extends('layouts.parent')

@section('title', __('store.pages.brands.title') . ' - ' . __('store.app_name'))

@section('content')

    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>{{ __('store.pages.brands.page_title') }}</h2>
                        <p>{{ __('store.pages.brands.browse') }}</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                        <a href="{{ route('brands') }}">{{ __('store.nav.brands') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cat_product_area section_gap">
        <div class="container">
            <div class="row justify-content-center mb-40">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>{{ __('store.common.all') }}</span> {{ __('store.nav.brands') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse ($brands as $brand)
                    <div class="col-lg-4 col-md-6 mb-4 text-center">
                        <div class="single-product">
                            <div class="product-img">
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $brand->image) }}"
                                    alt="{{ $brand->name }}" />
                                <div class="p_icon">
                                    <a href="{{ route('products.brand', $brand->id) }}" title="{{ __('store.common.browse_brand') }}">
                                        <i class="ti-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-btm text-left">
                                <a href="{{ route('products.brand', $brand->id) }}" class="d-block" style="text-decoration:none;">
                                    <h4>{{ $brand->name }}</h4>
                                    <p style="color:#56a97a;">{{ __('store.common.browse_brand') }} &rarr;</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="single-product p-5">
                            <h3>{{ __('store.common.no_results') }}</h3>
                            <p>{{ __('store.common.try_different_keywords') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($brands->hasPages())
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <ul style="display:flex; gap:10px; justify-content:center; list-style:none; padding:0;">
                            @if ($brands->onFirstPage())
                                <li><span class="main_btn" style="opacity:0.5; cursor:not-allowed;">← {{ __('store.common.prev') }}</span></li>
                            @else
                                <li><a href="{{ $brands->previousPageUrl() }}" class="main_btn">← {{ __('store.common.prev') }}</a></li>
                            @endif

                            @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                                @if ($page == $brands->currentPage())
                                    <li><span class="main_btn">{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}" class="main_btn" style="background:#fff; color:#F28123; border:1px solid #F28123;">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if ($brands->hasMorePages())
                                <li><a href="{{ $brands->nextPageUrl() }}" class="main_btn">{{ __('store.common.next') }} →</a></li>
                            @else
                                <li><span class="main_btn" style="opacity:0.5; cursor:not-allowed;">{{ __('store.common.next') }} →</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
