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
        Schema::create('estoque_movimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->string('tipo_movimento');
            $table->integer('quantidade');
            $table->unsignedBigInteger('usuario_id');
            $table->string('observacao');
            $table->timestamps();

            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque_movimentos');
    }
};
