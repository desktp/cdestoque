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
            $table->foreign('filial_id')
                ->index()
                ->references('id')
                ->on('filiais');
            $table->foreign('produto_id')
                ->index()
                ->references('id')
                ->on('produtos');
            $table->integer('qtd');
            $table->timestamps();
            $table->index(['filial_id', 'produto_id'])->unique();
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
