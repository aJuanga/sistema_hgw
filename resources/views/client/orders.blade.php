@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mis Pedidos - {{ config('app.name', 'Healthy Glow Wellness') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0f172a] text-slate-100">
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Mis Pedidos</h1>
                    <p class="text-sm text-slate-400 mt-1">Historial de tus pedidos</p>
                </div>
                <a href="{{ route('client.dashboard') }}" class="text-sm text-slate-300 hover:text-white">
                    Volver al catálogo
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 lg:px-10 py-12">
        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-500/20 border border-red-500/50 p-4 text-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-white">Pedido {{ $order->order_number }}</h3>
                                <p class="text-sm text-slate-400 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-emerald-400">Bs. {{ number_format($order->total, 2) }}</p>
                                @if($order->status == 'pendiente')
                                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-xs font-semibold">
                                        Pendiente
                                    </span>
                                @elseif($order->status == 'en_preparacion')
                                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-orange-500/20 text-orange-400 text-xs font-semibold">
                                        En Preparación
                                    </span>
                                @elseif($order->status == 'listo')
                                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs font-semibold">
                                        Listo
                                    </span>
                                @elseif($order->status == 'entregado')
                                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-semibold">
                                        Entregado
                                    </span>
                                @elseif($order->status == 'cancelado')
                                    <span class="inline-block mt-2 px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-semibold">
                                        Cancelado
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-slate-400">Método de pago: 
                                <span class="text-white font-medium">{{ $order->paymentMethod->name ?? 'N/A' }}</span>
                            </p>
                            @if($order->estimated_time)
                                <p class="text-sm text-slate-400 mt-1">Tiempo estimado: 
                                    <span class="text-white font-medium">{{ $order->estimated_time }} minutos</span>
                                </p>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400">{{ $order->orderItems->count() }} producto(s)</p>
                            </div>
                            <a href="{{ route('client.orders.show', $order) }}" 
                               class="text-sm font-semibold text-emerald-400 hover:text-emerald-300">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/70 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">No tienes pedidos aún</h3>
                <p class="text-slate-400 mb-6">Realiza tu primer pedido desde el catálogo</p>
                <a href="{{ route('client.dashboard') }}" 
                   class="inline-flex items-center rounded-xl bg-emerald-500 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                    Ver Productos
                </a>
            </div>
        @endif
    </main>
</body>
</html>

