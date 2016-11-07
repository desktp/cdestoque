<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaMaquinaModelos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquina_modelos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fabricante_id')->unsigned();
            $table->integer('tipo_maquina_id')->unsigned();
            $table->string('nome');
            $table->timestamps();

            $table->foreign('fabricante_id')
                    ->references('id')
                    ->on('fabricantes');
            $table->foreign('tipo_maquina_id')
                ->references('id')
                ->on('tipo_maquinas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maquina_modelos');
    }
}
