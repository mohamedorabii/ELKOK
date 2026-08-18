<footer class="footer-area section_gap">
    <div class="container">

        <div class="row">

            {{-- About --}}
            <div class="col-lg-4 col-md-6 single-footer-widget">
                <h4>{{ __('store.pages.footer.about_title') }}</h4>

                <p>
                    {{ __('store.pages.footer.about_text') }}
                </p>

                <p class="mt-3">
                    {{ __('store.pages.footer.developer') }} <strong>Mohamed Alaa Oraby</strong>
                </p>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6 single-footer-widget">
                <h4>{{ __('store.pages.footer.quick_links') }}</h4>

                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ __('store.nav.home') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('products') }}">{{ __('store.nav.products') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}">{{ __('store.nav.contact') }}</a>
                    </li>

                    @auth
                        <li>
                            <a href="{{ route('orders.index') }}">{{ __('store.nav.my_orders') }}</a>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- Shop --}}
            <div class="col-lg-3 col-md-6 single-footer-widget">
                <h4>{{ __('store.pages.footer.shop') }}</h4>

                <ul>
                    <li>
                        <a href="{{ route('categories') }}">{{ __('store.nav.categories') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('subcategories') }}">{{ __('store.nav.subcategories') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('brands') }}">{{ __('store.nav.brands') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}">{{ __('store.nav.cart') }}</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-3 col-md-6 single-footer-widget">
                <h4>{{ __('store.pages.footer.contact') }}</h4>

                <p>
                    <i class="fa fa-phone mr-2"></i>
                    +20 128 185 6592
                </p>

                <p>
                    <i class="fa fa-envelope mr-2"></i>
                    devmohamedalaaoraby@gmail.com
                </p>

                <p>
                    <i class="fa fa-map-marker mr-2"></i>
                    Beni Suef, Egypt
                </p>

            </div>

        </div>

        <hr class="mt-4 mb-4">

        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12">
                <p class="footer-text mb-0">
                    © {{ date('Y') }}
                    <strong>{{ __('store.app_name') }}</strong>.
                    {{ __('store.pages.footer.all_rights') }}
                </p>
            </div>

            <div class="col-lg-6 col-md-12 text-lg-right text-center footer-social">

                <a href="https://www.facebook.com/share/1CfcigUQ94/" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>

                <a href="https://www.linkedin.com/in/mohamedalaaorabii" target="_blank">
                    <i class="fa fa-linkedin"></i>
                </a>

                <a href="https://github.com/mohamedorabii" target="_blank">
                    <i class="fa fa-github"></i>
                </a>

                <a href="https://wa.me/201281856592" target="_blank">
                    <i class="fa fa-whatsapp"></i>
                </a>

            </div>

        </div>

    </div>
</footer>