{{-- resources/views/dashboard/admin.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Usuarios registrados</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalUsuarios }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Emprendedores</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalEmprendedores }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Pedidos</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalPedidos }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Donaciones</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalDonaciones }}</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total ventas</h6>
                <p class="h3" style="color: var(--wayna-orange);">Bs. {{ number_format($totalVentas, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total donaciones</h6>
                <p class="h3" style="color: var(--wayna-orange);">Bs. {{ number_format($totalMontoDonaciones, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h6>Ingreso Wayna</h6>
                <p class="h3" style="color: var(--wayna-orange);">Bs. {{ number_format($ingresosWayna, 2) }}</p>
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
                <div class="col-md-3">
                    <a href="{{ route('emprendedores.index') }}" class="btn btn-outline-light w-100">Ver emprendedores</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-light w-100">Ver productos</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.pedidos') }}" class="btn btn-outline-light w-100">Ver pedidos</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.donaciones') }}" class="btn btn-outline-light w-100">Ver donaciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection