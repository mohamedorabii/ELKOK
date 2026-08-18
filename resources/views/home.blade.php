@extends('layouts.parent')

@section('title', 'Home - OrabyStore')

@section('content')

    {{-- Banner --}}
    <section class="home_banner_area mb-40">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content row">
                    <div class="col-lg-12">
                        <p class="sub text-uppercase">{{ __('store.pages.home.new_collection') }}</p>

                        @if (app()->getLocale() === 'ar')
                            <h3>أظهر <span>أسلوبك</span> الشخصي</h3>
                        @else
                          <h3><span>Show</span> Your <br />Personal <span>Style</span></h3>
                        @endif

                        <a class="main_btn mt-40"
                            href="{{ route('products') }}">{{ __('store.pages.home.view_collection') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="feature-area section_gap_bottom_custom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-money"></i>
                            <h3>{{ __('store.pages.home.money_back') }}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-truck"></i>
                            <h3>{{ __('store.pages.home.free_delivery') }}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-support"></i>
                            <h3>{{ __('store.pages.home.always_support') }}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-feature">
                        <a href="#" class="title">
                            <i class="flaticon-blockchain"></i>
                            <h3>{{ __('store.pages.home.secure_payment') }}</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section class="feature_product_area section_gap_bottom_custom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="main_title">
                        <h2><span>{{ __('store.pages.home.latest_products') }}</span></h2>
                    </div>
                </div>
            </div>

            {{-- Category Filter --}}
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <a href="{{ route('home') }}">
                        <button
                            class="main_btn {{ !request()->route('id') ? '' : 'btn-outline' }}">{{ __('store.common.all') }}</button>
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('home.category', $category->id) }}">
                            <button class="main_btn {{ request()->route('id') == $category->id ? '' : 'btn-outline' }}">
                                {{ $category->name }}
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="single-product">

                            <div class="product-img">

                                <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}" />

                                @if ($product->quantity > 0)
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

                                    @if ($product->quantity > 0)
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

                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <span class="mr-4">
                                        {{ app()->getLocale() === 'ar' ? number_format($product->price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($product->price, 2) }}
                                    </span>

                                    @if ($product->quantity > 0)
                                        <small class="text-success">
                                            {{ $product->quantity }} {{ __('store.common.left') }}
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
        </div>
    </section>

@endsection
