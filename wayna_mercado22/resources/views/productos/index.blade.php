{{-- resources/views/productos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Productos</h2>
            <p class="text-muted">Encuentra productos disponibles de emprendedores aprobados.</p>
        </div>
        <a href="{{ route('emprendedores.index') }}" class="btn btn-outline-wayna">
            <i class="fas fa-store"></i> Ver emprendedores
        </a>
    </div>

    @if($productos->count())
        <div class="row g-4">
            @foreach($productos as $producto)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div style="height: 230px; overflow: hidden; background: #f5f5f5;">
                            @if($producto->imagen_principal)
                                <img src="{{ asset('storage/' . $producto->imagen_principal) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $producto->nombre_producto }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100" style="background: #e9ecef;">
                                    <i class="fas fa-box-open fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                            @if($producto->categoria)
                                <p class="small text-muted mb-2">{{ $producto->categoria->nombre_categoria }}</p>
                            @endif

                            <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($producto->descripcion_corta ?? $producto->descripcion_larga, 90) }}</p>

                            <p class="h5 mb-2" style="color: var(--wayna-orange);">
                                Bs. {{ number_format($producto->precio, 2) }}
                            </p>
                            <p class="small text-muted mb-3">
                                <i class="fas fa-store"></i> {{ $producto->emprendedor->nombre_emprendimiento }}
                            </p>

                            <a href="{{ route('producto.show', $producto->slug) }}" class="btn btn-wayna mt-auto">
                                Ver producto
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $productos->links() }}
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No hay productos disponibles en este momento.
        </div>
    @endif
</div>
@endsection