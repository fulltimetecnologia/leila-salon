<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <x-icon name="o-sparkles" class="w-6 h-6 text-lavender-500" />
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nossos Serviços</h2>
        </div>
    </x-slot>

    <div class="mb-6 text-center">
        <p class="text-gray-600">Oferecemos uma variedade de serviços para realçar sua beleza e bem-estar.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($services as $service)
            <x-card class="hover:shadow-xl transition-shadow duration-300 border-salon-100">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="avatar placeholder">
                            <div
                                class="bg-gradient-to-br from-salon-100 to-lavender-100 text-salon-600 rounded-full w-14">
                                <x-icon name="o-scissors" class="w-7 h-7" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800">{{ $service->name }}</h3>
                            @if ($service->description)
                                <p class="text-gray-600 text-sm mt-1">{{ $service->description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="divider my-2"></div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p
                                class="text-3xl font-bold bg-gradient-to-r from-salon-500 to-lavender-500 bg-clip-text text-transparent">
                                R$ {{ number_format($service->price, 2, ',', '.') }}
                            </p>
                            <div class="flex items-center gap-1 text-sm text-gray-500 mt-1">
                                <x-icon name="o-clock" class="w-4 h-4" />
                                {{ $service->duration_minutes }} minutos
                            </div>
                        </div>
                    </div>

                    @auth
                        <x-button link="{{ route('bookings.create', ['service_id' => $service->id]) }}"
                            class="btn-primary w-full" icon="o-calendar">
                            Agendar Agora
                        </x-button>
                    @else
                        <x-button link="{{ route('login') }}" class="btn-outline btn-primary w-full"
                            icon="o-arrow-right-on-rectangle">
                            Faça login para agendar
                        </x-button>
                    @endauth
                </div>
            </x-card>
        @endforeach
    </div>

    @auth
        <div class="mt-8 text-center">
            <x-card class="inline-block bg-gradient-to-r from-salon-50 to-lavender-50">
                <p class="text-gray-700 mb-3">Pronta para agendar seu próximo serviço?</p>
                <x-button link="{{ route('bookings.create') }}" class="btn-primary" icon="o-plus">
                    Criar Novo Agendamento
                </x-button>
            </x-card>
        </div>
    @endauth
</x-app-layout>
