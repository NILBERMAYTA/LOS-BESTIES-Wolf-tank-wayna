{{-- resources/views/emprendedor/show.blade.php --}}
@extends('layouts.app')

@section('title', $emprendedor->nombre_emprendimiento)

@section('content')
<div class="container py-5">
    {{-- Portada --}}
    @if($emprendedor->foto_portada)
        <div class="mb-4" style="height: 300px; border-radius: 10px; overflow: hidden; background: #f0f0f0;">
            <img src="{{ asset('storage/' . $emprendedor->foto_portada) }}" 
                 alt="Portada"
                 class="w-100 h-100"
                 style="object-fit: cover;">
        </div>
    @else
        <div class="mb-4" style="height: 300px; border-radius: 10px; background: linear-gradient(135deg, var(--wayna-orange) 0%, #ff8c00 100%);"></div>
    @endif

    {{-- Información del emprendedor --}}
    <div class="row mb-5">
        {{-- Perfil lateral --}}
        <div class="col-md-4">
            <div class="card shadow">
                {{-- Foto de perfil --}}
                <div style="height: 250px; background: #f0f0f0; overflow: hidden;">
                    @if($emprendedor->foto_perfil)
                        <img src="{{ asset('storage/' . $emprendedor->foto_perfil) }}" 
                             alt="{{ $emprendedor->nombre_emprendimiento }}"
                             class="w-100 h-100"
                             style="object-fit: cover;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--wayna-orange) 0%, #ff8c00 100%);">
                            <i class="fas fa-store fa-4x text-white"></i>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <h4 class="card-title">{{ $emprendedor->nombre_emprendimiento }}</h4>
                    
                    <p class="text-muted">
                        <strong>{{ $emprendedor->user->nombre }} {{ $emprendedor->user->apellido }}</strong>
                    </p>

                    {{-- Categoría --}}
                    <p class="mb-3">
                        <span class="badge" style="background: var(--wayna-orange); font-size: 0.9em;">
                            <i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $emprendedor->categoria)) }}
                        </span>
                    </p>

                    {{-- Contacto --}}
                    @if($emprendedor->user->telefono)
                        <p class="mb-2">
                            <i class="fas fa-phone"></i> <strong>Teléfono:</strong> {{ $emprendedor->user->telefono }}
                        </p>
                    @endif

                    @if($emprendedor->ubicacion)
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt"></i> <strong>Ubicación:</strong> {{ $emprendedor->ubicacion }}
                        </p>
                    @endif

                    {{-- Video --}}
                    @if($emprendedor->video_url)
                        <a href="{{ $emprendedor->video_url }}" target="_blank" class="btn btn-sm btn-outline-danger w-100">
                            <i class="fab fa-youtube"></i> Ver Presentación
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información principal --}}
        <div class="col-md-8">
            {{-- Frase de impacto --}}
            @if($emprendedor->frase_impacto)
                <div class="card mb-4 border-0" style="background: linear-gradient(135deg, rgba(255, 140, 0, 0.1) 0%, rgba(255, 140, 0, 0.05) 100%);">
                    <div class="card-body">
                        <p class="lead mb-0" style="color: var(--wayna-orange);">
                            <i class="fas fa-quote-left"></i> {{ $emprendedor->frase_impacto }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Biografía --}}
            @if($emprendedor->biografia)
                <div class="card mb-4">
                    <div class="card-header" style="background: var(--wayna-orange); color: white;">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Historia de Vida</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $emprendedor->biografia }}</p>
                    </div>
                </div>
            @endif

            {{-- Descripción del emprendimiento --}}
            @if($emprendedor->descripcion_emprendimiento)
                <div class="card mb-4">
                    <div class="card-header" style="background: var(--wayna-orange); color: white;">
                        <h5 class="mb-0"><i class="fas fa-briefcase"></i> Sobre el Emprendimiento</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $emprendedor->descripcion_emprendimiento }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Productos --}}
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-cube"></i> Productos 
                <span class="badge" style="background: var(--wayna-orange);">{{ $productos->count() }}</span>
            </h3>

            @if($productos->count())
                <div class="row g-4">
                    @foreach($productos as $producto)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                {{-- Imagen del producto --}}
                                <div style="height: 200px; background: #f0f0f0; overflow: hidden;">
                                    @if($producto->imagen_principal)
                                        <img src="{{ asset('storage/' . $producto->imagen_principal) }}" 
                                             alt="{{ $producto->nombre_producto }}"
                                             class="w-100 h-100"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: #e0e0e0;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                                    
                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($producto->descripcion_corta ?? $producto->descripcion_larga, 80) }}
                                    </p>

                                    <p class="mb-2">
                                        <strong style="color: var(--wayna-orange); font-size: 1.2em;">
                                            Bs. {{ number_format($producto->precio, 2) }}
                                        </strong>
                                    </p>

                                    {{-- Stock --}}
                                    <p class="small mb-2">
                                        @if($producto->stock > 0)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Stock: {{ $producto->stock }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Agotado
                                            </span>
                                        @endif
                                    </p>

                                    {{-- Calificación --}}
                                    @if($producto->calificacion_promedio > 0)
                                        <p class="mb-0 small">
                                            <i class="fas fa-star" style="color: var(--wayna-orange);"></i>
                                            {{ number_format($producto->calificacion_promedio, 1) }} 
                                            ({{ $producto->total_reseñas }} reseñas)
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Este emprendedor aún no tiene productos publicados.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
