<?php

// require_once __DIR__ . '/jetstream.php';
// require_once __DIR__ . '/admin.php';
// require_once __DIR__ . '/portfolio.php';
// require_once __DIR__ . '/apps.php';
// require_once __DIR__ . '/bteb.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/products', [HomeController::class, 'products'])->name('home.products');
Route::get('/products/{slug}', [HomeController::class, 'productDetails'])->name('home.product-details');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('home.contact-us');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('home.page');

// return attribute values depend on attribute id
Route::post('/attribute-values', [HomeController::class, 'attributeValues'])->name('home.attribute-values');
// attribute value details
Route::post('/attribute-value-details', [HomeController::class, 'attributeValueDetails'])->name('home.attribute-value-details');
// color details
Route::post('/color-details', [HomeController::class, 'colorDetails'])->name('home.color-details');


// add to cart routes
Route::prefix('cart')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
    Route::post('/cart-item-count', [CartController::class, 'cartItemCount'])->name('cart.cart-item-count');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add-to-cart');
    Route::get('/clear-cart', [CartController::class, 'clearCart'])->name('cart.clear-cart');
    Route::post('/confirm-order', [CartController::class, 'confirmOrder'])->name('cart.confirm-order');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
});
