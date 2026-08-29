@extends('layouts.parent')

@section('title', __('store.pages.categories.title') . ' - ' . __('store.app_name'))

@section('content')

    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>{{ __('store.pages.categories.page_title') }}</h2>
                        <p>{{ __('store.pages.categories.browse') }}</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                        <a href="{{ route('categories') }}">{{ __('store.nav.categories') }}</a>
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
                        <h2><span>{{ __('store.common.all') }}</span> {{ __('store.nav.categories') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-lg-4 col-md-6 mb-4 text-center">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{ route('products', $category->id) }}" class="category-image-link">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}" loading="lazy" decoding="async"
                                        style="max-height:250px; min-height:250px; object-fit:cover;" />
                                </a>
                                <div class="p_icon">
                                    <a href="{{ route('products', $category->id) }}"
                                        title="{{ __('store.common.browse') }}">
                                        <i class="ti-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-btm text-left">
                                <a href="{{ route('products', $category->id) }}" class="d-block"
                                    style="text-decoration:none;">
                                    <h4>{{ $category->name }}</h4>
                                    <p style="color:#56a97a;">{{ __('store.common.browse') }} &rarr;</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($categories->hasPages())
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <ul
                            style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center; list-style:none; padding:0;">
                            @if ($categories->onFirstPage())
                                <li><span class="main_btn" style="opacity:0.5; cursor:not-allowed;">←
                                        {{ __('store.common.prev') }}</span></li>
                            @else
                                <li><a href="{{ $categories->previousPageUrl() }}" class="main_btn">←
                                        {{ __('store.common.prev') }}</a></li>
                            @endif

                            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                @if ($page == $categories->currentPage())
                                    <li><span class="main_btn">{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}" class="main_btn"
                                            style="background:#fff; color:#F28123; border:1px solid #F28123;">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($categories->hasMorePages())
                                <li><a href="{{ $categories->nextPageUrl() }}"
                                        class="main_btn">{{ __('store.common.next') }} →</a></li>
                            @else
                                <li><span class="main_btn"
                                        style="opacity:0.5; cursor:not-allowed;">{{ __('store.common.next') }} →</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
