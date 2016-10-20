<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaEstoqueMaquina extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_maquinas', function (Blueprint $table) {
            $table->foreign('maquina_id')
                ->index()
                ->references('id')
                ->on('maquinas');
            $table->foreign('produto_id')
                ->index()
                ->references('id')
                ->on('produtos');
            $table->integer('qtd');
            $table->integer('mola');
            $table->decimal('pcoSaida', 13, 2);
            $table->timestamps();
            $table->index(['maquina_id', 'produto_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estoque_maquinas');
    }
}
