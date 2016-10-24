<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->integer('filial_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->integer('qtd');
            $table->timestamps();
            $table->index(['filial_id', 'produto_id'])->unique();

            // FKs
            $table->foreign('filial_id')
                ->references('id')
                ->on('filiais');
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
        Schema::dropIfExists('estoque');
    }
}
