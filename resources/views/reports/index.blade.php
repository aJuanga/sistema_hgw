<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-3 rounded-lg shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Reportes del Sistema</h2>
                    <p class="text-sm text-gray-600">Análisis y estadísticas de HGW</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-purple-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Grid de Reportes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                <!-- Reporte de Inventario/Stock -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-30 p-3 rounded-lg backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">Inventario / Stock</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Productos disponibles vs vendidos, stock actual, alertas de reposición y movimientos de inventario.
                        </p>
                        <ul class="space-y-2 mb-6 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Stock actual vs mínimo requerido
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Alertas de productos a reponer
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Valor total del inventario
                            </li>
                        </ul>
                        <a href="{{ route('reports.inventory') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-cyan-700 transition duration-200">
                            <span>Ver Reporte</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Reporte de Ventas -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-30 p-3 rounded-lg backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">Ventas</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Ventas por período, productos más vendidos, ingresos totales y comparativas.
                        </p>
                        <ul class="space-y-2 mb-6 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Ventas por día/semana/mes
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Productos más vendidos
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Comparativa de períodos
                            </li>
                        </ul>
                        <a href="{{ route('reports.sales') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-emerald-700 transition duration-200">
                            <span>Ver Reporte</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Reporte de Empleados -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-30 p-3 rounded-lg backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">Empleados</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Pedidos realizados, puntos generados, desempeño por empleado.
                        </p>
                        <ul class="space-y-2 mb-6 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pedidos realizados por empleado
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Puntos generados por empleado
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Tasa de completación
                            </li>
                        </ul>
                        <a href="{{ route('reports.employees') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-red-700 transition duration-200">
                            <span>Ver Reporte</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Reporte Financiero -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-30 p-3 rounded-lg backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">Financiero</h3>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Ingresos vs costos, ganancias por período, métodos de pago más usados.
                        </p>
                        <ul class="space-y-2 mb-6 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Ingresos totales por período
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Métodos de pago más usados
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Comparativa de períodos
                            </li>
                        </ul>
                        <a href="{{ route('reports.financial') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-700 transition duration-200">
                            <span>Ver Reporte</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Información adicional -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Acerca de los Reportes</h4>
                        <p class="text-sm text-gray-600">
                            Los reportes incluyen filtros por fecha y la opción de descargar en formato PDF.
                            Todos los datos se actualizan en tiempo real según las transacciones del sistema.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
