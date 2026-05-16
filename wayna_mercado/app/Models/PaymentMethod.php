<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'metodos_pago';
    protected $primaryKey = 'id_metodo';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'instrucciones',
        'qr_code',
        'numero_cuenta',
        'activo'
    ];
}
