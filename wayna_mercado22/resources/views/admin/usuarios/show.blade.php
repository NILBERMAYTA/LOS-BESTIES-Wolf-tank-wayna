@extends('layouts.app')

@section('title', 'Detalles del Usuario - Admin')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1><i class="fas fa-user"></i> {{ $usuario->nombre }} {{ $usuario->apellido }}</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.usuarios.edit', $usuario->id_usuario) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h5 class="mb-0">Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>ID Usuario:</strong>
                            <p>#{{ $usuario->id_usuario }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Nombre:</strong>
                            <p>{{ $usuario->nombre }} {{ $usuario->apellido }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p>{{ $usuario->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Teléfono:</strong>
                            <p>{{ $usuario->telefono ?? 'No especificado' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Rol:</strong>
                            <p>
                                <span class="badge {{ $usuario->id_rol === 2 ? 'bg-info' : 'bg-primary' }}">
                                    {{ $usuario->id_rol === 2 ? 'Emprendedor' : 'Cliente' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Registro:</strong>
                            <p>{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($usuario->isEmprendedor() && $usuario->emprendedor)
                <div class="card shadow">
                    <div class="card-header" style="background: var(--wayna-orange); color: white;">
                        <h5 class="mb-0">Información del Emprendimiento</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nombre:</strong>
                                <p>{{ $usuario->emprendedor->nombre_emprendimiento }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Categoría:</strong>
                                <p>{{ $usuario->emprendedor->categoria }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Biografía:</strong>
                            <p>{{ $usuario->emprendedor->biografia }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Frase de Impacto:</strong>
                            <p><em>{{ $usuario->emprendedor->frase_impacto }}</em></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Estado:</strong>
                                <p>
                                    <span class="badge {{ $usuario->emprendedor->estado_validacion === 'aprobado' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($usuario->emprendedor->estado_validacion) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong>Verificado:</strong>
                                <p>{{ $usuario->emprendedor->verificado ? '✓ Sí' : '✗ No' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h5 class="mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.usuarios.edit', $usuario->id_usuario) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> Editar Usuario
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
