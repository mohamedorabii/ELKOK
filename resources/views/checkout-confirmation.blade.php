@extends('layouts.parent')

@section('title', __('store.pages.checkout_confirmation.title') . ' - ' . __('store.app_name'))

@push('styles')
    <style>
        .payment-card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            background: #fff;
            padding: 24px;
            text-align: center;
            height: 100%;
            cursor: pointer;
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .payment-card.selected {
            border: 2px solid #3b82f6;
            background-color: #f0f9ff;
        }

        .payment-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 20px;
        }

        .payment-icon.instapay {
            background: #dbeafe;
            color: #2563eb;
        }

        .payment-icon.vodafone {
            background: #dcfce7;
            color: #16a34a;
        }

        .qr-code {
            width: 150px;
            height: 150px;
            margin: 16px auto;
            display: block;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 6px;
            background: #fff;
        }

        .payment-details {
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .payment-instructions {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .whatsapp-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #25D366;
            color: #fff;
            font-weight: bold;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 8px;
        }

        .whatsapp-link:hover {
            background-color: #128C7E;
            color: #fff;
            transform: translateY(-2px);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        .success-badge {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #dcfce7;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto;
        }

        .order-summary-pill {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 10px 22px;
            font-size: 0.9rem;
            color: #334155;
        }

        .order-summary-pill .divider {
            width: 1px;
            height: 16px;
            background: #cbd5e1;
        }
    </style>
@endpush

@section('content')

    @php
        $t = fn($key) => __('store.pages.checkout_confirmation.' . $key);

        $vodafoneLink = config('services.vodafone_cash.link');
        $instapayLink = config('services.instapay.link');
        $instapayUsername = config('services.instapay.username');

        $vodafoneQr = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($vodafoneLink);
        $instapayQr = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($instapayLink);

        $formattedTotal =
            app()->getLocale() === 'ar'
                ? number_format($order->total_price, 2) . ' ' . __('store.currency')
                : __('store.currency') . ' ' . number_format($order->total_price, 2);

        $whatsappMessage = strtr($t('whatsapp_message'), [
            ':order_number' => $order->order_number,
            ':total' => $formattedTotal,
        ]);

        $whatsappUrl =
            'https://wa.me/' . config('services.whatsapp.number') . '?text=' . rawurlencode($whatsappMessage);
    @endphp

    <div class="product-section mt-100 mb-150">
        <div class="container">

            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="success-badge">
                        <i class="fa fa-check"></i>
                    </div>
                    <h3 class="mb-2 mt-3">{{ $t('title') }}</h3>
                    <p class="text-muted mb-3">{{ $t('subtitle') }}</p>
                    <div class="order-summary-pill">
                        <span>{{ $t('order_number') }}: <strong>{{ $order->order_number }}</strong></span>
                        <span class="divider"></span>
                        <span>{{ $t('total') }}: <strong>{{ $formattedTotal }}</strong></span>
                    </div>
                </div>
            </div>

            {{-- Payment Options --}}
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto">
                    <div class="login-card"
                        style="background: #f0f9ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 24px;">
                        <h4 class="text-center mb-2">{{ $t('payment_options_title') }}</h4>
                        <p class="text-center text-muted mb-4">{{ $t('payment_options_subtitle') }}</p>

                        <div class="row">
                            {{-- Instapay Option --}}
                            <div class="col-md-6 mb-4">
                                <div class="payment-card" data-method="instapay">
                                    <div class="payment-icon instapay">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <h5 class="mb-1">{{ $t('instapay') }}</h5>
                                    <p class="text-muted mb-0">{{ $t('instapay_desc') }}</p>

                                    <div class="mt-4">
                                        <a href="{{ $instapayLink }}" target="_blank">
                                            <img src="{{ $instapayQr }}" alt="Instapay QR" class="qr-code">
                                        </a>
                                    </div>

                                    <div class="payment-details text-start">
                                        <p class="mb-1"><strong>{{ $t('username') }}:</strong> {{ $instapayUsername }}</p>
                                        <p class="mb-0"><strong>{{ $t('payment_link') }}:</strong>
                                            <a href="{{ $instapayLink }}" target="_blank">{{ $t('click_to_transfer') }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Vodafone Cash Option --}}
                            <div class="col-md-6 mb-4">
                                <div class="payment-card" data-method="vodafone_cash">
                                    <div class="payment-icon vodafone">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <h5 class="mb-1">{{ $t('vodafone_cash') }}</h5>
                                    <p class="text-muted mb-0">{{ $t('vodafone_cash_desc') }}</p>

                                    <div class="mt-4">
                                        <a href="{{ $vodafoneLink }}" target="_blank">
                                            <img src="{{ $vodafoneQr }}" alt="Vodafone Cash QR" class="qr-code">
                                        </a>
                                    </div>

                                    <div class="payment-details text-start">
                                        <p class="mb-0"><strong>{{ $t('payment_link') }}:</strong>
                                            <a href="{{ $vodafoneLink }}" target="_blank">{{ $t('click_to_transfer') }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-instructions">
                            <h6 class="mb-2"><i class="fa fa-info-circle me-2"></i> {{ $t('payment_instructions') }}</h6>
                            <ul class="mb-0 ps-3">
                                <li>{{ $t('instruction_1') }}</li>
                                <li>{{ $t('instruction_2') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Send Receipt --}}
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="login-card text-center">
                        <h4 class="mb-3">{{ $t('send_receipt_title') }}</h4>
                        <p class="mb-4">{{ $t('send_receipt_subtitle') }}</p>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="whatsapp-link">
                            <i class="fa fa-whatsapp"></i>
                            {{ $t('send_via_whatsapp') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-8 mx-auto text-center">
                    <a href="{{ route('orders.index') }}"
                        style="display: inline-flex; align-items: center; gap: 6px; color: #3b82f6; font-weight: 500; font-size: 0.9rem; text-decoration: none; padding: 8px 20px; border: 1px solid #3b82f6; border-radius: 8px; transition: all 0.3s ease;"
                        onmouseover="this.style.background='#3b82f6'; this.style.color='#fff';"
                        onmouseout="this.style.background='transparent'; this.style.color='#3b82f6';">
                        <i class="fa fa-arrow-left" style="font-size: 0.8rem;"></i>
                        {{ $t('view_all_orders') }}
                    </a>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentOptions = document.querySelectorAll('.payment-card');

                paymentOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        paymentOptions.forEach(opt => opt.classList.remove('selected'));
                        this.classList.add('selected');
                    });
                });
            });
        </script>
    @endpush

@endsection