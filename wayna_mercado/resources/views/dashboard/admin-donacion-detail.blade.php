{{-- resources/views/dashboard/admin-donacion-detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle Donación')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Donación #{{ $donacion->id_donacion }}</h2>
            <p class="text-muted mb-0">Detalle de la donación realizada.</p>
        </div>
        <a href="{{ route('admin.donaciones') }}" class="btn btn-secondary">Volver a Donaciones</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $donacion->cliente->nombre ?? 'Cliente' }} {{ $donacion->cliente->apellido ?? '' }}</p>
            <p><strong>Emprendedor:</strong> {{ $donacion->emprendedor->nombre_emprendimiento ?? '-' }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($donacion->fecha_donacion)->format('d/m/Y H:i') }}</p>
            <p><strong>Monto:</strong> Bs. {{ number_format($donacion->monto, 2) }}</p>
            <p><strong>Mensaje:</strong> {{ $donacion->mensaje_apoyo ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection
