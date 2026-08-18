@extends('layouts.parent')

@section('title', __('store.pages.product_details.title') . ' - ' . __('store.app_name'))

@section('content')

    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>{{ __('store.pages.product_details.title') }}</h2>
                        <p>{{ $product->name }}</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                        <a href="{{ route('products') }}">{{ __('store.nav.products') }}</a>
                        <a href="#">{{ $product->name }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="product_image_area section_gap">
        <div class="container">
            <div class="row s_product_inner align-items-center">

                <div class="col-lg-6">
                    <div class="s_product_img text-center">
                        <img class="img-fluid product-details-img" src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}">
                    </div>
                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">

                        <h3 class="mb-3">{{ $product->name }}</h3>

                        <h2 class="text-primary font-weight-bold mb-4">
                            {{ app()->getLocale() === 'ar' ? number_format($product->price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($product->price, 2) }}
                        </h2>

                        <ul class="list-unstyled mb-4">

                            <li class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <strong>{{ __('store.pages.product_details.category') }}</strong>
                                <span>{{ $product->category?->name ?? __('store.common.all') }}</span>
                            </li>

                            <li class="d-flex justify-content-between align-items-center py-3">
                                <strong>{{ __('store.pages.product_details.availability') }}</strong>

                                @if ($product->quantity > 0)
                                    <span class="badge badge-success"
                                        style="font-size:15px;padding:7px 14px;border-radius:20px;font-weight:600;">
                                        {{ __('store.pages.product_details.in_stock') }} ({{ __('store.pages.product_details.quantity_left', ['count' => $product->quantity]) }})
                                    </span>
                                @else
                                    <span class="badge badge-danger"
                                        style="font-size:15px;padding:7px 14px;border-radius:20px;font-weight:600;">
                                        {{ __('store.common.out_of_stock') }}
                                    </span>
                                @endif
                            </li>

                        </ul>

                        <p class="text-muted mb-4" style="line-height: 1.8;">
                            {{ $product->description }}
                        </p>

                        @if ($product->quantity > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="row align-items-end">

                                    <div class="col-md-4">
                                        <label class="font-weight-bold mb-2">
                                            {{ __('store.common.quantity') }}
                                        </label>

                                        <input type="number" name="quantity" min="1" max="{{ $product->quantity }}"
                                            value="1" class="form-control">
                                    </div>

                                    <div class="col-md-8 mt-3 mt-md-0">
                                        <button type="submit" class="main_btn w-100">
                                            <i class="ti-shopping-cart mr-2"></i>
                                            {{ __('store.common.add_to_cart') }}
                                        </button>
                                    </div>

                                </div>

                            </form>
                        @else
                            <button class="main_btn" disabled
                                style="background:#6c757d;border-color:#6c757d;cursor:not-allowed;">
                                {{ __('store.common.out_of_stock') }}
                            </button>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="cat_product_area section_gap">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>{{ __('store.common.related_products') }}</span></h2>
                    </div>
                </div>
            </div>

            <div class="row">

                @foreach ($related_products as $related)
                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="single-product">

                            <div class="product-img">

                                @if ($related->quantity > 0)
                                    <span class="badge badge-success"
                                        style="position:absolute;top:10px;left:10px;font-size:13px;padding:6px 12px;border-radius:20px;z-index:10;">
                                        {{ __('store.common.in_stock') }}
                                    </span>
                                @else
                                    <span class="badge badge-danger"
                                        style="position:absolute;top:10px;left:10px;font-size:13px;padding:6px 12px;border-radius:20px;z-index:10;">
                                        {{ __('store.common.out_of_stock') }}
                                    </span>
                                @endif

                                <img class="related-product-img"
                                    src="{{ asset('storage/' . $related->image) }}"
                                    alt="{{ $related->name }}">

                                <div class="p_icon">

                                    <a href="{{ route('product.details', $related->id) }}" title="{{ __('store.common.view') }}">
                                        <i class="ti-eye"></i>
                                    </a>

                                    @if ($related->quantity > 0)
                                        <a href="#"
                                            class="cart-trigger"
                                            data-form="cart-form-{{ $related->id }}"
                                            title="{{ __('store.common.add_to_cart') }}">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                    @endif

                                </div>

                            </div>

                            <div class="product-btm">

                                <a href="{{ route('product.details', $related->id) }}" class="d-block">
                                    <h4>{{ $related->name }}</h4>
                                </a>

                                <div class="d-flex justify-content-between align-items-center mt-3">

                                    <span class="mr-4 font-weight-bold">
                                        {{ app()->getLocale() === 'ar' ? number_format($related->price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($related->price, 2) }}
                                    </span>

                                    @if ($related->quantity > 0)
                                        <small class="text-success">
                                            {{ $related->quantity }} {{ __('store.common.left') }}
                                        </small>
                                    @else
                                        <small class="text-danger">
                                            {{ __('store.common.sold_out') }}
                                        </small>
                                    @endif

                                </div>

                            </div>

                        </div>

                        <form id="cart-form-{{ $related->id }}"
                            action="{{ route('cart.add') }}"
                            method="POST"
                            style="display:none;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $related->id }}">
                            <input type="hidden" name="quantity" value="1">
                        </form>

                    </div>
                @endforeach

            </div>

        </div>
    </section>

@endsection
