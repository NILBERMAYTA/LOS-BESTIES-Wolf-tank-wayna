<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-orange-600">Crear Cuenta</h2>
        <p class="text-gray-400 text-sm">Únete a Wayna Mercado</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="space-y-4">
            <div class="relative">
                <input id="name" type="text" name="name" required class="w-full border-b-2 border-gray-200 focus:border-orange-500 outline-none py-2 peer bg-transparent" placeholder=" ">
                <label class="absolute left-0 top-2 text-gray-400 transition-all peer-focus:-top-4 peer-focus:text-xs peer-focus:text-orange-500 text-sm">Nombre Completo</label>
            </div>

            <div class="relative">
                <input id="email" type="email" name="email" required class="w-full border-b-2 border-gray-200 focus:border-orange-500 outline-none py-2 peer bg-transparent" placeholder=" ">
                <label class="absolute left-0 top-2 text-gray-400 transition-all peer-focus:-top-4 peer-focus:text-xs peer-focus:text-orange-500 text-sm">Correo Electrónico</label>
            </div>

            <div class="relative">
                <input id="password" type="password" name="password" required class="w-full border-b-2 border-gray-200 focus:border-orange-500 outline-none py-2 peer bg-transparent" placeholder=" ">
                <label class="absolute left-0 top-2 text-gray-400 transition-all peer-focus:-top-4 peer-focus:text-xs peer-focus:text-orange-500 text-sm">Contraseña</label>
            </div>

            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border-b-2 border-gray-200 focus:border-orange-500 outline-none py-2 peer bg-transparent" placeholder=" ">
                <label class="absolute left-0 top-2 text-gray-400 transition-all peer-focus:-top-4 peer-focus:text-xs peer-focus:text-orange-500 text-sm">Confirmar Contraseña</label>
            </div>
        </div>

        <button type="submit" class="w-full bg-orange-500 text-white font-bold py-4 rounded-2xl mt-8 hover:bg-orange-600 shadow-lg shadow-orange-200 transition">
            REGISTRARSE
        </button>
        
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-orange-500 text-sm font-bold underline">¿Ya tienes cuenta? Entra aquí</a>
        </div>
    </form>
</x-guest-layout>