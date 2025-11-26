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
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.about');
})->name('home');

// Rutas públicas para registro de clientes (sin autenticación)
Route::get('/register-client', [\App\Http\Controllers\PublicOrderController::class, 'showRegisterForm'])->name('public.register');
Route::post('/register-client', [\App\Http\Controllers\PublicOrderController::class, 'registerClient'])->name('public.register.store');

// Redirigir /dashboard a /orders
Route::get('/dashboard', function () {
    return redirect()->route('orders.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del Cliente (accesibles para todos los usuarios autenticados)
    Route::get('/client/dashboard', [ClientPortalController::class, 'index'])->name('client.dashboard');
    Route::get('/client/profile', [ClientProfileController::class, 'show'])->name('client.profile');
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

// ========================================
// RUTAS ESPECÍFICAS POR ROL
// ========================================

// Rutas exclusivas de JEFA (acceso completo)
Route::middleware(['auth', 'role:jefa'])->group(function () {
    // Solo Jefa puede crear/editar/eliminar Productos
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Solo Jefa puede crear/editar/eliminar Categorías
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Gestión completa de Enfermedades y Propiedades Saludables
    Route::resource('diseases', DiseaseController::class);
    Route::resource('health-properties', HealthPropertyController::class);

    // Rutas de Reportes (solo accesibles para Jefa)
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
    Route::get('reports/financial', [ReportController::class, 'financial'])->name('reports.financial');

    // Rutas para PDFs de Reportes
    Route::get('reports/inventory/pdf', [ReportController::class, 'inventoryPdf'])->name('reports.inventory.pdf');
    Route::get('reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('reports/employees/pdf', [ReportController::class, 'employeesPdf'])->name('reports.employees.pdf');
    Route::get('reports/financial/pdf', [ReportController::class, 'financialPdf'])->name('reports.financial.pdf');
});

// Rutas de JEFA y ADMINISTRADOR (sin acceso de Empleado)
Route::middleware(['auth', 'role:jefa,administrador'])->group(function () {
    // Gestión de Inventario (solo Jefa y Administrador)
    Route::resource('inventory', InventoryController::class)->except(['create', 'store']);

    // Acciones de stock
    Route::post('inventory/{inventory}/add-stock', [InventoryController::class, 'addStock'])->name('inventory.add-stock');
    Route::post('inventory/{inventory}/subtract-stock', [InventoryController::class, 'subtractStock'])->name('inventory.subtract-stock');
    Route::post('inventory/{inventory}/restock', [InventoryController::class, 'restockToRecommended'])->name('inventory.restock');
});

// Ruta pública de pedidos (sin autenticación) - para registro de clientes
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('orders', [OrderController::class, 'store'])->name('orders.store');

// Rutas de JEFA, ADMINISTRADOR y EMPLEADO (autenticadas)
Route::middleware(['auth', 'role:jefa,administrador,empleado'])->group(function () {
    // Ver listados (todos pueden ver)
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

    // Gestión de Pedidos (solo ver, editar, eliminar requieren auth)
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// Rutas específicas de EMPLEADO
Route::middleware(['auth', 'role:empleado'])->group(function () {
    Route::get('/employee/dashboard', [\App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

// Rutas específicas de ADMINISTRADOR
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Rutas específicas de JEFA
Route::middleware(['auth', 'role:jefa'])->group(function () {
    Route::get('/jefa/dashboard', [\App\Http\Controllers\JefaDashboardController::class, 'index'])->name('jefa.dashboard');

    // Gestión completa de Usuarios (solo Jefa)
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

require __DIR__.'/auth.php';