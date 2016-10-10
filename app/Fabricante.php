<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
	protected $fillable = ['fabricante'];

    public function maquina(){
    	return $this->hasMany('App\Maquina');
    }
}
