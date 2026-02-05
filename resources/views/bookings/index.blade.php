<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meus Agendamentos</h2>
            <x-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                Novo Agendamento
            </x-button>
        </div>
    </x-slot>

    @if(session('suggested_date'))
            <x-alert icon="o-information-circle" class="alert-info mb-4">
                Você já tem um agendamento para esta semana em {{ session('suggested_date')->format('d/m/Y H:i') }}.
                Recomendamos agendar os serviços na mesma data!
            </x-alert>
        @endif

        <x-card>
            @if($bookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Serviço</th>
                                <th>Status</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <x-icon name="o-calendar" class="w-5 h-5 text-salon-500" />
                                            {{ $booking->scheduled_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <x-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                                            <div>
                                                <div class="font-medium">{{ $booking->service->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $booking->service->duration_minutes }} min</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'pending' => ['class' => 'badge-warning', 'label' => 'Pendente', 'icon' => 'o-clock'],
                                                'confirmed' => ['class' => 'badge-info', 'label' => 'Confirmado', 'icon' => 'o-check-circle'],
                                                'completed' => ['class' => 'badge-success', 'label' => 'Concluído', 'icon' => 'o-check-badge'],
                                                'cancelled' => ['class' => 'badge-error', 'label' => 'Cancelado', 'icon' => 'o-x-circle']
                                            ];
                                            $config = $statusConfig[$booking->status];
                                        @endphp
                                        <x-badge :value="$config['label']" class="{{ $config['class'] }}" />
                                    </td>
                                    <td class="text-right">
                                        <div class="flex gap-2 justify-end">
                                            <x-button link="{{ route('bookings.show', $booking) }}" icon="o-eye" 
                                                class="btn-sm btn-ghost" tooltip="Ver detalhes" />
                                            
                                            @if($booking->canBeModified() && in_array($booking->status, ['pending', 'confirmed']))
                                                <x-button link="{{ route('bookings.edit', $booking) }}" icon="o-pencil" 
                                                    class="btn-sm btn-primary" tooltip="Editar" />
                                                
                                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" icon="o-trash" class="btn-sm btn-error" 
                                                        tooltip="Cancelar" onclick="return confirm('Deseja cancelar este agendamento?')" />
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <x-icon name="o-calendar-days" class="w-16 h-16 mx-auto text-gray-300 mb-4" />
                    <p class="text-gray-500 mb-4 text-lg">Você ainda não tem agendamentos.</p>
                    <x-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                        Criar Primeiro Agendamento
                    </x-button>
                </div>
        @endif
    </x-card>
</x-app-layout>
