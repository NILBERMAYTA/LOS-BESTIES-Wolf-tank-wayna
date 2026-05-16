<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - {{ $emprendedor->nombre_emprendimiento }}</title>
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
</head>
<body>
    <div class="container">
        <!-- HEADER NARANJA -->
        <header>
            <div class="header-content">
                <div class="header-left">
                    <div class="header-logo">
                        <span>🚀</span>
                    </div>
                    <div class="header-title">
                        <h1>Editar Perfil</h1>
                        <p>{{ $emprendedor->nombre_emprendimiento }}</p>
                    </div>
                </div>
                <div class="header-buttons">
                    <a href="{{ route('perfil.index') }}" class="btn btn-edit">👈 Volver</a>
                    <form action="{{ route('perfil.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-logout">🚪 Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="main-content">
            @if($errors->any())
                <div class="alert alert-error">
                    <strong>✗ Errores encontrados:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- FORMULARIO EDITAR PERFIL -->
            <div class="formulario-container">
                <h2 style="margin-bottom: 30px; color: #333; font-size: 24px;">
                    ✏️ Actualizar Información del Emprendimiento
                </h2>

                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- NOMBRE DEL EMPRENDIMIENTO -->
                    <div class="form-grupo">
                        <label for="nombre_emprendimiento">Nombre del Emprendimiento *</label>
                        <input 
                            type="text" 
                            id="nombre_emprendimiento" 
                            name="nombre_emprendimiento" 
                            value="{{ old('nombre_emprendimiento', $emprendedor->nombre_emprendimiento) }}"
                            required
                            maxlength="150"
                            placeholder="Ej: Artesanías del Valle"
                        >
                    </div>

                    <!-- CATEGORÍA -->
                    <div class="form-grupo">
                        <label for="categoria">Categoría *</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">-- Selecciona una categoría --</option>
                            <option value="gastronomia" {{ old('categoria', $emprendedor->categoria) === 'gastronomia' ? 'selected' : '' }}>🍽️ Gastronomía</option>
                            <option value="cosmetica" {{ old('categoria', $emprendedor->categoria) === 'cosmetica' ? 'selected' : '' }}>💄 Cosmética Natural</option>
                            <option value="artesania" {{ old('categoria', $emprendedor->categoria) === 'artesania' ? 'selected' : '' }}>🎨 Artesanía</option>
                            <option value="textiles" {{ old('categoria', $emprendedor->categoria) === 'textiles' ? 'selected' : '' }}>👗 Textiles</option>
                            <option value="otros" {{ old('categoria', $emprendedor->categoria) === 'otros' ? 'selected' : '' }}>📦 Otros</option>
                        </select>
                    </div>

                    <!-- UBICACIÓN -->
                    <div class="form-grupo">
                        <label for="ubicacion">Ubicación</label>
                        <input 
                            type="text" 
                            id="ubicacion" 
                            name="ubicacion" 
                            value="{{ old('ubicacion', $emprendedor->ubicacion) }}"
                            maxlength="150"
                            placeholder="Ej: La Paz, Bolivia"
                        >
                    </div>

                    <!-- DESCRIPCIÓN DEL EMPRENDIMIENTO -->
                    <div class="form-grupo">
                        <label for="descripcion_emprendimiento">Descripción del Emprendimiento *</label>
                        <textarea 
                            id="descripcion_emprendimiento" 
                            name="descripcion_emprendimiento" 
                            required
                            maxlength="1000"
                            placeholder="Describe tu emprendimiento, qué vendes, y qué hace diferente tu negocio..."
                        >{{ old('descripcion_emprendimiento', $emprendedor->descripcion_emprendimiento) }}</textarea>
                        <small style="color: #888;">Máximo 1000 caracteres</small>
                    </div>

                    <!-- FRASE DE IMPACTO -->
                    <div class="form-grupo">
                        <label for="frase_impacto">Frase de Impacto</label>
                        <input 
                            type="text" 
                            id="frase_impacto" 
                            name="frase_impacto" 
                            value="{{ old('frase_impacto', $emprendedor->frase_impacto) }}"
                            maxlength="255"
                            placeholder="Ej: 'Transformando sueños en realidad'"
                        >
                    </div>

                    <!-- BIOGRAFÍA -->
                    <div class="form-grupo">
                        <label for="biografia">Biografía / Historia de Vida</label>
                        <textarea 
                            id="biografia" 
                            name="biografia" 
                            maxlength="2000"
                            placeholder="Cuéntanos tu historia como emprendedor, qué te inspiró a crear este negocio..."
                        >{{ old('biografia', $emprendedor->biografia) }}</textarea>
                        <small style="color: #888;">Máximo 2000 caracteres</small>
                    </div>

                    <!-- URL DEL VIDEO -->
                    <div class="form-grupo">
                        <label for="video_url">URL del Video de Presentación</label>
                        <input 
                            type="url" 
                            id="video_url" 
                            name="video_url" 
                            value="{{ old('video_url', $emprendedor->video_url) }}"
                            placeholder="Ej: https://www.youtube.com/embed/dQw4w9WgXcQ"
                        >
                        <small style="color: #888;">Usa la URL de embed de YouTube (iframe src)</small>
                    </div>

                    <!-- BOTONES -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 30px;">
                        <a href="{{ route('perfil.index') }}" class="btn btn-cancelar" style="text-align: center;">
                            ← Cancelar
                        </a>
                        <button type="submit" class="btn btn-submit">
                            ✓ Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- FOOTER NEGRO -->
        <footer>
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Sobre Nosotros</h4>
                    <p>Wayna es una plataforma que apoya a emprendedores jóvenes de América Latina.</p>
                </div>
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <a href="/">Inicio</a>
                    <a href="#">Productos</a>
                    <a href="#">Categorías</a>
                    <a href="#">Contacto</a>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <p>📧 info@wayna.com</p>
                    <p>📱 +591 70000000</p>
                    <p>📍 La Paz, Bolivia</p>
                </div>
                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">Twitter</a>
                    <a href="#">LinkedIn</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Wayna Mercado. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>