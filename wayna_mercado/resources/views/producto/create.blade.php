{{-- resources/views/producto/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Nuevo Producto')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h4 class="mb-0">
                        <i class="fas fa-plus"></i> Crear Nuevo Producto
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre_producto" class="form-label">Nombre del Producto *</label>
                            <input type="text" class="form-control @error('nombre_producto') is-invalid @enderror" 
                                   id="nombre_producto" name="nombre_producto" value="{{ old('nombre_producto') }}" required>
                            @error('nombre_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_categoria" class="form-label">Categoría *</label>
                                    <select class="form-select @error('id_categoria') is-invalid @enderror" 
                                            id="id_categoria" name="id_categoria" required>
                                        <option value="">Selecciona una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id_categoria }}" 
                                                    {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                                {{ $categoria->nombre_categoria ?? $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_categoria')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="precio" class="form-label">Precio (Bs.) *</label>
                                    <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" 
                                           id="precio" name="precio" value="{{ old('precio') }}" required>
                                    @error('precio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock *</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock_minimo" class="form-label">Stock Mínimo *</label>
                                    <input type="number" class="form-control @error('stock_minimo') is-invalid @enderror" 
                                           id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', 5) }}" required>
                                    @error('stock_minimo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_corta" class="form-label">Descripción Corta *</label>
                            <input type="text" maxlength="255" class="form-control @error('descripcion_corta') is-invalid @enderror" 
                                   id="descripcion_corta" name="descripcion_corta" value="{{ old('descripcion_corta') }}" required>
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
                            @error('descripcion_corta')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_larga" class="form-label">Descripción Detallada</label>
                            <textarea class="form-control @error('descripcion_larga') is-invalid @enderror" 
                                      id="descripcion_larga" name="descripcion_larga" rows="5">{{ old('descripcion_larga') }}</textarea>
                            @error('descripcion_larga')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imagen_principal" class="form-label">Imagen Principal</label>
                            <input type="file" class="form-control @error('imagen_principal') is-invalid @enderror" 
                                   id="imagen_principal" name="imagen_principal" accept="image/*">
                            <small class="form-text text-muted">PNG, JPG, GIF. Máximo 5MB</small>
                            @error('imagen_principal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('emprendedor.productos', $emprendedor->slug_emprendimiento) }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn" style="background: var(--wayna-orange); color: white;">
                                <i class="fas fa-save"></i> Crear Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
