<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wayna Mercado - Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .blob { position: absolute; border-radius: 50%; filter: blur(60px); z-index: -1; }
    </style>
</head>
<body class="bg-orange-500 min-h-screen flex items-center justify-center font-sans overflow-hidden relative p-6">
    <div class="blob w-96 h-96 bg-orange-400 -top-20 -left-20 animate-pulse"></div>
    <div class="blob w-80 h-80 bg-orange-300 bottom-10 right-10 animate-bounce" style="animation-duration: 10s;"></div>

    <div class="text-center animate__animated animate__fadeIn flex flex-col items-center">
        <div class="mb-10 drop-shadow-2xl animate__animated animate__pulse animate__infinite">
            <img src="{{ asset('images/wayna_logo_cafe.png') }}" alt="Wayna Mercado Logo" class="w-64 h-64 mx-auto rounded-full">
        </div>

        <p class="text-white text-xl font-light mb-12 tracking-widest uppercase">Bienvenido al Mercado Inteligente</p>
        
        <div class="flex flex-col space-y-5 items-center">
            <a href="{{ route('login') }}" class="bg-white text-orange-600 font-bold py-4 px-12 rounded-full shadow-2xl hover:scale-105 transition transform w-72 text-center text-lg">
                INICIAR SESIÓN
            </a>
            <a href="{{ route('register') }}" class="text-white font-bold border-2 border-white py-4 px-12 rounded-full hover:bg-white hover:text-orange-600 transition w-72 text-center text-lg">
                REGISTRARSE
            </a>
        </div>
    </div>

    <p class="absolute bottom-6 text-white/60 text-xs">© 2026 Wayna Mercado - Bolivia</p>
</body>
</html>