<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $fillable = ['nome', 'fabricante_id', 'tipo_maquina_id'];

    public function fabricante(){
    	return $this->belongsTo('App\Fabricante', 'fabricante_id');
    }

    public function tipo_maquina(){
    	return $this->belongsTo('App\TipoMaquina', 'tipo_maquina_id');
    }
}
