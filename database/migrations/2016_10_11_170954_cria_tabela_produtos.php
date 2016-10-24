<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marca_id')->unsigned();
            $table->integer('tipo_produto_id')->unsigned();
            $table->string('nome');
            $table->timestamps();

            //FKs
            $table->foreign('marca_id')
                ->references('id')
                ->on('marcas');
            $table->foreign('tipo_produto_id')
                ->references('id')
                ->on('tipo_produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
