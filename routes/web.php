<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/home', function () {
    if (!session('logado')) {
        return redirect()->route('login');
    }
    return view('home');
})->name('home');

Route::get('/vendas', function () {
    if (!session('logado')) {
        return redirect()->route('login');
    }
    return view('vendas');
})->name('vendas');

Route::controller(LoginController::class)->group(function(){
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
