<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('forma_pagamento_id');
            $table->unsignedBigInteger('loja_id');
            $table->string('tipo_venda');
            $table->string('total');
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamento');
            $table->foreign('loja_id')->references('id')->on('lojas');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
