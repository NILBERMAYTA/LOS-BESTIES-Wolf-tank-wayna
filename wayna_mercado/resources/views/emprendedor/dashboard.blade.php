{{-- resources/views/emprendedor/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    @if(Auth::check() && Auth::user()->id_rol == 2)
        {{-- Dashboard para Emprendedores --}}
        @php
            $emprendedor = Auth::user()->emprendedor;
        @endphp

        @if($emprendedor)
            @php
                $productosRecientes = $emprendedor->productos()->take(5)->get();
                $productoCount = $emprendedor->productos()->count();
            @endphp
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="mb-3">
                        <i class="fas fa-store"></i> Bienvenido, {{ Auth::user()->nombre }}
                    </h2>
                    <p class="text-muted">Aquí está tu espacio para gestionar tu emprendimiento</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge badge-wayna px-3 py-2" style="font-size: 1.1em;">
                        @if($emprendedor->estado_validacion == 'aprobado')
                            <i class="fas fa-check-circle"></i> Aprobado
                        @else
                            <i class="fas fa-clock"></i> {{ ucfirst($emprendedor->estado_validacion) }}
                        @endif
                    </span>
                </div>
            </div>

            {{-- Tarjetas de información --}}
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-cube fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Productos</p>
                            <h3 style="color: var(--wayna-orange);">
                                {{ $emprendedor->productos()->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-star fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Calificación Promedio</p>
                            <h3 style="color: var(--wayna-orange);">
                                {{ number_format(rand(40, 50) / 10, 1) }}/5
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-eye fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Visitas</p>
                            <h3 style="color: var(--wayna-orange);">
                                {{ rand(100, 1000) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección de tu emprendimiento --}}
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header" style="background: var(--wayna-orange); color: white;">
                            <h5 class="mb-0">
                                <i class="fas fa-briefcase"></i> {{ $emprendedor->nombre_emprendimiento }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                <strong>Categoría:</strong> 
                                <span class="badge badge-wayna">
                                    {{ ucfirst(str_replace('_', ' ', $emprendedor->categoria)) }}
                                </span>
                            </p>

                            @if($emprendedor->frase_impacto)
                                <p class="mb-3">
                                    <strong>Frase de impacto:</strong><br>
                                    <em>{{ $emprendedor->frase_impacto }}</em>
                                </p>
                            @endif

                            @if($emprendedor->biografia)
                                <p class="mb-3">
                                    <strong>Tu historia:</strong><br>
                                    {{ \Illuminate\Support\Str::limit($emprendedor->biografia, 200) }}
                                </p>
                            @endif

                            <a href="{{ route('emprendedor.show', $emprendedor->slug_emprendimiento) }}" 
                               class="btn btn-wayna">
                                <i class="fas fa-eye"></i> Ver mi perfil público
                            </a>
                        </div>
                    </div>

                    {{-- Productos recientes --}}
                    <div class="card shadow">
                        <div class="card-header" style="background: var(--wayna-orange); color: white;">
                            <h5 class="mb-0">
                                <i class="fas fa-cube"></i> Mis Productos ({{ $productoCount }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($productoCount > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-wayna">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Stock</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($productosRecientes as $producto)
                                                <tr>
                                                    <td>{{ $producto->nombre_producto }}</td>
                                                    <td>Bs. {{ number_format($producto->precio, 2) }}</td>
                                                    <td>{{ $producto->stock }}</td>
                                                    <td>
                                                        <span class="badge badge-wayna-status {{ $producto->estado == 'activo' ? 'active' : 'inactive' }}">
                                                            {{ ucfirst($producto->estado) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-center mt-3">
                                    <a href="{{ route('emprendedor.productos', $emprendedor->slug_emprendimiento) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        Ver todos los productos
                                    </a>
                                </p>
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i> Aún no has publicado productos.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Acciones rápidas --}}
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header" style="background: var(--wayna-orange); color: white;">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs"></i> Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('producto.create') }}" class="btn btn-outline-warning w-100 mb-2">
                                <i class="fas fa-plus"></i> Nuevo Producto
                            </a>
                            <a href="{{ route('emprendedor.editPerfil') }}" class="btn btn-outline-warning w-100 mb-2">
                                <i class="fas fa-edit"></i> Editar Perfil
                            </a>
                            <button class="btn btn-outline-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalFotos">
                                <i class="fas fa-images"></i> Fotos
                            </button>
                            <button class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#modalEstadisticas">
                                <i class="fas fa-chart-bar"></i> Estadísticas
                            </button>
                        </div>
                    </div>

                    {{-- Estado de verificación --}}
                    <div class="card shadow mt-3">
                        <div class="card-body">
                            @if($emprendedor->verificado)
                                <p class="mb-0">
                                    <i class="fas fa-check-circle" style="color: green;"></i> 
                                    <strong>Tu cuenta está verificada</strong>
                                </p>
                            @else
                                <p class="mb-0">
                                    <i class="fas fa-hourglass" style="color: orange;"></i> 
                                    <strong>Verificación pendiente</strong>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                No tiene un perfil de emprendedor creado. 
                <a href="{{ route('register.emprendedor') }}">Crear perfil</a>
            </div>
        @endif
    @else
        {{-- Para otros usuarios --}}
        <div class="card shadow">
            <div class="card-header" style="background: var(--wayna-orange); color: white;">
                <h4 class="mb-0">Acceso Restringido</h4>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-lock fa-3x mb-3 text-muted"></i>
                <p>Este espacio está reservado para emprendedores.</p>
                <a href="{{ route('register.emprendedor') }}" class="btn" style="background: var(--wayna-orange); color: white;">
                    ¿Eres emprendedor? Regístrate aquí
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
