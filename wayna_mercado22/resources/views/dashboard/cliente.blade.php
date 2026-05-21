{{-- resources/views/dashboard/cliente.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2>Bienvenido, {{ auth()->user()->nombre }}</h2>
            <p class="text-muted">Explora productos y apoya a los emprendedores con compras o donaciones.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('productos.index') }}" class="btn btn-wayna">
                <i class="fas fa-shopping-bag"></i> Ver productos
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5>Mi perfil</h5>
                <p class="mb-1"><strong>Nombre:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p class="mb-0"><strong>Teléfono:</strong> {{ auth()->user()->telefono ?? 'No definido' }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5>Donaciones rápidas</h5>
                <p class="mb-3">Apoya a un emprendedor con un aporte directo.</p>
                <a href="{{ route('productos.index') }}" class="btn btn-outline-wayna w-100">Buscar productos</a>
            </div>
        </div>
    </div>
</div>
@endsection