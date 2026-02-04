<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gerenciar Serviços</h2>
            <x-mary-button link="{{ route('admin.services.create') }}" icon="o-plus" class="btn-primary">
                Novo Serviço
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

            <x-mary-card>
                @if($services->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Duração</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="font-bold">{{ $service->name }}</div>
                                                @if($service->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($service->description, 50) }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $service->duration_minutes }} min</td>
                                        <td class="font-semibold">R$ {{ number_format($service->price, 2, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $service->active ? 'badge-success' : 'badge-error' }}">
                                                {{ $service->active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex gap-2">
                                                <x-mary-button link="{{ route('admin.services.edit', $service) }}" 
                                                    icon="o-pencil" class="btn-sm btn-primary" />
                                                
                                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-mary-button type="submit" icon="o-trash" class="btn-sm btn-error"
                                                        onclick="return confirm('Deseja excluir este serviço?')" />
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">Nenhum serviço cadastrado.</p>
                        <x-mary-button link="{{ route('admin.services.create') }}" icon="o-plus" class="btn-primary">
                            Criar Primeiro Serviço
                        </x-mary-button>
                    </div>
                @endif
            </x-mary-card>
        </div>
    </div>
</x-app-layout>
