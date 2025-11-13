<?php

namespace App\Http\Controllers;

use App\Models\HealthProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'icon' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('health-properties', 'public');
        }

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
            'icon' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            if ($healthProperty->icon) {
                Storage::disk('public')->delete($healthProperty->icon);
            }
            $validated['icon'] = $request->file('icon')->store('health-properties', 'public');
        }

        $healthProperty->update($validated);

        return redirect()->route('health-properties.index')
            ->with('success', 'Propiedad saludable actualizada exitosamente');
    }

    public function destroy(HealthProperty $healthProperty)
    {
        if ($healthProperty->icon) {
            Storage::disk('public')->delete($healthProperty->icon);
        }

        $healthProperty->delete();

        return redirect()->route('health-properties.index')
            ->with('success', 'Propiedad saludable eliminada exitosamente');
    }
}
