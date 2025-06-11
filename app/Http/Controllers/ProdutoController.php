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

        $resposta = Http::withoutVerifying()->get($url);
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

    public function buscaRapida(Request $request)
    {
        $query = $request->input('query');
        $produtos = \App\Models\produtos::where('nome', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%") // <-- ajuste aqui
            ->where('estoque_atual', '>', 0)
            ->limit(10)
            ->get(['id', 'nome', 'estoque_atual', 'preco_venda']); // <-- ajuste aqui

        return response()->json($produtos);
    }
}

