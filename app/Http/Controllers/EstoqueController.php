<?php

namespace App\Http\Controllers;
use App\Models\produtos;
use App\Models\estoque_movimento;
use App\Models\custos_historicos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function adicionarProduto(array $dados, int $usuarioId)
    {
        DB::beginTransaction();

        try {
            $produto = produto::create([
                'id'            => $dados['id'],
                'loja_id'       => $dados['loja_id'],
                'nome'          => $dados['nome'],
                'preco_venda'   => $dados['preco_venda'],
                'custo'         => $dados['custo'],
                'estoque_atual' => $dados['quantidade_inicial'],
                'created_at'    => now()
            ]);

            $movimento = estoque_movimento::create([
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
}
