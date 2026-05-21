@extends('layouts.app')

@section('title', 'Crear Usuario - Admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="mb-4"><i class="fas fa-user-plus"></i> Nuevo Usuario</h1>

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
                <div class="card-body p-4">
                    <form action="{{ route('admin.usuarios.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="nombre">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" 
                                name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="apellido">Apellido</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" 
                                name="apellido" value="{{ old('apellido') }}">
                            @error('apellido')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" 
                                name="email" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="telefono">Teléfono</label>
                            <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono" 
                                name="telefono" value="{{ old('telefono') }}">
                            @error('telefono')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="id_rol">Rol <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_rol') is-invalid @enderror" id="id_rol" name="id_rol" required>
                                <option value="">Selecciona un rol</option>
                                <option value="2" {{ old('id_rol') === '2' ? 'selected' : '' }}>Emprendedor</option>
                                <option value="3" {{ old('id_rol') === '3' ? 'selected' : '' }}>Cliente</option>
                            </select>
                            @error('id_rol')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" 
                                name="password" required>
                            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="password_confirmation">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                name="password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-wayna flex-grow-1">
                                <i class="fas fa-save"></i> Crear Usuario
                            </button>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
