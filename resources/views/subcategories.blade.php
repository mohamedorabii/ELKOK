@extends('layouts.parent')

@section('title', __('store.pages.subcategories.title') . ' - ' . __('store.app_name'))

@section('content')

<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2>{{ __('store.pages.subcategories.page_title') }}</h2>
                    <p>{{ __('store.pages.subcategories.browse') }}</p>
                </div>
                <div class="page_link">
                    <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                    <a href="{{ route('subcategories') }}">{{ __('store.nav.subcategories') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cat_product_area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="main_title">
                    <h2><span>{{ __('store.common.all') }}</span> {{ __('store.nav.subcategories') }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($subcategories as $subcategory)
            <div class="col-lg-4 col-md-6 mb-4 text-center">
                <div class="single-product">
                    <div class="product-img">
                        <img class="img-fluid w-100"
                            src="{{ asset('storage/' . $subcategory->image) }}"
                            alt="{{ $subcategory->name }}" />
                        <div class="p_icon">
                            <a href="{{ route('subcategories.products', $subcategory->id) }}" title="{{ __('store.common.view') }}">
                                <i class="ti-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-btm text-left">
                        <a href="{{ route('subcategories.products', $subcategory->id) }}" class="d-block">
                            <h4>{{ $subcategory->name }}</h4>
                            <p class="browse-link">{{ __('store.common.browse') }} &rarr;</p>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if ($subcategories->hasPages())
        <div class="row mt-4">
            <div class="col-12 text-center">
                <ul class="pagination-list">
                    @if ($subcategories->onFirstPage())
                        <li><span class="main_btn btn-disabled">← {{ __('store.common.prev') }}</span></li>
                    @else
                        <li><a href="{{ $subcategories->previousPageUrl() }}" class="main_btn">← {{ __('store.common.prev') }}</a></li>
                    @endif

                    @foreach ($subcategories->getUrlRange(1, $subcategories->lastPage()) as $page => $url)
                        @if ($page == $subcategories->currentPage())
                            <li><span class="main_btn">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="main_btn btn-outline-page">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($subcategories->hasMorePages())
                        <li><a href="{{ $subcategories->nextPageUrl() }}" class="main_btn">{{ __('store.common.next') }} →</a></li>
                    @else
                        <li><span class="main_btn btn-disabled">{{ __('store.common.next') }} →</span></li>
                    @endif
                </ul>
            </div>
        </div>
        @endif

    </div>
</section>

@endsection