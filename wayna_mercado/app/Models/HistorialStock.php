<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialStock extends Model
{
    protected $table = 'historial_stock';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'cantidad_anterior',
        'cantidad_nueva',
        'tipo_cambio',
        'referencia_id',
        'observaciones',
        'fecha_cambio',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
