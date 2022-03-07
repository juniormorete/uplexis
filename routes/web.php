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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('captura')->group(function () {
    Route::get('/', [App\Http\Controllers\CapturaController::class, 'index'])->name('index');

    Route::post('capturar', [
        App\Http\Controllers\CapturaController::class,
        'capturar',
        'before' => 'csrf'
    ])->name('capturar');

    Route::get('lista', [App\Http\Controllers\CapturaController::class, 'lista'])->name('lista');

    Route::delete('excluir', [
        App\Http\Controllers\CapturaController::class,
        'excluir',
        'before' => 'csrf'
    ])->name('excluir');
});
