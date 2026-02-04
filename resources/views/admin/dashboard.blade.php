<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Administrativo</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <x-mary-card>
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <x-mary-icon name="o-adjustments-horizontal" class="w-5 h-5" />
                    Período de Análise
                </div>
            </x-slot:title>
            
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <x-mary-input 
                    label="Data Inicial" 
                    type="date" 
                    name="start_date" 
                    :value="$startDate->format('Y-m-d')"
                    icon="o-calendar"
                />
                <x-mary-input 
                    label="Data Final" 
                    type="date" 
                    name="end_date" 
                    :value="$endDate->format('Y-m-d')"
                    icon="o-calendar"
                />
                <x-mary-button type="submit" class="btn-primary" icon="o-funnel">
                    Aplicar Filtro
                </x-mary-button>
            </form>
        </x-mary-card>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-mary-stat
                title="Total de Agendamentos"
                :value="$stats['total_bookings']"
                icon="o-calendar-days"
                color="text-salon-500"
            />

            <x-mary-stat
                title="Confirmados"
                :value="$stats['confirmed_bookings']"
                icon="o-check-circle"
                color="text-info"
            />

            <x-mary-stat
                title="Receita Total"
                value="R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}"
                icon="o-currency-dollar"
                color="text-success"
            />
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-mary-card class="bg-warning/5 border-warning/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Pendentes</p>
                        <p class="text-3xl font-bold text-warning">{{ $stats['pending_bookings'] }}</p>
                    </div>
                    <x-mary-icon name="o-clock" class="w-12 h-12 text-warning/30" />
                </div>
            </x-mary-card>

            <x-mary-card class="bg-info/5 border-info/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Confirmados</p>
                        <p class="text-3xl font-bold text-info">{{ $stats['confirmed_bookings'] }}</p>
                    </div>
                    <x-mary-icon name="o-check-badge" class="w-12 h-12 text-info/30" />
                </div>
            </x-mary-card>

            <x-mary-card class="bg-success/5 border-success/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Concluídos</p>
                        <p class="text-3xl font-bold text-success">{{ $stats['completed_bookings'] }}</p>
                    </div>
                    <x-mary-icon name="o-check-circle" class="w-12 h-12 text-success/30" />
                </div>
            </x-mary-card>

            <x-mary-card class="bg-error/5 border-error/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Cancelados</p>
                        <p class="text-3xl font-bold text-error">{{ $stats['cancelled_bookings'] }}</p>
                    </div>
                    <x-mary-icon name="o-x-circle" class="w-12 h-12 text-error/30" />
                </div>
            </x-mary-card>
        </div>

        <x-mary-card>
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <x-mary-icon name="o-clock" class="w-5 h-5 text-salon-500" />
                    Próximos Agendamentos
                </div>
            </x-slot:title>

            @if($upcomingBookings->count() > 0)
                <x-mary-table :headers="[
                    ['key' => 'scheduled', 'label' => 'Quando'],
                    ['key' => 'client', 'label' => 'Cliente'],
                    ['key' => 'service', 'label' => 'Serviço'],
                    ['key' => 'status', 'label' => 'Status'],
                    ['key' => 'actions', 'label' => 'Ações', 'sortable' => false]
                ]" :rows="$upcomingBookings" striped>
                    @scope('cell_scheduled', $booking)
                        <span class="font-medium">{{ $booking->scheduled_at->format('d/m H:i') }}</span>
                    @endscope

                    @scope('cell_client', $booking)
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-user" class="w-4 h-4 text-gray-400" />
                            {{ $booking->user->name }}
                        </div>
                    @endscope

                    @scope('cell_service', $booking)
                        {{ $booking->service->name }}
                    @endscope

                    @scope('cell_status', $booking)
                        @php
                            $config = [
                                'pending' => ['class' => 'badge-warning', 'label' => 'Pendente'],
                                'confirmed' => ['class' => 'badge-info', 'label' => 'Confirmado']
                            ][$booking->status] ?? ['class' => 'badge-ghost', 'label' => $booking->status];
                        @endphp
                        <x-mary-badge :value="$config['label']" class="{{ $config['class'] }}" />
                    @endscope

                    @scope('cell_actions', $booking)
                        <div class="flex gap-1">
                            @if($booking->isPending())
                                <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <x-mary-button type="submit" class="btn-xs btn-info" icon="o-check" 
                                        tooltip="Confirmar" />
                                </form>
                            @endif
                            <x-mary-button link="{{ route('admin.bookings.edit', $booking) }}" 
                                class="btn-xs btn-ghost" icon="o-pencil" tooltip="Editar" />
                        </div>
                    @endscope
                </x-mary-table>
            @else
                <div class="text-center py-8">
                    <x-mary-icon name="o-calendar-days" class="w-12 h-12 mx-auto text-gray-300 mb-2" />
                    <p class="text-gray-500">Nenhum agendamento próximo.</p>
                </div>
            @endif
        </x-mary-card>

        <x-mary-card>
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <x-mary-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                    Agendamentos Recentes
                </div>
            </x-slot:title>

            @if($recentBookings->count() > 0)
                <x-mary-table :headers="[
                    ['key' => 'created', 'label' => 'Criado em'],
                    ['key' => 'client', 'label' => 'Cliente'],
                    ['key' => 'service', 'label' => 'Serviço'],
                    ['key' => 'scheduled', 'label' => 'Agendado para'],
                    ['key' => 'status', 'label' => 'Status']
                ]" :rows="$recentBookings" striped>
                    @scope('cell_created', $booking)
                        {{ $booking->created_at->format('d/m H:i') }}
                    @endscope

                    @scope('cell_client', $booking)
                        {{ $booking->user->name }}
                    @endscope

                    @scope('cell_service', $booking)
                        {{ $booking->service->name }}
                    @endscope

                    @scope('cell_scheduled', $booking)
                        {{ $booking->scheduled_at->format('d/m H:i') }}
                    @endscope

                    @scope('cell_status', $booking)
                        <x-mary-badge :value="$booking->status" class="badge-sm" />
                    @endscope
                </x-mary-table>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Nenhum agendamento recente.</p>
                </div>
            @endif
        </x-mary-card>

        <div class="flex gap-4">
            <x-mary-button link="{{ route('admin.bookings.index') }}" class="btn-primary" icon="o-calendar">
                Gerenciar Agendamentos
            </x-mary-button>
            <x-mary-button link="{{ route('admin.services.index') }}" class="btn-secondary" icon="o-scissors">
                Gerenciar Serviços
            </x-mary-button>
        </div>
    </div>
</x-app-layout>
