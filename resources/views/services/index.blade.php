<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Serviços Disponíveis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <x-mary-card>
                        <div class="space-y-3">
                            <h3 class="text-xl font-bold text-primary">{{ $service->name }}</h3>
                            
                            @if($service->description)
                                <p class="text-gray-600">{{ $service->description }}</p>
                            @endif

                            <div class="flex justify-between items-center pt-2 border-t">
                                <div>
                                    <p class="text-2xl font-bold text-primary">
                                        R$ {{ number_format($service->price, 2, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $service->duration_minutes }} minutos</p>
                                </div>
                            </div>

                            @auth
                                <x-mary-button link="{{ route('bookings.create', ['service_id' => $service->id]) }}" class="btn-primary w-full" icon="o-calendar">
                                    Agendar
                                </x-mary-button>
                            @else
                                <x-mary-button link="{{ route('login') }}" class="btn-primary w-full" icon="o-arrow-right-on-rectangle">
                                    Faça login para agendar
                                </x-mary-button>
                            @endauth
                        </div>
                    </x-mary-card>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
