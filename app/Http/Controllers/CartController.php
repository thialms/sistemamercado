<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('addProdutoCarrinho');
    }

    public function telaVenda()
    {
        if (!session()->has('carrinho')) {
            session(['carrinho' => []]);
        }
        // Carregue os itens do carrinho se quiser exibir na view
        $carrinho = session('carrinho', []);
        return view('vendas', compact('carrinho'));
    }
}


