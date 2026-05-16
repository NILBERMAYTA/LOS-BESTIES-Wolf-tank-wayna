<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'id_emprendedor',
        'id_categoria',
        'nombre_producto',
        'slug',
        'descripcion_corta',
        'descripcion_larga',
        'precio',
        'stock',
        'stock_minimo',
        'imagen_principal',
        'estado',
        'destacado',
    ];

    public function emprendedor()
    {
        return $this->belongsTo(Emprendedor::class, 'id_emprendedor', 'id_emprendedor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
