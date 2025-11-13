<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-900">Productos Más Vendidos</h2>
                <p class="text-sm text-slate-600 mt-1">Análisis de popularidad y rendimiento</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('reports.products') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label for="start_date" class="block text-sm font-semibold text-slate-700 mb-2">Fecha Inicio</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                               class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="end_date" class="block text-sm font-semibold text-slate-700 mb-2">Fecha Fin</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                               class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                    </div>
                    <div class="w-32">
                        <label for="limit" class="block text-sm font-semibold text-slate-700 mb-2">Top</label>
                        <select id="limit" name="limit" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                            <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('limit') == 20 || !request('limit') ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- Top Productos -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Top Productos por Cantidad Vendida</h3>
                </div>
                <div class="p-6">
                    @if($topProducts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Producto</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Categoría</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Precio</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Cantidad</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Ingresos</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Pedidos</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($topProducts as $index => $product)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $product->name }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">{{ $product->category_name ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">Bs. {{ number_format($product->price, 2) }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-amber-700">{{ $product->total_quantity }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-green-700">Bs. {{ number_format($product->total_revenue, 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700">{{ $product->order_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-slate-600 py-8">No hay datos para el período seleccionado</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Ventas por Categoría -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Ventas por Categoría</h3>
                    </div>
                    <div class="p-6">
                        @if($productsByCategory->count() > 0)
                            <div class="space-y-3">
                                @foreach($productsByCategory as $category)
                                    <div class="p-4 bg-slate-50 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="font-semibold text-slate-900">{{ $category->category }}</p>
                                            <span class="text-sm font-medium text-amber-700">{{ $category->total_quantity }} unidades</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-slate-600">Ingresos:</span>
                                            <span class="text-lg font-bold text-green-700">Bs. {{ number_format($category->total_revenue, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-slate-600 py-8">No hay datos</p>
                        @endif
                    </div>
                </div>

                <!-- Productos con Bajo Stock -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Alertas de Stock Bajo</h3>
                    </div>
                    <div class="p-6">
                        @if($lowStockProducts->count() > 0)
                            <div class="space-y-3">
                                @foreach($lowStockProducts as $product)
                                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                            <p class="text-sm text-slate-600">Stock mínimo: {{ $product->stock_min }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-red-700">{{ $product->stock }}</p>
                                            <p class="text-xs text-slate-600">Actual</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-slate-600">Todos los productos tienen stock adecuado</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
