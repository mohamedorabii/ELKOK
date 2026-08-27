@extends('layouts.parent')

@section('title', __('store.pages.product_details.title') . ' - ' . __('store.app_name'))

@section('content')
    @php
        $galleryImages = collect([$product->image ? asset('storage/' . $product->image) : null])
            ->filter()
            ->merge($product->images->map(fn($image) => asset('storage/' . $image->image)))
            ->unique()
            ->values();

        $variantOptions = $product->variants
            ->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'color_id' => $variant->color_id,
                    'color_name' => $variant->color?->name,
                    'size_id' => $variant->size_id,
                    'size_name' => $variant->size?->name,
                    'stock' => $variant->stock,
                    'price' => $variant->effective_price,
                    'sku' => $variant->sku,
                ];
            })
            ->values();

        $availableColors = $product->variants->pluck('color')->filter()->unique('id')->values();

        $initialPrice =
            app()->getLocale() === 'ar'
                ? number_format($product->price, 2) . ' ' . __('store.currency')
                : __('store.currency') . ' ' . number_format($product->price, 2);
    @endphp

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
            <div class="row s_product_inner align-items-start">

                <div class="col-lg-6">
                    <div class="s_product_img text-center">
                        <img id="product-main-image" class="img-fluid product-details-img"
                            src="{{ $galleryImages->first() }}" alt="{{ $product->name }}">
                    </div>

                    @if ($galleryImages->count() > 1)
                        <div class="d-flex flex-wrap justify-content-center mt-3" style="gap:12px;">
                            @foreach ($galleryImages as $galleryImage)
                                <button type="button" class="btn btn-light p-0 border gallery-thumb"
                                    data-image="{{ $galleryImage }}"
                                    style="width:72px;height:72px;overflow:hidden;border-radius:12px;">
                                    <img src="{{ $galleryImage }}" alt="{{ $product->name }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">

                        <h3 class="mb-3">{{ $product->name }}</h3>

                        <h2 id="product-price-display" class="text-primary font-weight-bold mb-4">
                            {{ $initialPrice }}
                        </h2>

                        <ul class="list-unstyled mb-4">
                            <li class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <strong>{{ __('store.pages.product_details.category') }}</strong>
                                <span>{{ $product->category?->name ?? __('store.common.all') }}</span>
                            </li>

                            <li class="d-flex justify-content-between align-items-center py-3">
                                <strong>{{ __('store.pages.product_details.availability') }}</strong>
                                <span id="product-stock-badge"
                                    class="badge {{ $product->stock_quantity > 0 ? 'badge-success' : 'badge-danger' }}"
                                    style="font-size:15px;padding:7px 14px;border-radius:20px;font-weight:600;">
                                    @if ($product->stock_quantity > 0)
                                        {{ __('store.pages.product_details.in_stock') }}
                                        ({{ __('store.pages.product_details.quantity_left', ['count' => $product->stock_quantity]) }})
                                    @else
                                        {{ __('store.common.out_of_stock') }}
                                    @endif
                                </span>
                            </li>
                        </ul>

                        <p class="text-muted mb-4" style="line-height: 1.8;">
                            {{ $product->description }}
                        </p>

                        @if ($product->has_variants)
                            <div id="product-variant-root" data-variants="{{ json_encode($variantOptions) }}"
                                data-initial-price="{{ $initialPrice }}" data-currency="{{ __('store.currency') }}"
                                data-locale="{{ app()->getLocale() }}"
                                data-in-stock-text="{{ __('store.pages.product_details.in_stock') }}"
                                data-choose-color-size-text="{{ app()->getLocale() === 'ar' ? 'اختر اللون والمقاس' : 'Choose a color and size' }}"
                                data-no-sizes-text="{{ app()->getLocale() === 'ar' ? 'لا توجد أحجام متاحة لهذا اللون' : 'No sizes available for this color' }}"
                                data-no-instock-sizes-text="{{ app()->getLocale() === 'ar' ? 'لا توجد كميات متاحة لهذا اللون' : 'No in-stock sizes for this color' }}"
                                data-left-text="{{ __('store.common.left') }}">

                                <div class="mb-4">
                                    <strong class="d-block mb-2">Color</strong>
                                    <div class="d-flex flex-wrap" id="variant-colors" style="gap:10px;">
                                        @foreach ($availableColors as $color)
                                            <button type="button" class="btn btn-outline-dark variant-color-btn"
                                                data-color-id="{{ $color->id }}" data-color-name="{{ $color->name }}"
                                                style="border-radius:999px;">
                                                @if ($color->hex_code)
                                                    <span
                                                        style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ $color->hex_code }};margin-right:8px;"></span>
                                                @endif
                                                {{ $color->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <strong class="d-block mb-2">Size</strong>
                                    <div class="d-flex flex-wrap" id="variant-sizes" style="gap:10px;">
                                        <span
                                            class="text-muted">{{ app()->getLocale() === 'ar' ? 'اختر لونًا أولًا' : 'Select a color first' }}</span>
                                    </div>
                                </div>

                                <div class="mb-4 p-3" style="background:#f8f9fa;border-radius:16px;">
                                    <strong class="d-block mb-2">Selected variant</strong>
                                    <span class="text-muted" id="selected-variant-text">
                                        {{ app()->getLocale() === 'ar' ? 'اختر اللون والمقاس' : 'Choose a color and size' }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if ($product->stock_quantity > 0)
                            <form action="{{ route('cart.add') }}" method="POST" id="product-add-to-cart-form">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="variant_id" id="selected-variant-id" value="">

                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="font-weight-bold mb-2">
                                            {{ __('store.common.quantity') }}
                                        </label>

                                        <input type="number" name="quantity" id="product-quantity-input" min="1"
                                            max="{{ $product->has_variants ? 1 : $product->stock_quantity }}"
                                            value="1" class="form-control"
                                            {{ $product->has_variants ? 'disabled' : '' }}>
                                    </div>

                                    <div class="col-md-8 mt-3 mt-md-0">
                                        <button type="submit" class="main_btn w-100" id="add-to-cart-button"
                                            {{ $product->has_variants ? 'disabled' : '' }}>
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

                                @if ($related->stock_quantity > 0)
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

                                {{-- الصورة تفتح Product Details --}}
                                <a href="{{ route('product.details', $related->id) }}" class="d-block">
                                    <img class="related-product-img" src="{{ asset('storage/' . $related->image) }}"
                                        alt="{{ $related->name }}">
                                </a>

                                <div class="p_icon">
                                    <a href="{{ route('product.details', $related->id) }}"
                                        title="{{ __('store.common.view') }}">
                                        <i class="ti-eye"></i>
                                    </a>

                                    @if ($related->has_variants && $related->stock_quantity > 0)
                                        <a href="{{ route('product.details', $related->id) }}"
                                            title="{{ __('store.common.choose_options') }}">
                                            <i class="ti-list"></i>
                                        </a>
                                    @elseif (!$related->has_variants && $related->stock_quantity > 0)
                                        <a href="#" class="cart-trigger" data-form="cart-form-{{ $related->id }}"
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

                                    @if ($related->stock_quantity > 0)
                                        <small class="text-success">
                                            {{ $related->stock_quantity }} {{ __('store.common.left') }}
                                        </small>
                                    @else
                                        <small class="text-danger">
                                            {{ __('store.common.sold_out') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form id="cart-form-{{ $related->id }}" action="{{ route('cart.add') }}" method="POST"
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

    @if ($product->has_variants)
        @push('scripts')
            <script src="{{ asset('new-template/js/product-details.js') }}"></script>
        @endpush
    @endif

@endsection
