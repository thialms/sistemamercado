<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produtos;
use App\Models\vendas;
use App\Models\vendas_itens;
use App\Models\estoque_movimentos;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function finalizarCompra(Request $request)
    {
        $itens = $request->input('itens', []);
        if (!is_array($itens) || count($itens) == 0) {
            return response()->json(['erro' => 'Nenhum item enviado para venda.'], 400);
        }

        $usuarioId = 1; // Ajuste conforme autenticação
        $lojaId = 1; // Ajuste conforme autenticação
        $formaPagamento = 1;
        $tipoVenda =  'normal'; // 'fiado' ou 'normal'
        $totalVenda = 0;

        DB::beginTransaction();
        try {
            $itensInsuficientes = [];

            // 1. Verifica todos os itens antes de atualizar o estoque
            foreach ($itens as $item) {
                if (!isset($item['id']) || !isset($item['quantidade'])) {
                    DB::rollBack();
                    return response()->json(['erro' => 'Dados do item inválidos.'], 400);
                }
                $produto = produtos::where('id', $item['id'])->lockForUpdate()->first();
                if (!$produto || $produto->estoque_atual < $item['quantidade']) {
                    $itensInsuficientes[] = $item['nome'] ?? 'ID '.$item['id'];
                }
            }

            if (count($itensInsuficientes) > 0) {
                DB::rollBack();
                return response()->json([
                    'erro' => 'Estoque insuficiente para: ' . implode(', ', $itensInsuficientes)
                ], 400);
            }

            // 2. Atualiza estoque e calcula total
            foreach ($itens as $item) {
                $produto = produtos::where('id', $item['id'])->lockForUpdate()->first();
                $produto->estoque_atual -= $item['quantidade'];
                $produto->save();
                $totalVenda += $produto->preco_venda * $item['quantidade'];
            }

            // 3. Salva venda
            $venda = vendas::create([
                'usuario_id'      => $usuarioId,
                'loja_id'         => $lojaId,
                'forma_pagamento_id' => $formaPagamento,
                'tipo_venda'      => $tipoVenda,
                'total'           => $totalVenda,
            ]);

            // 4. Salva itens da venda
            foreach ($itens as $item) {
                $produto = produtos::find($item['id']);
                vendas_itens::create([
                    'venda_id'    => $venda->id,
                    'produto_id'  => $produto->id,
                    'quantidade'  => $item['quantidade'],
                    'preco_unitario' => $produto->preco_venda,
                ]);

                // 5. Salva movimento de estoque
                estoque_movimentos::create([
                    'produto_id'     => $produto->id,
                    'tipo_movimento' => 'VENDA',
                    'quantidade'     => $item['quantidade'],
                    'usuario_id'     => $usuarioId,
                    'loja_id'        => $lojaId,
                    'observacao'     => 'Venda realizada',
                ]);
            }

            DB::commit();
            return response()->json(['sucesso' => true, 'venda_id' => $venda->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['erro' => $e->getMessage()], 500);
        }
    }

    public function relatorio()
    {
        $vendas = \App\Models\vendas::with(['itens.produto', 'usuario'])->orderBy('id', 'desc')->get();
        return view('relatorio', compact('vendas'));
    }
    public function novaVenda()
    {
        $ultimoId = \App\Models\vendas::max('id') ?? 0;
        $proximoId = $ultimoId + 1;
        // Passe $proximoId para a view
        return view('vendas', [
            'proximoId' => $proximoId,
            // outros dados necessários...
        ]);
    }
}