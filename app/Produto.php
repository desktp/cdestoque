<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'marca_id', 'tipo_produto_id'];

    public function marca(){
    	return $this->belongsTo('App\Marca', 'marca_id');
    }

    public function tipo_produto(){
    	return $this->belongsTo('App\TipoProduto', 'tipo_produto_id');
    }

    public function estoque_maquina(){
    	return $this->hasMany('App\EstoqueMaquina');
    }

    public function estoque_saida(){
        return $this->hasMany('App\EstoqueSaida');
    }
}
