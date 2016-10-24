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
            $table->integer('maquina_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->integer('qtd');
            $table->integer('mola');
            $table->decimal('pcoSaida', 13, 2);
            $table->timestamps();
            $table->index(['maquina_id', 'produto_id']);

            $table->foreign('maquina_id')
                ->references('id')
                ->on('maquinas');
            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos');
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
