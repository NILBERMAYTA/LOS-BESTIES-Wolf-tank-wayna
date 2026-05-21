{{-- resources/views/admin/productos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Administrar Productos')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de productos</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('admin.productos.index') }}">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Buscar producto, emprendedor o categoría" value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-wayna">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    @if($productos->count())
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Emprendimiento</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->id_producto }}</td>
                            <td>{{ $producto->nombre_producto }}</td>
                            <td>{{ optional($producto->emprendedor)->nombre_emprendimiento }}</td>
                            <td>{{ optional($producto->categoria)->nombre_categoria ?? 'Sin categoría' }}</td>
                            <td>Bs. {{ number_format($producto->precio, 2) }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ ucfirst($producto->estado) }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.productos.show', $producto->id_producto) }}" class="btn btn-sm btn-primary mb-1">Ver</a>
                                <form action="{{ route('admin.productos.update_status', $producto->id_producto) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="estado" value="{{ $producto->estado === 'oculto' ? 'activo' : 'oculto' }}">
                                    <button type="submit" class="btn btn-sm {{ $producto->estado === 'oculto' ? 'btn-success' : 'btn-warning' }} mb-1">
                                        {{ $producto->estado === 'oculto' ? 'Publicar' : 'Ocultar' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.productos.destroy', $producto->id_producto) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Ocultar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Ocultar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    @else
        <div class="alert alert-info">No se encontraron productos.</div>
    @endif
</div>
@endsection
