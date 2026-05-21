{{-- resources/views/emprendedor/productos.blade.php --}}
@extends('layouts.app')

@section('title', 'Productos - ' . $emprendedor->nombre_emprendimiento)

@section('content')
<div class="container py-5">
    {{-- Encabezado --}}
    <div class="mb-5">
        <h2 class="mb-3">
            <i class="fas fa-cube"></i> Productos de {{ $emprendedor->nombre_emprendimiento }}
        </h2>
        <p class="text-muted">
            <a href="{{ route('emprendedor.show', $emprendedor->slug_emprendimiento) }}">
                <i class="fas fa-arrow-left"></i> Volver al perfil
            </a>
        </p>
    </div>

    @if($productos->count())
        <div class="row g-4">
            @foreach($productos as $producto)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-scale">
                        {{-- Imagen --}}
                        <div style="height: 250px; background: #f0f0f0; overflow: hidden; position: relative;">
                            @if($producto->imagen_principal)
                                <img src="{{ asset('storage/' . $producto->imagen_principal) }}" 
                                     alt="{{ $producto->nombre_producto }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: #e0e0e0;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif

                            {{-- Badge de estado --}}
                            @if($producto->destacado)
                                <span class="badge" style="background: var(--wayna-orange); position: absolute; top: 10px; right: 10px;">
                                    <i class="fas fa-star"></i> Destacado
                                </span>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                            
                            {{-- Categoría --}}
                            @if($producto->categoria)
                                <p class="small mb-2">
                                    <span class="badge bg-light text-dark">
                                        {{ $producto->categoria->nombre_categoria }}
                                    </span>
                                </p>
                            @endif

                            {{-- Descripción --}}
                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit($producto->descripcion_corta ?? $producto->descripcion_larga, 100) }}
                            </p>

                            {{-- Precio --}}
                            <p class="h5 mb-2">
                                <strong style="color: var(--wayna-orange);">
                                    Bs. {{ number_format($producto->precio, 2) }}
                                </strong>
                            </p>

                            {{-- Stock --}}
                            <p class="small mb-3">
                                @if($producto->stock > 0)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Stock: {{ $producto->stock }}
                                    </span>
                                @elseif($producto->estado == 'agotado')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation"></i> Agotado
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> No disponible
                                    </span>
                                @endif
                            </p>

                            {{-- Calificación --}}
                            @if($producto->calificacion_promedio > 0)
                                <p class="small mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < floor($producto->calificacion_promedio))
                                            <i class="fas fa-star" style="color: var(--wayna-orange);"></i>
                                        @elseif($i < ceil($producto->calificacion_promedio))
                                            <i class="fas fa-star-half-alt" style="color: var(--wayna-orange);"></i>
                                        @else
                                            <i class="far fa-star" style="color: var(--wayna-orange);"></i>
                                        @endif
                                    @endfor
                                    <strong>{{ number_format($producto->calificacion_promedio, 1) }}</strong>
                                    ({{ $producto->total_reseñas }} reseñas)
                                </p>
                            @endif

                            {{-- Botón de acción --}}
                            <button class="btn btn-outline-warning w-100">
                                <i class="fas fa-heart"></i> Agregar a favoritos
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $productos->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No hay productos disponibles.
        </div>
    @endif
</div>

<style>
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
