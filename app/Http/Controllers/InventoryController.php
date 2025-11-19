<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with('product.category')->get();

        // Productos con stock bajo (menor o igual al mínimo)
        $lowStock = $inventories->filter(function ($inventory) {
            return $inventory->current_stock <= $inventory->minimum_stock;
        });

        return view('inventory.index', compact('inventories', 'lowStock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $inventory->load('product.category');
        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'maximum_stock' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:20',
            'last_restock_date' => 'nullable|date',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', '✅ Inventario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    /**
     * Agregar stock al inventario
     */
    public function addStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.01',
            'reason' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $previousStock = $inventory->current_stock;
            $newStock = $previousStock + $validated['quantity'];

            // Actualizar el inventario
            $inventory->update([
                'current_stock' => $newStock,
                'last_restock_date' => now(),
            ]);

            // Registrar el movimiento
            InventoryMovement::create([
                'product_id' => $inventory->product_id,
                'type' => 'entrada',
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'user_id' => auth()->id(),
                'reason' => $validated['reason'] ?? 'Ingreso manual de stock',
            ]);

            DB::commit();

            return redirect()->route('inventory.index')
                ->with('success', '✅ Stock agregado correctamente: +' . $validated['quantity'] . ' unidades');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('inventory.index')
                ->with('error', '❌ Error al agregar stock: ' . $e->getMessage());
        }
    }

    /**
     * Descontar stock del inventario
     */
    public function subtractStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.01',
            'reason' => 'nullable|string|max:255',
        ]);

        // Validar que no quede negativo
        if ($inventory->current_stock < $validated['quantity']) {
            return redirect()->route('inventory.index')
                ->with('error', '❌ No hay suficiente stock. Stock actual: ' . $inventory->current_stock);
        }

        DB::beginTransaction();
        try {
            $previousStock = $inventory->current_stock;
            $newStock = $previousStock - $validated['quantity'];

            // Actualizar el inventario
            $inventory->update([
                'current_stock' => $newStock,
            ]);

            // Registrar el movimiento
            InventoryMovement::create([
                'product_id' => $inventory->product_id,
                'type' => 'ajuste',
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'user_id' => auth()->id(),
                'reason' => $validated['reason'] ?? 'Descuento manual de stock',
            ]);

            DB::commit();

            return redirect()->route('inventory.index')
                ->with('success', '✅ Stock descontado correctamente: -' . $validated['quantity'] . ' unidades');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('inventory.index')
                ->with('error', '❌ Error al descontar stock: ' . $e->getMessage());
        }
    }

    /**
     * Reabastecer al stock recomendado (máximo)
     */
    public function restockToRecommended(Inventory $inventory)
    {
        // Si ya está en el máximo o superior, no hacer nada
        if ($inventory->current_stock >= $inventory->maximum_stock) {
            return redirect()->route('inventory.index')
                ->with('info', 'ℹ️ El stock ya está en el nivel recomendado o superior');
        }

        DB::beginTransaction();
        try {
            $previousStock = $inventory->current_stock;
            $quantityToAdd = $inventory->maximum_stock - $previousStock;
            $newStock = $inventory->maximum_stock;

            // Actualizar el inventario
            $inventory->update([
                'current_stock' => $newStock,
                'last_restock_date' => now(),
            ]);

            // Registrar el movimiento
            InventoryMovement::create([
                'product_id' => $inventory->product_id,
                'type' => 'entrada',
                'quantity' => $quantityToAdd,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'user_id' => auth()->id(),
                'reason' => 'Reabastecimiento automático al stock máximo',
            ]);

            DB::commit();

            return redirect()->route('inventory.index')
                ->with('success', '✅ Stock reabastecido al nivel recomendado: +' . $quantityToAdd . ' unidades');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('inventory.index')
                ->with('error', '❌ Error al reabastecer: ' . $e->getMessage());
        }
    }
}