@extends('layouts.app')

@section('title', 'Gestionar Usuarios - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-wayna">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Errores:</strong>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, email, teléfono..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Todos los roles</option>
                        <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Emprendedor</option>
                        <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>Cliente</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td><strong>#{{ $usuario->id_usuario }}</strong></td>
                                <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->telefono ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $usuario->id_rol === 2 ? 'bg-info' : 'bg-primary' }}">
                                        {{ $usuario->id_rol === 2 ? 'Emprendedor' : 'Cliente' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.usuarios.show', $usuario->id_usuario) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.usuarios.edit', $usuario->id_usuario) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($usuario->id_usuario !== auth()->id() || !$usuario->isAdmin())
                                        <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection
