<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver productos
    }

    public function view(User $user, Producto $producto): bool
    {
        return true; // Todos pueden ver un producto específico
    }

    public function create(User $user): bool
    {
        return $user->isEmprendedor();
    }

    public function update(User $user, Producto $producto): bool
    {
        return $user->isAdmin() || 
               ($user->isEmprendedor() && $user->emprendedor?->id_emprendedor === $producto->id_emprendedor);
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $user->isAdmin() || 
               ($user->isEmprendedor() && $user->emprendedor?->id_emprendedor === $producto->id_emprendedor);
    }

    public function restore(User $user, Producto $producto): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Producto $producto): bool
    {
        return $user->isAdmin();
    }
}
