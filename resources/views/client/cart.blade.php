@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carrito - {{ config('app.name', 'Healthy Glow Wellness') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0f172a] text-slate-100">
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Carrito de Compras</h1>
                    <p class="text-sm text-slate-400 mt-1">Revisa tus productos antes de continuar</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('client.dashboard') }}" class="text-sm text-slate-300 hover:text-white">
                        Continuar comprando
                    </a>
                    <a href="{{ route('client.orders') }}" class="text-sm text-slate-300 hover:text-white">
                        Mis Pedidos
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 lg:px-10 py-12">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-500/20 border border-emerald-500/50 p-4 text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-500/20 border border-red-500/50 p-4 text-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if(count($products) > 0)
            <div class="grid gap-8 lg:grid-cols-[1fr,400px]">
                <div class="space-y-4">
                    @foreach($products as $item)
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                            <div class="flex gap-6">
                                <div class="flex-shrink-0">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/'.$item['product']->image) }}" 
                                             alt="{{ $item['product']->name }}"
                                             class="h-24 w-24 rounded-xl object-cover">
                                    @else
                                        <div class="h-24 w-24 rounded-xl bg-slate-800 flex items-center justify-center text-slate-500 text-xs">
                                            Sin imagen
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-white">{{ $item['product']->name }}</h3>
                                    <p class="text-sm text-slate-400 mt-1">{{ $item['product']->category->name ?? 'Sin categoría' }}</p>
                                    
                                    @if($item['product']->customization_options && count($item['product']->customization_options) > 0)
                                        <div class="mt-3 space-y-2">
                                            @foreach($item['product']->customization_options as $option)
                                                <div>
                                                    <label class="text-sm text-slate-300">{{ $option['label'] ?? $option['name'] }}:</label>
                                                    <select name="customization_{{ $item['product']->id }}_{{ $loop->index }}" 
                                                            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-1 text-white text-sm">
                                                        @foreach($option['options'] as $opt)
                                                            <option value="{{ $opt['value'] ?? $opt }}">{{ $opt['label'] ?? $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <form action="{{ route('client.cart.update') }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                <label class="text-sm text-slate-400">Cantidad:</label>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                                       class="w-20 rounded-lg border border-slate-700 bg-slate-800 px-3 py-1 text-white text-sm">
                                                <button type="submit" class="text-sm text-emerald-400 hover:text-emerald-300">
                                                    Actualizar
                                                </button>
                                            </form>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-emerald-400">Bs. {{ number_format($item['subtotal'], 2) }}</p>
                                            <p class="text-xs text-slate-400">Bs. {{ number_format($item['product']->price, 2) }} c/u</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('client.cart.remove', $item['product']->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-400 hover:text-red-300">
                                            Eliminar del carrito
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lg:sticky lg:top-6 h-fit">
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Resumen del Pedido</h2>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Subtotal:</span>
                                <span class="text-white font-medium">Bs. {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Impuesto (13%):</span>
                                <span class="text-white font-medium">Bs. {{ number_format($total * 0.13, 2) }}</span>
                            </div>
                            <div class="border-t border-slate-700 pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-white">Total:</span>
                                    <span class="text-xl font-bold text-emerald-400">Bs. {{ number_format($total * 1.13, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('client.checkout') }}" 
                           class="block w-full rounded-xl bg-emerald-500 px-6 py-3 text-center font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                            Proceder al Pago
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/70 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">Tu carrito está vacío</h3>
                <p class="text-slate-400 mb-6">Agrega productos desde el catálogo</p>
                <a href="{{ route('client.dashboard') }}" 
                   class="inline-flex items-center rounded-xl bg-emerald-500 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                    Ver Productos
                </a>
            </div>
        @endif
    </main>
</body>
</html>

