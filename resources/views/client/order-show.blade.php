@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pedido {{ $order->order_number }} - {{ config('app.name', 'Healthy Glow Wellness') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0f172a] text-slate-100">
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Pedido {{ $order->order_number }}</h1>
                    <p class="text-sm text-slate-400 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <a href="{{ route('client.orders') }}" class="text-sm text-slate-300 hover:text-white">
                    Volver a mis pedidos
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 lg:px-10 py-12">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-500/20 border border-emerald-500/50 p-4 text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Estado del Pedido</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Estado:</span>
                        @if($order->status == 'pendiente')
                            <span class="px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-sm font-semibold">
                                Pendiente
                            </span>
                        @elseif($order->status == 'en_preparacion')
                            <span class="px-3 py-1 rounded-full bg-orange-500/20 text-orange-400 text-sm font-semibold">
                                En Preparación
                            </span>
                        @elseif($order->status == 'listo')
                            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 text-sm font-semibold">
                                Listo
                            </span>
                        @elseif($order->status == 'entregado')
                            <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-sm font-semibold">
                                Entregado
                            </span>
                        @elseif($order->status == 'cancelado')
                            <span class="px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-sm font-semibold">
                                Cancelado
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Tipo de pedido:</span>
                        <span class="text-white font-medium">
                            @if($order->delivery_type == 'para_llevar')
                                Para Llevar
                            @else
                                Consumir en Local
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Método de pago:</span>
                        <span class="text-white font-medium">{{ $order->paymentMethod->name ?? 'N/A' }}</span>
                    </div>
                    @php
                        try {
                            $totalPoints = \App\Models\LoyaltyPoint::getUserTotalPoints(auth()->id());
                        } catch (\Exception $e) {
                            $totalPoints = 0;
                        }
                    @endphp
                    @if($totalPoints > 0)
                        <div class="flex items-center justify-between pt-3 border-t border-slate-700">
                            <span class="text-slate-400">Tus puntos:</span>
                            <span class="text-amber-400 font-bold">{{ $totalPoints }} puntos</span>
                        </div>
                    @endif
                    @if($order->estimated_time)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Tiempo estimado:</span>
                            <span class="text-white font-medium">{{ $order->estimated_time }} minutos</span>
                        </div>
                    @endif
                    @if($order->notes)
                        <div>
                            <span class="text-slate-400 block mb-2">Notas:</span>
                            <p class="text-white">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Resumen</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Subtotal:</span>
                        <span class="text-white font-medium">Bs. {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Impuesto (13%):</span>
                        <span class="text-white font-medium">Bs. {{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="border-t border-slate-700 pt-3 mt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-white">Total:</span>
                            <span class="text-xl font-bold text-emerald-400">Bs. {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Productos</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center gap-4 pb-4 border-b border-slate-800 last:border-0">
                        @if($item->product->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}" 
                                 alt="{{ $item->product->name }}"
                                 class="h-20 w-20 rounded-lg object-cover">
                        @else
                            <div class="h-20 w-20 rounded-lg bg-slate-800 flex items-center justify-center text-slate-500 text-xs">
                                Sin imagen
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-semibold text-white">{{ $item->product->name }}</h3>
                            <p class="text-sm text-slate-400">Cantidad: {{ $item->quantity }} × Bs. {{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <p class="font-semibold text-emerald-400">Bs. {{ number_format($item->subtotal, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($order->status == 'entregado')
            <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-900/80 p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Valora tu Experiencia</h2>
                <p class="text-sm text-slate-400 mb-4">Ayúdanos a mejorar calificando los productos que pediste</p>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        @php
                            try {
                                $existingRating = \App\Models\ProductRating::where('user_id', auth()->id())
                                    ->where('product_id', $item->product_id)
                                    ->where('order_id', $order->id)
                                    ->first();
                            } catch (\Exception $e) {
                                $existingRating = null;
                            }
                        @endphp
                        @if(!$existingRating)
                            <div class="rounded-xl border border-slate-800 bg-slate-800/50 p-4">
                                <div class="flex items-center gap-4 mb-3">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/'.$item->product->image) }}" 
                                             alt="{{ $item->product->name }}"
                                             class="h-16 w-16 rounded-lg object-cover">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-slate-700 flex items-center justify-center text-slate-500 text-xs">
                                            Sin imagen
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-white">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-slate-400">Cantidad: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('client.ratings.store') }}" method="POST" class="space-y-3" id="ratingForm{{ $item->id }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div>
                                        <label class="block text-sm text-slate-300 mb-2">Calificación</label>
                                        <div class="flex gap-2" id="ratingStars{{ $item->id }}">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer">
                                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                                    <svg class="h-8 w-8 text-slate-600 peer-checked:text-amber-400 hover:text-amber-300 transition" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-slate-300 mb-2">Comentario (opcional)</label>
                                        <textarea name="comment" rows="2" 
                                                  class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-white text-sm focus:border-emerald-500 focus:outline-none focus:ring focus:ring-emerald-500/20"
                                                  placeholder="¿Qué te pareció este producto?"></textarea>
                                    </div>
                                    <button type="submit" 
                                            class="w-full rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                                        Enviar Valoración
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="rounded-xl border border-slate-800 bg-slate-800/50 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="h-12 w-12 rounded-lg object-cover">
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-white">{{ $item->product->name }}</h3>
                                            <div class="flex items-center gap-1 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="h-4 w-4 {{ $i <= $existingRating->rating ? 'text-amber-400' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-sm text-slate-400">Ya valorado</span>
                                </div>
                                @if($existingRating->comment)
                                    <p class="text-sm text-slate-300 mt-2 italic">"{{ $existingRating->comment }}"</p>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </main>
</body>
</html>

