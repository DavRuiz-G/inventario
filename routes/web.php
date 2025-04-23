<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/products', App\Http\Controllers\ProductController::class);
Route::resource('/productos', App\Http\Controllers\ProductoController::class);
Route::resource('/entradas', App\Http\Controllers\EntradaController::class);
Route::resource('/salidas', App\Http\Controllers\SalidaController::class);
