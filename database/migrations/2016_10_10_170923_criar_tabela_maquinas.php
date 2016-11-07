lar<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaMaquinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fabricante_id')->unsigned();
            $table->integer('maquina_modelo_id')->unsigned();
            $table->integer('unidade_id')->unsigned()
            $table->timestamps();

            // FKs

            $table->foreign('fabricante_id')
                ->references('id')
                ->on('fabricantes');
            $table->foreign('maquina_modelo_id')
                ->references('id')
                ->on('maquina_modelos');
            $table->foreign('unidade_id')
                ->references('id')
                ->on('unidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maquinas');
    }
}
