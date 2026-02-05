<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lailasalon" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leila Salon - Beleza & Estilo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-rose-50 via-pink-50 to-purple-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-lg shadow-md">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <x-application-logo class="w-10 h-10" />
                    <div class="flex flex-col leading-tight">
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                            Leila Salon
                        </span>
                        <span class="text-[10px] text-gray-500 -mt-0.5">Beleza & Estilo</span>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm text-gray-700 hover:text-primary">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm shadow-lg">
                            Cadastrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-28 pb-16 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1
                        class="text-5xl md:text-6xl font-bold leading-tight bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                        Beleza & Estilo
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                        Transforme seu visual no Leila Salon. Serviços profissionais de beleza com atendimento
                        personalizado e ambiente acolhedor.
                    </p>
                    <div class="flex gap-4 pt-2">
                        <a href="{{ route('register') }}"
                            class="btn btn-primary border-2 btn-lg no-animation rounded-full px-8 py-4 text-lg hover:scale-105 hover:shadow-xl transition-all duration-300">
                            Agendar Agora
                        </a>
                        <a href="#nossos-servicos"
                            class="btn btn-primary border-2 btn-lg no-animation rounded-full px-8 py-4 text-lg hover:scale-105 hover:shadow-xl transition-all duration-300">
                            Ver Serviços
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="card bg-gradient-to-br from-pink-50 via-purple-50 to-lavender-50 shadow-2xl">
                        <div class="card-body p-8">
                            <img src="{{ asset('salon.svg') }}" alt="Leila Salon" class="w-full h-auto">
                        </div>
                    </div>
                    <div
                        class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-pink-300 to-purple-300 rounded-full blur-2xl opacity-50">
                    </div>
                    <div
                        class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-rose-300 to-pink-300 rounded-full blur-2xl opacity-50">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-4 bg-white/50">
        <div class="container mx-auto max-w-6xl">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">
                Por que escolher o Leila Salon?
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="card bg-white shadow-2xl hover:shadow-3xl transition-all duration-300 border-2 border-pink-100 hover:border-pink-300 rounded-2xl">
                    <div class="card-body items-center text-center p-10">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-pink-400 to-purple-400 rounded-full flex items-center justify-center mb-6 shadow-lg mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="white" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Profissionais Qualificados</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Equipe experiente e atualizada com as últimas tendências de beleza
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-white shadow-2xl hover:shadow-3xl transition-all duration-300 border-2 border-purple-100 hover:border-purple-300 rounded-2xl">
                    <div class="card-body items-center text-center p-10">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center mb-6 shadow-lg mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="white" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Agendamento Fácil</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Sistema online prático para marcar seus horários com comodidade
                        </p>
                    </div>
                </div>

                <div
                    class="card bg-white shadow-2xl hover:shadow-3xl transition-all duration-300 border-2 border-rose-100 hover:border-rose-300 rounded-2xl">
                    <div class="card-body items-center text-center p-10">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-pink-400 to-rose-400 rounded-full flex items-center justify-center mb-6 shadow-lg mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="white" class="w-12 h-12 mx-auto">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Ambiente Acolhedor</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Espaço confortável e relaxante para você se sentir em casa
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section id="nossos-servicos" class="py-20 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 text-gray-800">Nossos Serviços</h2>
                <p class="text-xl text-gray-600">Confira alguns de nossos principais serviços</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $services = [
                        ['name' => 'Corte Feminino', 'emoji' => '✂️', 'gradient' => 'from-pink-400 to-rose-400'],
                        ['name' => 'Coloração', 'emoji' => '🎨', 'gradient' => 'from-purple-400 to-pink-400'],
                        ['name' => 'Manicure', 'emoji' => '💅', 'gradient' => 'from-rose-400 to-pink-400'],
                        ['name' => 'Escova', 'emoji' => '💇‍♀️', 'gradient' => 'from-pink-400 to-purple-400'],
                    ];
                @endphp

                @foreach ($services as $service)
                    <div
                        class="card bg-white shadow-2xl hover:shadow-3xl hover:-translate-y-2 transition-all duration-300 border-2 border-pink-100 hover:border-pink-300 rounded-2xl">
                        <div class="card-body items-center text-center p-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br {{ $service['gradient'] }} rounded-3xl flex items-center justify-center mb-5 shadow-lg mx-auto">
                                <span class="text-4xl">{{ $service['emoji'] }}</span>
                            </div>
                            <h3 class="font-bold text-gray-800 text-xl">{{ $service['name'] }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="/register"
                    class="btn btn-primary border-2 btn-lg no-animation rounded-full px-8 py-4 text-lg hover:scale-105 hover:shadow-xl transition-all duration-300">
                    Ver Todos os Serviços
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-gradient-to-r from-pink-500 to-purple-600 text-white">
        <div class="container mx-auto max-w-4xl text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Pronta para se transformar?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Agende seu horário agora e experimente o melhor em beleza e estilo
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="btn btn-lg btn-outline border-2 border-white text-white hover:bg-white/10 hover:border-white no-animation rounded-full px-8 py-4 text-lg">
                    Criar Conta e Agendar
                </a>
                <a href="{{ route('login') }}"
                    class="btn btn-lg btn-outline border-2 border-white text-white hover:bg-white/10 hover:border-white no-animation rounded-full px-8 py-4 text-lg">
                    Já tenho conta
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <x-application-logo class="w-10 h-10" />
                        <div class="flex flex-col leading-tight">
                            <span
                                class="text-xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">Leila
                                Salon</span>
                            <span class="text-xs text-gray-500 -mt-0.5">Beleza & Estilo</span>
                        </div>
                    </div>
                    <p class="text-gray-400">
                        Transformando beleza em arte desde sempre
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Links Rápidos</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('services.index') }}" class="hover:text-white">Serviços</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white">Cadastrar</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Horário de Funcionamento</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Segunda - Sexta: 9h - 19h</li>
                        <li>Sábado: 9h - 17h</li>
                        <li>Domingo: Fechado</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Leila Salon. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>
