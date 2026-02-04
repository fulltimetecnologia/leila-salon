<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Histórico de Agendamentos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="label">
                                <span class="label-text">Data Inicial</span>
                            </label>
                            <input 
                                type="date" 
                                name="start_date" 
                                class="input input-bordered w-full"
                                value="{{ request('start_date', $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : $startDate) }}"
                            />
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text">Data Final</span>
                            </label>
                            <input 
                                type="date" 
                                name="end_date" 
                                class="input input-bordered w-full"
                                value="{{ request('end_date', $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : $endDate) }}"
                            />
                        </div>

                        <div class="flex items-end">
                            <x-button type="submit" class="btn-primary" icon="o-magnifying-glass">
                                Filtrar
                            </x-button>
                        </div>
                    </div>
                </form>

                @if($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data/Hora</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
                                    <th>Valor</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->scheduled_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'badge-warning',
                                                    'confirmed' => 'badge-info',
                                                    'completed' => 'badge-success',
                                                    'cancelled' => 'badge-error'
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Pendente',
                                                    'confirmed' => 'Confirmado',
                                                    'completed' => 'Concluído',
                                                    'cancelled' => 'Cancelado'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusColors[$booking->status] }}">
                                                {{ $statusLabels[$booking->status] }}
                                            </span>
                                        </td>
                                        <td class="font-semibold">R$ {{ number_format($booking->service->price, 2, ',', '.') }}</td>
                                        <td>
                                            <x-button link="{{ route('bookings.show', $booking) }}" icon="o-eye" class="btn-sm" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-600">
                        <strong>Total de agendamentos:</strong> {{ $bookings->count() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Nenhum agendamento encontrado no período selecionado.</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
