<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerfilController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas del perfil del emprendedor - Requieren autenticación
Route::prefix('perfil')->group(function () {
    Route::get('/', [PerfilController::class, 'index'])->name('perfil.index');
    Route::get('/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::post('/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
    Route::post('/logout', [PerfilController::class, 'logout'])->name('perfil.logout');
});