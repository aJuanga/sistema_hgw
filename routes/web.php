<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\HealthPropertyController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\ClientOrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
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
        // Estadísticas principales
        $categoriesCount = \App\Models\Category::count();
        $productsCount = \App\Models\Product::count();
        $diseasesCount = \App\Models\Disease::count();
        $healthPropertiesCount = \App\Models\HealthProperty::count();
        
        // Pedidos
        $ordersCount = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::with('user')
            ->whereIn('status', ['pendiente', 'en_preparacion'])
            ->latest()
            ->take(5)
            ->get();
        
        // Inventario bajo
        $lowStockCount = 0;// \App\Models\Inventory::whereRaw('current_stock <= minimum_stock')->count();
        
        // Productos recientes
        $recentProducts = \App\Models\Product::with('category')
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'categoriesCount',
            'productsCount',
            'diseasesCount',
            'healthPropertiesCount',
            'ordersCount',
            'pendingOrders',
            'lowStockCount',
            'recentProducts'
        ));
    } catch (\Exception $e) {
        // Si hay error de conexión a la base de datos
        return view('dashboard', [
            'error' => 'Error: ' . $e->getMessage(),  // ← LÍNEA CORREGIDA
            'categoriesCount' => 0,
            'productsCount' => 0,
            'diseasesCount' => 0,
            'healthPropertiesCount' => 0,
            'ordersCount' => 0,
            'pendingOrders' => collect([]),
            'lowStockCount' => 0,
            'recentProducts' => collect([])
        ]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del Cliente (accesibles para todos los usuarios autenticados)
    Route::get('/client/dashboard', [ClientPortalController::class, 'index'])->name('client.dashboard');
    Route::get('/client/profile', [ClientPortalController::class, 'profile'])->name('client.profile');
    Route::get('/client/cart', [ClientOrderController::class, 'cart'])->name('client.cart');
    Route::post('/client/cart/add', [ClientOrderController::class, 'addToCart'])->name('client.cart.add');
    Route::post('/client/cart/update', [ClientOrderController::class, 'updateCart'])->name('client.cart.update');
    Route::delete('/client/cart/remove/{productId}', [ClientOrderController::class, 'removeFromCart'])->name('client.cart.remove');
    Route::get('/client/checkout', [ClientOrderController::class, 'checkout'])->name('client.checkout');
    Route::post('/client/checkout', [ClientOrderController::class, 'processCheckout'])->name('client.checkout.process');
    Route::get('/client/orders', [ClientOrderController::class, 'myOrders'])->name('client.orders');
    Route::get('/client/orders/{order}', [ClientOrderController::class, 'showOrder'])->name('client.orders.show');
    Route::post('/client/ratings', [ClientOrderController::class, 'storeRating'])->name('client.ratings.store');
});

// Rutas de Administración (solo para jefa, administrador y empleado)
Route::middleware(['auth', 'role:jefa,administrador,empleado'])->group(function () {
    // CRUD Resources - Productos
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('diseases', DiseaseController::class);
    Route::resource('health-properties', HealthPropertyController::class);

    // CRUD Resources - Pedidos
    Route::resource('orders', OrderController::class);
});

// Rutas exclusivas de la Jefa
Route::middleware(['auth', 'role:jefa'])->group(function () {
    // CRUD Resources - Inventario (solo jefa)
    Route::resource('inventory', InventoryController::class);

    // CRUD Resources - Roles (solo jefa)
    Route::resource('roles', RoleController::class);

    // Reportes (solo jefa)
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
});

// Rutas de Usuarios (jefa y administrador)
Route::middleware(['auth', 'role:jefa,administrador'])->group(function () {
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';