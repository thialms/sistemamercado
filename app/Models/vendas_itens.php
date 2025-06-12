<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendas_itens extends Model
{
    public $timestamps = false; // Adicione esta linha

    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
    ];

    public function produto()
    {
        return $this->belongsTo(\App\Models\produtos::class, 'produto_id');
    }
}
