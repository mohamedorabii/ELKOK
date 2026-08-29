@extends('layouts.parent')

@section('title', __('store.pages.products.title') . ' - ' . __('store.app_name'))

@section('content')

    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>{{ __('store.pages.products.page_title') }}</h2>
                        <p>{{ __('store.pages.products.browse') }}</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                        <a href="{{ route('products') }}">{{ __('store.nav.products') }}</a>
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
                        <h2><span>{{ __('store.common.all') }}</span> {{ __('store.nav.products') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{ route('product.details', $product->id) }}" class="product-image-link">
                                    <img class="related-product-img"
                                        src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}" loading="lazy" decoding="async" />
                                </a>

                                @if ($product->stock_quantity > 0)
                                    <span class="badge badge-success"
                                        style="position:absolute;top:10px;left:10px;font-size:13px;padding:6px 12px;border-radius:20px;">
                                        {{ __('store.common.in_stock') }}
                                    </span>
                                @else
                                    <span class="badge badge-danger"
                                        style="position:absolute;top:10px;left:10px;font-size:13px;padding:6px 12px;border-radius:20px;">
                                        {{ __('store.common.out_of_stock') }}
                                    </span>
                                @endif

                                <div class="p_icon">
                                    <a href="{{ route('product.details', $product->id) }}"
                                        title="{{ __('store.common.view') }}">
                                        <i class="ti-eye"></i>
                                    </a>

                                    @if ($product->has_variants && $product->stock_quantity > 0)
                                        <a href="{{ route('product.details', $product->id) }}"
                                            title="{{ __('store.common.choose_options') }}">
                                            <i class="ti-list"></i>
                                        </a>
                                    @elseif (!$product->has_variants && $product->stock_quantity > 0)
                                        <a href="#" class="cart-trigger" data-form="cart-form-{{ $product->id }}"
                                            title="{{ __('store.common.add_to_cart') }}">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="product-btm">
                                <a href="{{ route('product.details', $product->id) }}" class="d-block">
                                    <h4>{{ $product->name }}</h4>
                                </a>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="mr-4 font-weight-bold">
                                        {{ app()->getLocale() === 'ar' ? number_format($product->price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($product->price, 2) }}
                                    </span>

                                    @if ($product->stock_quantity > 0)
                                        <small class="text-success">
                                            {{ $product->stock_quantity }} {{ __('store.common.left') }}
                                        </small>
                                    @else
                                        <small class="text-danger">
                                            {{ __('store.common.sold_out') }}
                                        </small>
                                    @endif
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

            @if ($products->hasPages())
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <ul
                            style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center; list-style:none; padding:0;">
                            @if ($products->onFirstPage())
                                <li><span class="main_btn" style="opacity:0.5; cursor:not-allowed;">←
                                        {{ __('store.common.prev') }}</span></li>
                            @else
                                <li><a href="{{ $products->previousPageUrl() }}" class="main_btn">←
                                        {{ __('store.common.prev') }}</a></li>
                            @endif

                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <li><span class="main_btn">{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}" class="main_btn"
                                            style="background:#fff; color:#333; border:1px solid #ddd;">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($products->hasMorePages())
                                <li><a href="{{ $products->nextPageUrl() }}"
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
