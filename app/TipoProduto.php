<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
	protected $table = 'tipoProdutos';
    protected $fillable = ['tipoProduto'];

    public function produto(){
    	return $this->hasMany('App\Produto');
    }
}
