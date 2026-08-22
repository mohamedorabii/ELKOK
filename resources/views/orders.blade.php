@extends('layouts.parent')

@section('title', 'My Orders')

@section('content')

    <div class="product-section mt-100 mb-150">
        <div class="container">

            {{-- Page Title --}}
            <div class="row mb-5">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">My</span> Orders</h3>
                        <p>Track your orders and view all purchased products.</p>
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Empty Orders --}}
            @if ($orders->isEmpty())

                <div class="row">
                    <div class="col-lg-6 offset-lg-3">

                        <div class="login-card text-center">

                            <i class="fas fa-box-open fa-4x text-secondary mb-4"></i>

                            <h4>No Orders Yet</h4>

                            <p class="mb-4">
                                Once you place your first order, it will appear here.
                            </p>

                            <a href="{{ route('products') }}" class="main_btn">
                                <i class="fas fa-shopping-bag"></i>
                                Shop Now
                            </a>

                        </div>

                    </div>
                </div>
            @else
                <div class="row">

                    @foreach ($orders as $order)
                        @php

                            $statusClass = match ($order->status) {
                                'pending' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            };

                            $statusText = match ($order->status) {
                                'pending' => 'Pending',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                                default => ucfirst($order->status),
                            };

                        @endphp

                        <div class="col-lg-6 mb-4">

                            <div class="login-card h-100 shadow-sm">

                                {{-- Header --}}
                                <div class="d-flex justify-content-between align-items-center">

                                    <div>
                                        <h5 class="mb-1">
                                            Order #{{ $order->order_number }}
                                        </h5>

                                        <small class="text-muted">
                                            {{ $order->created_at->format('d M Y - h:i A') }}
                                        </small>
                                    </div>

                                    <span class="badge badge-{{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>

                                </div>

                                <hr>

                                {{-- Customer Info --}}
                                <div class="mb-3">

                                    <p class="mb-2">
                                        <strong>Name:</strong>
                                        {{ $order->name }}
                                    </p>

                                    <p class="mb-2">
                                        <strong>Phone:</strong>
                                        {{ $order->phone }}
                                    </p>

                                    <p class="mb-0">
                                        <strong>Address:</strong>
                                        {{ $order->address }},
                                        {{ $order->city }},
                                        {{ $order->governorate }}
                                    </p>

                                </div>

                                <hr>

                                {{-- Totals --}}
                                <div class="row text-center mb-3">

                                    <div class="col-4">
                                        <small class="text-muted d-block">Products</small>

                                        <strong>
                                            {{ $order->items->count() }}
                                        </strong>
                                    </div>

                                    <div class="col-4">
                                        <small class="text-muted d-block">Shipping</small>

                                        <strong>
                                            {{ app()->getLocale() === 'ar' ? number_format($order->shipping_price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($order->shipping_price, 2) }}
                                        </strong>
                                    </div>

                                    <div class="col-4">
                                        <small class="text-muted d-block">Total</small>

                                        <strong class="text-success">
                                            {{ app()->getLocale() === 'ar' ? number_format($order->total_price, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($order->total_price, 2) }}
                                        </strong>
                                    </div>

                                </div>

                                <hr>

                                {{-- Items --}}
                                <h6 class="mb-3">
                                    Order Items
                                </h6>

                                <ul class="list-group mb-3">

                                    @foreach ($order->items as $item)
                                        <li class="list-group-item">

                                            <div class="d-flex justify-content-between">

                                                <div>

                                                    <strong>
                                                        {{ optional($item->product)->name_en ?? 'Product Removed' }}
                                                    </strong>

                                                    @if ($item->variant_label)
                                                        <br>
                                                        <small class="text-muted">{{ $item->variant_label }}</small>
                                                    @endif

                                                    <br>

                                                    <small class="text-muted">

                                                        Quantity :
                                                        {{ $item->quantity }}

                                                    </small>

                                                </div>

                                                <div class="text-end">

                                                    @if ($item->product)
                                                        <strong class="text-success">

                                                            {{ app()->getLocale() === 'ar' ? number_format($item->price * $item->quantity, 2) . ' ' . __('store.currency') : __('store.currency') . ' ' . number_format($item->price * $item->quantity, 2) }}

                                                        </strong>
                                                    @else
                                                        <span class="text-danger">

                                                            N/A

                                                        </span>
                                                    @endif

                                                </div>

                                            </div>

                                        </li>
                                    @endforeach

                                </ul>
                                @if ($order->status === 'pending')
                                    <a href="{{ route('checkout.confirmation', $order) }}"
                                        class="btn btn-outline-primary btn-block mb-2">
                                        <i class="fa fa-credit-card"></i>
                                        إتمام الدفع
                                    </a>
                                @endif
                                {{-- Cancel Button --}}
                                @if ($order->status === 'pending')
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this order?')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-outline-danger btn-block">

                                            <i class="fas fa-times-circle"></i>

                                            Cancel Order

                                        </button>

                                    </form>
                                @elseif($order->status === 'cancelled')
                                    <button class="btn btn-danger btn-block" disabled>

                                        <i class="fas fa-ban"></i>

                                        Order Cancelled

                                    </button>
                                @elseif($order->status === 'delivered')
                                    <button class="btn btn-success btn-block" disabled>

                                        <i class="fas fa-check-circle"></i>

                                        Delivered

                                    </button>
                                @elseif($order->status === 'shipped')
                                    <button class="btn btn-info btn-block" disabled>

                                        <i class="fas fa-truck"></i>

                                        Shipped

                                    </button>
                                @endif

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>
    </div>

@endsection
