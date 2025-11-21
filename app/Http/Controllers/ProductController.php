<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\HealthProperty;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status === 'available', function ($query) {
                $query->where('is_available', true);
            })
            ->when($status === 'unavailable', function ($query) {
                $query->where('is_available', false);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();
        
        return view('products.index', [
            'products' => $products,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $healthProperties = HealthProperty::all();
        $diseases = Disease::all();
        return view('products.create', compact('categories', 'healthProperties', 'diseases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'preparation_time' => 'nullable|integer|min:0',
            'health_properties' => 'nullable|array',
            'health_properties.*' => 'exists:health_properties,id',
            'diseases' => 'nullable|array',
            'diseases.*' => 'exists:diseases,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Crear el producto
        $product = Product::create($validated);

        // Sincronizar propiedades saludables
        if ($request->has('health_properties')) {
            $product->healthProperties()->sync($request->health_properties);
        }

        // Sincronizar enfermedades contraindicadas
        if ($request->has('diseases')) {
            $product->contraindicatedDiseases()->sync($request->diseases);
        }

        // Crear automáticamente el registro de inventario
        DB::table('inventory')->insert([
            'product_id' => $product->id,
            'current_stock' => 0,
            'minimum_stock' => 5,
            'maximum_stock' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'healthProperties', 'contraindicatedDiseases']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Cargar las relaciones del producto
        $product->load(['healthProperties', 'contraindicatedDiseases']);

        $categories = Category::all();
        $healthProperties = HealthProperty::all();
        $diseases = Disease::all();
        return view('products.edit', compact('product', 'categories', 'healthProperties', 'diseases'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'preparation_time' => 'nullable|integer|min:0',
            'health_properties' => 'nullable|array',
            'health_properties.*' => 'exists:health_properties,id',
            'diseases' => 'nullable|array',
            'diseases.*' => 'exists:diseases,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        // Sincronizar propiedades saludables
        if ($request->has('health_properties')) {
            $product->healthProperties()->sync($request->health_properties);
        } else {
            // Si no se envían propiedades, desvincular todas
            $product->healthProperties()->sync([]);
        }

        // Sincronizar enfermedades contraindicadas
        if ($request->has('diseases')) {
            $product->contraindicatedDiseases()->sync($request->diseases);
        } else {
            // Si no se envían enfermedades, desvincular todas
            $product->contraindicatedDiseases()->sync([]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Eliminar el producto (soft delete)
        $product->delete();

        // Eliminar también el registro de inventario asociado
        DB::table('inventory')->where('product_id', $product->id)->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}