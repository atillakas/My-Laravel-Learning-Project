<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::prefix('admin')->group(function () {
    Route::resources([
        'products'=>ProductController::class
    ]);
});

Route::get('/home', function () {
    return view('theme.home');
});
Route::get('/category', function () {
    return view('theme.category');
});
Route::get('/product', function () {
    return view('theme.product-detail');
});
Route::get('/cart', function () {
    return view('theme.cart');
});
Route::get('/checkout', function () {
    return view('theme.checkout');
});
Route::get('/login-register', function () {
    return view('theme.login-register');
});