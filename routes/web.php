<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutoController;

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
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


Route::get('/carrinho/adicionar', function () {
    if (!session('logado')) {
        return redirect()->route('login');
    }
    return app(\App\Http\Controllers\CartController::class)->index();
})->name('addProdutoCarrinho');

Route::get('/scan', function () {
    if (!session('logado')) {
        return redirect()->route('login');
    }
    return view('scan'); 
})->name('scan');

Route::post('/buscar-produto', [ProdutoController::class, 'buscarProduto']);