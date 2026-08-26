@extends('layouts.parent')

@section('title', 'Shopping Cart - OrabyStore')

@section('content')

{{-- Banner --}}
<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2>Shopping Cart</h2>
                    <p>Review your selected products</p>
                </div>
                <div class="page_link">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('cart.index') }}">Cart</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Cart Section --}}
<section class="cart_area section_gap" id="cart-root"
    data-currency="{{ __('store.currency') }}"
    data-locale="{{ app()->getLocale() }}">
    <div class="container">

        {{-- Alerts --}}
        @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if ($cartItems->isEmpty())
        <div class="row">
            <div class="col-12 text-center">
                <div class="single-product p-5">
                    <h4 class="mb-3">Your cart is empty</h4>
                    <p class="mb-4">Looks like you haven't added products yet.</p>
                    <a href="{{ route('products') }}" class="main_btn">Start Shopping</a>
                </div>
            </div>
        </div>

        @else
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Remove</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                        @if ($item->product)
                        <tr>
                            <td>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:none; border:none; color:red; font-size:18px;">
                                        <i class="ti-close"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="media">
                                    <div class="d-flex mr-3">
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name_en }}"
                                            style="width:80px; height:80px; object-fit:cover;">
                                    </div>
                                    <div class="media-body align-self-center">
                                        <p>{{ $item->product->name_en }}</p>
                                        @if ($item->variant_label)
                                            <small class="text-muted d-block">{{ $item->variant_label }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>{{ app()->getLocale() === 'ar' ? number_format($item->unit_price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($item->unit_price, 2) }}</h5>
                            </td>
                            <td>
                                <div class="d-flex align-items-center cart-qty-stepper"
                                     data-cart-id="{{ $item->id }}"
                                     data-update-url="{{ route('cart.update', $item) }}"
                                     data-unit-price="{{ $item->unit_price }}"
                                     data-max-stock="{{ $item->available_stock }}"
                                     style="gap:0; border:1px solid #dee2e6; border-radius:4px; overflow:hidden; width:fit-content;">
                                    <button type="button" class="cart-qty-minus"
                                            style="border:none;background:#f8f9fa;width:32px;height:32px;font-size:16px;">
                                        −
                                    </button>
                                    <span class="cart-qty-value"
                                          style="width:40px;text-align:center;font-size:14px;">{{ $item->quantity }}</span>
                                    <button type="button" class="cart-qty-plus"
                                            style="border:none;background:#f8f9fa;width:32px;height:32px;font-size:16px;">
                                        +
                                    </button>
                                </div>
                                <small class="cart-qty-error text-danger d-none" style="font-size:11px;"></small>
                            </td>
                            <td>
                                <h5 class="cart-line-total" data-cart-id="{{ $item->id }}">{{ app()->getLocale() === 'ar' ? number_format($item->unit_price * $item->quantity, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($item->unit_price * $item->quantity, 2) }}</h5>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        {{-- Total --}}
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><h5><strong>Total</strong></h5></td>
                            <td><h5><strong id="cart-total-value">{{ app()->getLocale() === 'ar' ? number_format($total, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($total, 2) }}</strong></h5></td>
                        </tr>

                        {{-- Buttons --}}
                        <tr class="out_button_area">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner d-flex flex-column" style="gap:10px;">
                                    <a href="{{ route('products') }}" class="gray_btn">Continue Shopping</a>
                                    <a href="{{ route('checkout.index') }}" class="main_btn">Proceed to Checkout</a>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="gray_btn w-100">Clear Cart</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</section>

@endsection