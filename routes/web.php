<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/buy-product/{id}', [HomeController::class, 'buy'])->name('buy-product');

Route::get('/product', [ProductController::class, 'create'])->name('create-product');
Route::post('/product', [ProductController::class, 'store'])->name('products-store');

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/invoices', [InvoicesController::class, 'list'])->name('list-invoices');
Route::post('/invoices/{id}', [InvoicesController::class, 'create'])->name('create-invoices');

Auth::routes();

