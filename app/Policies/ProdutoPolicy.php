<?php

namespace App\Policies;

use App\Models\Usuario;

class ProdutoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(Usuario $userlogado) : bool
    {
        return $userlogado->perfil === 'usuario' || 'admin';
    }

    public function view(Usuario $userlogado) : bool
    {
        return $userlogado->perfil === 'usuario' || 'admin';
    }

    public function update(Usuario $userlogado) : bool
    {
        return $userlogado->perfil === 'usuario' || 'admin';
    }

    public function delete(Usuario $userlogado) : bool
    {
        return $userlogado->perfil === 'admin';
    }

    public function isAdmin(Usuario $userlogado) : bool 
    {
        return $userlogado->perfil === 'admin';
    }
}
