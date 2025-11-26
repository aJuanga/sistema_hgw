<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-lg shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Reporte de Inventario</h2>
                    <p class="text-sm text-gray-600">Stock y movimientos de productos</p>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Volver a Reportes
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <form method="GET" action="{{ route('reports.inventory') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-lg hover:from-blue-600 hover:to-cyan-700 transition font-semibold">
                        Filtrar
                    </button>
                    <a href="{{ route('reports.inventory.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-lg hover:from-red-600 hover:to-pink-700 transition font-semibold">
                        Descargar PDF
                    </a>
                </form>
            </div>

            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Total Productos</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ $stats['total_products'] ?? 0 }}</p>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Stock Bajo</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ $stats['low_stock_count'] ?? 0 }}</p>
                </div>

                <div class="bg-gradient-to-br from-red-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Sin Stock</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ $stats['out_of_stock'] ?? 0 }}</p>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold uppercase tracking-wide">Valor Total</span>
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-4xl font-bold">{{ number_format($stats['total_stock_value'] ?? 0, 2) }} Bs</p>
                </div>
            </div>

            <!-- Alertas de Stock Bajo -->
            @if($lowStockProducts->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Alertas de Stock Bajo ({{ $lowStockProducts->count() }})
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Actual</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Mínimo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($lowStockProducts as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Sin categoría' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold {{ ($product->current_stock ?? 0) == 0 ? 'text-red-600' : 'text-orange-600' }}">
                                        {{ $product->current_stock ?? 0 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $product->minimum_stock ?? 0 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(($product->current_stock ?? 0) == 0)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Agotado
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Crítico
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Gráficas de Inventario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Distribución de Stock -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Distribución de Stock</h3>
                    <div style="height: 300px;">
                        <canvas id="stockDistributionChart"></canvas>
                    </div>
                </div>

                <!-- Productos por Categoría -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Productos por Categoría</h3>
                    <div style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- Valor de Inventario por Categoría -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Valor de Inventario por Categoría</h3>
                    <div style="height: 300px;">
                        <canvas id="categoryValueChart"></canvas>
                    </div>
                </div>

                <!-- Top 10 Productos más Vendidos -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Top 10 Productos más Vendidos (Período)</h3>
                    <div style="height: 300px;">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tabla de Inventario Completo -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Inventario Completo</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Actual</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendidos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Sin categoría' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($product->price ?? 0, 2) }} Bs</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold {{ ($product->current_stock ?? 0) <= ($product->minimum_stock ?? 0) ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->current_stock ?? 0 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $soldProducts[$product->id] ?? 0 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format(($product->current_stock ?? 0) * ($product->price ?? 0), 2) }} Bs
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar que Chart.js esté cargado
            if (typeof Chart === 'undefined') {
                console.error('Chart.js no se cargó correctamente');
                return;
            }

            // Distribución de Stock
            const stockCtx = document.getElementById('stockDistributionChart');
            if (stockCtx) {
                try {
                    const stockData = [
                        {{ $stats['low_stock_count'] ?? 0 }}, 
                        {{ $stats['medium_stock_count'] ?? 0 }}, 
                        {{ $stats['high_stock_count'] ?? 0 }}
                    ];
                    
                    new Chart(stockCtx.getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: ['Stock Bajo', 'Stock Medio', 'Stock Alto'],
                            datasets: [{
                                data: stockData,
                                backgroundColor: ['#EF4444', '#F59E0B', '#10B981'],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error al crear gráfica de distribución de stock:', error);
                }
            } else {
                console.error('No se encontró el elemento stockDistributionChart');
            }

            // Productos por Categoría
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                try {
                    const categoryLabels = {!! json_encode($productsByCategory->keys()->toArray() ?? []) !!};
                    const categoryData = {!! json_encode($productsByCategory->pluck('count')->toArray() ?? []) !!};
                    
                    new Chart(categoryCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: categoryLabels && categoryLabels.length > 0 ? categoryLabels : ['Sin categorías'],
                            datasets: [{
                                label: 'Cantidad de Productos',
                                data: categoryData && categoryData.length > 0 ? categoryData : [0],
                                backgroundColor: '#3B82F6',
                                borderColor: '#2563EB',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error al crear gráfica de productos por categoría:', error);
                }
            } else {
                console.error('No se encontró el elemento categoryChart');
            }

            // Valor de Inventario por Categoría
            const categoryValueCtx = document.getElementById('categoryValueChart');
            if (categoryValueCtx) {
                try {
                    const valueLabels = {!! json_encode($productsByCategory->keys()->toArray() ?? []) !!};
                    const valueData = {!! json_encode($productsByCategory->pluck('value')->toArray() ?? []) !!};
                    
                    new Chart(categoryValueCtx.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: valueLabels && valueLabels.length > 0 ? valueLabels : ['Sin categorías'],
                            datasets: [{
                                data: valueData && valueData.length > 0 ? valueData : [0],
                                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': ' + context.parsed.toFixed(2) + ' Bs';
                                        }
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error al crear gráfica de valor por categoría:', error);
                }
            } else {
                console.error('No se encontró el elemento categoryValueChart');
            }

            // Top 10 Productos más Vendidos
            const topProductsCtx = document.getElementById('topProductsChart');
            if (topProductsCtx) {
                try {
                    const topProductsData = {!! json_encode($products->sortByDesc(function($p) use ($soldProducts) {
                        return $soldProducts[$p->id] ?? 0;
                    })->take(10)->map(function($p) use ($soldProducts) {
                        return [
                            'name' => $p->name,
                            'sold' => $soldProducts[$p->id] ?? 0
                        ];
                    })->values()->toArray()) !!};

                    if (topProductsData && topProductsData.length > 0) {
                        new Chart(topProductsCtx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: topProductsData.map(p => p.name && p.name.length > 20 ? p.name.substring(0, 20) + '...' : (p.name || 'Sin nombre')),
                                datasets: [{
                                    label: 'Unidades Vendidas',
                                    data: topProductsData.map(p => p.sold || 0),
                                    backgroundColor: '#10B981',
                                    borderColor: '#059669',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        // Mostrar gráfica vacía si no hay datos
                        new Chart(topProductsCtx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: ['Sin datos'],
                                datasets: [{
                                    label: 'Unidades Vendidas',
                                    data: [0],
                                    backgroundColor: '#10B981',
                                    borderColor: '#059669',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error al crear gráfica de top productos:', error);
                }
            } else {
                console.error('No se encontró el elemento topProductsChart');
            }
        });
    </script>
    @endpush
</x-app-layout>
