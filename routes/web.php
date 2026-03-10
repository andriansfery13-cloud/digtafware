<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/marketplace', [\App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/products/{slug}', [\App\Http\Controllers\ProductDetailController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon/apply', [\App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon/remove', [\App\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Midtrans Webhook (Must be outside CSRF in production, handled via Exclude in VerifyCsrfToken)
Route::post('/payment/midtrans/webhook', [\App\Http\Controllers\PaymentController::class, 'midtransWebhook'])->name('payment.webhook');

// Secure Download Route
Route::get('/download/{token}', [\App\Http\Controllers\DownloadController::class, 'process'])
    ->middleware('download')
    ->name('download.process');

// Checkout routes (Require auth)
Route::middleware(['checkout'])->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/manual/{order}', [\App\Http\Controllers\CheckoutController::class, 'manualPayment'])->name('checkout.manual');
    Route::post('/checkout/manual/{order}', [\App\Http\Controllers\CheckoutController::class, 'storeManualPayment'])->name('checkout.manual.store');
    Route::get('/checkout/success/{order}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');

        Route::get('/orders', [\App\Http\Controllers\Dashboard\OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [\App\Http\Controllers\Dashboard\OrderController::class, 'show'])->name('orders.show');

        Route::get('/downloads', [\App\Http\Controllers\Dashboard\DownloadController::class, 'index'])->name('downloads');

        Route::get('/wishlist', [\App\Http\Controllers\Dashboard\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle', [\App\Http\Controllers\Dashboard\WishlistController::class, 'toggle'])->name('wishlist.toggle');

        Route::get('/invoices/{order}', [\App\Http\Controllers\Dashboard\InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/invoices/{order}/download', [\App\Http\Controllers\Dashboard\InvoiceController::class, 'download'])->name('invoices.download');

        Route::resource('support', \App\Http\Controllers\Dashboard\SupportController::class)->except(['edit', 'update', 'destroy']);

        Route::post('/reviews/{product}', [\App\Http\Controllers\Dashboard\ReviewController::class, 'store'])->name('reviews.store');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/verify', [\App\Http\Controllers\Admin\OrderController::class, 'verifyPayment'])->name('orders.verify');

        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/suspend', [\App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('users.suspend');

        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->except(['show']);
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->except(['show', 'edit', 'update']);
    });
});

require __DIR__ . '/auth.php';
