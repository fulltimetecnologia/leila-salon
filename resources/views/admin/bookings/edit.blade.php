<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Agendamento (Admin)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="label"><span class="label-text">Cliente</span></label>
                            <input type="text" class="input input-bordered w-full" value="{{ $booking->user->name }}" disabled>
                        </div>

                        <div>
                            <x-select 
                                label="Serviço" 
                                name="service_id" 
                                :options="$services" 
                                option-value="id" 
                                option-label="name"
                                :value="$booking->service_id"
                                required
                            />
                            @error('service_id')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Data e Hora</span></label>
                            <input 
                                type="datetime-local" 
                                name="scheduled_at" 
                                class="input input-bordered w-full @error('scheduled_at') input-error @enderror"
                                value="{{ old('scheduled_at', $booking->scheduled_at->format('Y-m-d\TH:i')) }}"
                                required
                            />
                            @error('scheduled_at')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-select 
                                label="Status" 
                                name="status" 
                                :options="[
                                    ['value' => 'pending', 'label' => 'Pendente'],
                                    ['value' => 'confirmed', 'label' => 'Confirmado'],
                                    ['value' => 'completed', 'label' => 'Concluído'],
                                    ['value' => 'cancelled', 'label' => 'Cancelado']
                                ]"
                                option-value="value"
                                option-label="label"
                                :value="$booking->status"
                                required
                            />
                            @error('status')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Observações</span></label>
                            <textarea 
                                name="notes" 
                                class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror"
                                rows="3"
                            >{{ old('notes', $booking->notes) }}</textarea>
                            @error('notes')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <x-button type="submit" class="btn-primary" icon="o-check">
                                Salvar Alterações
                            </x-button>
                            <x-button link="{{ route('admin.bookings.index') }}" icon="o-x-mark">
                                Cancelar
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
