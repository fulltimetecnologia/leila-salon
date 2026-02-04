<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(auth()->user()->isAdmin())
                <x-mary-card title="Área Administrativa">
                    <p class="mb-4">Você está logado como administrador.</p>
                    <x-mary-button link="{{ route('admin.dashboard') }}" icon="o-chart-bar">
                        Ir para Dashboard Admin
                    </x-mary-button>
                </x-mary-card>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-mary-card title="Meus Agendamentos">
                    <p class="text-gray-600 mb-4">Gerencie seus agendamentos no salão.</p>
                    <div class="space-x-2">
                        <x-mary-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                            Novo Agendamento
                        </x-mary-button>
                        <x-mary-button link="{{ route('bookings.index') }}" icon="o-calendar">
                            Ver Agendamentos
                        </x-mary-button>
                    </div>
                </x-mary-card>

                <x-mary-card title="Serviços Disponíveis">
                    <p class="text-gray-600 mb-4">Veja todos os serviços oferecidos.</p>
                    <x-mary-button link="{{ route('services.index') }}" icon="o-sparkles">
                        Ver Serviços
                    </x-mary-button>
                </x-mary-card>
            </div>

            <x-mary-card title="Histórico">
                <p class="text-gray-600 mb-4">Consulte o histórico dos seus agendamentos.</p>
                <x-mary-button link="{{ route('bookings.history') }}" icon="o-clock">
                    Ver Histórico
                </x-mary-button>
            </x-mary-card>
        </div>
    </div>
</x-app-layout>
