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
            $table->integer('tipo_maquina_id')->unsigned();
            $table->integer('fabricante_id')->unsigned();
            $table->string('nome');
            $table->timestamps();

            // FKs
            $table->foreign('tipo_maquina_id')
                ->references('id')
                ->on('tipo_maquinas');
            $table->foreign('fabricante_id')
                ->references('id')
                ->on('fabricantes');
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
