<?php

namespace App\Repositories;

use App\User;
use App\Unidade;

class UnidadeRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */

    public function all(){
        return Unidade::orderBy('id', 'asc')->get();
    }
}