<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    protected $fillable = ['filial'];

    public function estoque(){
    	return $this->hasMany('App\Estoque');
    }
}
