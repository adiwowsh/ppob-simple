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


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/login', [\App\Http\Controllers\HomeController::class, 'login']);
Route::post('/login', [\App\Http\Controllers\HomeController::class, 'loginPost']);
Route::get('/logout', [\App\Http\Controllers\HomeController::class, 'logout']);

Route::get('/register', [\App\Http\Controllers\HomeController::class, 'register']);
Route::get('/account', [\App\Http\Controllers\HomeController::class, 'account']);
Route::get('/pulsa', [\App\Http\Controllers\HomeController::class, 'productPulsa']);
Route::get('/pln-token', [\App\Http\Controllers\HomeController::class, 'productPlnToken']);
Route::get('/pln-pascabayar', [\App\Http\Controllers\HomeController::class, 'productPlnPascabayar']);
Route::get('/topup', [\App\Http\Controllers\HomeController::class, 'topup']);
