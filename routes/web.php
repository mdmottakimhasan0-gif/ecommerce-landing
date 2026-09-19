<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourierController as AdminCourierController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LandingPageController as AdminLandingPageController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPagePublicController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront Routes (Phase 1)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

// Fast Cash-on-Delivery Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order-success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// Order Tracking
Route::get('/track-order', [OrderTrackingController::class, 'index'])->name('tracking.index');
Route::post('/track-order', [OrderTrackingController::class, 'search'])->name('tracking.search');

// Unified Customer & Admin Auth
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Customer Protected Portal
Route::get('/my-orders', [CustomerOrderController::class, 'index'])->middleware('auth')->name('customer.orders');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products & Categories
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);

        // Orders & Fraud Check
        Route::get('orders/fraud-check', [AdminOrderController::class, 'fraudCheck'])->name('orders.fraudCheck');
        Route::get('orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('orders/{order}/sticker', [AdminOrderController::class, 'sticker'])->name('orders.sticker');
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::match(['post', 'put'], 'orders/{order}/update-details', [AdminOrderController::class, 'updateDetails'])->name('orders.updateDetails');
        Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/book-courier', [AdminOrderController::class, 'bookCourier'])->name('orders.bookCourier');
        Route::post('orders/{order}/sync-courier-status', [AdminOrderController::class, 'syncCourierStatus'])->name('orders.syncCourierStatus');
        Route::post('orders/sync-all-couriers', [AdminOrderController::class, 'syncAllCourierStatuses'])->name('orders.syncAllCouriers');

        // Payment Gateways & Transaction History
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::post('payments', [AdminPaymentController::class, 'updateSettings'])->name('payments.update');
        Route::post('payments/{order}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');

        // Courier & Shipping Management (BD Courier, Steadfast, Pathao, RedX, Carrybee, etc.)
        Route::get('couriers', [AdminCourierController::class, 'index'])->name('couriers.index');
        Route::post('couriers', [AdminCourierController::class, 'update'])->name('couriers.update');
        Route::post('couriers/test', [AdminCourierController::class, 'testConnection'])->name('couriers.test');

        // Landing Pages & Builder
        Route::get('landing-pages', [AdminLandingPageController::class, 'index'])->name('landing-pages.index');
        Route::get('landing-pages/create', [AdminLandingPageController::class, 'create'])->name('landing-pages.create');
        Route::post('landing-pages', [AdminLandingPageController::class, 'store'])->name('landing-pages.store');
        Route::post('landing-pages/upload-image', [AdminLandingPageController::class, 'uploadImage'])->name('landing-pages.uploadImage');
        Route::get('landing-pages/{landingPage}/builder', [AdminLandingPageController::class, 'builder'])->name('landing-pages.builder');
        Route::match(['post', 'put'], 'landing-pages/{landingPage}/builder', [AdminLandingPageController::class, 'saveBuilder'])->name('landing-pages.builder.save');
        Route::post('landing-pages/{landingPage}/toggle-publish', [AdminLandingPageController::class, 'togglePublish'])->name('landing-pages.togglePublish');
        Route::delete('landing-pages/{landingPage}', [AdminLandingPageController::class, 'destroy'])->name('landing-pages.destroy');

        // Templates
        Route::get('templates', [AdminTemplateController::class, 'index'])->name('templates.index');
        Route::post('templates', [AdminTemplateController::class, 'store'])->name('templates.store');
        Route::delete('templates/{template}', [AdminTemplateController::class, 'destroy'])->name('templates.destroy');

        // Pixel, GTM, TikTok & Store Settings
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Home Page Banners Management
        Route::get('banners', [AdminBannerController::class, 'index'])->name('banners.index');
        Route::post('banners', [AdminBannerController::class, 'update'])->name('banners.update');

        // Header Navigation Menu & Announcement Bar
        Route::get('menus', [AdminMenuController::class, 'index'])->name('menus.index');
        Route::post('menus', [AdminMenuController::class, 'update'])->name('menus.update');
    });
});

/*
|--------------------------------------------------------------------------
| Public Product Landing Page Route (Dynamic Catch-all)
|--------------------------------------------------------------------------
| Must remain at bottom to prevent shadowing application routes.
*/
Route::get('/{slug}', [LandingPagePublicController::class, 'show'])->name('landing.show');
Route::post('/{slug}/order', [LandingPagePublicController::class, 'order'])->name('landing.order');
