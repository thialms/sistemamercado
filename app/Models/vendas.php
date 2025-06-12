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

    public function itens()
    {
        return $this->hasMany(\App\Models\vendas_itens::class, 'venda_id');
    }
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
}
