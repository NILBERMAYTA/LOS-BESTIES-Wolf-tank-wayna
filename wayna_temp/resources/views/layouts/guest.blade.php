<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Wayna Mercado</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-orange-500 min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full sm:max-w-md bg-white rounded-[2.5rem] shadow-2xl px-10 py-12 relative overflow-hidden">
            <div class="flex justify-center mb-8">
                <div class="bg-orange-500 p-4 rounded-full shadow-inner">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            {{ $slot }}
        </div>
    </body>
</html>