{{-- resources/views/dashboard/admin-donaciones.blade.php --}}
@extends('layouts.app')

@section('title', 'Donaciones Admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Donaciones</h2>
            <p class="text-muted mb-0">Lista de donaciones recibidas por emprendedores.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($donaciones->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Emprendedor</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Mensaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donaciones as $donacion)
                                <tr>
                                    <td>{{ $donacion->id_donacion }}</td>
                                    <td>{{ $donacion->cliente->nombre ?? 'Cliente' }} {{ $donacion->cliente->apellido ?? '' }}</td>
                                    <td>{{ $donacion->emprendedor->nombre_emprendimiento ?? 'Emprendedor' }}</td>
                                    <td>Bs. {{ number_format($donacion->monto, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($donacion->fecha_donacion)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $donacion->mensaje_apoyo ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $donaciones->links() }}
                </div>
            @else
                <div class="alert alert-info mb-0">
                    No hay donaciones registradas todavía.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
