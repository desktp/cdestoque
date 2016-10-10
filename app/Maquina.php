<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $fillable = ['modelo', 'fabricante_id', 'tipoMaquina_id'];

    public function fabricante(){
    	return $this->belongsTo('App\Fabricante', 'fabricante_id');
    }

    public function tipoMaquina(){
    	return $this->belongsTo('App\TipoMaquina', 'tipoMaquina_id');
    }
}
