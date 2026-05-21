<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_cliente',
        'fecha_pedido',
        'estado_pedido',
        'tipo',
        'subtotal',
        'total',
        'metodo_pago',
        'id_metodo_pago',
        'comprobante_pago',
        'comision_plataforma',
        'total_emprendedor',
        'notas',
        'fecha_pago',
        'fecha_confirmacion',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }
}
