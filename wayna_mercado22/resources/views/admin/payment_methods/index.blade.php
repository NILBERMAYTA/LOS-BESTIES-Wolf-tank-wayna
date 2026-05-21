@extends('layouts.app')

@section('title', 'Métodos de Pago')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Métodos de Pago</h2>
            <p class="text-muted mb-0">Administrar los métodos disponibles para pagos y donaciones.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($metodos->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Activo</th>
                                <th>Cuenta / Código</th>
                                <th>QR</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($metodos as $metodo)
                                <tr>
                                    <td>{{ $metodo->id_metodo }}</td>
                                    <td>{{ $metodo->nombre }}</td>
                                    <td>{{ $metodo->activo ? 'Sí' : 'No' }}</td>
                                    <td>{{ $metodo->codigo ?? $metodo->numero_cuenta ?? '-' }}</td>
                                    <td>
                                        @if($metodo->qr_code)
                                            <img src="{{ asset('storage/' . $metodo->qr_code) }}" alt="QR" style="max-width:80px;">
                                        @else
                                            <span class="text-muted">Sin QR</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.metodos.edit_qr', $metodo->id_metodo) }}" class="btn btn-sm btn-wayna">Editar QR</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    No hay métodos de pago configurados.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
