<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <x-icon name="o-plus-circle" class="w-6 h-6 text-salon-500" />
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Agendamento</h2>
        </div>
    </x-slot>

    <x-card>
        <x-alert icon="o-information-circle" class="alert-info mb-6">
            <span class="font-medium">Agendamento deve ser feito com pelo menos 24h de antecedência</span>
        </x-alert>

        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="label">
                    <span class="label-text">Serviço *</span>
                </label>
                <select name="service_id"
                    class="select select-bordered w-full border-2 border-gray-300 focus:border-primary @error('service_id') select-error border-error @enderror"
                    required>
                    <option value="" disabled selected>Selecione um serviço</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="label">
                    <span class="label-text">Data e Hora do Agendamento *</span>
                </label>
                <div class="relative">
                    <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}"
                        min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                        class="input input-bordered w-full pl-10 border-2 border-gray-300 focus:border-primary @error('scheduled_at') input-error border-error @enderror"
                        required />
                </div>
                @error('scheduled_at')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <x-textarea label="Observações" name="notes" :value="old('notes')" rows="3"
                placeholder="Alguma observação sobre o agendamento?"
                class="textarea-bordered border-2 border-gray-300 focus:border-primary" />

            <div class="flex gap-3 pt-4 justify-end">
                <x-button link="{{ route('bookings.index') }}" class="btn-ghost" icon="o-x-mark">
                    Cancelar
                </x-button>
                <x-button type="submit" class="btn-primary" icon="o-check">
                    Confirmar Agendamento
                </x-button>
            </div>
        </form>
    </x-card>

    <x-card class="mt-6">
        <x-slot:title>
            <div class="flex items-center gap-2">
                <x-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                Serviços Disponíveis
            </div>
        </x-slot:title>

        <div class="space-y-4">
            @foreach ($services as $service)
                <div
                    class="flex items-start gap-4 p-4 rounded-lg border border-salon-100 hover:border-salon-300 hover:bg-salon-50/30 transition">
                    <div class="avatar placeholder">
                        <div class="bg-gradient-to-br from-salon-100 to-lavender-100 text-salon-600 rounded-full w-12">
                            <x-icon name="o-scissors" class="w-6 h-6" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-800">{{ $service->name }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $service->description }}</p>
                        <div class="flex gap-4 mt-2">
                            <span class="text-salon-600 font-bold text-lg">
                                R$ {{ number_format($service->price, 2, ',', '.') }}
                            </span>
                            <span class="flex items-center gap-1 text-gray-500">
                                <x-icon name="o-clock" class="w-4 h-4" />
                                {{ $service->duration_minutes }} min
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
</x-app-layout>
