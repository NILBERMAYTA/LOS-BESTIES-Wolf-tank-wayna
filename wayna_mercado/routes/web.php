<?php
// routes/web.php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PÚBLICAS
// ============================================

// Página principal
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Productos y emprendedores públicos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('producto.show');
Route::get('/emprendedores', [EmprendedorController::class, 'index'])->name('emprendedores.index');
Route::get('/emprendedor/{slugEmprendimiento}', [EmprendedorController::class, 'show'])->name('emprendedor.show');
Route::get('/emprendedor/{slugEmprendimiento}/productos', [EmprendedorController::class, 'productos'])->name('emprendedor.productos');

// Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Registro de emprendedor
Route::get('/registro-emprendedor', [RegistroController::class, 'formulario'])->name('register.emprendedor');
Route::post('/registro-emprendedor', [RegistroController::class, 'guardar'])->name('register.emprendedor.post');

// Compra y donación
Route::middleware('auth')->group(function () {
    Route::post('/producto/{slug}/comprar', [TransactionController::class, 'purchase'])->name('producto.comprar');
    Route::post('/producto/{slug}/donar', [TransactionController::class, 'donate'])->name('producto.donar');
});

// ============================================
// RUTAS DE DASHBOARD PARA ROLES
// ============================================

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/emprendedor/dashboard', [DashboardController::class, 'emprendedor'])->name('emprendedor.dashboard');
    Route::get('/cliente/dashboard', [DashboardController::class, 'cliente'])->name('cliente.dashboard');

    // Rutas CRUD de productos para emprendedores
    Route::prefix('emprendedor')->group(function () {
        Route::get('/productos/crear', [ProductoController::class, 'create'])->name('producto.create');
        Route::post('/productos', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('producto.edit');
        Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('producto.update');
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');
        Route::get('/perfil/editar', [EmprendedorController::class, 'editPerfil'])->name('emprendedor.editPerfil');
        Route::put('/perfil', [EmprendedorController::class, 'updatePerfil'])->name('emprendedor.updatePerfil');
    });
});