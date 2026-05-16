{{-- resources/views/auth/register-emprendedor.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Emprendimiento')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h4 class="mb-0">Registrar mi Emprendimiento</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register.emprendedor.post') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="apellido" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contraseña *</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmar Contraseña *</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Datos del Emprendimiento</h5>

                        <div class="mb-3">
                            <label class="form-label">Nombre del Emprendimiento *</label>
                            <input type="text" name="nombre_emprendimiento" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <option value="gastronomia">Gastronomía</option>
                                <option value="cosmetica">Cosmética Natural</option>
                                <option value="artesania">Artesanía</option>
                                <option value="textiles">Textiles</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Frase de Impacto *</label>
                            <input type="text" name="frase_impacto" class="form-control" placeholder="Ej: 'El esfuerzo de hoy es el éxito de mañana'" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción del emprendimiento</label>
                            <textarea name="descripcion_emprendimiento" rows="3" class="form-control" placeholder="Describe tu emprendimiento"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" class="form-control" placeholder="Ciudad / Barrio">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Historia / Biografía *</label>
                            <textarea name="biografia" rows="5" class="form-control" placeholder="Cuéntanos tu historia..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Video (URL de YouTube)</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        </div>

                        {{-- BOTÓN DE ENVÍO --}}
                        <button type="submit" class="btn w-100 mt-3" style="background: var(--wayna-orange); color: white; padding: 12px;">
                            <i class="fas fa-check-circle"></i> Registrar Emprendimiento
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">Tu cuenta quedará pendiente de validación por nuestro equipo.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection