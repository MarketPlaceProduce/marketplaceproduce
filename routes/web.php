<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\OrderController;

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

Route::get('/dashboard', [OrderController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/orders/create', [OrderController::class, 'create'])->middleware(['auth'])->name('create-order');

Route::post('/orders/create', [OrderController::class, 'store'])->middleware(['auth'])->name('create-order');

require __DIR__.'/auth.php';
