<?php
// app/Models/Emprendedor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprendedor extends Model
{
    protected $table = 'emprendedores';
    protected $primaryKey = 'id_emprendedor';

    protected $fillable = [
        'id_usuario',
        'nombre_emprendimiento',
        'slug_emprendimiento',
        'descripcion_emprendimiento',
        'biografia',
        'frase_impacto',
        'video_url',
        'foto_perfil',
        'foto_portada',
        'categoria',
        'ubicacion',
        'latitud',
        'longitud',
        'estado_validacion',
        'fecha_solicitud',
        'fecha_validacion',
        'id_admin_validador',
        'comentario_rechazo',
        'verificado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_emprendedor');
    }

    public function productosActivos()
    {
        return $this->hasMany(Producto::class, 'id_emprendedor')
                    ->where('estado', '!=', 'oculto');
    }
}