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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id(); // codigo de barras
            $table->unsignedBigInteger('loja_id');
            $table->bigInteger('codigo_barras')->unique();
            $table->string('nome')->unique();
            $table->string('marca');
            $table->double('preco_venda');
            $table->double('custo');
            $table->integer('estoque_atual');
            $table->timestamps();
            
            $table->foreign('loja_id')->references('id')->on('lojas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
