<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMaquina extends Model
{
	protected $table = 'tipoMaquinas';
	protected $fillable = ['tipoMaquina'];

    public function maquina(){
    	return $this->hasMany('App\Maquina');
    }
}
