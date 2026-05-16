<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

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