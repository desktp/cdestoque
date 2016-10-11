<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'marca_id', 'tipoProduto_id'];

    public function marca(){
    	return $this->belongsTo('App\Marca', 'marca_id');
    }

    public function tipoProduto(){
    	return $this->belongsTo('App\TipoProduto', 'tipoproduto_id');
    }
}
