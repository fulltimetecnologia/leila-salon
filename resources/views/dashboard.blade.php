<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Bem-vinda, {{ auth()->user()->name }}!
        </h2>
    </x-slot>

    @if (auth()->user()->isAdmin())
        <x-alert icon="o-shield-check" class="alert-info">
            <div class="flex items-center justify-end w-full gap-4">
                <span class="mr-auto">Você está logado como administrador.</span>
                <x-button link="{{ route('admin.dashboard') }}" icon="o-chart-bar" class="btn-sm btn-primary">
                    Dashboard Admin
                </x-button>
            </div>
        </x-alert>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <x-card>
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <x-icon name="o-calendar-days" class="w-5 h-5 text-salon-500" />
                    Meus Agendamentos
                </div>
            </x-slot:title>

            <p class="text-gray-600 mb-6">Crie novos agendamentos ou gerencie os existentes.</p>
            <div class="flex flex-col gap-3">
                <x-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary w-full">
                    Novo Agendamento
                </x-button>
                <x-button link="{{ route('bookings.index') }}" icon="o-eye" class="btn-outline w-full">
                    Ver Meus Agendamentos
                </x-button>
            </div>
        </x-card>

        <x-card>
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <x-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                    Serviços
                </div>
            </x-slot:title>

            <p class="text-gray-600 mb-6">Conheça todos os nossos serviços de beleza e estilo.</p>
            <x-button link="{{ route('services.index') }}" icon="o-scissors" class="btn-secondary w-full">
                Ver Todos os Serviços
            </x-button>
        </x-card>
    </div>

    <x-card class="bg-gradient-to-r from-salon-50 to-lavender-50 mt-6">
        <x-slot:title>
            <div class="flex items-center gap-2">
                <x-icon name="o-clock" class="w-5 h-5 text-salon-500" />
                Histórico de Agendamentos
            </div>
        </x-slot:title>

        <p class="text-gray-600 mb-4">Acesse o histórico completo dos seus atendimentos anteriores.</p>
        <x-button link="{{ route('bookings.history') }}" icon="o-document-text" class="btn-ghost">
            Consultar Histórico
        </x-button>
    </x-card>
</x-app-layout>
