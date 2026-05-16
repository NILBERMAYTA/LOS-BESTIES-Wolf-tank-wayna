{{-- resources/views/emprendedor/edit-perfil.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Mi Perfil')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit"></i> Editar Mi Perfil
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('emprendedor.updatePerfil') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Sección de Fotos --}}
                        <h5 class="mb-3 mt-4">
                            <i class="fas fa-images"></i> Fotos
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                                    @if($emprendedor->foto_perfil)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $emprendedor->foto_perfil) }}" 
                                                 alt="Foto de perfil" style="max-height: 150px; border-radius: 50%;" class="img-thumbnail">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" 
                                           id="foto_perfil" name="foto_perfil" accept="image/*">
                                    <small class="form-text text-muted">PNG, JPG, GIF. Máximo 5MB</small>
                                    @error('foto_perfil')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto_portada" class="form-label">Foto de Portada</label>
                                    @if($emprendedor->foto_portada)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $emprendedor->foto_portada) }}" 
                                                 alt="Foto de portada" style="max-height: 150px;" class="img-thumbnail">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('foto_portada') is-invalid @enderror" 
                                           id="foto_portada" name="foto_portada" accept="image/*">
                                    <small class="form-text text-muted">PNG, JPG, GIF. Máximo 5MB</small>
                                    @error('foto_portada')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Sección de Información del Emprendimiento --}}
                        <h5 class="mb-3">
                            <i class="fas fa-briefcase"></i> Tu Emprendimiento
                        </h5>

                        <div class="mb-3">
                            <label for="nombre_emprendimiento" class="form-label">Nombre del Emprendimiento *</label>
                            <input type="text" class="form-control @error('nombre_emprendimiento') is-invalid @enderror" 
                                   id="nombre_emprendimiento" name="nombre_emprendimiento" 
                                   value="{{ old('nombre_emprendimiento', $emprendedor->nombre_emprendimiento) }}" required>
                            @error('nombre_emprendimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_emprendimiento" class="form-label">Descripción Breve</label>
                            <input type="text" maxlength="255" class="form-control @error('descripcion_emprendimiento') is-invalid @enderror" 
                                   id="descripcion_emprendimiento" name="descripcion_emprendimiento" 
                                   value="{{ old('descripcion_emprendimiento', $emprendedor->descripcion_emprendimiento) }}">
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
                            @error('descripcion_emprendimiento')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="frase_impacto" class="form-label">Frase de Impacto *</label>
                            <input type="text" maxlength="255" class="form-control @error('frase_impacto') is-invalid @enderror" 
                                   id="frase_impacto" name="frase_impacto" 
                                   value="{{ old('frase_impacto', $emprendedor->frase_impacto) }}" required>
                            <small class="form-text text-muted">Una frase que represente tu emprendimiento. Máximo 255 caracteres</small>
                            @error('frase_impacto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="biografia" class="form-label">Tu Historia *</label>
                            <textarea class="form-control @error('biografia') is-invalid @enderror" 
                                      id="biografia" name="biografia" rows="5" required>{{ old('biografia', $emprendedor->biografia) }}</textarea>
                            @error('biografia')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoría *</label>
                                    <select class="form-select @error('categoria') is-invalid @enderror" 
                                            id="categoria" name="categoria" required>
                                        <option value="">Selecciona una categoría</option>
                                        <option value="gastronomia" {{ old('categoria', $emprendedor->categoria) == 'gastronomia' ? 'selected' : '' }}>
                                            Gastronomía
                                        </option>
                                        <option value="cosmetica" {{ old('categoria', $emprendedor->categoria) == 'cosmetica' ? 'selected' : '' }}>
                                            Cosmética
                                        </option>
                                        <option value="artesania" {{ old('categoria', $emprendedor->categoria) == 'artesania' ? 'selected' : '' }}>
                                            Artesanía
                                        </option>
                                        <option value="textiles" {{ old('categoria', $emprendedor->categoria) == 'textiles' ? 'selected' : '' }}>
                                            Textiles
                                        </option>
                                        <option value="otros" {{ old('categoria', $emprendedor->categoria) == 'otros' ? 'selected' : '' }}>
                                            Otros
                                        </option>
                                    </select>
                                    @error('categoria')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación</label>
                                    <input type="text" maxlength="150" class="form-control @error('ubicacion') is-invalid @enderror" 
                                           id="ubicacion" name="ubicacion" 
                                           value="{{ old('ubicacion', $emprendedor->ubicacion) }}">
                                    @error('ubicacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('emprendedor.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn" style="background: var(--wayna-orange); color: white;">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
