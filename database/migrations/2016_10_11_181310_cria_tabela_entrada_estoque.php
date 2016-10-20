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
            $table->foreign('produto_id')
                ->index()
                ->references('id')
                ->on('produtos');
            $table->foreign('filial_id')
                ->index()
                ->references('id')
                ->on('filiais');
            $table->integer('qtd');
            $table->decimal('pcoEntrada', 13, 2);
            $table->timestamps();
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
