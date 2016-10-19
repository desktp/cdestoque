<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstoqueEntrada extends Model
{
    protected $table = 'estoque_entrada';

    protected $fillable = [
    	'produto_id',
    	'filial_id',
    	'qtd',
    	'pcoEntrada'
    	];

    public function produto(){
    	return $this->belongsTo('App\Produto');
    }

    public function filial(){
    	return $this->belongsTo('App\Filial');
    }
}
