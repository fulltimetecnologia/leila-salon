<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bem-vinda, {{ auth()->user()->name }}!
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        @if(auth()->user()->isAdmin())
            <x-mary-alert icon="o-shield-check" class="alert-info">
                <div class="flex items-center justify-between w-full">
                    <span>Você está logado como administrador.</span>
                    <x-mary-button link="{{ route('admin.dashboard') }}" icon="o-chart-bar" class="btn-sm btn-primary">
                        Dashboard Admin
                    </x-mary-button>
                </div>
            </x-mary-alert>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-mary-card class="bg-gradient-to-br from-salon-50 to-salon-100 border-salon-200">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-white rounded-full">
                        <x-mary-icon name="o-calendar-days" class="w-8 h-8 text-salon-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Próximo agendamento</p>
                        <p class="text-2xl font-bold text-salon-700">Em breve</p>
                    </div>
                </div>
            </x-mary-card>

            <x-mary-card class="bg-gradient-to-br from-lavender-50 to-lavender-100 border-lavender-200">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-white rounded-full">
                        <x-mary-icon name="o-sparkles" class="w-8 h-8 text-lavender-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Serviços disponíveis</p>
                        <p class="text-2xl font-bold text-lavender-700">Vários</p>
                    </div>
                </div>
            </x-mary-card>

            <x-mary-card class="bg-gradient-to-br from-pink-50 to-pink-100 border-pink-200">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-white rounded-full">
                        <x-mary-icon name="o-heart" class="w-8 h-8 text-pink-500" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Sua beleza</p>
                        <p class="text-2xl font-bold text-pink-700">Prioridade</p>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-mary-card>
                <x-slot:title>
                    <div class="flex items-center gap-2">
                        <x-mary-icon name="o-calendar-days" class="w-5 h-5 text-salon-500" />
                        Meus Agendamentos
                    </div>
                </x-slot:title>
                
                <p class="text-gray-600 mb-6">Crie novos agendamentos ou gerencie os existentes.</p>
                <div class="flex flex-col gap-3">
                    <x-mary-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary w-full">
                        Novo Agendamento
                    </x-mary-button>
                    <x-mary-button link="{{ route('bookings.index') }}" icon="o-eye" class="btn-outline w-full">
                        Ver Meus Agendamentos
                    </x-mary-button>
                </div>
            </x-mary-card>

            <x-mary-card>
                <x-slot:title>
                    <div class="flex items-center gap-2">
                        <x-mary-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                        Serviços
                    </div>
                </x-slot:title>
                
                <p class="text-gray-600 mb-6">Conheça todos os nossos serviços de beleza e estilo.</p>
                <x-mary-button link="{{ route('services.index') }}" icon="o-scissors" class="btn-secondary w-full">
                    Ver Todos os Serviços
                </x-mary-button>
            </x-mary-card>
        </div>

        <x-mary-card class="bg-gradient-to-r from-salon-50 to-lavender-50">
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <x-mary-icon name="o-clock" class="w-5 h-5 text-salon-500" />
                    Histórico de Agendamentos
                </div>
            </x-slot:title>
            
            <p class="text-gray-600 mb-4">Acesse o histórico completo dos seus atendimentos anteriores.</p>
            <x-mary-button link="{{ route('bookings.history') }}" icon="o-document-text" class="btn-ghost">
                Consultar Histórico
            </x-mary-button>
        </x-mary-card>
    </div>
</x-app-layout>
