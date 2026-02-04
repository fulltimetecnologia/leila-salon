<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gerenciar Agendamentos</h2>
            <x-select 
                placeholder="Filtrar por status" 
                :options="[
                    ['value' => '', 'label' => 'Todos'],
                    ['value' => 'pending', 'label' => 'Pendentes'],
                    ['value' => 'confirmed', 'label' => 'Confirmados'],
                    ['value' => 'completed', 'label' => 'Concluídos'],
                    ['value' => 'cancelled', 'label' => 'Cancelados']
                ]"
                option-value="value"
                option-label="label"
                onchange="window.location.href='?status=' + this.value"
            />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <x-alert icon="o-check-circle" class="alert-success mb-4">
                    {{ session('success') }}
                </x-alert>
            @endif

            <x-card>
                @if($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Data/Hora</th>
                                    <th>Cliente</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->scheduled_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'badge-warning',
                                                    'confirmed' => 'badge-info',
                                                    'completed' => 'badge-success',
                                                    'cancelled' => 'badge-error'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusColors[$booking->status] }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex gap-1">
                                                @if($booking->isPending())
                                                    <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button type="submit" class="btn-sm btn-info" icon="o-check" 
                                                            title="Confirmar" />
                                                    </form>
                                                @endif

                                                @if($booking->isConfirmed())
                                                    <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button type="submit" class="btn-sm btn-success" icon="o-check-circle" 
                                                            title="Concluir" />
                                                    </form>
                                                @endif

                                                <x-button link="{{ route('admin.bookings.edit', $booking) }}" 
                                                    class="btn-sm btn-primary" icon="o-pencil" title="Editar" />

                                                @if(!$booking->isCancelled() && !$booking->isCompleted())
                                                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-button type="submit" class="btn-sm btn-error" icon="o-x-mark" 
                                                            title="Cancelar"
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
                        <p class="text-gray-500">Nenhum agendamento encontrado.</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
