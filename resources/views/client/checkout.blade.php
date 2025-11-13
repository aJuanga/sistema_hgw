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
</head>
<body class="min-h-screen bg-[#0f172a] text-slate-100">
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Finalizar Pedido</h1>
                    <p class="text-sm text-slate-400 mt-1">Completa tu información y método de pago</p>
                </div>
                <a href="{{ route('client.cart') }}" class="text-sm text-slate-300 hover:text-white">
                    Volver al carrito
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 lg:px-10 py-12">
        <form action="{{ route('client.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="grid gap-8 lg:grid-cols-[1fr,400px]">
                <div class="space-y-6">
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Productos</h2>
                        <div class="space-y-4">
                            @foreach($products as $item)
                                <div class="flex items-center gap-4 pb-4 border-b border-slate-800 last:border-0">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/'.$item['product']->image) }}" 
                                             alt="{{ $item['product']->name }}"
                                             class="h-16 w-16 rounded-lg object-cover">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-slate-800 flex items-center justify-center text-slate-500 text-xs">
                                            Sin imagen
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-white">{{ $item['product']->name }}</h3>
                                        <p class="text-sm text-slate-400">Cantidad: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-semibold text-emerald-400">Bs. {{ number_format($item['subtotal'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Tipo de Pedido</h2>
                        <div class="space-y-3 mb-6">
                            <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-800 bg-slate-800/50 cursor-pointer hover:bg-slate-800 transition">
                                <input type="radio" name="delivery_type" value="consumir_local" 
                                       class="h-5 w-5 text-emerald-500 focus:ring-emerald-500" 
                                       checked>
                                <div class="flex-1">
                                    <p class="font-semibold text-white">Consumir en el Local</p>
                                    <p class="text-sm text-slate-400">Disfruta tu pedido en nuestro ambiente acogedor</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-800 bg-slate-800/50 cursor-pointer hover:bg-slate-800 transition">
                                <input type="radio" name="delivery_type" value="para_llevar" 
                                       class="h-5 w-5 text-emerald-500 focus:ring-emerald-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-white">Para Llevar</p>
                                    <p class="text-sm text-slate-400">Empacado listo para llevar</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Método de Pago</h2>
                        <div class="space-y-3">
                            @foreach($paymentMethods as $method)
                                <label class="flex items-center gap-4 p-4 rounded-xl border border-slate-800 bg-slate-800/50 cursor-pointer hover:bg-slate-800 transition">
                                    <input type="radio" name="payment_method_id" value="{{ $method->id }}" 
                                           class="h-5 w-5 text-emerald-500 focus:ring-emerald-500" 
                                           required
                                           onchange="handlePaymentMethodChange('{{ $method->slug }}')">
                                    <div class="flex-1">
                                        <p class="font-semibold text-white">{{ $method->name }}</p>
                                        <p class="text-sm text-slate-400">{{ $method->description }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6" id="qrPaymentSection" style="display: none;">
                        <h2 class="text-xl font-semibold text-white mb-4">Pago con QR</h2>
                        <p class="text-sm text-slate-400 mb-4">Escanea el código QR con tu aplicación bancaria para realizar el pago</p>
                        <div class="flex justify-center p-6 bg-white rounded-xl min-h-[300px] items-center" id="qrContainer">
                            <canvas id="qrcode" class="max-w-xs w-full"></canvas>
                        </div>
                        <p class="text-sm text-slate-400 mt-4 text-center">
                            Número de cuenta: <span class="font-semibold text-white">1234-5678-9012-3456</span><br>
                            Banco: <span class="font-semibold text-white">Banco Nacional</span>
                        </p>
                        <p class="text-xs text-slate-500 mt-2 text-center">Total a pagar: <span class="font-semibold text-emerald-400">Bs. {{ number_format($total, 2) }}</span></p>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Notas Adicionales</h2>
                        <textarea name="notes" rows="4" 
                                  class="w-full rounded-lg border border-slate-700 bg-slate-800 px-4 py-3 text-white placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring focus:ring-emerald-500/20"
                                  placeholder="Instrucciones especiales, alergias, preferencias..."></textarea>
                    </div>
                </div>

                <div class="lg:sticky lg:top-6 h-fit">
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Resumen</h2>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Subtotal:</span>
                                <span class="text-white font-medium">Bs. {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Impuesto (13%):</span>
                                <span class="text-white font-medium">Bs. {{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="border-t border-slate-700 pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-white">Total:</span>
                                    <span class="text-xl font-bold text-emerald-400">Bs. {{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" 
                                class="w-full rounded-xl bg-emerald-500 px-6 py-3 text-center font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                            Confirmar Pedido
                        </button>
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
                // Esperar un momento para que el DOM se actualice
                setTimeout(function() {
                    generateQRCode();
                }, 100);
            } else {
                qrSection.style.display = 'none';
            }
        }

        function generateQRCode() {
            const canvas = document.getElementById('qrcode');
            if (!canvas) return;
            
            // Limpiar canvas anterior
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            const total = {{ $total }};
            const orderData = {
                amount: total,
                currency: 'BOB',
                account: '1234-5678-9012-3456',
                merchant: 'Healthy Glow Wellness',
                timestamp: new Date().toISOString()
            };
            
            const qrData = JSON.stringify(orderData);
            
            // Verificar que QRCode esté disponible
            if (typeof QRCode === 'undefined') {
                console.error('QRCode library not loaded');
                const container = document.getElementById('qrContainer');
                if (container) {
                    container.innerHTML = '<p class="text-red-500 text-center p-4">Error al cargar el código QR. Por favor recarga la página.</p>';
                }
                return;
            }
            
            QRCode.toCanvas(canvas, qrData, {
                width: 300,
                margin: 2,
                color: {
                    dark: '#000000',
                    light: '#FFFFFF'
                }
            }, function (error) {
                if (error) {
                    console.error('QR Code generation error:', error);
                    const container = document.getElementById('qrContainer');
                    if (container) {
                        container.innerHTML = '<p class="text-red-500 text-center p-4">Error al generar el código QR. Por favor intenta de nuevo.</p>';
                    }
                }
            });
        }

        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method_id"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                alert('Por favor selecciona un método de pago');
                return false;
            }
        });
    </script>
</body>
</html>

