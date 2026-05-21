{{-- resources/views/emprendedor/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    @if(Auth::check() && Auth::user()->isEmprendedor())
        {{-- Dashboard para Emprendedores --}}
        @php
            $emprendedor = Auth::user()->emprendedor;
        @endphp

        @if($emprendedor)
            @php
                $productosRecientes = $emprendedor->productos()->take(5)->get();
                $productoCount = $totalProductos;
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
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-cube fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Productos</p>
                            <h3 style="color: var(--wayna-orange);">
                                {{ $totalProductos }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-cart fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Ventas</p>
                            <h3 style="color: var(--wayna-orange);">
                                Bs. {{ number_format($totalVentas, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-boxes fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Unidades vendidas</p>
                            <h3 style="color: var(--wayna-orange);">
                                {{ $totalUnidadesVendidas }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-hand-holding-heart fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Donaciones</p>
                            <h3 style="color: var(--wayna-orange);">
                                Bs. {{ number_format($totalDonaciones, 2) }}
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

{{-- Modales usados por los botones del panel --}}
{{-- Modal Fotos --}}
<div class="modal fade" id="modalFotos" tabindex="-1" aria-labelledby="modalFotosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFotosLabel"><i class="fas fa-images"></i> Fotos del emprendimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6>Foto de perfil</h6>
                        @if($emprendedor?->foto_perfil)
                            <img src="{{ asset('storage/' . $emprendedor->foto_perfil) }}" class="img-fluid rounded" alt="Foto de perfil">
                        @else
                            <div class="p-5 text-center" style="background:#f5f5f5;">
                                <i class="fas fa-user fa-3x text-muted"></i>
                                <p class="mt-2">Sin foto de perfil</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Foto de portada</h6>
                        @if($emprendedor?->foto_portada)
                            <img src="{{ asset('storage/' . $emprendedor?->foto_portada) }}" class="img-fluid rounded" alt="Foto de portada">
                        @else
                            <div class="p-5 text-center" style="background:#f5f5f5;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2">Sin foto de portada</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('emprendedor.editPerfil') }}" class="btn btn-outline-warning">Editar fotos</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Estadísticas --}}
<div class="modal fade" id="modalEstadisticas" tabindex="-1" aria-labelledby="modalEstadisticasLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstadisticasLabel"><i class="fas fa-chart-bar"></i> Estadísticas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <h6>Productos</h6>
                        <p class="h4">{{ $totalProductos ?? 0 }}</p>
                    </div>
                    <div class="col-6">
                        <h6>Ventas (Bs.)</h6>
                        <p class="h4">{{ number_format($totalVentas ?? 0, 2) }}</p>
                    </div>
                    <div class="col-6">
                        <h6>Unidades vendidas</h6>
                        <p class="h5">{{ $totalUnidadesVendidas ?? 0 }}</p>
                    </div>
                    <div class="col-6">
                        <h6>Donaciones (Bs.)</h6>
                        <p class="h5">{{ number_format($totalDonaciones ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection
