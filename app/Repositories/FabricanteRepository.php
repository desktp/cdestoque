<?php

namespace App\Repositories;

use App\User;
use App\Fabricante;

class FabricanteRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */

    public function all(){
        return Fabricante::orderBy('id', 'asc')->get();
    }
}