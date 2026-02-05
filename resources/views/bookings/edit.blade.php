<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Agendamento</h2>
    </x-slot>

    <x-card>
        <form action="{{ route('bookings.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="label">
                        <span class="label-text">Serviço *</span>
                    </label>
                    <select name="service_id"
                        class="select select-bordered w-full border-2 border-gray-300 focus:border-primary @error('service_id') select-error border-error @enderror"
                        required>
                        <option value="" disabled>Selecione um serviço</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}"
                                {{ old('service_id', $booking->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Data e Hora</span>
                    </label>
                    <input type="datetime-local" name="scheduled_at"
                        class="input input-bordered w-full @error('scheduled_at') input-error @enderror"
                        value="{{ old('scheduled_at', $booking->scheduled_at->format('Y-m-d\TH:i')) }}"
                        min="{{ now()->addDays(2)->format('Y-m-d\TH:i') }}" required />
                    @error('scheduled_at')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                    <span class="text-sm text-gray-500">Alterações devem ser feitas com pelo menos 2 dias de
                        antecedência.</span>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Observações (opcional)</span>
                    </label>
                    <textarea name="notes" class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror"
                        rows="3" placeholder="Alguma observação sobre o agendamento?">{{ old('notes', $booking->notes) }}</textarea>
                    @error('notes')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <x-button type="submit" class="btn-primary" icon="o-check">
                        Salvar Alterações
                    </x-button>
                    <x-button link="{{ route('bookings.index') }}" icon="o-x-mark">
                        Cancelar
                    </x-button>
                </div>
            </div>
        </form>
    </x-card>
</x-app-layout>
