@extends('layouts.parent')

@section('title', 'Search Results - OrabyStore')

@section('content')

    {{-- Banner --}}
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Search Results</h2>
                        <p>Results for: "{{ $query }}"</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="#">Search</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section_gap search-results-page">
        <div class="container">

            {{-- Products --}}
            @if ($products->count() > 0)
                <div class="main_title mb-4">
                    <h2><span>Products</span> ({{ $products->total() }})</h2>
                </div>
                <div class="row mb-5">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="single-product">
                                <div class="product-img">
                                    <img class="related-product-img" src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name_en }}" />
                                    <div class="p_icon">
                                        <a href="{{ route('product.details', $product->id) }}">
                                            <i class="ti-eye"></i>
                                        </a>
                                        @if ($product->has_variants && $product->stock_quantity > 0)
                                            <a href="{{ route('product.details', $product->id) }}"
                                                title="{{ __('store.common.choose_options') }}">
                                                <i class="ti-list"></i>
                                            </a>
                                        @elseif (!$product->has_variants && $product->stock_quantity > 0)
                                            <a href="#" class="cart-trigger"
                                                data-form="cart-form-{{ $product->id }}">
                                                <i class="ti-shopping-cart"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-btm">
                                    <a href="{{ route('product.details', $product->id) }}" class="d-block">
                                        <h4>{{ $product->name_en }}</h4>
                                    </a>
                                    <div class="mt-3">
                                        <span
                                            class="mr-4">{{ app()->getLocale() === 'ar' ? number_format($product->price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($product->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <form id="cart-form-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST"
                                style="display:none;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                            </form>
                        </div>
                    @endforeach
                </div>
                {{ $products->appends(['q' => $query])->links() }}
            @endif

            {{-- Categories --}}
            @if ($categories->count() > 0)
                <div class="main_title mb-4">
                    <h2><span>Categories</span></h2>
                </div>
                <div class="row mb-5">
                    @foreach ($categories as $category)
                        <div class="col-lg-3 col-md-4 mb-3">
                            <a href="{{ route('categories') }}" class="category-card-link">
                                <div class="category-card">
                                    <img src="{{ asset('storage/' . $category->image) }}" class="category-img"
                                        alt="{{ $category->name_en }}" />
                                    <div class="category-card-body">
                                        <h3>{{ $category->name_en }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Brands --}}
            @if ($brands->count() > 0)
                <div class="main_title mb-4">
                    <h2><span>Brands</span></h2>
                </div>
                <div class="row mb-5">
                    @foreach ($brands as $brand)
                        <div class="col-lg-3 col-md-4 mb-3">
                            <a href="{{ route('brands') }}" class="category-card-link">
                                <div class="category-card brand-card">
                                    <img src="{{ asset('storage/' . $brand->image) }}" class="category-img"
                                        alt="{{ $brand->name }}" />
                                    <div class="category-card-body">
                                        <h3>{{ $brand->name }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- No Results --}}
            @if ($products->count() == 0 && $categories->count() == 0 && $brands->count() == 0)
                <div class="text-center py-5">
                    <i class="ti-search" style="font-size: 50px; color: #ddd;"></i>
                    <h3 class="mt-3">No results found for "{{ $query }}"</h3>
                    <p>Try different keywords</p>
                    <a href="{{ route('home') }}" class="main_btn mt-3">Back to Home</a>
                </div>
            @endif

        </div>
    </section>

@endsection
