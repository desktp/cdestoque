<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstoqueMaquina extends Model
{
    protected  $fillable = ['maquina_id', 'produto_id', 'qtd', 'mola', 'pcoSaida'];

    public function maquina(){
    	return $this->belongsTo('App\Maquina', 'maquina_id');
    }

    public function produto(){
    	return $this->belongsTo('App\Produto', 'produto_id');
    }
}
