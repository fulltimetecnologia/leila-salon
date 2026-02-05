<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lailasalon">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-salon-50 via-lavender-50 to-salon-100">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-lavender-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute bottom-0 left-0 w-96 h-96 bg-salon-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
        </div>

        <div class="relative z-10">
            <a href="/">
                <x-application-logo class="mb-8" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/80 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-salon-200 relative z-10">
            {{ $slot }}
        </div>

        <p class="mt-6 text-sm text-salon-400 relative z-10">
            © {{ date('Y') }} Laila Salon - Beleza & Estilo
        </p>
    </div>
</body>

</html>
