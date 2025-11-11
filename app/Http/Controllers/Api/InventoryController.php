<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of inventory
     */
    public function index(Request $request)
    {
        $query = Inventory::with('product.category');

        // Filtrar por stock bajo
        if ($request->has('low_stock') && $request->low_stock == true) {
            $query->whereRaw('current_stock <= minimum_stock');
        }

        // Filtrar por producto
        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $inventory = $query->orderBy('current_stock', 'asc')->get();

        // Agregar alerta de stock bajo
        $inventory->each(function($item) {
            $item->needs_restock = $item->current_stock <= $item->minimum_stock;
        });

        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }

    /**
     * Store a newly created inventory
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id|unique:inventory,product_id',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_of_measure' => 'required|string|max:20',
            'cost_per_unit' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $inventory = Inventory::create([
            'product_id' => $request->product_id,
            'current_stock' => $request->current_stock,
            'minimum_stock' => $request->minimum_stock,
            'unit_of_measure' => $request->unit_of_measure,
            'cost_per_unit' => $request->cost_per_unit,
            'last_restock_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inventario creado exitosamente',
            'data' => $inventory->load('product')
        ], 201);
    }

    /**
     * Display the specified inventory
     */
    public function show($id)
    {
        $inventory = Inventory::with([
            'product.category',
            'transactions' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            }
        ])->find($id);

        if (!$inventory) {
            return response()->json([
                'success' => false,
                'message' => 'Inventario no encontrado'
            ], 404);
        }

        $inventory->needs_restock = $inventory->current_stock <= $inventory->minimum_stock;

        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }

    /**
     * Update inventory stock
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json([
                'success' => false,
                'message' => 'Inventario no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'current_stock' => 'nullable|numeric|min:0',
            'minimum_stock' => 'nullable|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:20',
            'cost_per_unit' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Si se actualiza el stock, actualizar fecha de restock
        if ($request->has('current_stock') && $request->current_stock > $inventory->current_stock) {
            $inventory->last_restock_date = now();
        }

        $inventory->update([
            'current_stock' => $request->current_stock ?? $inventory->current_stock,
            'minimum_stock' => $request->minimum_stock ?? $inventory->minimum_stock,
            'unit_of_measure' => $request->unit_of_measure ?? $inventory->unit_of_measure,
            'cost_per_unit' => $request->cost_per_unit ?? $inventory->cost_per_unit,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inventario actualizado exitosamente',
            'data' => $inventory->load('product')
        ]);
    }

    /**
     * Remove the specified inventory
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);

        if (!$inventory) {
            return response()->json([
                'success' => false,
                'message' => 'Inventario no encontrado'
            ], 404);
        }

        $inventory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inventario eliminado exitosamente'
        ]);
    }

    /**
     * Get products with low stock
     */
    public function lowStock()
    {
        $inventory = Inventory::with('product.category')
            ->whereRaw('current_stock <= minimum_stock')
            ->orderBy('current_stock', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $inventory->count(),
            'data' => $inventory
        ]);
    }
}