<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendas extends Model
{
    protected $fillable = [
        'usuario_id',
        'loja_id',
        'forma_pagamento_id',
        'tipo_venda',
        'total',
    ];
}
