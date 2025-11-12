<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\HealthPropertyController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/test-auth', function () {
    Auth::login(\App\Models\User::where('email', 'admin@admin.com')->first());
    return redirect('/dashboard');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    try {
        // Intentar obtener los datos del dashboard
        $categoriesCount = \App\Models\Category::count();
        $productsCount = \App\Models\Product::count();
        $diseasesCount = \App\Models\Disease::count();
        $healthPropertiesCount = \App\Models\HealthProperty::count();
        $recentProducts = \App\Models\Product::latest()->take(5)->get();
        
        return view('dashboard', compact(
            'categoriesCount',
            'productsCount',
            'diseasesCount',
            'healthPropertiesCount',
            'recentProducts'
        ));
    } catch (\Exception $e) {
        // Si hay error de conexión a la base de datos
        return view('dashboard', [
            'error' => 'Error de conexión a la base de datos. Por favor, verifica que la base de datos esté creada y las migraciones ejecutadas.',
            'categoriesCount' => 0,
            'productsCount' => 0,
            'diseasesCount' => 0,
            'healthPropertiesCount' => 0,
            'recentProducts' => collect([])
        ]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Resources - Productos
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('diseases', DiseaseController::class);
    Route::resource('health-properties', HealthPropertyController::class);

    // CRUD Resources - Inventario y Pedidos
    Route::resource('inventory', InventoryController::class);
    Route::resource('orders', OrderController::class);
});

require __DIR__.'/auth.php';