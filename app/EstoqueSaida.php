<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstoqueSaida extends Model
{
    protected $table = 'estoque_saida';

    protected $fillable = [
    	'maquina_id',
    	'produto_id',
    	'filial_id',
    	'qtd',
    	'pcoSaida'
    	];

    public function maquina(){
    	return $this->belongsTo('App\Maquina');
    }

    public function produto(){
    	return $this->belongsTo('App\Produto');
    }

    public function filial(){
    	return $this->belongsTo('App\Filial');
    }
}
