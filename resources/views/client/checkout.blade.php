@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - {{ config('app.name', 'Healthy Glow Wellness') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

    <style>
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .animate-slide-down {
            animation: slideInDown 0.4s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .step-indicator {
            position: relative;
        }

        .step-indicator::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            width: 100%;
            height: 2px;
            background: #334155;
            z-index: -1;
        }

        .step-indicator:last-child::after {
            display: none;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800/50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/50">
                        HGW
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Finalizar Pedido</p>
                        <p class="text-xs text-slate-400 -mt-0.5">Paso final para tu experiencia wellness</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('client.cart') }}"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="hidden sm:inline">Volver al carrito</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Progress Steps -->
    <div class="bg-slate-900/50 border-b border-slate-800/50 py-6 animate-fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center space-x-4 md:space-x-8">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500 text-white font-semibold shadow-lg shadow-emerald-500/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-sm font-medium text-emerald-400 hidden sm:inline">Carrito</span>
                </div>
                <div class="w-12 md:w-24 h-0.5 bg-emerald-500"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500 text-white font-semibold shadow-lg shadow-emerald-500/50 ring-4 ring-emerald-500/20">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-emerald-400 hidden sm:inline">Checkout</span>
                </div>
                <div class="w-12 md:w-24 h-0.5 bg-slate-700"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-700 text-slate-400 font-semibold">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-slate-400 hidden sm:inline">Confirmación</span>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        @if($errors->any())
            <div class="mb-6 rounded-xl bg-red-500/10 border border-red-500/30 p-4 animate-fade-in">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-red-400 mb-2">Error al procesar el pedido</h3>
                        <ul class="list-disc list-inside text-sm text-red-300 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-xl bg-red-500/10 border border-red-500/30 p-4 animate-fade-in">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-red-300">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(isset($stockWarnings) && count($stockWarnings) > 0)
            <div class="mb-6 rounded-xl bg-orange-500/10 border border-orange-500/30 p-4 animate-fade-in">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-orange-400 mb-2">Advertencia de Stock Insuficiente</h3>
                        <p class="text-sm text-orange-300 mb-2">Los siguientes productos no tienen suficiente stock disponible:</p>
                        <ul class="list-disc list-inside text-sm text-orange-300 space-y-1">
                            @foreach($stockWarnings as $warning)
                                <li>
                                    <strong>{{ $warning['product'] }}</strong>: 
                                    Stock disponible: {{ $warning['stock_disponible'] }}, 
                                    Cantidad solicitada: {{ $warning['cantidad_solicitada'] }}
                                </li>
                            @endforeach
                        </ul>
                        <p class="text-xs text-orange-400 mt-2">Por favor, ajusta las cantidades en tu carrito o contacta con nosotros.</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('client.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="grid gap-6 lg:gap-8 lg:grid-cols-[1fr,420px]">
                <div class="space-y-6">
                    <!-- Productos Section -->
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Tu pedido ({{ count($products) }} {{ count($products) == 1 ? 'producto' : 'productos' }})</h2>
                        </div>
                        <div class="space-y-4">
                            @foreach($products as $item)
                                <div class="flex items-center gap-4 pb-4 border-b border-slate-700/50 last:border-0 group">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/'.$item['product']->image) }}"
                                             alt="{{ $item['product']->name }}"
                                             class="h-20 w-20 rounded-xl object-cover ring-2 ring-slate-700 group-hover:ring-emerald-500/50 transition-all">
                                    @else
                                        <div class="h-20 w-20 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center ring-2 ring-slate-700">
                                            <span class="text-2xl font-bold text-slate-600">HGW</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-white line-clamp-1">{{ $item['product']->name }}</h3>
                                        <p class="text-sm text-slate-400 mt-1">
                                            <span class="inline-flex items-center rounded-full bg-slate-800/50 px-2 py-0.5 text-xs">
                                                {{ $item['product']->category->name ?? 'Sin categoría' }}
                                            </span>
                                        </p>
                                        <p class="text-xs text-slate-500 mt-1">Cantidad: {{ $item['quantity'] }}</p>
                                        @if(isset($item['stock_disponible']) && $item['stock_disponible'] !== null)
                                            @if($item['stock_disponible'] < $item['quantity'])
                                                <p class="text-xs text-orange-400 mt-1 font-semibold">
                                                    Stock disponible: {{ $item['stock_disponible'] }} (insuficiente)
                                                </p>
                                            @elseif($item['stock_disponible'] < ($item['quantity'] * 2))
                                                <p class="text-xs text-yellow-400 mt-1">
                                                    Stock disponible: {{ $item['stock_disponible'] }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-500 mb-1">Bs. {{ number_format($item['product']->price, 2) }} × {{ $item['quantity'] }}</p>
                                        <p class="font-bold text-emerald-400 text-lg">Bs. {{ number_format($item['subtotal'], 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tipo de Pedido -->
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Tipo de Pedido</h2>
                        </div>
                        <div class="space-y-3">
                            <label class="relative flex items-center gap-4 p-4 rounded-xl border-2 border-slate-700/50 bg-slate-800/30 cursor-pointer hover:bg-slate-800/50 hover:border-emerald-500/50 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10 has-[:checked]:shadow-lg has-[:checked]:shadow-emerald-500/20">
                                <input type="radio" name="delivery_type" value="consumir_local"
                                       class="h-5 w-5 text-emerald-500 focus:ring-emerald-500 focus:ring-2"
                                       checked>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <p class="font-bold text-white">Consumir en el Local</p>
                                    </div>
                                    <p class="text-sm text-slate-400 pl-7">Disfruta tu pedido en nuestro espacio wellness acogedor</p>
                                </div>
                            </label>
                            <label class="relative flex items-center gap-4 p-4 rounded-xl border-2 border-slate-700/50 bg-slate-800/30 cursor-pointer hover:bg-slate-800/50 hover:border-emerald-500/50 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10 has-[:checked]:shadow-lg has-[:checked]:shadow-emerald-500/20">
                                <input type="radio" name="delivery_type" value="para_llevar"
                                       class="h-5 w-5 text-emerald-500 focus:ring-emerald-500 focus:ring-2">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        <p class="font-bold text-white">Para Llevar</p>
                                    </div>
                                    <p class="text-sm text-slate-400 pl-7">Empacado con amor, listo para llevar</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Método de Pago</h2>
                        </div>
                        <div class="space-y-3">
                            @foreach($paymentMethods as $method)
                                <label class="relative flex items-center gap-4 p-4 rounded-xl border-2 border-slate-700/50 bg-slate-800/30 cursor-pointer hover:bg-slate-800/50 hover:border-emerald-500/50 transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10 has-[:checked]:shadow-lg has-[:checked]:shadow-emerald-500/20">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}"
                                           class="h-5 w-5 text-emerald-500 focus:ring-emerald-500 focus:ring-2"
                                           required
                                           onchange="handlePaymentMethodChange('{{ $method->slug }}')">
                                    <div class="flex-1">
                                        <p class="font-bold text-white mb-1">{{ $method->name }}</p>
                                        <p class="text-sm text-slate-400">{{ $method->description }}</p>
                                    </div>
                                    @if($method->slug === 'qr')
                                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                    @elseif($method->slug === 'efectivo')
                                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- QR Payment Section -->
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in" id="qrPaymentSection" style="display: none;">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Pago con QR</h2>
                        </div>
                        <p class="text-sm text-slate-400 mb-6">Escanea el código QR con tu aplicación bancaria para realizar el pago</p>
                        <div class="flex justify-center p-8 bg-white rounded-2xl shadow-inner mb-6" id="qrContainer">
                            <div class="max-w-xs w-full">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>
                        <div class="bg-slate-800/50 rounded-xl border border-slate-700/50 p-5 mb-4">
                            <h3 class="text-sm font-bold text-white mb-4 flex items-center">
                                <svg class="h-5 w-5 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Datos Bancarios
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center pb-2 border-b border-slate-700/50">
                                    <span class="text-slate-400">Titular:</span>
                                    <span class="font-bold text-white">HGW S.R.L.</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-slate-700/50">
                                    <span class="text-slate-400">Número de cuenta:</span>
                                    <span class="font-mono font-bold text-white">1234567890</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-slate-700/50">
                                    <span class="text-slate-400">Tipo de cuenta:</span>
                                    <span class="font-bold text-white">Caja de Ahorro</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-slate-700/50">
                                    <span class="text-slate-400">Banco:</span>
                                    <span class="font-bold text-white">Banco Nacional de Bolivia</span>
                                </div>
                                <div class="pt-3 flex justify-between items-center">
                                    <span class="text-slate-300 font-semibold">Total a pagar:</span>
                                    <span class="font-bold text-emerald-400 text-xl">Bs. {{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-xl bg-yellow-500/10 border border-yellow-500/30 p-4 mb-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm text-yellow-300 leading-relaxed font-medium">
                                    Una vez realizado el pago, marca como "Pago Procesado" abajo antes de confirmar tu pedido.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Section -->
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Procesar Pago</h2>
                        </div>
                        <p class="text-sm text-slate-400 mb-4">Selecciona el estado del pago antes de confirmar tu pedido</p>
                        <div class="grid grid-cols-2 gap-4">
                            <button type="button"
                                    onclick="setPaymentStatus('pendiente')"
                                    id="btn_pendiente"
                                    class="payment-status-btn group relative p-6 rounded-xl border-2 border-orange-500/30 bg-orange-500/10 cursor-pointer hover:bg-orange-500/20 hover:border-orange-500/50 transition-all">
                                <div class="text-center">
                                    <div class="flex justify-center mb-3">
                                        <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="font-bold text-white text-lg mb-1">Pendiente</div>
                                    <div class="text-xs text-slate-400">Pagaré después</div>
                                </div>
                                <div class="absolute inset-0 rounded-xl ring-2 ring-orange-500/50 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                            </button>
                            <button type="button"
                                    onclick="setPaymentStatus('pagado')"
                                    id="btn_pagado"
                                    class="payment-status-btn group relative p-6 rounded-xl border-2 border-slate-700/50 bg-slate-800/30 cursor-pointer hover:bg-slate-800/50 hover:border-slate-600/50 transition-all">
                                <div class="text-center">
                                    <div class="flex justify-center mb-3">
                                        <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="font-bold text-white text-lg mb-1">Pago Procesado</div>
                                    <div class="text-xs text-slate-400">Ya realicé el pago</div>
                                </div>
                                <div class="absolute inset-0 rounded-xl ring-2 ring-green-500/50 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                            </button>
                        </div>
                        <input type="hidden" name="payment_status" id="payment_status" value="pendiente" required>
                    </div>

                    <!-- Notas Adicionales -->
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Notas Adicionales</h2>
                        </div>
                        <textarea name="notes" rows="4"
                                  class="w-full rounded-xl border-2 border-slate-700/50 bg-slate-800/30 px-4 py-3 text-white placeholder-slate-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition"
                                  placeholder="Instrucciones especiales, alergias alimentarias, preferencias de preparación..."></textarea>
                        <p class="text-xs text-slate-500 mt-2">Ejemplo: Sin azúcar, leche de almendras, extra caliente</p>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:sticky lg:top-24 h-fit">
                    <div class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 shadow-2xl animate-fade-in">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Resumen del Pedido</h2>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Subtotal ({{ count($products) }} {{ count($products) == 1 ? 'producto' : 'productos' }}):</span>
                                <span class="text-white font-semibold">Bs. {{ number_format($subtotal, 2) }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400 flex items-center space-x-1">
                                    <span>Impuesto (13%):</span>
                                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                <span class="text-white font-semibold">Bs. {{ number_format($tax, 2) }}</span>
                            </div>

                            <div class="border-t border-slate-700/50 pt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-lg font-bold text-white">Total:</span>
                                    <span class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent">
                                        Bs. {{ number_format($total, 2) }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 text-right">Todos los impuestos incluidos</p>
                            </div>
                        </div>

                        <button type="submit"
                                class="group w-full rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4 text-center font-bold text-white shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:from-emerald-600 hover:to-emerald-700 hover:shadow-emerald-500/50 hover:scale-105 mb-4">
                            <span class="flex items-center justify-center space-x-2">
                                <span>Confirmar Pedido</span>
                                <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </button>

                        <div class="rounded-xl bg-slate-800/30 border border-slate-700/50 p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="h-5 w-5 text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-white mb-1">Pago Seguro</p>
                                    <p class="text-xs text-slate-400 leading-relaxed">Tu pedido será procesado de forma segura y recibirás una confirmación inmediata.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        function handlePaymentMethodChange(slug) {
            const qrSection = document.getElementById('qrPaymentSection');
            if (slug === 'qr') {
                qrSection.style.display = 'block';
            } else {
                qrSection.style.display = 'none';
            }
        }

        function setPaymentStatus(status) {
            document.getElementById('payment_status').value = status;

            // Actualizar estilos de botones
            const btnPendiente = document.getElementById('btn_pendiente');
            const btnPagado = document.getElementById('btn_pagado');

            // Resetear estilos
            btnPendiente.classList.remove('border-orange-500/50', 'bg-orange-500/20', 'ring-2', 'ring-orange-500/30');
            btnPagado.classList.remove('border-green-500/50', 'bg-green-500/20', 'ring-2', 'ring-green-500/30');

            btnPendiente.classList.add('border-orange-500/30', 'bg-orange-500/10');
            btnPagado.classList.add('border-slate-700/50', 'bg-slate-800/30');

            // Aplicar estilos según selección
            if (status === 'pendiente') {
                btnPendiente.classList.remove('border-orange-500/30', 'bg-orange-500/10');
                btnPendiente.classList.add('border-orange-500/50', 'bg-orange-500/20', 'ring-2', 'ring-orange-500/30');
            } else {
                btnPagado.classList.remove('border-slate-700/50', 'bg-slate-800/30');
                btnPagado.classList.add('border-green-500/50', 'bg-green-500/20', 'ring-2', 'ring-green-500/30');
            }
        }

        const checkoutForm = document.getElementById('checkoutForm');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                const paymentMethod = document.querySelector('input[name="payment_method_id"]:checked');
                if (!paymentMethod) {
                    e.preventDefault();
                    alert('Por favor selecciona un método de pago');
                    return false;
                }

                const paymentStatus = document.getElementById('payment_status');
                if (!paymentStatus) {
                    console.error('Campo payment_status no encontrado');
                    e.preventDefault();
                    alert('Error: Campo de estado de pago no encontrado');
                    return false;
                }

                if (!paymentStatus.value || (paymentStatus.value !== 'pendiente' && paymentStatus.value !== 'pagado')) {
                    e.preventDefault();
                    alert('Por favor selecciona el estado del pago (Pendiente o Pago Procesado)');
                    return false;
                }

                // Deshabilitar el botón para evitar doble envío
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="flex items-center justify-center space-x-2"><span>Procesando...</span><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>';
                }
            });
        }

        // Inicializar el estado de pago
        setPaymentStatus('pendiente');
    </script>
</body>
</html>

