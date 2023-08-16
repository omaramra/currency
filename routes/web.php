<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;

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

Route::resource('/products', ProductController::class);
Route::resource('/currencies', CurrencyController::class);
Route::resource('/categories', CategoryController::class);

Route::put('/customers/changeStatus/{customer}', [CustomerController::class, 'toggleStatus'])->name('customers.toggleStatus');
Route::resource('/customers', CustomerController::class);



Route::get('/{any?}', function () {
    return view('layouts.app');
});
