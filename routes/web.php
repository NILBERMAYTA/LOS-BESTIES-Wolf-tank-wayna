<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // <-- Importante para consultas directas
use App\Http\Controllers\ProductoController;

// --- RUTA DE BIENVENIDA ---
Route::get('/', function () {
    return view('welcome');
});

// --- RUTAS DEL BACKEND ---

// 1. Ruta para ver Emprendedores (Consulta directa a tu tabla actual)
Route::get('/ver-datos', function () {
    return DB::table('emprendedores')->get();
});

// 2. Ruta para LISTAR los productos (Llama a tu Controlador)
Route::get('/api-productos', [ProductoController::class, 'index']);

// 3. Ruta para GUARDAR productos (Llama a tu Controlador)
Route::post('/api-productos', [ProductoController::class, 'store']);

// Ruta para cambiar estado (Ej: localhost/api-productos/toggle/5)
Route::get('/api-productos/toggle/{id}', [ProductoController::class, 'cambiarEstado']);

// Ruta para eliminar (Ej: localhost/api-productos/eliminar/5)
Route::get('/api-productos/eliminar/{id}', [ProductoController::class, 'destroy']);