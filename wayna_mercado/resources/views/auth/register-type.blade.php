{{-- resources/views/auth/register-type.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h1>Bienvenido a Wayna Mercado</h1>
                <p class="text-muted">¿Qué tipo de cuenta deseas crear?</p>
            </div>

            <div class="row g-4">
                <!-- Cliente -->
                <div class="col-md-6">
                    <div class="card shadow-lg h-100 border-0 hover-card" style="cursor: pointer; transition: transform 0.3s;">
                        <div class="card-body text-center p-5">
                            <div style="font-size: 48px; color: var(--wayna-orange); margin-bottom: 20px;">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h3 class="card-title mb-3">Soy Cliente</h3>
                            <p class="card-text text-muted mb-4">
                                Compra productos y apoya a emprendedores a través de donaciones.
                            </p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Compra de productos</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Realizar donaciones</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mi carrito de compras</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Historial de pedidos</li>
                            </ul>
                            <a href="{{ route('register.cliente') }}" class="btn btn-wayna w-100">
                                Registrarse como Cliente
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Emprendedor -->
                <div class="col-md-6">
                    <div class="card shadow-lg h-100 border-0 hover-card" style="cursor: pointer; transition: transform 0.3s;">
                        <div class="card-body text-center p-5">
                            <div style="font-size: 48px; color: var(--wayna-orange); margin-bottom: 20px;">
                                <i class="fas fa-store"></i>
                            </div>
                            <h3 class="card-title mb-3">Soy Emprendedor</h3>
                            <p class="card-text text-muted mb-4">
                                Vende tus productos y recibe apoyo de la comunidad.
                            </p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Crear tu tienda</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gestionar productos</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ver análisis de ventas</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Recibir donaciones</li>
                            </ul>
                            <a href="{{ route('register.emprendedor') }}" class="btn btn-outline-wayna w-100">
                                Registrarse como Emprendedor
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection
