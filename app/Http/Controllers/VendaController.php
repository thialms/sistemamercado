<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produtos;

class VendaController extends Controller
{
    public function finalizarCompra(Request $request)
    {
        $itens = $request->input('itens', []);
        foreach ($itens as $item) {
            $produto = produtos::where('id', $item['id'])->first();
            if ($produto && $produto->estoque_atual >= $item['quantidade']) {
                $produto->estoque_atual -= $item['quantidade'];
                $produto->save();
            } else {
                return response()->json(['erro' => "Estoque insuficiente para {$item['nome']}"], 400);
            }
        }
        return response()->json(['sucesso' => true]);
    }
}