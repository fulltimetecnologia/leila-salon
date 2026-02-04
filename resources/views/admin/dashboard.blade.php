<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Administrativo</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-mary-card title="Período de Análise">
                <form method="GET" class="flex gap-4 items-end">
                    <div>
                        <label class="label"><span class="label-text">Data Inicial</span></label>
                        <input type="date" name="start_date" class="input input-bordered" 
                            value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="label"><span class="label-text">Data Final</span></label>
                        <input type="date" name="end_date" class="input input-bordered" 
                            value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <x-mary-button type="submit" class="btn-primary" icon="o-magnifying-glass">
                        Filtrar
                    </x-mary-button>
                </form>
            </x-mary-card>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-mary-card title="Total de Agendamentos">
                    <p class="text-4xl font-bold text-primary">{{ $stats['total_bookings'] }}</p>
                </x-mary-card>

                <x-mary-card title="Agendamentos Confirmados">
                    <p class="text-4xl font-bold text-info">{{ $stats['confirmed_bookings'] }}</p>
                </x-mary-card>

                <x-mary-card title="Receita (Concluídos)">
                    <p class="text-4xl font-bold text-success">
                        R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}
                    </p>
                </x-mary-card>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-mary-card title="Pendentes" class="bg-warning/10">
                    <p class="text-3xl font-bold text-warning">{{ $stats['pending_bookings'] }}</p>
                </x-mary-card>

                <x-mary-card title="Confirmados" class="bg-info/10">
                    <p class="text-3xl font-bold text-info">{{ $stats['confirmed_bookings'] }}</p>
                </x-mary-card>

                <x-mary-card title="Concluídos" class="bg-success/10">
                    <p class="text-3xl font-bold text-success">{{ $stats['completed_bookings'] }}</p>
                </x-mary-card>

                <x-mary-card title="Cancelados" class="bg-error/10">
                    <p class="text-3xl font-bold text-error">{{ $stats['cancelled_bookings'] }}</p>
                </x-mary-card>
            </div>

            <x-mary-card title="Próximos Agendamentos">
                @if($upcomingBookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Data/Hora</th>
                                    <th>Cliente</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->scheduled_at->format('d/m H:i') }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>
                                            @php
                                                $colors = ['pending' => 'warning', 'confirmed' => 'info'];
                                            @endphp
                                            <span class="badge badge-{{ $colors[$booking->status] ?? 'ghost' }} badge-sm">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex gap-1">
                                                @if($booking->isPending())
                                                    <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-mary-button type="submit" class="btn-xs btn-info" icon="o-check" />
                                                    </form>
                                                @endif
                                                <x-mary-button link="{{ route('admin.bookings.edit', $booking) }}" 
                                                    class="btn-xs" icon="o-pencil" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Nenhum agendamento próximo.</p>
                @endif
            </x-mary-card>

            <x-mary-card title="Agendamentos Recentes">
                @if($recentBookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Criado em</th>
                                    <th>Cliente</th>
                                    <th>Serviço</th>
                                    <th>Data Agendada</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->created_at->format('d/m H:i') }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>{{ $booking->scheduled_at->format('d/m H:i') }}</td>
                                        <td>
                                            <span class="badge badge-sm">{{ $booking->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Nenhum agendamento recente.</p>
                @endif
            </x-mary-card>

            <div class="flex gap-4">
                <x-mary-button link="{{ route('admin.bookings.index') }}" class="btn-primary" icon="o-calendar">
                    Gerenciar Agendamentos
                </x-mary-button>
                <x-mary-button link="{{ route('admin.services.index') }}" class="btn-secondary" icon="o-sparkles">
                    Gerenciar Serviços
                </x-mary-button>
            </div>
        </div>
    </div>
</x-app-layout>
