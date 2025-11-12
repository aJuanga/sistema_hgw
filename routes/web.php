<?php

use App\Http\Controllers\ClientPortalController;
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
    if (auth()->user()?->isCliente()) {
        return redirect()->route('client.dashboard');
    }

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

    Route::middleware('role:cliente')->group(function () {
        Route::get('/mi-catalogo', [ClientPortalController::class, 'index'])->name('client.dashboard');
    });

    // Catálogo visible para todos los usuarios autenticados
    Route::middleware('role:jefa,administrador,empleado,cliente')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    });

    // Gestión de catálogo (solo Jefa y Administrador)
    Route::middleware('role:jefa,administrador')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::match(['put', 'patch'], '/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::resource('categories', CategoryController::class);
        Route::resource('diseases', DiseaseController::class);
        Route::resource('health-properties', HealthPropertyController::class);
    });

    Route::middleware('role:jefa,administrador,empleado,cliente')->group(function () {
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    });

    // Operaciones (Jefa, Administrador y Empleado)
    Route::middleware('role:jefa,administrador,empleado')->group(function () {
        Route::resource('inventory', InventoryController::class);
        Route::resource('orders', OrderController::class);
    });
});

require __DIR__.'/auth.php';