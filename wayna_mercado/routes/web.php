<?php
// routes/web.php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\EmprendedorController as AdminEmprendedorController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Admin\DonacionController as AdminDonacionController;
use App\Http\Controllers\Admin\PaymentMethodController;
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

// Registro - Seleccionar tipo de cuenta
Route::get('/register', [RegistroController::class, 'showType'])->name('register.type');
Route::get('/registro-cliente', [RegistroController::class, 'showCliente'])->name('register.cliente');
Route::post('/registro-cliente', [RegistroController::class, 'guardarCliente'])->name('register.cliente.post');

// Registro de emprendedor
Route::get('/registro-emprendedor', [RegistroController::class, 'showEmprendedor'])->name('register.emprendedor');
Route::post('/registro-emprendedor', [RegistroController::class, 'guardarEmprendedor'])->name('register.emprendedor.post');

// Compra y donación
Route::middleware('auth')->group(function () {
    Route::post('/producto/{slug}/comprar', [TransactionController::class, 'purchase'])->name('producto.comprar');
    Route::post('/producto/{slug}/donar', [TransactionController::class, 'donate'])->name('producto.donar');
    Route::get('/pago/confirmacion/{type}/{id}', [TransactionController::class, 'confirmation'])
        ->name('payment.confirmation');
});

// ============================================
// RUTAS DE DASHBOARD PARA ROLES
// ============================================

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/dashboard/export/{format?}', [DashboardController::class, 'exportMetrics'])->name('admin.dashboard.export');
    Route::get('/admin/pedidos', [DashboardController::class, 'adminPedidos'])->name('admin.pedidos');
    Route::get('/admin/donaciones', [DashboardController::class, 'adminDonaciones'])->name('admin.donaciones');
    Route::get('/admin/pedidos/{id}', [DashboardController::class, 'showPedido'])->name('admin.pedidos.show');
    Route::get('/admin/donaciones/{id}', [DashboardController::class, 'showDonacion'])->name('admin.donaciones.show');
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

    // Admin: payment methods management
    Route::prefix('admin')->middleware('auth')->group(function(){
        // Métodos de pago
        Route::get('/metodos', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'index'])->name('admin.metodos.index');
        Route::get('/metodos/crear', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'create'])->name('admin.metodos.create');
        Route::post('/metodos', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'store'])->name('admin.metodos.store');
        Route::get('/metodos/{id}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'show'])->name('admin.metodos.show');
        Route::get('/metodos/{id}/editar', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'edit'])->name('admin.metodos.edit');
        Route::put('/metodos/{id}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'update'])->name('admin.metodos.update');
        Route::get('/metodos/{id}/qr', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'editQr'])->name('admin.metodos.edit_qr');
        Route::put('/metodos/{id}/qr', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'updateQr'])->name('admin.metodos.update_qr');
        Route::delete('/metodos/{id}', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'destroy'])->name('admin.metodos.destroy');

        // Usuarios
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
        Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('admin.usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('admin.usuarios.store');
        Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('admin.usuarios.show');
        Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');

        // Categorías
        Route::get('/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index');
        Route::get('/categorias/crear', [CategoriaController::class, 'create'])->name('admin.categorias.create');
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
        Route::get('/categorias/{id}', [CategoriaController::class, 'show'])->name('admin.categorias.show');
        Route::get('/categorias/{id}/editar', [CategoriaController::class, 'edit'])->name('admin.categorias.edit');
        Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
        Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

        // Emprendedores
        Route::get('/emprendedores', [AdminEmprendedorController::class, 'index'])->name('admin.emprendedores.index');
        Route::get('/emprendedores/crear', [AdminEmprendedorController::class, 'create'])->name('admin.emprendedores.create');
        Route::post('/emprendedores', [AdminEmprendedorController::class, 'store'])->name('admin.emprendedores.store');
        Route::get('/emprendedores/{id}', [AdminEmprendedorController::class, 'show'])->name('admin.emprendedores.show');
        Route::get('/emprendedores/{id}/editar', [AdminEmprendedorController::class, 'edit'])->name('admin.emprendedores.edit');
        Route::put('/emprendedores/{id}', [AdminEmprendedorController::class, 'update'])->name('admin.emprendedores.update');
        Route::put('/emprendedores/{id}/status', [AdminEmprendedorController::class, 'updateStatus'])->name('admin.emprendedores.update_status');
        Route::delete('/emprendedores/{id}', [AdminEmprendedorController::class, 'destroy'])->name('admin.emprendedores.destroy');

        // Productos
        Route::get('/productos', [AdminProductoController::class, 'index'])->name('admin.productos.index');
        Route::get('/productos/crear', [AdminProductoController::class, 'create'])->name('admin.productos.create');
        Route::post('/productos', [AdminProductoController::class, 'store'])->name('admin.productos.store');
        Route::get('/productos/{id}', [AdminProductoController::class, 'show'])->name('admin.productos.show');
        Route::get('/productos/{id}/editar', [AdminProductoController::class, 'edit'])->name('admin.productos.edit');
        Route::put('/productos/{id}', [AdminProductoController::class, 'update'])->name('admin.productos.update');
        Route::put('/productos/{id}/status', [AdminProductoController::class, 'updateStatus'])->name('admin.productos.update_status');
        Route::delete('/productos/{id}', [AdminProductoController::class, 'destroy'])->name('admin.productos.destroy');

        // Pedidos
        Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('admin.pedidos.index');
        Route::get('/pedidos/{id}', [AdminPedidoController::class, 'show'])->name('admin.pedidos.show');
        Route::get('/pedidos/{id}/editar', [AdminPedidoController::class, 'edit'])->name('admin.pedidos.edit');
        Route::put('/pedidos/{id}', [AdminPedidoController::class, 'update'])->name('admin.pedidos.update');
        Route::put('/pedidos/{id}/status', [AdminPedidoController::class, 'updateStatus'])->name('admin.pedidos.update_status');
        Route::delete('/pedidos/{id}', [AdminPedidoController::class, 'destroy'])->name('admin.pedidos.destroy');

        // Donaciones
        Route::get('/donaciones', [AdminDonacionController::class, 'index'])->name('admin.donaciones.index');
        Route::get('/donaciones/{id}', [AdminDonacionController::class, 'show'])->name('admin.donaciones.show');
        Route::get('/donaciones/{id}/editar', [AdminDonacionController::class, 'edit'])->name('admin.donaciones.edit');
        Route::put('/donaciones/{id}', [AdminDonacionController::class, 'update'])->name('admin.donaciones.update');
        Route::put('/donaciones/{id}/status', [AdminDonacionController::class, 'updateStatus'])->name('admin.donaciones.update_status');
        Route::delete('/donaciones/{id}', [AdminDonacionController::class, 'destroy'])->name('admin.donaciones.destroy');
    });
});