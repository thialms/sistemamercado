<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produtos extends Model
{
    protected $fillable = [
        'loja_id',
        'codigo_barras', // <-- Adicione esta linha
        'nome',
        'marca',
        'preco_venda',
        'custo',
        'estoque_atual',
        'created_at',
        // adicione outros campos se necessário
    ];
}
