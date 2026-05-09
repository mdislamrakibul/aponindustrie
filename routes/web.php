<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
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
Route::get('/login', function () {
    return view('auth.login');
});

//login//
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
//login//

//register//
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
//register//

// Route::get('/', function () {
//     return view('welcome');
// });

//OTP//

//OTP//

//admin//

Route::get('/admin/login', [AuthController::class, 'showAdminLogin']);

Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', function () {

        if(Auth::user()->role != 'admin') {
            abort(403);
        }

        return view('admin.dashboard');

    });

    Route::get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users');


});

//admin//


Route::get('/', [HomeController::class, 'Index'])->name('home.index');
Route::get('/about-us', [HomeController::class, 'About_Us'])->name('about_us.index');
Route::get('/privacy-policy', [HomeController::class, 'Privacy_Policy'])->name('Privacy_Policy.index');
Route::get('/terms-and-conditions', [HomeController::class, 'Terms_And_Conditions'])->name('Terms_And_Conditions.index');
Route::get('/faq', [HomeController::class, 'FAQ'])->name('FAQ.index');
Route::get('/our-service', [HomeController::class, 'Our_Service'])->name('Our_Service.index');

// Product urls
// your-site.com/product-details?category=electronics&min_price=100&max_price=500&brand=sony&sort=price_desc&page=2
Route::get('/product-details', [ProductController::class, 'Product_Details'])->name('Product_Details');
Route::get('/product-by-category', [ProductController::class, 'Product_by_category'])->name('Product_By_Category');



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
