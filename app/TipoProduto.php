<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
	//protected $table = 'tipoProdutos';
    protected $fillable = ['tipo_produto'];

    public function produto(){
    	return $this->hasMany('App\Produto');
    }
}
