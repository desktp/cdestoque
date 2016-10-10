<?php

namespace App\Repositories;

use App\User;
use App\Maquina;

class MaquinaRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function porFabricante(Fabricante $fabricante)
    {
        return Task::where('fabricante_id', $fabricante->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}