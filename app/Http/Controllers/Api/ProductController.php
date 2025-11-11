<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'healthProperties']);

        // Filtrar por categoría
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtrar por disponibilidad
        if ($request->has('is_available')) {
            $query->where('is_available', $request->is_available);
        }

        // Buscar por nombre
        if ($request->has('search')) {
            $query->where('name', 'ILIKE', '%' . $request->search . '%');
        }

        $products = $query->orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200|unique:products,name',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'calories' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbohydrates' => 'nullable|numeric|min:0',
            'fats' => 'nullable|numeric|min:0',
            'fiber' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url',
            'is_available' => 'boolean',
            'health_properties' => 'nullable|array',
            'health_properties.*' => 'exists:health_properties,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        
        try {
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'cost' => $request->cost,
                'preparation_time' => $request->preparation_time ?? 5,
                'calories' => $request->calories,
                'protein' => $request->protein,
                'carbohydrates' => $request->carbohydrates,
                'fats' => $request->fats,
                'fiber' => $request->fiber,
                'image_url' => $request->image_url,
                'is_available' => $request->is_available ?? true,
            ]);

            // Asociar propiedades saludables
            if ($request->has('health_properties')) {
                $product->healthProperties()->attach($request->health_properties);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $product->load('category', 'healthProperties')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified product
     */
    public function show($id)
    {
        $product = Product::with([
            'category',
            'healthProperties',
            'inventory'
        ])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200|unique:products,name,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:0',
            'calories' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbohydrates' => 'nullable|numeric|min:0',
            'fats' => 'nullable|numeric|min:0',
            'fiber' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url',
            'is_available' => 'boolean',
            'health_properties' => 'nullable|array',
            'health_properties.*' => 'exists:health_properties,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'cost' => $request->cost,
                'preparation_time' => $request->preparation_time ?? $product->preparation_time,
                'calories' => $request->calories,
                'protein' => $request->protein,
                'carbohydrates' => $request->carbohydrates,
                'fats' => $request->fats,
                'fiber' => $request->fiber,
                'image_url' => $request->image_url,
                'is_available' => $request->is_available ?? $product->is_available,
            ]);

            // Actualizar propiedades saludables
            if ($request->has('health_properties')) {
                $product->healthProperties()->sync($request->health_properties);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'data' => $product->load('category', 'healthProperties')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified product (soft delete)
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}