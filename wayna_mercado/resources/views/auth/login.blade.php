{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    {{-- Mostrar errores generales --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}" novalidate>
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label" for="email">Correo Electrónico</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="form-control @error('password') is-invalid @enderror" 
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn w-100" style="background: var(--wayna-orange); color: white;">
                            Ingresar
                        </button>
                    </form>

                    <hr>

                    <div class="text-center">
                        <p>¿No tienes cuenta?</p>
                        <a href="{{ route('register.type') }}" class="btn btn-wayna w-100 mb-3">
                            <i class="fas fa-user-plus"></i> Crear una cuenta
                        </a>
                        <p class="text-muted small">Elige entre ser cliente o emprendedor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection