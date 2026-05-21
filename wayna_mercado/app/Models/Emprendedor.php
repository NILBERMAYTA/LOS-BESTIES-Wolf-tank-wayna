<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprendedor extends Model
{
    use HasFactory;

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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function user()
    {   
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_emprendedor', 'id_emprendedor');
    }

    /**
     * Productos activos
     */
    public function productosActivos()
    {
        return $this->hasMany(Producto::class, 'id_emprendedor')
                    ->where('estado', '!=', 'oculto');
    }

    /**
     * Relación con donaciones
     */
    public function donaciones()
    {
        return $this->hasMany(Donacion::class, 'id_emprendedor', 'id_emprendedor');
    }

    /**
     * Obtener datos completos
     */
    public function obtenerDatosCompletos()
    {
        return [
            'nombre_emprendimiento' => $this->nombre_emprendimiento,
            'descripcion' => $this->descripcion_emprendimiento,
            'biografia' => $this->biografia,
            'frase_impacto' => $this->frase_impacto,
            'foto_perfil' => $this->foto_perfil ?? 'https://via.placeholder.com/150',
            'foto_portada' => $this->foto_portada ?? 'https://via.placeholder.com/1200x300',
            'categoria' => $this->categoria,
            'ubicacion' => $this->ubicacion,
            'video_url' => $this->video_url,
            'verificado' => $this->verificado,
            'estado' => $this->estado_validacion,
            'usuario_nombre' => $this->usuario->nombre ?? '',
            'usuario_apellido' => $this->usuario->apellido ?? '',
            'usuario_email' => $this->usuario->email ?? '',
            'usuario_telefono' => $this->usuario->telefono ?? '',
        ];
    }
}