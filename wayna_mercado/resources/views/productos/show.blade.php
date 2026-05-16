{{-- resources/views/productos/show.blade.php --}}
@extends('layouts.app')

@section('title', $producto->nombre_producto)

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div style="height: 420px; overflow: hidden; background: #f8f9fa;">
                    @if($producto->imagen_principal)
                        <img src="{{ asset('storage/' . $producto->imagen_principal) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $producto->nombre_producto }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100" style="background: #e9ecef;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <h3>{{ $producto->nombre_producto }}</h3>
                    <p class="text-muted mb-2">
                        {{ $producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                    </p>
                    <p class="text-muted small mb-3">
                        Emprendedor: <strong>{{ $producto->emprendedor->nombre_emprendimiento }}</strong>
                    </p>
                    <p class="mb-3">{{ $producto->descripcion_larga ?? $producto->descripcion_corta }}</p>
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark">
                            Bs. {{ number_format($producto->precio, 2) }}
                        </span>
                        <span class="badge bg-{{ $producto->stock > 0 ? 'success' : 'danger' }} text-white">
                            {{ $producto->stock > 0 ? 'Stock: ' . $producto->stock : 'Agotado' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            Producto publicado por <a href="{{ route('emprendedor.show', $producto->emprendedor->slug_emprendimiento) }}">{{ $producto->emprendedor->nombre_emprendimiento }}</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Comprar</h5>
                </div>
                <div class="card-body">
                    @guest
                        <p class="mb-3">Debes iniciar sesión para comprar este producto.</p>
                        <a href="{{ route('login') }}" class="btn btn-wayna w-100">Ingresar</a>
                    @else
                        <form method="POST" action="{{ route('producto.comprar', $producto->slug) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" min="1" value="1" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                @error('cantidad')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Método de pago</label>
                                <select name="payment_method_id" class="form-control" required {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                    <option value="">Seleccionar</option>
                                    @foreach($metodosPago as $metodo)
                                    <option value="{{ $metodo->id_metodo }}">{{ $metodo->nombre }}</option>
                                @endforeach
                                </select>
                                @error('payment_method_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-wayna w-100" {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                                Comprar ahora
                            </button>
                        </form>
                    @endguest
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h5 class="mb-0"><i class="fas fa-hand-holding-heart"></i> Donar</h5>
                </div>
                <div class="card-body">
                    @guest
                        <p class="mb-3">Inicia sesión para poder donar.</p>
                        <a href="{{ route('login') }}" class="btn btn-wayna w-100">Ingresar</a>
                    @else
                        <form method="POST" action="{{ route('producto.donar', $producto->slug) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Monto de donación (Bs.)</label>
                                <input type="number" name="monto" class="form-control" min="1" step="0.01" value="10" required>
                                @error('monto')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Método de pago</label>
                                <select name="payment_method_id" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($metodosPago as $metodo)
                                        <option value="{{ $metodo->id_metodo }}">{{ $metodo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-outline-wayna w-100">
                                Donar ahora
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection