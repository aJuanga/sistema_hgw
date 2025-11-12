<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::withCount('healthProfiles')
            ->latest()
            ->paginate(10);

        return view('diseases.index', compact('diseases'));
    }

    public function create()
    {
        return view('diseases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|in:cronica,aguda',
            'description' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Disease::create($validated);

        return redirect()->route('diseases.index')
            ->with('success', 'Enfermedad creada exitosamente');
    }

    public function show(Disease $disease)
    {
        $disease->load(['healthProfiles', 'contraindicatedProducts']);
        return view('diseases.show', compact('disease'));
    }

    public function edit(Disease $disease)
    {
        return view('diseases.edit', compact('disease'));
    }

    public function update(Request $request, Disease $disease)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|in:cronica,aguda',
            'description' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $disease->update($validated);

        return redirect()->route('diseases.index')
            ->with('success', 'Enfermedad actualizada exitosamente');
    }

    public function destroy(Disease $disease)
    {
        $disease->delete();

        return redirect()->route('diseases.index')
            ->with('success', 'Enfermedad eliminada exitosamente');
    }
}
