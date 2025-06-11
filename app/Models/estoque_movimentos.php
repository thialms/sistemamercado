<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estoque_movimentos extends Model
{
    protected $fillable = [
        'produto_id',
        'tipo_movimento',
        'quantidade',
        'usuario_id',
        'loja_id',
        'observacao',
    ];
}
