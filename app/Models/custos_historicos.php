<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class custos_historicos extends Model
{
    protected $fillable = [
        'produto_id',
        'custo',
        'origem_movimento_id',
        'loja_id',
        'observacao',
    ];
}
