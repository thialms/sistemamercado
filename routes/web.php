<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\CartController;

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
    // Executa a lógica de inicialização do carrinho do CartController
    app(CartController::class)->telaVenda();

    $itens = []; // Ou carregue os itens do carrinho se desejar
    return view('vendas', compact('itens'));
})->name('vendas');

Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque');

Route::post('/estoque', [EstoqueController::class, 'adicionarProdutoView'])->name('produtos.store');

Route::controller(LoginController::class)->group(function(){
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/scan', function () {
    if (!session('logado')) {
        return redirect()->route('login');
    }
    return view('scan'); 
})->name('scan');

Route::post('/buscar-produto', [ProdutoController::class, 'buscarProduto']);
Route::post('/estoque/adicionar-produto', [EstoqueController::class, 'adicionarProdutoView'])->name('produtos.store');
Route::put('/produtos/{produto}', [EstoqueController::class, 'update'])->name('produtos.update');
Route::get('/produtos/busca-rapida', [ProdutoController::class, 'buscaRapida']);
Route::post('/finalizar-compra', [VendaController::class, 'finalizarCompra']);
Route::post('/buscar-no-estoque', [ProdutoController::class, 'buscarNoEstoque']);