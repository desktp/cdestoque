<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaEstoqueSaida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_saida', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filial_id')->unsigned();
            $table->integer('maquina_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->integer('qtd');
            $table->decimal('pcoSaida', 13, 2);
            $table->timestamps();
            
            $table->index(['filial_id', 'maquina_id', 'produto_id']);

            //FKs
            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos');
            $table->foreign('filial_id')
                ->references('id')
                ->on('filiais');
            $table->foreign('maquina_id')
                ->references('id')
                ->on('maquinas');                
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estoque_saida');
    }
}
