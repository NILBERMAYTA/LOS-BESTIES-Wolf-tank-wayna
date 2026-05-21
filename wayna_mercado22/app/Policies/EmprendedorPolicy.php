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
        return $user->isEmprendedor() && $user->emprendedor;
    }
}
