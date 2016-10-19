<?php

namespace App\Repositories;

use App\User;
use App\Filial;

class FilialRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */

    public function all(){
        return Filial::orderBy('id', 'asc')->get();
    }
}