<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $fillable = ['maquina_modelo_id', 'unidade_id'];

    public function maquina_modelo(){
    	return $this->belongsTo('App\MaquinaModelo', 'maquina_modelo_id');
    }

    public function unidade(){
    	return $this->belongsTo('App\Unidade', 'unidade_id');
    }
}
