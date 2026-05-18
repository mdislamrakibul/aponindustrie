<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccountController;

use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProductController as FrontProductController;

use App\Http\Controllers\Admin\ProductManagementController;



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


//login//
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
//login//

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');



//OTP//

//OTP//
//admin//

Route::get('/admin/login', [AuthController::class, 'showAdminLogin']);
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users');

    Route::post('/users/store', [UserController::class, 'store'])
        ->name('users.store');

    Route::post('/users/{id}/update', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->name('users.delete');

    // PRODUCT MANAGEMENT

    Route::get('/products', [ProductManagementController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [ProductManagementController::class, 'create'])
        ->name('products.create');

    Route::get('/products/{id}/edit', [ProductManagementController::class, 'edit'])
        ->name('products.edit');

    Route::get('/products/{id}', [ProductManagementController::class, 'show'])
        ->name('products.show');
});

Route::middleware(['role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {

    Route::get('/users', [UserController::class, 'index'])
        ->name('users');
});
//accounts



Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // =============================
        // PRODUCT MANAGEMENT
        // =============================

        Route::get('/products', [App\Http\Controllers\Admin\ProductManagementController::class, 'index'])
            ->name('products.index');

        Route::post('/products/store', [App\Http\Controllers\Admin\ProductManagementController::class, 'store'])
            ->name('products.store');

        Route::post('/products/{id}/update', [App\Http\Controllers\Admin\ProductManagementController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{id}', [App\Http\Controllers\Admin\ProductManagementController::class, 'destroy'])
            ->name('products.delete');


        Route::get('/accounts', [AccountController::class, 'index'])
            ->name('accounts.index');
        Route::get('/accounts/create/{id}', [AccountController::class, 'create'])
            ->name('accounts.create');
        Route::post('/accounts/store/{id}', [AccountController::class, 'store'])
            ->name('accounts.store');
        Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])
            ->name('accounts.edit');
        Route::post('/accounts/{id}/update', [AccountController::class, 'update'])
            ->name('accounts.update');
        Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])
            ->name('accounts.delete');



        Route::get('/order/all', [AdminOrderController::class, 'order_index'])
            ->name('order.index');
    });


//admin//


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
Route::get('/product-cart/add', [CartController::class, 'Product_Cart_Add'])->name('Product_Cart_Add');
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
Route::get('/product/weekly-featured', [StoreController::class, 'Weekly_Featured'])->name('Weekly_Featured');


// product/weekly-featured Url
Route::get('/product/hot-sale-item', [StoreController::class, 'Hot_Sale_Item'])->name('Hot_Sale_Item');
// product/weekly-featured Url
Route::get('/product/top-new-items', [StoreController::class, 'Top_New_Items'])->name('Top_New_Items');
// product/weekly-featured Url
Route::get('/product/top-selling', [StoreController::class, 'Top_Selling'])->name('Top_Selling');
// product/weekly-featured Url
Route::get('/product/top-rated-item', [StoreController::class, 'Top_Rated_Item'])->name('Top_Rated_Item');
