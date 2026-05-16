<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Wayna Mercado')</title>

    {{-- Vite compila resources/css/app.css y resources/js/app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body>

    {{-- Navbar --}}
    <header>
        <nav>
            <a href="{{ route('emprendedores.index') }}">Emprendedores</a>
        </nav>
    </header>

    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <p>&copy; {{ date('Y') }} Wayna Mercado. Todos los derechos reservados.</p>
    </footer>

    @stack('scripts')
</body>
</html>
