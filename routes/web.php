<?php

use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\InventoryController;
use App\Http\Controllers\admin\ProductManagementController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdsManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| USER AUTH ROUTES
|--------------------------------------------------------------------------
*/


Route::get('/fix-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('clear-compiled');
    return "Optimization caches completely cleared!";
});




Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/my-account', [CustomerProfileController::class, 'index'])
    ->name('customer.profile');

Route::get('/my-account/order/{id}', [CustomerProfileController::class, 'orderSummary'])
    ->name('customer.order.summary');

Route::get('/admin/management-login', [AuthController::class, 'showAdminLogin'])
    ->name('admin.login');

Route::post('/admin/management-login', [AuthController::class, 'adminLogin'])
    ->name('admin.login.post');

// OTP//

// OTP//

Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users');

    Route::get('/users/edit/{id}', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::post('/users/store', [UserController::class, 'store'])
        ->name('users.store');

    Route::post('/users/{id}/update', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->name('users.delete');

    Route::post(
        '/users/{id}/toggle-status',
        [UserController::class, 'toggleStatus']
    )
        ->name('users.toggle-status');

    // PRODUCT MANAGEMENT

    Route::get('/products', [ProductManagementController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [ProductManagementController::class, 'create'])
        ->name('products.create');

    Route::get('/products/{id}/edit', [ProductManagementController::class, 'edit'])
        ->name('products.edit');

    Route::get('/products/{id}', [ProductManagementController::class, 'show'])
        ->name('products.show');
    // =====================================
    // CUSTOMER MANAGEMENT
    // =====================================

    Route::get(
        '/customers',
        [App\Http\Controllers\admin\CustomerController::class, 'index']
    )->name('customers.index');

    Route::get(
        '/customers/order-history/{id}',
        [App\Http\Controllers\admin\CustomerController::class, 'orderHistory']
    )->name('customers.order.history');

    Route::get(
        '/customers/top',
        [CustomerController::class, 'topCustomers']
    )->name('customers.top');

    Route::post(
        '/top-customers/{id}/update-type',
        [CustomerController::class, 'updateCustomerType']
    )->name('customers.update.type');

    Route::get(
        '/activity-logs',
        [App\Http\Controllers\admin\ActivityLogController::class, 'index']
    )->name('activity.logs');

    Route::post(
        '/notifications/read-all',
        [App\Http\Controllers\admin\NotificationController::class, 'markAllRead']
    )->name('notifications.read-all');

    /*
    |--------------------------------------------------------------------------
    | ADS MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::get('/ads', [AdsManagementController::class, 'index'])->name('ads.index');
    Route::post('/ads', [AdsManagementController::class, 'store'])->name('ads.store');
    Route::post('/ads/{id}/update', [AdsManagementController::class, 'update'])->name('ads.update');
    Route::post('/ads/{id}/toggle', [AdsManagementController::class, 'toggle'])->name('ads.toggle');
    Route::delete('/ads/{id}', [AdsManagementController::class, 'destroy'])->name('ads.destroy');
    Route::post('/ads/{id}/text', [AdsManagementController::class, 'updateText'])->name('ads.update-text');
});

// Shared between admin and cashier: own profile, Order Management ("sales"),
// and the Accounts Management order-history view. Everything else in the
// admin panel stays admin-only (see the role:admin group above/below).
Route::middleware(['role:admin,cashier'])->prefix('admin')->name('admin.')->group(function () {

    Route::get(
        '/profile',
        [App\Http\Controllers\admin\AdminProfileController::class, 'index']
    )->name('profile');

    Route::post(
        '/profile/update',
        [App\Http\Controllers\admin\AdminProfileController::class, 'update']
    )->name('profile.update');

    Route::post(
        '/profile/password',
        [App\Http\Controllers\admin\AdminProfileController::class, 'updatePassword']
    )->name('profile.password.update');

    Route::get('/orders/new-orders', [AdminOrderController::class, 'newOrders'])->name('orders.new');
    Route::get('/orders/new', [AdminOrderController::class, 'newOrdersPage'])->name('orders.new.page');
    Route::get('/orders/product-search', [AdminOrderController::class, 'productSearch'])->name('orders.product.search');
    Route::post('/orders/store-manual', [AdminOrderController::class, 'storeManual'])->name('orders.store.manual');
    Route::post('/orders/{id}/accept', [AdminOrderController::class, 'acceptOrder'])->name('orders.accept');
    Route::post('/orders/{id}/reject', [AdminOrderController::class, 'rejectOrder'])->name('orders.reject');
    Route::post('/orders/{id}/payment-callback', [AdminOrderController::class, 'paymentCallback'])->name('orders.payment.callback');

    Route::get('/orders', [AdminOrderController::class, 'order_index'])->name('orders.index');

    //order view//
    Route::get(
        '/orders/{id}',
        [AdminOrderController::class, 'show']
    )->name('orders.show');
    Route::patch(
        '/orders/{id}/update-status',
        [AdminOrderController::class, 'updateStatus']
    )->name('orders.update.status');

    Route::post('/orders/{id}/delivery', [AdminOrderController::class, 'updateDelivery'])->name('orders.delivery');

    /*
    |--------------------------------------------------------------------------
    | ACCOUNTS MANAGEMENT (order history only — cashier's "sales" view)
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/accounts/order-history',
        [App\Http\Controllers\admin\AccountsManagementController::class, 'orderHistory']
    )->name('accounts.order.history');
});


// accounts

Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
    |--------------------------------------------------------------------------
    | PRODUCT MANAGEMENT
    |--------------------------------------------------------------------------
    */

        Route::post(
            '/products/store',
            [ProductManagementController::class, 'store']
        )->name('products.store');

        Route::put(
            '/products/{id}/update',
            [ProductManagementController::class, 'update']
        )->name('products.update');

        Route::delete(
            '/products/{id}',
            [ProductManagementController::class, 'destroy']
        )->name('products.delete');

        /*
    |--------------------------------------------------------------------------
    | SALARY MANAGEMENT
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/salary',
            [AccountController::class, 'salary']
        )->name('salary.index');

        Route::post(
            '/salary/store',
            [AccountController::class, 'salaryStore']
        )->name('salary.store');

        Route::post(
            '/salary/{id}/update',
            [AccountController::class, 'salaryUpdate']
        )->name('salary.update');

        Route::delete(
            '/salary/{id}/delete',
            [AccountController::class, 'salaryDelete']
        )->name('salary.delete');
    });

// inventory-management
Route::middleware(['role:admin'])->prefix('admin/inventory')->group(function () {

    Route::get(
        '/list',
        [InventoryController::class, 'inventoryList']
    )->name('inventory.list');

    Route::post('/update', [InventoryController::class, 'inventoryUpdate'])
        ->name('inventory.update');

    Route::get(
        '/accounts',
        [InventoryController::class, 'inventoryAccounts']
    )->name('inventory.accounts');
});
// admin//

Route::get('/', [HomeController::class, 'Index'])->name('home.index');
Route::get('/about-us', [HomeController::class, 'About_Us'])->name('about_us.index');
Route::get('/privacy-policy', [HomeController::class, 'Privacy_Policy'])->name('Privacy_Policy.index');
Route::get('/terms-and-conditions', [HomeController::class, 'Terms_And_Conditions'])->name('Terms_And_Conditions.index');
Route::get('/faq', [HomeController::class, 'FAQ'])->name('FAQ.index');
Route::get('/our-service', [HomeController::class, 'Our_Service'])->name('Our_Service.index');

Route::patch(
    '/admin/products/{id}/toggle-status',
    [ProductManagementController::class, 'toggleStatus']
)->name('admin.products.toggle-status');
// Product urls
// your-site.com/product-details?category=electronics&min_price=100&max_price=500&brand=sony&sort=price_desc&page=2
Route::get('/product-details', [FrontProductController::class, 'Product_Details'])
    ->name('Product_Details');
Route::get('/product-by-category', [FrontProductController::class, 'Product_by_category'])
    ->name('Product_By_Category');

// Cart Url
Route::get('/product-cart/add', [CartController::class, 'Product_Cart_ADD'])->name('Product_Cart_Add');
Route::get('/product-cart', [CartController::class, 'Product_Cart'])->name('Product_Cart');
Route::get('/product-cart/remove/all', [CartController::class, 'Product_Cart_Remove'])->name('Product_Cart_Remove');
Route::get('/product-cart/remove/single/{id}', [CartController::class, 'Product_Cart_Remove_Single'])->name('Product_Cart_Remove_Single');
Route::get('/product-cart/update/single/{id}/quantity/{quantity}', [CartController::class, 'Product_Cart_update_Single'])->name('Product_Cart_update_Single');

// checkout Url
Route::get('/product-checkout', [CheckoutController::class, 'Product_Checkout'])->name('Product_Checkout');
Route::post('/product-checkout/create', [CheckoutController::class, 'Product_Checkout_Create'])->name('Product_Checkout_Create');

// order success Url
Route::get('/product/order/success/{id}', [OrderController::class, 'Order_Success'])->name('Order_Success');

// product/weekly-featured Url
Route::get('/search', [StoreController::class, 'search'])->name('search');
Route::get('/search/suggest', [StoreController::class, 'searchSuggestions'])->name('search.suggest');

Route::get('/shop', [StoreController::class, 'shop'])->name('shop');

Route::get('/product/weekly-featured', [StoreController::class, 'Weekly_Featured'])->name('Weekly_Featured');

// product/weekly-featured Url
Route::get('/product/hot-sale-item', [StoreController::class, 'Hot_Sale_Item'])->name('Hot_Sale_Item');
// product/weekly-featured Url
Route::get('/product/top-new-items', [StoreController::class, 'Top_New_Items'])->name('Top_New_Items');
// product/weekly-featured Url
Route::get('/product/top-selling', [StoreController::class, 'Top_Selling'])->name('Top_Selling');
// product/weekly-featured Url
Route::get('/product/top-rated-item', [StoreController::class, 'Top_Rated_Item'])->name('Top_Rated_Item');
