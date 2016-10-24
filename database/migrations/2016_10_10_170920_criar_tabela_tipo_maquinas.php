<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaTipoMaquinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_maquinas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_maquina');
            $table->timestamps();
        });

        DB::table('tipo_maquinas')->insert(
            array(
                'tipo_maquina' => 'Bebidas Quentes'
            )
        );

        DB::table('tipo_maquinas')->insert(
            array(
                'tipo_maquina' => 'Snack Machine'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_maquinas');
    }
}
