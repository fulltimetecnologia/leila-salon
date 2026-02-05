<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalhes do Agendamento</h2>
    </x-slot>

    <x-card>
        <div class="space-y-4">
            <div>
                <label class="font-semibold text-gray-700">Serviço:</label>
                <p class="text-lg">{{ $booking->service->name }}</p>
            </div>

            @if ($booking->service->description)
                <div>
                    <label class="font-semibold text-gray-700">Descrição:</label>
                    <p class="text-gray-600">{{ $booking->service->description }}</p>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Data e Hora:</label>
                    <p>{{ $booking->scheduled_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Duração:</label>
                    <p>{{ $booking->service->duration_minutes }} minutos</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Valor:</label>
                    <p class="text-lg font-bold text-primary">R$
                        {{ number_format($booking->service->price, 2, ',', '.') }}</p>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Status:</label>
                    @php
                        $statusColors = [
                            'pending' => 'badge-warning',
                            'confirmed' => 'badge-info',
                            'completed' => 'badge-success',
                            'cancelled' => 'badge-error',
                        ];
                        $statusLabels = [
                            'pending' => 'Pendente',
                            'confirmed' => 'Confirmado',
                            'completed' => 'Concluído',
                            'cancelled' => 'Cancelado',
                        ];
                    @endphp
                    <span class="badge {{ $statusColors[$booking->status] }}">
                        {{ $statusLabels[$booking->status] }}
                    </span>
                </div>
            </div>

            @if ($booking->notes)
                <div>
                    <label class="font-semibold text-gray-700">Observações:</label>
                    <p class="text-gray-600">{{ $booking->notes }}</p>
                </div>
            @endif

            <div class="border-t pt-4">
                <label class="font-semibold text-gray-700">Criado em:</label>
                <p class="text-sm text-gray-500">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="flex gap-2 pt-4">
                <x-button link="{{ route('bookings.index') }}" icon="o-arrow-left">
                    Voltar
                </x-button>

                @if ($booking->canBeModified() && in_array($booking->status, ['pending', 'confirmed']))
                    <x-button link="{{ route('bookings.edit', $booking) }}" icon="o-pencil" class="btn-primary">
                        Editar
                    </x-button>
                @endif
            </div>
        </div>
    </x-card>
</x-app-layout>
