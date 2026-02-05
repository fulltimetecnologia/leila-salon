<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gerenciar Agendamentos</h2>
    </x-slot>

    <x-card>
        <div class="mb-4 flex justify-end">
            <div>
                <label class="label">
                    <span class="label-text">Filtrar por Status</span>
                </label>
                <select class="select select-bordered w-48 border-2 border-gray-300 focus:border-primary"
                    onchange="window.location.href='?status=' + this.value">
                    <option value="">Todos</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendentes</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmados
                    </option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluídos
                    </option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelados
                    </option>
                </select>
            </div>
        </div>

        @if ($bookings->count() > 0)
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
                        @foreach ($bookings as $booking)
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
                                            'cancelled' => 'badge-error',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$booking->status] }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        @if ($booking->isPending())
                                            <form action="{{ route('admin.bookings.confirm', $booking) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-button type="submit" class="btn-sm btn-info" icon="o-check"
                                                    title="Confirmar" />
                                            </form>
                                        @endif

                                        @if ($booking->isConfirmed())
                                            <form action="{{ route('admin.bookings.complete', $booking) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-button type="submit" class="btn-sm btn-success"
                                                    icon="o-check-circle" title="Concluir" />
                                            </form>
                                        @endif

                                        <x-button link="{{ route('admin.bookings.edit', $booking) }}"
                                            class="btn-sm btn-primary" icon="o-pencil" title="Editar" />

                                        @if (!$booking->isCancelled() && !$booking->isCompleted())
                                            <form action="{{ route('admin.bookings.cancel', $booking) }}"
                                                method="POST" class="inline">
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
</x-app-layout>
