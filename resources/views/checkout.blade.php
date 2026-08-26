@extends('layouts.parent')

@section('title', 'Checkout - OrabyStore')

@section('content')

{{-- Banner --}}
<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2>Checkout</h2>
                    <p>Complete your order</p>
                </div>
                <div class="page_link">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('checkout.index') }}">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Checkout Section --}}
<section class="checkout_area section_gap">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="main_title">
                    <h2><span>Complete</span> Your Order</h2>
                    <p>Review your details and confirm your purchase.</p>
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('checkout.placeOrder') }}" method="POST" id="checkout-form"
              data-currency="{{ __('store.currency') }}"
              data-locale="{{ app()->getLocale() }}"
              data-subtotal="{{ $subtotal }}"
              data-shipping-options="{{ $shippingOptions->pluck('price', 'governorate')->toJson() }}">
            @csrf
            <div class="row">

                {{-- Billing Details --}}
                <div class="col-lg-8">
                    <div class="billing_details">
                        <h3 class="mb-4">Billing Details</h3>
                        <div class="row contact_form">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="Full Name"
                                    value="{{ old('name', auth()->user()->name ?? '') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="phone"
                                    placeholder="Phone Number"
                                    value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="address"
                                    placeholder="Address"
                                    value="{{ old('address') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="city"
                                    placeholder="City"
                                    value="{{ old('city') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <select class="form-control" name="governorate" id="governorate-select">
                                    <option value="">Select Governorate</option>
                                    @foreach($shippingOptions as $option)
                                        <option value="{{ $option->governorate }}"
                                            {{ old('governorate') === $option->governorate ? 'selected' : '' }}>
                                            {{ $option->governorate }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>

                        {{-- Products --}}
                        <ul class="list">
                            <li class="d-flex justify-content-between">
                                <span><strong>Product</strong></span>
                                <span><strong>Total</strong></span>
                            </li>
                            @foreach($cartItems as $item)
                            @if($item->product)
                            <li class="d-flex justify-content-between">
                                <span>
                                    {{ $item->product->name_en }}
                                    @if ($item->variant_label)
                                        - {{ $item->variant_label }}
                                    @endif
                                    x{{ $item->quantity }}
                                </span>
                                <span>{{ app()->getLocale() === 'ar' ? number_format($item->unit_price * $item->quantity, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($item->unit_price * $item->quantity, 2) }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>

                        {{-- Totals --}}
                        <ul class="list list_2">
                            <li class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span id="checkout-subtotal-value">{{ app()->getLocale() === 'ar' ? number_format($subtotal, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($subtotal, 2) }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Shipping</span>
                                <span id="checkout-shipping-value">
                                    {{ app()->getLocale() === 'ar' ? number_format($shipping, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($shipping, 2) }}
                                </span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span><strong>Total</strong></span>
                                <span><strong id="checkout-total-value">{{ app()->getLocale() === 'ar' ? number_format($total, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($total, 2) }}</strong></span>
                            </li>
                        </ul>

                        <small id="governorate-hint" class="text-muted d-block mb-2"></small>

                        <button type="submit" class="main_btn w-100"
                                style="border:none; cursor:pointer;">
                            Place Order
                        </button>
                        <a href="{{ route('cart.index') }}"
                           class="gray_btn w-100 text-center mt-2 d-block">
                            Back to Cart
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

@push('scripts')
    <script src="{{ asset('new-template/js/checkout.js') }}"></script>
@endpush

<style>
    #governorate-select + .nice-select {
        height: 48px;
        line-height: 46px;
        padding-left: 15px;
        padding-right: 35px;
        font-size: 15px;
        border-radius: 5px;
    }

    #governorate-select + .nice-select .current {
        line-height: 46px;
    }

    #governorate-select + .nice-select .list {
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
    }

@endsection