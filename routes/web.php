<?php

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
Route::get('/addProduct', function () {
    return view('addProduct');
});

Route::post('/addProduct/store', [App\Http\Controllers\ProductController::class,'add'])->name('addProduct');

Route::get('/showProduct', [App\Http\Controllers\ProductController::class, 'view'])->name('showProduct');

Route::get('/deleteProduct/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('deleteProduct');

Route::get('/editProduct/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('editProduct');

Route::post('/updateProduct', [App\Http\Controllers\ProductController::class, 'update'])->name('updateProduct');

Route::get('/productDetail/{id}', [App\Http\Controllers\ProductController::class, 'productDetail'])->name('productDetail');

Route::post('/addCart', [App\Http\Controllers\CartController::class, 'addCart'])->name('addCart');

// Route for the product page
Route::post('/addToCart', [App\Http\Controllers\CartController::class, 'addToCart'])->name('addToCart');

Route::get('/allProduct', [App\Http\Controllers\ProductController::class, 'allProduct'])->name('allProduct');

Route::match(['get', 'post'], '/allProduct', [App\Http\Controllers\ProductController::class, 'allProduct'])->name('allProduct');

Route::get('/search', 'ProductController@search')->name('search');

Route::get('/myCart', [App\Http\Controllers\CartController::class,'view'])->name('myCart');

Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'paymentPost'])->name('payment.post');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
