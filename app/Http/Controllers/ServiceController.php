<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();

        return view('services.index', compact('services'));
    }

    public function adminIndex()
    {
        $services = Service::all();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'active' => 'boolean',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Serviço criado com sucesso!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'active' => 'boolean',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Serviço excluído com sucesso!');
    }
}
