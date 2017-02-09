<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    protected $fillable = ['filial'];
    protected $table = 'filiais';
    
    public function estoque(){
    	return $this->hasMany('App\Estoque');
    }

    public function estoque_saida(){
        return $this->hasMany('App\EstoqueSaida');
    }
}
