{{-- resources/views/auth/register-cliente.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrarse como Cliente')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> Registrarse como Cliente</h4>
                </div>
                <div class="card-body p-5">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.cliente.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}">
                            @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mínimo 6 caracteres</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-wayna w-100 mb-3">
                            Crear Cuenta
                        </button>

                        <div class="text-center">
                            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
                            <p><a href="{{ route('register.type') }}">Volver a seleccionar tipo de cuenta</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
