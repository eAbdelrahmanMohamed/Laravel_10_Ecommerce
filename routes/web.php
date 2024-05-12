<?php

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


Auth::routes();

Route::get('/', [App\Http\Controllers\AppController::class, 'index'])->name('home');
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/update_cart_wishlist_count', [App\Http\Controllers\ShopController::class, 'UpdateCartWishlistCount'])->name('shop.update_cart_wishlist_count');
// Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.filter');
Route::get('/product/{slug}', [App\Http\Controllers\ShopController::class, 'productDetails'])->name('shop.product.detail');
// Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
// Route::get('/cart/update', [App\Http\Controllers\CartController::class, 'updatecart'])->name('cart.update');
// Route::post('/cart/store', [App\Http\Controllers\CartController::class, 'addtocart'])->name('cart.store');
Route::prefix('cart')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/store', [App\Http\Controllers\CartController::class, 'addtocart'])->name('cart.store');
    Route::put('/update', [App\Http\Controllers\CartController::class, 'updatecart'])->name('cart.update');
    Route::delete('/delete', [App\Http\Controllers\CartController::class, 'removefromcart'])->name('cart.delete');
});
Route::prefix('wishlist')->group(function () {
    Route::get('/', [App\Http\Controllers\WishListController::class, 'index'])->name('wishlist');
    Route::post('/add', [App\Http\Controllers\WishListController::class, 'addProductToWishlist'])->name('wishlist.store');
    Route::put('/update', [App\Http\Controllers\WishListController::class, 'updatewishlist'])->name('wishlist.update');
    Route::delete('/delete', [App\Http\Controllers\WishListController::class, 'removefromwishlist'])->name('wishlist.delete');
});
Route::middleware('auth')->group(function () {
    Route::get('/my-account', [App\Http\Controllers\Usercontroller::class, 'index'])->name('users.index');
});
Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admins.index');
});
