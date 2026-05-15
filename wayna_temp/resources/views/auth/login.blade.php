<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-orange-600">¡Bienvenido!</h2>
        <p class="text-gray-400 text-sm">Ingresa tus datos para continuar</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-6">
            <div class="relative">
                <input id="email" type="email" name="email" required autofocus class="w-full border-b-2 border-gray-200 focus:border-orange-500 outline-none py-2 transition-colors peer bg-transparent" placeholder=" ">
                <label class="absolute left-0 top-2 text-gray-400 pointer-events-none transition-all peer-focus:-top-4 peer-focus:text-xs peer-focus:text-orange-500">Correo Electrónico</label>
            </div>

            <div class="relative">
                <input id="password" type="password" name="password" required class="w-full border-b-2 border-gray-200 focus:border-orange-500 outline-none py-2 transition-colors peer bg-transparent" placeholder=" ">
                <label class="absolute left-0 top-2 text-gray-400 pointer-events-none transition-all peer-focus:-top-4 peer-focus:text-xs peer-focus:text-orange-500">Contraseña</label>
            </div>
        </div>

        <button type="submit" class="w-full bg-orange-500 text-white font-bold py-4 rounded-2xl mt-10 hover:bg-orange-600 shadow-lg shadow-orange-200 transition">
            INICIAR SESIÓN
        </button>

        <div class="mt-6 text-center">
            <p class="text-gray-400 text-sm">¿No tienes cuenta? 
                <a href="{{ route('register') }}" class="text-orange-500 font-bold underline">Regístrate ahora</a>
            </p>
        </div>
    </form>
</x-guest-layout>
