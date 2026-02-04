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
        <x-mary-main full-width>
            <x-slot:sidebar drawer="main-drawer" collapsible class="bg-gradient-to-b from-salon-50 to-lavender-50 border-r border-salon-200 lg:bg-inherit">
                <div class="p-4 border-b border-salon-200">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo />
                    </a>
                </div>

                @include('layouts.navigation')
            </x-slot:sidebar>

            <x-slot:content>
                <!-- Top Bar -->
                <div class="navbar bg-base-100 border-b border-base-300 lg:hidden">
                    <div class="flex-none">
                        <label for="main-drawer" class="btn btn-square btn-ghost drawer-button lg:hidden">
                            <x-mary-icon name="o-bars-3" class="h-6 w-6" />
                        </label>
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('dashboard') }}" class="btn btn-ghost">
                            <x-application-logo />
                        </a>
                    </div>
                    <div class="flex-none">
                        <x-mary-dropdown>
                            <x-slot:trigger>
                                <x-mary-button icon="o-user-circle" class="btn-circle btn-ghost" />
                            </x-slot:trigger>
                            <x-mary-menu-item title="Perfil" icon="o-user" link="{{ route('profile.edit') }}" />
                            <x-mary-menu-separator />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-mary-menu-item title="Sair" icon="o-arrow-right-on-rectangle" 
                                    onclick="event.preventDefault(); this.closest('form').submit();" />
                            </form>
                        </x-mary-dropdown>
                    </div>
                </div>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-gradient-to-r from-salon-50 to-lavender-50 border-b border-salon-200">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="p-4 lg:p-6">
                    @if(session('success'))
                        <x-mary-alert icon="o-check-circle" class="alert-success mb-4">
                            {{ session('success') }}
                        </x-mary-alert>
                    @endif

                    @if(session('error'))
                        <x-mary-alert icon="o-x-circle" class="alert-error mb-4">
                            {{ session('error') }}
                        </x-mary-alert>
                    @endif

                    {{ $slot }}
                </main>
            </x-slot:content>
        </x-mary-main>
    </body>
</html>
