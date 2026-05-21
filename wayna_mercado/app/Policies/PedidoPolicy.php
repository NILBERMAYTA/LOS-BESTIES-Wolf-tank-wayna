<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEmprendedor();
    }

    public function view(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin() || $user->id_usuario === $pedido->id_cliente;
    }

    public function create(User $user): bool
    {
        return $user->isCliente();
    }

    public function update(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin();
    }
}
