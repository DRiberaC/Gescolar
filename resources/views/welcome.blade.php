<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a Gescolar</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div class="bg-gray-50 ">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-primary-500 selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        {{-- Aquí puedes colocar tu logo si tienes uno --}}
                    </div>
                </header>

                <main class="mt-6">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                            Gescolar
                        </h1>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            Sistema de Administración Escolar.
                        </p>
                        <p class="mt-2 text-md text-gray-500 dark:text-gray-500">
                            Gestiona estudiantes, docentes, matriculaciones y más, de forma sencilla y eficiente.
                        </p>
                    </div>

                    <div class="mt-12 text-center">
                        <a href="{{ url('admin/login') }}"
                            class="inline-block rounded-lg bg-primary-600 px-6 py-3 text-base font-semibold  shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                            Iniciar Sesión
                        </a>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Gescolar
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
