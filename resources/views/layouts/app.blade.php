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
    <body class="font-sans antialiased bg-base-200">
        <x-main full-width>
            <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-base-100">
                <div class="px-6 py-4 border-b border-base-300">
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
                        <x-application-logo />
                    </a>
                </div>

                <div class="px-2 py-4">
                    @include('layouts.navigation')
                </div>
            </x-slot:sidebar>

            <x-slot:content>
                <!-- Top Bar -->
                <div class="navbar bg-base-100 border-b border-base-300 sticky top-0 z-10">
                    <div class="flex-none lg:hidden">
                        <label for="main-drawer" class="btn btn-square btn-ghost drawer-button">
                            <x-icon name="o-bars-3" class="h-5 w-5" />
                        </label>
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('dashboard') }}" class="btn btn-ghost text-xl">
                            <span class="hidden lg:inline">Salão da Leila</span>
                            <span class="lg:hidden"><x-application-logo /></span>
                        </a>
                    </div>
                    <div class="flex-none">
                        <div class="hidden lg:flex items-center gap-2 mr-2">
                            <span class="text-sm">{{ auth()->user()->name }}</span>
                        </div>
                        <x-dropdown>
                            <x-slot:trigger>
                                <x-button icon="o-user-circle" class="btn-circle btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-menu-item title="Perfil" icon="o-user" link="{{ route('profile.edit') }}" />
                            <x-menu-separator />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-menu-item title="Sair" icon="o-arrow-right-on-rectangle" 
                                    onclick="event.preventDefault(); this.closest('form').submit();" />
                            </form>
                        </x-dropdown>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="min-h-screen">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-gradient-to-r from-salon-50 to-lavender-50 border-b border-base-300">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <div class="p-4 lg:p-8">
                        @if(session('success'))
                            <x-alert icon="o-check-circle" class="alert-success mb-4">
                                {{ session('success') }}
                            </x-alert>
                        @endif

                        @if(session('error'))
                            <x-alert icon="o-x-circle" class="alert-error mb-4">
                                {{ session('error') }}
                            </x-alert>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </x-slot:content>
        </x-main>
    </body>
</html>
