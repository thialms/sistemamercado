<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produtos extends Model
{
    protected $fillable = [
        'loja_id',
        'nome',
        'marca',
        'preco_venda',
        'custo',
        'estoque_atual',
        'created_at',
        // adicione outros campos se necessário
    ];
}
