<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaEntradaEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_entrada', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('filial_id')->unsigned();
            $table->integer('qtd');
            $table->decimal('pcoEntrada', 13, 2);
            $table->timestamps();

            //FKs
            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos');
            $table->foreign('filial_id')
                ->references('id')
                ->on('filiais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estoque_entrada');
    }
}
