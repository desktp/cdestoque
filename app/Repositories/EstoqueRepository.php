<?php

namespace App\Repositories;

use App\User;
use App\Produto;
use App\Marca;
use App\Filial;
use App\Estoque;

class EstoqueRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */

    public function all(){
        return Estoque::orderBy('id', 'asc')->get();
    }

    public function porProduto(Produto $produto){
        return Estoque::where('produto_id', $produto->id)
                        ->orderBy('created_at', 'asc')
                        ->get();
    }

    public function porFilial(Filial $filial)
    {
        return Estoque::where('filial_id', $filial->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    public function porProdutoEFilial(int $produto, int $filial){
        return Estoque::where('filial_id', $filial)
                    ->where('produto_id', $produto)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}