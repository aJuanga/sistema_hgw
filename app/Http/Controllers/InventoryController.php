<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with('product')
            ->orderByRaw('CASE WHEN current_stock <= minimum_stock THEN 0 ELSE 1 END')
            ->orderBy('current_stock', 'asc')
            ->paginate(15);

        return view('inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::whereDoesntHave('inventory')->get();

        return view('inventory.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id|unique:inventory',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'last_restock_date' => 'nullable|date',
        ]);

        Inventory::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        $inventory->load('product');

        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'last_restock_date' => 'nullable|date',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventario eliminado exitosamente.');
    }
}
