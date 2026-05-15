<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprendedor extends Model
{
    // Indicar el nombre exacto de la tabla que tienes en HeidiSQL
    protected $table = 'emprendedores'; 

    // Indicar tu llave primaria (PK)
    protected $primaryKey = 'ID_emprendedor';

    // Desactivar timestamps porque no los creamos en la tabla manual
    public $timestamps = false;
}