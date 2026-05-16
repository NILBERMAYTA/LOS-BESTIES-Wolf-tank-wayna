{{-- resources/views/dashboard/admin.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h5>Usuarios registrados</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalUsuarios }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h5>Emprendedores</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalEmprendedores }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h5>Productos publicados</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalProductos }}</p>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header" style="background: var(--wayna-orange); color: white;">
            <h4 class="mb-0">Panel de administración</h4>
        </div>
        <div class="card-body">
            <p>Como administrador, puedes supervisar el sistema y validar emprendedores, ver pedidos y donaciones.</p>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-light w-100">Ver emprendedores</a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-light w-100">Ver productos</a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-light w-100">Ver donaciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection