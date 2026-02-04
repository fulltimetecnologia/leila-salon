<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Agendamento</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-mary-card>
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <x-mary-select 
                                label="Serviço" 
                                name="service_id" 
                                :options="$services" 
                                option-value="id" 
                                option-label="name"
                                placeholder="Selecione um serviço"
                                required
                            />
                            @error('service_id')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text">Data e Hora</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                name="scheduled_at" 
                                class="input input-bordered w-full @error('scheduled_at') input-error @enderror"
                                value="{{ old('scheduled_at') }}"
                                min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                                required
                            />
                            @error('scheduled_at')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text">Observações (opcional)</span>
                            </label>
                            <textarea 
                                name="notes" 
                                class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror"
                                rows="3"
                                placeholder="Alguma observação sobre o agendamento?"
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <x-mary-button type="submit" class="btn-primary" icon="o-check">
                                Agendar
                            </x-mary-button>
                            <x-mary-button link="{{ route('bookings.index') }}" icon="o-x-mark">
                                Cancelar
                            </x-mary-button>
                        </div>
                    </div>
                </form>
            </x-mary-card>

            <x-mary-card class="mt-6" title="Serviços Disponíveis">
                <div class="space-y-3">
                    @foreach($services as $service)
                        <div class="border-l-4 border-primary pl-4">
                            <h4 class="font-bold">{{ $service->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $service->description }}</p>
                            <div class="flex gap-4 mt-1 text-sm">
                                <span class="text-primary font-semibold">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                                <span class="text-gray-500">{{ $service->duration_minutes }} minutos</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-mary-card>
        </div>
    </div>
</x-app-layout>
