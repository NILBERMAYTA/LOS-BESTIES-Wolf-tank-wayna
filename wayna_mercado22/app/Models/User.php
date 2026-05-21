<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public const ROLE_ADMIN = 1;
    public const ROLE_EMPRENDEDOR = 2;
    public const ROLE_CLIENTE = 3;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'id_rol',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->id_rol === self::ROLE_ADMIN;
    }

    public function isEmprendedor(): bool
    {
        return $this->id_rol === self::ROLE_EMPRENDEDOR;
    }

    public function isCliente(): bool
    {
        return $this->id_rol === self::ROLE_CLIENTE;
    }

    public function emprendedor()
    {
        return $this->hasOne(Emprendedor::class, 'id_usuario', 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_usuario');
    }

    public function donaciones()
    {
        return $this->hasMany(Donacion::class, 'id_cliente', 'id_usuario');
    }
}