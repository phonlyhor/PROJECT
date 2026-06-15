<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
use App\Services\TelegramService;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Must Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard (មានតែមួយគត់)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Users
    Route::get('dashboard/users', [UserController::class, 'index'])->name('user');
    Route::get('dashboard/users/form', [UserController::class, 'form'])->name('form');
    Route::post('dashboard/user/store',[UserController::class,'store'])->name('store');
    Route::get('dashboard/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('dashboard/users/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('dashboard/users/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

    // Products
    Route::get('dashboard/product', [ProductsController::class, 'product'])->name('products');
    Route::post('/productStore', [ProductsController::class, 'productStore'])->name('productStore');
    Route::get('dashboard/productList', [ProductsController::class, 'productList'])->name('productList');
    Route::get('dashboard/productEdit/{id}', [ProductsController::class,'productedit'])->name('productsEdit');
    Route::post('dashboard/productEdit', [ProductsController::class,'productUpdate'])->name('pro');
    Route::delete('dashboard/product/delete/{id}', [ProductsController::class, 'productDelete'])->name('productDelete');

    // Category
    Route::get('dashboard/category', [CategoryController::class, 'create'])->name('category.create');
    Route::post('dashboard/categoryStore', [CategoryController::class, 'store'])->name('category.store');
    Route::get('dashboard/categoryList', [CategoryController::class, 'list'])->name('category.list');
    Route::get('dashboard/categoryEdit/{id}', [CategoryController::class,'categoryShowData'])->name('showEdit');
    Route::put('dashboard/categoryEdit/{id}', [CategoryController::class, 'categoryUpdate'])->name('category.update');
    Route::delete('dashboard/categoryDelete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Seller
Route::get('seller', [UserController::class,'seller'])->name('seller');
Route::get('seller/shop', [UserController::class,'shop'])->name('seller.shop');
Route::post('seller', [UserController::class,'stores'])->name('seller.store');

// Cart
Route::get('seller/cart', [CartController::class, 'view'])->name('seller.cart.view');
Route::post('seller/cart/add/{id}', [CartController::class, 'add'])->name('seller.cart.add');
Route::post('seller/cart/remove/{id}', [CartController::class, 'remove'])->name('seller.cart.remove');

// Payment
Route::get('seller/checkout/{id}', [PaymentController::class, 'checkout'])->name('seller.checkout');
Route::post('/verify-transaction', [PaymentController::class, 'verifyTransaction'])->name('verify.transaction');

// Language (keep only ONE)
Route::get('lang/{lang}', [LanguageController::class, 'switchLanguage'])->name('switch.language');


// routes/web.php

