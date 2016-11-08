<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColunaFabricanteTabelaMaquina extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maquinas', function (Blueprint $table) {
            $table->dropForeign(['fabricante_id']);
            $table->dropColumn('fabricante_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maquinas', function (Blueprint $table) {
            
            $table->integer('fabricante_id')->unsigned();
            $table->foreign('fabricante_id')
                ->references('id')
                ->on('fabricantes');
        });
    }
}
