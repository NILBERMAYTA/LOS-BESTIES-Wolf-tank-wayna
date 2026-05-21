<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    protected $table = 'donaciones';
    protected $primaryKey = 'id_donacion';

    protected $fillable = [
        'id_cliente',
        'id_emprendedor',
        'monto',
        'mensaje_apoyo',
        'estado',
        'fecha_donacion',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente', 'id_usuario');
    }

    public function emprendedor()
    {
        return $this->belongsTo(Emprendedor::class, 'id_emprendedor', 'id_emprendedor');
    }
}
