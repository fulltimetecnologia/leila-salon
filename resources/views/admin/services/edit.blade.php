<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Serviço</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-mary-card>
                <form action="{{ route('admin.services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="label"><span class="label-text">Nome do Serviço *</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                class="input input-bordered w-full @error('name') input-error @enderror"
                                value="{{ old('name', $service->name) }}"
                                required
                            />
                            @error('name')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label"><span class="label-text">Descrição</span></label>
                            <textarea 
                                name="description" 
                                class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                                rows="3"
                            >{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label"><span class="label-text">Duração (minutos) *</span></label>
                                <input 
                                    type="number" 
                                    name="duration_minutes" 
                                    class="input input-bordered w-full @error('duration_minutes') input-error @enderror"
                                    value="{{ old('duration_minutes', $service->duration_minutes) }}"
                                    min="15"
                                    step="15"
                                    required
                                />
                                @error('duration_minutes')
                                    <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="label"><span class="label-text">Preço (R$) *</span></label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    class="input input-bordered w-full @error('price') input-error @enderror"
                                    value="{{ old('price', $service->price) }}"
                                    min="0"
                                    step="0.01"
                                    required
                                />
                                @error('price')
                                    <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>

                        <div>
                            <label class="label cursor-pointer justify-start gap-2">
                                <input 
                                    type="checkbox" 
                                    name="active" 
                                    class="checkbox"
                                    value="1"
                                    {{ old('active', $service->active) ? 'checked' : '' }}
                                />
                                <span class="label-text">Serviço ativo</span>
                            </label>
                        </div>

                        <div class="flex gap-2 pt-4">
                            <x-mary-button type="submit" class="btn-primary" icon="o-check">
                                Salvar Alterações
                            </x-mary-button>
                            <x-mary-button link="{{ route('admin.services.index') }}" icon="o-x-mark">
                                Cancelar
                            </x-mary-button>
                        </div>
                    </div>
                </form>
            </x-mary-card>
        </div>
    </div>
</x-app-layout>
