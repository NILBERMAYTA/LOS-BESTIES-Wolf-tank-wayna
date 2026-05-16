{{-- resources/views/emprendedor/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Emprendedores')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">
        <i class="fas fa-store"></i> Nuestros Emprendedores
    </h2>

    @if($emprendedores->count())
        <div class="row g-4">
            @foreach($emprendedores as $emprendedor)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm hover-scale">
                        {{-- Foto de perfil --}}
                        <div style="height: 200px; background: #f0f0f0; position: relative; overflow: hidden;">
                            @if($emprendedor->foto_perfil)
                                <img src="{{ asset('storage/' . $emprendedor->foto_perfil) }}" 
                                     alt="{{ $emprendedor->nombre_emprendimiento }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--wayna-orange) 0%, #ff8c00 100%);">
                                    <i class="fas fa-store fa-3x text-white"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                {{ $emprendedor->nombre_emprendimiento }}
                            </h5>

                            <p class="small text-muted mb-2">
                                <i class="fas fa-tag"></i> 
                                <span class="badge" style="background: var(--wayna-orange);">
                                    {{ ucfirst(str_replace('_', ' ', $emprendedor->categoria)) }}
                                </span>
                            </p>

                            <p class="card-text small flex-grow-1">
                                {{ Str::limit($emprendedor->frase_impacto, 80) }}
                            </p>

                            <p class="small text-muted">
                                <i class="fas fa-user"></i> {{ $emprendedor->user->nombre }}
                            </p>

                            <a href="{{ route('emprendedor.show', $emprendedor->slug_emprendimiento) }}" 
                               class="btn btn-sm w-100" 
                               style="background: var(--wayna-orange); color: white;">
                                Ver Perfil
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $emprendedores->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No hay emprendedores disponibles aún.
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
