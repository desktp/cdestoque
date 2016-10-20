<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaTipoProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_produto');
            $table->timestamps();
        });

        DB::table('tipo_produtos')->insert(
            array(
                'tipo_produto' => 'Insumo'
            )
        );

        DB::table('tipo_produtos')->insert(
            array(
                'tipo_produto' => 'Bebida'
            )
        );

        DB::table('tipo_produtos')->insert(
            array(
                'tipo_produto' => 'Snack'
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
        Schema::dropIfExists('tipoProdutos');
    }
}
