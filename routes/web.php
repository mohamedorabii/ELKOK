<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\SearchController;
use App\Http\Controllers\Backend\SocialController;
use App\Http\Controllers\Backend\VerificationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontEnd\{HomeController, ProductController, CategoryController, BrandController, CartController};
use App\Http\Controllers\FrontEnd\SubCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 🔐 Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes(['verify' => true]);

Route::get('/language/{locale}', function (string $locale) {
    $allowedLocales = ['en', 'ar'];

    if (! in_array($locale, $allowedLocales, true)) {
        $locale = config('app.locale');
    }

    session()->put('locale', $locale);
    app()->setLocale($locale);

    return redirect()->back();
})->name('language.switch');

/*
|--------------------------------------------------------------------------
| 🌐 Social Login
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [SocialController::class, 'redirect']);
    Route::get('{provider}/callback', [SocialController::class, 'callback']);
});

/*
|--------------------------------------------------------------------------
| 🏠 Frontend Routes
|--------------------------------------------------------------------------
*/
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'LatestProducts')->name('home');
    Route::get('/home/category/{id?}', 'showProductsByCategory')->name('home.category');
});

/*
|--------------------------------------------------------------------------
| 📦 Products & Categories & Subcategory
|--------------------------------------------------------------------------
*/
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/{id?}', 'index')->name('products');
    Route::get('/details/{id}', 'productdetails')->name('product.details');
});

Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/{id?}', 'index')->name('categories');
});
Route::controller(SubCategoryController::class)->prefix('subcategories')->group(function () {
    Route::get('/{id?}', 'index')->name('subcategories');
    Route::get('/products/{id}', 'showProductsBySubcategory')->name('subcategories.products');
});

Route::controller(BrandController::class)->group(function () {
    Route::get('/brands', 'index')->name('brands');
    Route::get('/products/brand/{id}', 'products')->name('products.brand');
});

/*
|--------------------------------------------------------------------------
| 🛒 Cart Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'addToCart')->name('add');
    Route::post('/update/{cart}', 'updateCart')->name('update');
    Route::post('/remove/{cart}', 'removeFromCart')->name('remove');
    Route::post('/clear', 'clearCart')->name('clear');
});

/*
|--------------------------------------------------------------------------
| 💳 Checkout & Orders
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.index');
        Route::post('/checkout/place-order', 'placeOrder')->name('checkout.placeOrder');
        Route::get('/my-orders', 'myOrders')->name('orders.index');
        Route::patch('/orders/{order}/cancel', 'cancelOrder')
            ->name('orders.cancel');
    });
});

/*
|--------------------------------------------------------------------------
| 📞 Contact Pages
|--------------------------------------------------------------------------
*/
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


////////////////// Search Routes/////////////////
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');



Route::post('/email/verify', [VerificationController::class, 'verify'])
    ->middleware('throttle:5,1')
    ->name('verification.verify.otp');

Route::get('/password/reset/{token?}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/password/reset', [ResetPasswordController::class, 'reset'])
    ->middleware('throttle:5,1')
    ->name('password.update');
