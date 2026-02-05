<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Administrativo</h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form method="GET" id="filter-form">
            <div class="flex items-center gap-2 mb-4 text-sm text-gray-700">
                <x-icon name="o-funnel" class="w-5 h-5 text-salon-500" />
                <span class="font-semibold">Período:</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label">
                        <span class="label-text">Data Inicial</span>
                    </label>
                    <input type="date" name="start_date"
                        class="input input-bordered w-full border-2 border-gray-300 focus:border-primary"
                        value="{{ $startDate->format('Y-m-d') }}" id="start_date" />
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Data Final</span>
                    </label>
                    <input type="date" name="end_date"
                        class="input input-bordered w-full border-2 border-gray-300 focus:border-primary"
                        value="{{ $endDate->format('Y-m-d') }}" id="end_date" />
                </div>

                <div class="flex items-end">
                    <x-button type="submit" class="btn-primary" icon="o-magnifying-glass">
                        Filtrar
                    </x-button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const form = document.getElementById('filter-form');

            form.addEventListener('submit', function(e) {
                if (startDate.value && endDate.value && endDate.value < startDate.value) {
                    e.preventDefault();
                    alert('A data final não pode ser menor que a data inicial.');
                }
            });

            startDate.addEventListener('change', function() {
                endDate.min = this.value;
            });

            if (startDate.value) {
                endDate.min = startDate.value;
            }
        });
    </script>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <x-stat title="Total de Agendamentos" :value="$stats['total_bookings']" icon="o-calendar-days" color="text-salon-500" />

        <x-stat title="Confirmados" :value="$stats['confirmed_bookings']" icon="o-check-circle" color="text-info" />

        <x-stat title="Receita Total" value="R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}"
            icon="o-currency-dollar" color="text-success" />
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <x-card class="bg-warning/5 border-warning/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pendentes</p>
                    <p class="text-3xl font-bold text-warning">{{ $stats['pending_bookings'] }}</p>
                </div>
                <x-icon name="o-clock" class="w-12 h-12 text-warning/30" />
            </div>
        </x-card>

        <x-card class="bg-info/5 border-info/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Confirmados</p>
                    <p class="text-3xl font-bold text-info">{{ $stats['confirmed_bookings'] }}</p>
                </div>
                <x-icon name="o-check-badge" class="w-12 h-12 text-info/30" />
            </div>
        </x-card>

        <x-card class="bg-success/5 border-success/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Concluídos</p>
                    <p class="text-3xl font-bold text-success">{{ $stats['completed_bookings'] }}</p>
                </div>
                <x-icon name="o-check-circle" class="w-12 h-12 text-success/30" />
            </div>
        </x-card>

        <x-card class="bg-error/5 border-error/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Cancelados</p>
                    <p class="text-3xl font-bold text-error">{{ $stats['cancelled_bookings'] }}</p>
                </div>
                <x-icon name="o-x-circle" class="w-12 h-12 text-error/30" />
            </div>
        </x-card>
    </div>

    <x-card class="mt-6">
        <x-slot:title>
            <div class="flex items-center gap-2">
                <x-icon name="o-clock" class="w-5 h-5 text-salon-500" />
                Próximos Agendamentos
            </div>
        </x-slot:title>

        @if ($upcomingBookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Quando</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($upcomingBookings as $booking)
                            <tr>
                                <td>
                                    <span class="font-medium">{{ $booking->scheduled_at->format('d/m H:i') }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <x-icon name="o-user" class="w-4 h-4 text-gray-400" />
                                        {{ $booking->user->name }}
                                    </div>
                                </td>
                                <td>{{ $booking->service->name }}</td>
                                <td>
                                    @php
                                        $config = [
                                            'pending' => ['class' => 'badge-warning', 'label' => 'Pendente'],
                                            'confirmed' => ['class' => 'badge-info', 'label' => 'Confirmado'],
                                        ][$booking->status] ?? ['class' => 'badge-ghost', 'label' => $booking->status];
                                    @endphp
                                    <x-badge :value="$config['label']" class="{{ $config['class'] }}" />
                                </td>
                                <td class="text-right">
                                    <div class="flex gap-1 justify-end">
                                        @if ($booking->isPending())
                                            <form action="{{ route('admin.bookings.confirm', $booking) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-button type="submit" class="btn-xs btn-info" icon="o-check"
                                                    tooltip="Confirmar" />
                                            </form>
                                        @endif
                                        <x-button link="{{ route('admin.bookings.edit', $booking) }}"
                                            class="btn-xs btn-ghost" icon="o-pencil" tooltip="Editar" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <x-icon name="o-calendar-days" class="w-12 h-12 mx-auto text-gray-300 mb-2" />
                <p class="text-gray-500">Nenhum agendamento próximo.</p>
            </div>
        @endif
    </x-card>

    <x-card class="mt-6">
        <x-slot:title>
            <div class="flex items-center gap-2">
                <x-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                Agendamentos Recentes
            </div>
        </x-slot:title>

        @if ($recentBookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Criado em</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Agendado para</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->created_at->format('d/m H:i') }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->service->name }}</td>
                                <td>{{ $booking->scheduled_at->format('d/m H:i') }}</td>
                                <td><x-badge :value="$booking->status" class="badge-sm" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">Nenhum agendamento recente.</p>
            </div>
        @endif
    </x-card>
</x-app-layout>
