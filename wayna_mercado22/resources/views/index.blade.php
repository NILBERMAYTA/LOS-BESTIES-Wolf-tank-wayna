{{-- resources/views/landing/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<div class="hero">
    <div class="container text-center">
        <h1>Bienvenido a <span>Wayna Mercado</span></h1>
        <p class="lead mb-4">Descubre el talento de jóvenes emprendedores bolivianos</p>
        <a href="{{ url('/registro-emprendedor') }}" class="btn btn-wayna btn-lg">Registrar mi Emprendimiento</a>
    </div>
</div>
<div class="container py-5">
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card-wayna p-4">
                <i class="fas fa-store fa-3x" style="color: var(--wayna-orange);"></i>
                <h5 class="mt-3">Emprendedores Wayna</h5>
                <p>Jóvenes talentos con productos únicos</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-wayna p-4">
                <i class="fas fa-heart fa-3x" style="color: var(--wayna-orange);"></i>
                <h5 class="mt-3">Apoyo Directo</h5>
                <p>Tu apoyo va directamente al emprendedor</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-wayna p-4">
                <i class="fas fa-video fa-3x" style="color: var(--wayna-orange);"></i>
                <h5 class="mt-3">Conoce su Historia</h5>
                <p>Cada emprendedor tiene una historia inspiradora</p>
            </div>
        </div>
    </div>
</div>
<div class="text-center py-4" style="background: linear-gradient(135deg, var(--wayna-black) 0%, #2a2a2a 100%); color: white;">
    <div class="container">
        <h3>¿Eres un emprendedor?</h3>
        <p>Únete a Wayna y comparte tus productos</p>
        <a href="{{ url('/registro-emprendedor') }}" class="btn btn-wayna btn-lg">Registrar mi Emprendimiento</a>
    </div>
</div>
@endsection