<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - {{ $usuario['nombre_emprendimiento'] ?? $usuario['nombre'] }}</title>
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
</head>
<body>
    <div class="container">
        <!-- HEADER NARANJA -->
        <header>
            <div class="header-content">
                <div class="header-left">
                    <div class="header-title">
                        <h1>{{ $usuario['nombre_emprendimiento'] ?? $usuario['nombre'] }}</h1>
                        <p>Módulo de Emprendedor</p>
                    </div>
                </div>
                <div class="header-buttons">
                    <a href="{{ route('perfil.edit') }}" class="btn btn-edit">Editar Perfil</a>
                    <form action="{{ route('perfil.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-logout">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="main-content">
            @if($message = session('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            @if($message = session('error'))
                <div class="alert alert-error">
                    {{ $message }}
                </div>
            @endif

            <!-- CONTENEDOR DEL PERFIL -->
            <div class="perfil-container">
                <!-- PORTADA -->
                <div class="portada">
                    <img src="{{ $datos['foto_portada'] ?? 'https://via.placeholder.com/1200x300' }}" alt="Portada">
                </div>

                <!-- HEADER DEL PERFIL -->
                <div class="perfil-header">
                    <div class="perfil-foto">
                        <img src="{{ $datos['foto_perfil'] ?? 'https://via.placeholder.com/150' }}" alt="Foto Perfil">
                        @if($usuario['verificado'])
                            <div class="verificado-badge" title="Perfil Verificado">✓</div>
                        @endif
                    </div>

                    <div class="perfil-info-header">
                        <h2>{{ $datos['nombre_emprendimiento'] ?? $usuario['nombre'] }}</h2>
                        <p class="frase-impacto">{{ $datos['frase_impacto'] ?? '"Transformando sueños en realidad"' }}</p>
                        
                        <span class="estado-validacion estado-{{ $datos['estado'] ?? 'pendiente' }}">
                            @if($usuario['estado'] === 'aprobado')
                                Aprobado
                            @elseif($usuario['estado'] === 'pendiente')
                                Pendiente
                            @else
                                Rechazado
                            @endif
                        </span>
                    </div>
                </div>

                <!-- CONTENIDO DEL PERFIL -->
                <div class="perfil-content">
                    <!-- SECCIÓN: INFORMACIÓN PERSONAL -->
                    <div class="seccion">
                        <div class="seccion-titulo">Información Personal</div>
                        <div class="grid-2">
                            <div class="info-item">
                                <div class="info-label">Nombre Completo</div>
                                <div class="info-value">{{ $usuario['usuario_nombre'] ?? 'N/A' }} {{ $datos['usuario_apellido'] ?? '' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Correo Electrónico</div>
                                <div class="info-value">{{ $usuario['usuario_email'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Teléfono</div>
                                <div class="info-value">{{ $usuario['usuario_telefono'] ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Ubicación</div>
                                <div class="info-value">{{ $usuario['usuario_ubicacion'] ?? 'No especificada' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN: INFORMACIÓN DEL EMPRENDIMIENTO -->
                    <div class="seccion">
                        <div class="seccion-titulo">Información del Emprendimiento</div>
                        <div class="grid-2">
                            <div class="info-item">
                                <div class="info-label">Categoría</div>
                                <div class="info-value">
                                    @switch($usuario['categoria'])
                                        @case('gastronomia')
                                            Gastronomía
                                            @break
                                        @case('cosmetica')
                                            Cosmética
                                            @break
                                        @case('artesania')
                                            Artesanía
                                            @break
                                        @case('textiles')
                                            Textiles
                                            @break
                                        @default
                                            Otros
                                    @endswitch
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Estado</div>
                                <div class="info-value">
                                    @if($usuario['verificado'])
                                        <span style="color: #4CAF50;">✓ Verificado</span>
                                    @else
                                        <span style="color: #FF6B6B;">Pendiente</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 20px;">
                            <div class="info-label">Descripción del Emprendimiento</div>
                            <div class="descripcion-text">
                                {{ $usuario['descripcion'] ?? 'Sin descripción disponible' }}
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN: BIOGRAFÍA -->
                    <div class="seccion">
                        <div class="seccion-titulo">Biografía</div>
                        <div class="descripcion-text">
                            {{ $usuario['biografia'] ?? 'Sin biografía disponible' }}
                        </div>
                    </div>

                    <!-- SECCIÓN: VIDEO DE PRESENTACIÓN -->
                    @if($usuario['video_url'])
                        <div class="seccion">
                            <div class="seccion-titulo">Video de Presentación</div>
                            <div class="video-container">
                                <iframe src="{{ $usuario['video_url'] }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
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
                    <p>info@wayna.com</p>
                    <p>+591 70000000</p>
                    <p> La Paz, Bolivia</p>
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