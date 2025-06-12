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

    // 1 e 2: Busca produto pelo código de barras no estoque local
    public function buscarNoEstoque(Request $request)
    {
        $codigo = $request->input('codigo_barras');
        $produto = \App\Models\produtos::where('codigo_barras', $codigo)
            ->where('estoque_atual', '>', 0)
            ->first();

        if ($produto) {
            // Adiciona ao carrinho na sessão
            $carrinho = session('carrinho', []);
            if (isset($carrinho[$produto->id])) {
                $carrinho[$produto->id]['quantidade'] += 1;
            } else {
                $carrinho[$produto->id] = [
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'descricao' => $produto->descricao ?? '',
                    'codigo_barras' => $produto->codigo_barras,
                    'quantidade' => 1,
                    'preco' => $produto->preco_venda,
                    'estoque' => $produto->estoque_atual,
                    'subtotal' => $produto->preco_venda, // Para facilitar o JS
                ];
            }
            session(['carrinho' => $carrinho]);

            return response()->json([
                'sucesso' => true,
                'produto' => $carrinho[$produto->id],
                'carrinho' => $carrinho
            ]);
        } else {
            return response()->json(['erro' => 'Produto não encontrado ou sem estoque'], 404);
        }
    }

    // 4: Remove produto do carrinho (sessão)
    public function removerDoCarrinho(Request $request)
    {
        $produtoId = $request->input('produto_id');
        $carrinho = session('carrinho', []);
        unset($carrinho[$produtoId]);
        session(['carrinho' => $carrinho]);

        return response()->json(['sucesso' => true, 'carrinho' => $carrinho]);
    }

    // 5: Editar quantidade de um produto no carrinho (sessão)
    public function editarCarrinho(Request $request)
    {
        $produtoId = $request->input('produto_id');
        $quantidade = $request->input('quantidade', 1);

        $carrinho = session('carrinho', []);
        if (isset($carrinho[$produtoId])) {
            $carrinho[$produtoId]['quantidade'] = $quantidade;
            session(['carrinho' => $carrinho]);
            return response()->json(['sucesso' => true, 'carrinho' => $carrinho]);
        } else {
            return response()->json(['erro' => 'Produto não está no carrinho'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        \Log::info('Recebido para update', $request->all());

        $produto = \App\Models\produtos::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'codigo_barras' => 'nullable|numeric|unique:produtos,codigo_barras,' . $id,
            'estoque_atual' => 'required|integer|min:0',
            'preco_venda' => 'required|numeric|min:0',
        ]);

        $produto->nome = $request->input('nome');
        $produto->codigo_barras = $request->input('codigo_barras') ?: null;
        $produto->estoque_atual = $request->input('estoque_atual');
        $produto->preco_venda = $request->input('preco_venda');
        $produto->save();

        return response()->json(['success' => true]);
    }
}

