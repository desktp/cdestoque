<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMaquina extends Model
{
	//protected $table = 'tipo_maquinas';
	protected $fillable = ['tipo_maquina'];

    public function maquina_modelo(){
    	return $this->hasMany('App\MaquinaModelo');
    }
}
