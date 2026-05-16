{{-- resources/views/landing/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<section class="hero">
    <div class="container text-center">
        <h1>Bienvenido a <span>Wayna Mercado</span></h1>
        <p class="lead mb-4">Descubre el talento de jóvenes emprendedores bolivianos</p>
        <div class="d-flex justify-content-center gap-3">
            @if (Auth::check())
                <a href="{{ route('dashboard') }}" class="btn btn-wayna btn-lg">
                    <i class="fas fa-user"></i> Mi Cuenta
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-wayna btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            @else
                <a href="{{ route('productos.index') }}" class="btn btn-wayna btn-lg">
                    <i class="fas fa-search"></i> Ver Productos
                </a>
                <a href="{{ route('register.emprendedor') }}" class="btn btn-outline-wayna btn-lg">
                    <i class="fas fa-rocket"></i> Soy Emprendedor
                </a>
            @endif
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-wayna text-center p-4">
                    <div class="card-icon"><i class="fas fa-store"></i></div>
                    <h5>Emprendedores Wayna</h5>
                    <p>Jóvenes talentos con productos únicos</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wayna text-center p-4">
                    <div class="card-icon"><i class="fas fa-heart"></i></div>
                    <h5>Apoyo Directo</h5>
                    <p>Tu apoyo va directamente al emprendedor</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-wayna text-center p-4">
                    <div class="card-icon"><i class="fas fa-video"></i></div>
                    <h5>Conoce su Historia</h5>
                    <p>Cada emprendedor tiene una historia inspiradora</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Categorías</h2>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <i class="fas fa-utensils fa-3x" style="color: var(--wayna-orange);"></i>
                <h6 class="mt-2">Gastronomía</h6>
            </div>
            <div class="col-md-3">
                <i class="fas fa-palette fa-3x" style="color: var(--wayna-orange);"></i>
                <h6 class="mt-2">Artesanía</h6>
            </div>
            <div class="col-md-3">
                <i class="fas fa-leaf fa-3x" style="color: var(--wayna-orange);"></i>
                <h6 class="mt-2">Cosmética</h6>
            </div>
            <div class="col-md-3">
                <i class="fas fa-tshirt fa-3x" style="color: var(--wayna-orange);"></i>
                <h6 class="mt-2">Textiles</h6>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: linear-gradient(135deg, var(--wayna-black) 0%, #2a2a2a 100%);">
    <div class="container text-center">
        <h2 class="text-white">¿Eres un emprendedor?</h2>
        <p class="text-white-50 mb-4">Únete a Wayna y comparte tus productos</p>
        <a href="{{ route('register.emprendedor') }}" class="btn btn-wayna btn-lg">
            <i class="fas fa-store"></i> Registrar mi Emprendimiento
        </a>
    </div>
</section>
@endsection