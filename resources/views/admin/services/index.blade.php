<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gerenciar Serviços</h2>
            <x-button link="{{ route('admin.services.create') }}" icon="o-plus" class="btn-primary">
                Novo Serviço
            </x-button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <x-card>
            @if($services->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Serviço</th>
                                <th>Duração</th>
                                <th>Preço</th>
                                <th>Status</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-lavender-100 text-lavender-600 rounded-full w-10">
                                                    <x-icon name="o-scissors" class="w-5 h-5" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800">{{ $service->name }}</div>
                                                @if($service->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($service->description, 60) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <x-icon name="o-clock" class="w-4 h-4 text-gray-400" />
                                            <span class="font-medium">{{ $service->duration_minutes }} min</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-lg font-bold text-salon-600">
                                            R$ {{ number_format($service->price, 2, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <x-badge 
                                            :value="$service->active ? 'Ativo' : 'Inativo'" 
                                            class="{{ $service->active ? 'badge-success' : 'badge-error' }}" 
                                        />
                                    </td>
                                    <td class="text-right">
                                        <div class="flex gap-2 justify-end">
                                            <x-button link="{{ route('admin.services.edit', $service) }}" 
                                                icon="o-pencil" class="btn-sm btn-primary" tooltip="Editar" />
                                            
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" icon="o-trash" class="btn-sm btn-error"
                                                    tooltip="Excluir" onclick="return confirm('Deseja excluir este serviço?')" />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <x-icon name="o-scissors" class="w-16 h-16 mx-auto text-gray-300 mb-4" />
                    <p class="text-gray-500 mb-4 text-lg">Nenhum serviço cadastrado.</p>
                    <x-button link="{{ route('admin.services.create') }}" icon="o-plus" class="btn-primary">
                        Criar Primeiro Serviço
                    </x-button>
                </div>
            @endif
        </x-card>
    </div>
</x-app-layout>
