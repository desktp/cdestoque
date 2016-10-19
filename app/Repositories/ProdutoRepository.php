<?php

namespace App\Repositories;

use App\User;
use App\Produto;
use App\Marca;

class ProdutoRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function all(){
        return Produto::orderBy('id', 'asc');
    }

    public function porMarca(Marca $marca)
    {
        return Produto::where('marca_id', $marca->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}