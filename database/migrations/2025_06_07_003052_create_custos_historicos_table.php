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
        Schema::create('custos_historicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->double('custo');
            $table->unsignedBigInteger('origem_movimento_id');
            $table->unsignedBigInteger('loja_id');
            $table->string('observacao');
            $table->timestamps();
            
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('origem_movimento_id')->references('id')->on('estoque_movimentos');
            $table->foreign('loja_id')->references('id')->on('lojas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custos_historicos');
    }
};
