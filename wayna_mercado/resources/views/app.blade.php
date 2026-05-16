{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wayna Mercado - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ============================================
           WAYNA MERCADO - THEME ORANGE & BLACK
           ============================================ */
        
        :root {
            --wayna-orange: #FF6B35;
            --wayna-orange-dark: #E55A2B;
            --wayna-orange-light: #FF8C5A;
            --wayna-orange-soft: #FFF3ED;
            --wayna-black: #000000;
            --wayna-black-light: #1A1A1A;
            --wayna-gray: #4A4A4A;
            --wayna-light: #F5F5F5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            color: #000000;
        }

        /* ============================================
           NAVBAR
           ============================================ */
        .navbar {
            background-color: #000000 !important;
            padding: 1rem 0;
            border-bottom: 3px solid var(--wayna-orange);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--wayna-orange) !important;
        }

        .navbar-brand span {
            color: white;
        }

        .navbar-nav .nav-link {
            color: white !important;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--wayna-orange) !important;
        }

        /* ============================================
           BOTONES
           ============================================ */
        .btn-wayna {
            background-color: var(--wayna-orange);
            color: #000000;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-wayna:hover {
            background-color: var(--wayna-orange-dark);
            color: #000000;
            transform: translateY(-2px);
        }

        .btn-outline-wayna {
            background-color: transparent;
            color: var(--wayna-orange);
            border: 2px solid var(--wayna-orange);
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-outline-wayna:hover {
            background-color: var(--wayna-orange);
            color: #000000;
        }

        /* ============================================
           HERO SECTION
           ============================================ */
        .hero {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            padding: 80px 0;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #000000;
        }

        .hero h1 span {
            color: var(--wayna-orange);
        }

        .hero p {
            color: #000000;
            font-size: 1.2rem;
        }

        /* ============================================
           CARDS
           ============================================ */
        .card-wayna {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            background-color: white;
        }

        .card-wayna:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card-wayna .card-icon {
            font-size: 3rem;
            color: var(--wayna-orange);
            margin-bottom: 1rem;
        }

        .card-wayna .card-title,
        .card-wayna .card-text {
            color: #000000;
        }

        /* ============================================
           TABLAS
           ============================================ */
        .table-wayna thead th {
            border-bottom: 2px solid var(--wayna-orange);
            color: #000000;
        }

        .table-wayna tbody tr td {
            vertical-align: middle;
            color: #000000;
        }

        /* ============================================
           FORMULARIOS
           ============================================ */
        .form-wayna {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-wayna label {
            color: #000000;
            font-weight: 500;
        }

        .form-wayna input,
        .form-wayna select,
        .form-wayna textarea {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.75rem;
            width: 100%;
            transition: border-color 0.3s;
            color: #000000;
        }

        .form-wayna input:focus,
        .form-wayna select:focus,
        .form-wayna textarea:focus {
            border-color: var(--wayna-orange);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-wayna input::placeholder,
        .form-wayna textarea::placeholder {
            color: #999;
        }

        /* ============================================
           ALERTAS
           ============================================ */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #000000;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #000000;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #000000;
        }

        .alert-info {
            background-color: #fff4ed;
            border-color: var(--wayna-orange-light);
            color: #000000;
        }

        /* ============================================
           FOOTER
           ============================================ */
        .footer {
            background-color: #000000;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer p {
            color: white;
            margin-bottom: 0;
        }

        .footer a {
            color: var(--wayna-orange);
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--wayna-orange-light);
        }

        /* ============================================
           TEXTOS GENERALES
           ============================================ */
        h1, h2, h3, h4, h5, h6,
        p, span, div, li {
            color: #000000;
        }

        a:not(.nav-link):not(.btn-wayna):not(.btn-outline-wayna) {
            color: #000000;
            text-decoration: none;
            transition: color 0.3s;
        }

        a:not(.nav-link):not(.btn-wayna):not(.btn-outline-wayna):hover {
            color: var(--wayna-orange);
        }

        /* ============================================
           BADGES Y MISCELÁNEOS
           ============================================ */
        .badge-wayna {
            background-color: var(--wayna-orange) !important;
            color: #000000 !important;
        }

        .badge-wayna-status {
            color: white;
            padding: 0.5em 0.8em;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        .badge-wayna-status.active {
            background-color: #28a745;
        }

        .badge-wayna-status.inactive {
            background-color: #dc3545;
        }

        .modal-content {
            color: #000000;
        }

        .modal-title {
            color: #000000;
        }

        .dropdown-item {
            color: #000000;
        }

        .dropdown-item:hover {
            background-color: var(--wayna-orange-soft);
            color: #000000;
        }

        .page-link {
            color: #000000;
        }

        .page-item.active .page-link {
            background-color: var(--wayna-orange);
            border-color: var(--wayna-orange);
            color: #000000;
        }

        /* ============================================
           UTILIDADES
           ============================================ */
        .bg-wayna {
            background-color: var(--wayna-orange) !important;
        }

        .text-wayna {
            color: var(--wayna-orange) !important;
        }

        .border-wayna {
            border-color: var(--wayna-orange) !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">WAYNA <span>MERCADO</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Ingresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-wayna ms-2" href="{{ url('/registro-emprendedor') }}">Soy Emprendedor</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 76px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Wayna Mercado. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>