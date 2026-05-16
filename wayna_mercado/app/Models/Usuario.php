<?php

namespace App\Models;

class Usuario extends Model
{
    public static function obtenerUsuario()
    {
        return [
            'nombre' => 'Cristian Antezana',
            'email' => 'cristian@gmail.com',
            'telefono' => '+591 77777777',
            'direccion' => 'La Paz, Bolivia',
            'registro' => '15/05/2026',
            'foto' => 'https://i.pravatar.cc/150?img=12',
            'verificado' => true,
            'estado' => 'Activo',
            'categoria' => 'Gastronomía',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'

        ];
    }
}