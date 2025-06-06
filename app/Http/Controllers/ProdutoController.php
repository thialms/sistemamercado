<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdutoController extends Controller
{
    public function buscarProduto(Request $request)
    {
        $codigo = $request->input('codigo');

        $url = "https://world.openfoodfacts.org/api/v0/product/{$codigo}.json";

        $resposta = Http::get($url);
        $dados = $resposta->json();

        if ($dados['status'] === 1) {
            $produto = $dados['product'];

            return response()->json([
                'nome' => $produto['product_name'] ?? 'Não disponível',
                'marca' => $produto['brands'] ?? 'Não disponível',
                'descricao' => $produto['generic_name'] ?? 'Não disponível',
                'imagem' => $produto['image_url'] ?? null
            ]);
        } else {
            return response()->json([
                'erro' => 'Produto não encontrado.'
            ], 404);
        }
    }
}

