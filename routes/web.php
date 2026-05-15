<?php

use Illuminate\Support\Facades\Route;
// 1. Importamos el modelo (Esto es súper importante)
use App\Models\Emprendedor;

Route::get('/', function () {
    return view('welcome');
});

// 2. Agregamos la ruta que te falta
Route::get('/ver-datos', function () {
    return Emprendedor::all();
});