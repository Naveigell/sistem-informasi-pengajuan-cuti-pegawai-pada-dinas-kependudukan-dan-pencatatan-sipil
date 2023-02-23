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
Route::redirect('/', '/login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('dashboard', \App\Http\Controllers\Admin\DashboardController::class);
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class)->except('show');
});

Route::prefix('login')->name('login.')->group(function () {
    Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('store');
    Route::view('/', 'auth.login')->name('index');
});

Route::prefix('register')->name('register.')->group(function () {
    Route::post('/', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('store');
    Route::view('/', 'auth.register')->name('index');
});
