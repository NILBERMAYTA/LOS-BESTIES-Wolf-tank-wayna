<?php

namespace App\Policies;

use App\Models\User;

class EmprendedorPolicy
{
    /**
     * Verificar si el usuario es emprendedor
     */
    public function isEmprendedor(User $user)
    {
        return $user->id_rol == 2 && $user->emprendedor;
    }
}
