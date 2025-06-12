<?php

namespace App\Http\Controllers;
use App\Models\produtos;
use App\Models\estoque_movimentos;
use App\Models\custos_historicos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function adicionarProduto(array $dados, int $usuarioId)
    {
        DB::beginTransaction();

        try {
            $produto = produtos::create([
                // 'id'            => $dados['id'],
                'loja_id'       => $dados['loja_id'],
                'nome'          => $dados['nome'],
                'marca'        => $dados['marca'],
                'preco_venda'   => $dados['preco_venda'],
                'custo'         => $dados['custo'],
                'estoque_atual' => $dados['quantidade_inicial'],
                'created_at'    => now()
            ]);

            $movimento = estoque_movimentos::create([
                'produto_id'     => $produto->id,
                'tipo_movimento' => 'ENTRADA_INICIAL',
                'quantidade'     => $dados['quantidade_inicial'],
                'usuario_id'     => $usuarioId,
                'loja_id'        => $dados['loja_id'],
                'data_movimento' => now(),
                'observacao'     => 'Entrada inicial do produto'
            ]);

            custos_historicos::create([
                'produto_id'     => $produto->id,
                'data_inicio'    => now(),
                'custo'          => $dados['custo'],
                'origem_movimento_id'=>$movimento->id,
                'loja_id'        => $dados['loja_id'],
                'observacao'     => 'Entrada inicial do produto'
            ]);

            DB::commit();

            return $produto;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function adicionarProdutoView(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string',
            'marca' => 'nullable|string',
            'quantidade' => 'required|integer|min:0',
            'preco' => 'required|numeric|min:0',
            'custo' => 'required|numeric|min:0',
        ]);

        $dados['loja_id'] = 1;

        $userId = 1;
        // $dados['loja_id'] = auth()->user()->loja_id ?? 1;
        $dados['quantidade_inicial'] = $dados['quantidade'];
        $dados['preco_venda'] = $dados['preco'];

        // Corrija aqui: se não houver usuário, lance erro ou redirecione
        // $usuarioId = auth()->id();
        // if (!$usuarioId) {
        //     return redirect()->back()->with('error', 'Usuário não autenticado!');
        // }

        $this->adicionarProduto($dados, $userId);

        return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
    }
    public function index(Request $request)
    {
        $query = $request->input('query');
        $produtos = \App\Models\produtos::query();

        if ($query) {
            $produtos->where('nome', 'like', "%{$query}%");
        }

        $produtos = $produtos->get();

        return view('estoque', compact('produtos', 'query'));
    }
    public function update(Request $request, $id)
    {
        try {
            $produto = \App\Models\produtos::findOrFail($id);

            $dados = $request->validate([
                'nome' => 'required|string',
                'estoque_atual' => 'required|integer|min:0',
                'preco_venda' => 'required|numeric|min:0',
            ]);

            // Salva os dados antigos para comparação
            $estoqueAnterior = $produto->estoque_atual;

            $produto->update($dados);

            // Se houve alteração no estoque, salva o movimento
            if ($estoqueAnterior != $dados['estoque_atual']) {
                estoque_movimentos::create([
                    'produto_id'     => $produto->id,
                    'tipo_movimento' => 'AJUSTE',
                    'quantidade'     => $dados['estoque_atual'] - $estoqueAnterior,
                    'usuario_id'     => auth()->id() ?? 1,
                    'loja_id'        => $produto->loja_id,
                    'observacao'     => 'Ajuste manual de estoque',
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
