{{-- resources/views/admin/emprendedores/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Emprendedor: ' . $emprendedor->nombre_emprendimiento)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>{{ $emprendedor->nombre_emprendimiento }}</h2>
            <span class="badge bg-primary">{{ ucfirst($emprendedor->estado_validacion) }}</span>
            @if($emprendedor->verificado)
                <span class="badge bg-success">Verificado</span>
            @else
                <span class="badge bg-secondary">No verificado</span>
            @endif
        </div>
        <div>
            <a href="{{ route('admin.emprendedores.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">
                <h5>Información</h5>
                <p><strong>Emprendimiento:</strong> {{ $emprendedor->nombre_emprendimiento }}</p>
                <p><strong>Propietario:</strong> {{ optional($emprendedor->user)->nombre }} {{ optional($emprendedor->user)->apellido }}</p>
                <p><strong>Email:</strong> {{ optional($emprendedor->user)->email }}</p>
                <p><strong>Categoría:</strong> {{ ucfirst($emprendedor->categoria) }}</p>
                <p><strong>Ubicación:</strong> {{ $emprendedor->ubicacion ?? 'No especificada' }}</p>
                <p><strong>Biografía:</strong> {{ $emprendedor->biografia }}</p>
                <p><strong>Frase de impacto:</strong> {{ $emprendedor->frase_impacto }}</p>
                <p><strong>Fecha de solicitud:</strong> {{ $emprendedor->fecha_solicitud ? \Carbon\Carbon::parse($emprendedor->fecha_solicitud)->format('d/m/Y') : 'N/A' }}</p>
                <p><strong>Fecha de validación:</strong> {{ $emprendedor->fecha_validacion ? \Carbon\Carbon::parse($emprendedor->fecha_validacion)->format('d/m/Y') : 'N/A' }}</p>
                @if($emprendedor->comentario_rechazo)
                    <p><strong>Comentario:</strong> {{ $emprendedor->comentario_rechazo }}</p>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm p-4 mb-4">
                <h5>Acciones</h5>
                <form action="{{ route('admin.emprendedores.update_status', $emprendedor->id_emprendedor) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $emprendedor->estado_validacion === 'aprobado' ? 'rechazado' : 'aprobado' }}">
                    <div class="mb-3">
                        @if($emprendedor->estado_validacion === 'aprobado')
                            <button type="submit" class="btn btn-warning w-100">Rechazar emprendedor</button>
                        @else
                            <button type="submit" class="btn btn-success w-100">Aprobar emprendedor</button>
                        @endif
                    </div>
                </form>

                <form action="{{ route('admin.emprendedores.destroy', $emprendedor->id_emprendedor) }}" method="POST" onsubmit="return confirm('¿Ocultar este emprendedor y sus productos del sitio?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Ocultar emprendedor</button>
                </form>
            </div>

            <div class="card shadow-sm p-4">
                <h5>Productos</h5>
                @if($emprendedor->productos->count())
                    <ul class="list-group list-group-flush">
                        @foreach($emprendedor->productos as $producto)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $producto->nombre_producto }}</span>
                                <a href="{{ route('admin.productos.show', $producto->id_producto) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mb-0">No tiene productos registrados.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
