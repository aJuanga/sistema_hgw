<?php

namespace App\Http\Controllers;

use App\Models\HealthProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HealthPropertyController extends Controller
{
    public function index()
    {
        $healthProperties = HealthProperty::withCount('products')
            ->latest()
            ->paginate(10);

        return view('health-properties.index', compact('healthProperties'));
    }

    public function create()
    {
        return view('health-properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        HealthProperty::create($validated);

        return redirect()->route('health-properties.index')
            ->with('success', 'Propiedad saludable creada exitosamente');
    }

    public function show(HealthProperty $healthProperty)
    {
        $healthProperty->load('products');
        return view('health-properties.show', compact('healthProperty'));
    }

    public function edit(HealthProperty $healthProperty)
    {
        return view('health-properties.edit', compact('healthProperty'));
    }

    public function update(Request $request, HealthProperty $healthProperty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $healthProperty->update($validated);

        return redirect()->route('health-properties.index')
            ->with('success', 'Propiedad saludable actualizada exitosamente');
    }

    public function destroy(HealthProperty $healthProperty)
    {
        $healthProperty->delete();

        return redirect()->route('health-properties.index')
            ->with('success', 'Propiedad saludable eliminada exitosamente');
    }
}
