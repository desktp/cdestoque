<?php

namespace App\Repositories;

use App\User;
use App\Maquina;
use App\MaquinaModelo;
use App\Fabricante;
use App\Unidade;

class MaquinaRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function modelosPorFabricante(Fabricante $fabricante)
    {
        return MaquinaModelo::where('fabricante_id', $fabricante->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    public function maquinasPorUnidade(Unidade $unidade){
        return Maquina::where('unidade_id', $unidade->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    public function getModelo(MaquinaModelo $maquina_modelo){
        return MaquinaModelo::where('id', $maquina_modelo->id)->get();
    }
}