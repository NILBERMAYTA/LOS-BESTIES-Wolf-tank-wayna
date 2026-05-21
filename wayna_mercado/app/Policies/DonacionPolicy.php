<?php

namespace App\Policies;

use App\Models\Donacion;
use App\Models\User;

class DonacionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEmprendedor();
    }

    public function view(User $user, Donacion $donacion): bool
    {
        return $user->isAdmin() || 
               $user->id_usuario === $donacion->id_cliente ||
               ($user->isEmprendedor() && $user->emprendedor?->id_emprendedor === $donacion->id_emprendedor);
    }

    public function create(User $user): bool
    {
        return $user->isCliente();
    }

    public function update(User $user, Donacion $donacion): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Donacion $donacion): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Donacion $donacion): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Donacion $donacion): bool
    {
        return $user->isAdmin();
    }
}
