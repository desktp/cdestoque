<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $fillable =['produto_id', 'filial_id', 'qtd'];

    public function produto(){
    	return $this->belongsTo('App\Produto');
    }

    public function filial(){
    	return $this->belongsTo('App\Filial');
    }
}
