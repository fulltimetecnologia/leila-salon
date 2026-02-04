<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meus Agendamentos</h2>
            <x-mary-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                Novo Agendamento
            </x-mary-button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        @if(session('suggested_date'))
            <x-mary-alert icon="o-information-circle" class="alert-info mb-4">
                Você já tem um agendamento para esta semana em {{ session('suggested_date')->format('d/m/Y H:i') }}.
                Recomendamos agendar os serviços na mesma data!
            </x-mary-alert>
        @endif

        <x-mary-card>
            @if($bookings->count() > 0)
                <x-mary-table :headers="[
                    ['key' => 'scheduled_at', 'label' => 'Data/Hora'],
                    ['key' => 'service', 'label' => 'Serviço'],
                    ['key' => 'status', 'label' => 'Status'],
                    ['key' => 'actions', 'label' => 'Ações', 'sortable' => false]
                ]" :rows="$bookings" striped>
                    @scope('cell_scheduled_at', $booking)
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-calendar" class="w-5 h-5 text-salon-500" />
                            {{ $booking->scheduled_at->format('d/m/Y H:i') }}
                        </div>
                    @endscope

                    @scope('cell_service', $booking)
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                            <div>
                                <div class="font-medium">{{ $booking->service->name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->service->duration_minutes }} min</div>
                            </div>
                        </div>
                    @endscope

                    @scope('cell_status', $booking)
                        @php
                            $statusConfig = [
                                'pending' => ['class' => 'badge-warning', 'label' => 'Pendente', 'icon' => 'o-clock'],
                                'confirmed' => ['class' => 'badge-info', 'label' => 'Confirmado', 'icon' => 'o-check-circle'],
                                'completed' => ['class' => 'badge-success', 'label' => 'Concluído', 'icon' => 'o-check-badge'],
                                'cancelled' => ['class' => 'badge-error', 'label' => 'Cancelado', 'icon' => 'o-x-circle']
                            ];
                            $config = $statusConfig[$booking->status];
                        @endphp
                        <x-mary-badge :value="$config['label']" class="{{ $config['class'] }}" />
                    @endscope

                    @scope('cell_actions', $booking)
                        <div class="flex gap-2">
                            <x-mary-button link="{{ route('bookings.show', $booking) }}" icon="o-eye" 
                                class="btn-sm btn-ghost" tooltip="Ver detalhes" />
                            
                            @if($booking->canBeModified() && in_array($booking->status, ['pending', 'confirmed']))
                                <x-mary-button link="{{ route('bookings.edit', $booking) }}" icon="o-pencil" 
                                    class="btn-sm btn-primary" tooltip="Editar" />
                                
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-mary-button type="submit" icon="o-trash" class="btn-sm btn-error" 
                                        tooltip="Cancelar" onclick="return confirm('Deseja cancelar este agendamento?')" />
                                </form>
                            @endif
                        </div>
                    @endscope
                </x-mary-table>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <x-mary-icon name="o-calendar-days" class="w-16 h-16 mx-auto text-gray-300 mb-4" />
                    <p class="text-gray-500 mb-4 text-lg">Você ainda não tem agendamentos.</p>
                    <x-mary-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                        Criar Primeiro Agendamento
                    </x-mary-button>
                </div>
            @endif
        </x-mary-card>
    </div>
</x-app-layout>
