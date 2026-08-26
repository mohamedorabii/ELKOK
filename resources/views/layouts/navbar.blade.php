<header class="header_area">
    <div class="top_menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="float-left">
                        <p>{{ __('store.pages.contact.phone') }}: +201281856592</p>
                        <p>{{ __('store.common.email') }}: devmohamedalaaoraby@gmail.com</p>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="float-right">
                        <ul class="right_side">
                            <li><a href="{{ route('cart.index') }}">{{ __('store.nav.cart') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('store.nav.contact') }}</a></li>
                           <li>
    <a href="{{ route('language.switch', ['locale' => app()->getLocale() === 'en' ? 'ar' : 'en']) }}"
        title="{{ app()->getLocale() === 'en' ? __('store.switch_to_ar') : __('store.switch_to_en') }}"
        style="display:inline-flex; align-items:center; gap:5px;">
        <i class="ti-world"></i>
        {{ strtoupper(app()->getLocale() === 'en' ? 'ar' : 'en') }}
    </a>
</li>>

                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main_menu">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light w-100">

                <a class="navbar-brand logo_h" href="{{ route('home') }}">
                    <img src="{{ asset('new-template/img/logo.png') }}" alt="OrabyStore">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">

                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">

                    <div class="row w-100 mr-0">

                        {{-- Left Menu --}}
                        <div class="col-lg-7 pr-0">

                            <ul class="nav navbar-nav center_nav pull-right">

                                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('home') }}">
                                        {{ __('store.nav.home') }}
                                    </a>
                                </li>

                                <li
                                    class="nav-item submenu dropdown {{ request()->routeIs('products*', 'categories*', 'subcategories*', 'brands*') ? 'active' : '' }}">

                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                        {{ __('store.nav.shop') }}
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('categories') }}">
                                                {{ __('store.nav.categories') }}
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('subcategories') }}">
                                                {{ __('store.nav.subcategories') }}
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('products') }}">
                                                {{ __('store.nav.products') }}
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('brands') }}">
                                                {{ __('store.nav.brands') }}
                                            </a>
                                        </li>
                                    </ul>

                                </li>

                                <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('contact') }}">
                                        {{ __('store.nav.contact') }}
                                    </a>
                                </li>

                                @auth
                                    <li class="nav-item {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('orders.index') }}">
                                            {{ __('store.nav.my_orders') }}
                                        </a>
                                    </li>
                                @endauth

                            </ul>

                        </div>

                        {{-- Right Menu --}}
                        <div class="col-lg-5 pr-0">

                            <ul class="nav navbar-nav navbar-right right_nav pull-right">

                                {{-- Search --}}
                                <li class="nav-item search-nav-item">

                                    <div class="search-wrapper" data-live-search-url="{{ route('search.live') }}"
                                        data-search-url="{{ route('search') }}">

                                        <form action="{{ route('search') }}" method="GET">

                                            <input type="text" id="live-search-input" name="q"
                                                placeholder="{{ __('store.search_placeholder') }}" autocomplete="off" value="{{ request('q') }}">

                                            <button type="submit">
                                                <i class="ti-search"></i>
                                            </button>

                                        </form>

                                        <div id="search-dropdown">

                                            <div id="search-results"></div>

                                            <div id="search-all">
                                                <a href="#" id="search-all-link">
                                                    {{ __('store.view_all_results') }}
                                                </a>
                                            </div>

                                        </div>

                                    </div>

                                </li>

                                {{-- Cart --}}
                                <li class="nav-item">
                                    <a href="{{ route('cart.index') }}" class="icons">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                </li>

                                {{-- User --}}
                                <li class="nav-item">

                                    @guest

                                        <a href="{{ route('login') }}" class="icons">
                                            <i class="ti-user"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" class="icons user-toggle">
                                            <i class="ti-user"></i>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <ul class="user-dropdown">

                                            @if (Auth::user()->is_admin)
                                                <li>
                                                    <a href="{{ url('/admin') }}">
                                                        {{ __('store.nav.dashboard') }}
                                                    </a>
                                                </li>
                                            @endif

                                            <li>

                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                                    {{ __('store.nav.logout') }}

                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display:none;">

                                                    @csrf

                                                </form>

                                            </li>

                                        </ul>

                                    @endguest

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </nav>
        </div>
    </div>
</header>
