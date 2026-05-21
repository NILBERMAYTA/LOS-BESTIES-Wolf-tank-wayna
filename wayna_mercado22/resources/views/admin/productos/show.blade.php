{{-- resources/views/admin/productos/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Producto: ' . $producto->nombre_producto)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>{{ $producto->nombre_producto }}</h2>
            <span class="badge bg-info">{{ ucfirst($producto->estado) }}</span>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">
                <h5>Detalles del producto</h5>
                <p><strong>Categoría:</strong> {{ optional($producto->categoria)->nombre_categoria ?? 'Sin categoría' }}</p>
                <p><strong>Emprendimiento:</strong> {{ optional($producto->emprendedor)->nombre_emprendimiento }}</p>
                <p><strong>Precio:</strong> Bs. {{ number_format($producto->precio, 2) }}</p>
                <p><strong>Stock:</strong> {{ $producto->stock }}</p>
                <p><strong>Stock mínimo:</strong> {{ $producto->stock_minimo }}</p>
                <p><strong>Descripción corta:</strong> {{ $producto->descripcion_corta }}</p>
                <p><strong>Descripción larga:</strong> {{ $producto->descripcion_larga ?? 'No disponible' }}</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm p-4 mb-4">
                <h5>Acciones</h5>
                <form action="{{ route('admin.productos.update_status', $producto->id_producto) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="estado" value="{{ $producto->estado === 'oculto' ? 'activo' : 'oculto' }}">
                    <button type="submit" class="btn btn-{{ $producto->estado === 'oculto' ? 'success' : 'warning' }} w-100">
                        {{ $producto->estado === 'oculto' ? 'Publicar producto' : 'Ocultar producto' }}
                    </button>
                </form>

                <form action="{{ route('admin.productos.destroy', $producto->id_producto) }}" method="POST" onsubmit="return confirm('¿Ocultar este producto definitivamente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Ocultar permanentemente</button>
                </form>
            </div>

            @if($producto->imagen_principal)
                <div class="card shadow-sm p-4">
                    <h5>Imagen principal</h5>
                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" class="img-fluid rounded" alt="{{ $producto->nombre_producto }}">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
