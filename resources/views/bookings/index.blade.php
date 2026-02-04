<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meus Agendamentos</h2>
            <x-mary-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                Novo Agendamento
            </x-mary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <x-mary-alert icon="o-check-circle" class="alert-success mb-4">
                    {{ session('success') }}
                </x-mary-alert>
            @endif

            @if(session('error'))
                <x-mary-alert icon="o-exclamation-triangle" class="alert-error mb-4">
                    {{ session('error') }}
                </x-mary-alert>
            @endif

            @if(session('suggested_date'))
                <x-mary-alert icon="o-information-circle" class="alert-info mb-4">
                    Você já tem um agendamento para esta semana em {{ session('suggested_date')->format('d/m/Y H:i') }}.
                    Recomendamos agendar os serviços na mesma data!
                </x-mary-alert>
            @endif

            <x-mary-card>
                @if($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data/Hora</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
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
                                        <td>
                                            <div class="flex gap-2">
                                                <x-mary-button link="{{ route('bookings.show', $booking) }}" icon="o-eye" class="btn-sm" />
                                                
                                                @if($booking->canBeModified() && in_array($booking->status, ['pending', 'confirmed']))
                                                    <x-mary-button link="{{ route('bookings.edit', $booking) }}" icon="o-pencil" class="btn-sm btn-primary" />
                                                    
                                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-mary-button type="submit" icon="o-trash" class="btn-sm btn-error" 
                                                            onclick="return confirm('Deseja cancelar este agendamento?')" />
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
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">Você ainda não tem agendamentos.</p>
                        <x-mary-button link="{{ route('bookings.create') }}" icon="o-plus" class="btn-primary">
                            Criar Primeiro Agendamento
                        </x-mary-button>
                    </div>
                @endif
            </x-mary-card>
        </div>
    </div>
</x-app-layout>
