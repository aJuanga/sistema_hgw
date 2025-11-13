@php
    $user = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthy Glow Wellness') }} - Reseñas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-slate-950/90 border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/50">
                        HGW
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-emerald-400 font-semibold">Healthy Glow</p>
                        <p class="text-sm text-slate-400 -mt-0.5">Wellness</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('client.dashboard') }}"
                       class="inline-flex items-center space-x-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2 text-sm font-medium text-slate-200 backdrop-blur transition hover:bg-slate-700/50 hover:border-emerald-500/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="relative overflow-hidden pt-16 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-8">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">Reseñas de Clientes</h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                    Descubre lo que nuestros clientes piensan sobre Healthy Glow Wellness
                </p>
            </div>

            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="rounded-2xl border border-amber-500/30 bg-amber-500/10 backdrop-blur-xl p-6 text-center">
                    <p class="text-sm uppercase tracking-wider text-amber-400 font-semibold mb-2">Calificación Promedio</p>
                    <p class="text-5xl font-bold text-white mb-2">{{ number_format($stats['average'], 1) }}</p>
                    <div class="flex items-center justify-center space-x-1 mb-2">
                        @php
                            $avgRating = $stats['average'];
                            $fullStars = floor($avgRating);
                            $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $fullStars)
                                <svg class="h-6 w-6 text-amber-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @elseif ($i == $fullStars + 1 && $hasHalfStar)
                                <svg class="h-6 w-6 text-amber-400" viewBox="0 0 24 24">
                                    <defs>
                                        <linearGradient id="half-{{ $i }}">
                                            <stop offset="50%" stop-color="currentColor"/>
                                            <stop offset="50%" stop-color="transparent"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-{{ $i }})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    <path fill="none" stroke="currentColor" stroke-width="1.5" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-slate-600 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <p class="text-sm text-slate-400">de 5 estrellas</p>
                </div>

                <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 backdrop-blur-xl p-6 text-center">
                    <p class="text-sm uppercase tracking-wider text-emerald-400 font-semibold mb-2">Total Reseñas</p>
                    <p class="text-5xl font-bold text-white mb-2">{{ $stats['total'] }}</p>
                    <p class="text-sm text-slate-400">clientes opinaron</p>
                </div>

                <div class="rounded-2xl border border-blue-500/30 bg-blue-500/10 backdrop-blur-xl p-6">
                    <p class="text-sm uppercase tracking-wider text-blue-400 font-semibold mb-3">Distribución</p>
                    @foreach([5,4,3,2,1] as $star)
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm text-slate-300 w-8">{{ $star }}★</span>
                            <div class="flex-1 h-2 bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-amber-600 rounded-full transition-all duration-500"
                                     style="width: {{ $stats['distribution'][$star]['percentage'] }}%"></div>
                            </div>
                            <span class="text-xs text-slate-400 w-12 text-right">{{ $stats['distribution'][$star]['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <!-- Reviews List -->
    <section class="relative bg-slate-950 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($ratings->count() > 0)
                <div class="space-y-6">
                    @foreach($ratings as $rating)
                        <article class="rounded-2xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-xl p-6 transition hover:border-emerald-500/30">
                            <div class="flex items-start gap-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">{{ $rating->user->name }}</h3>
                                            <p class="text-sm text-slate-400">{{ $rating->created_at->diffForHumans() }}</p>
                                        </div>

                                        <!-- Rating Stars -->
                                        <div class="flex items-center space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating->rating)
                                                    <svg class="h-5 w-5 text-amber-400 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5 text-slate-600 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    @if($rating->comment)
                                        <p class="text-slate-300 leading-relaxed">{{ $rating->comment }}</p>
                                    @else
                                        <p class="text-slate-500 italic">Sin comentario</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $ratings->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/50 backdrop-blur-xl p-12 text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-800/50 mb-4">
                        <svg class="h-8 w-8 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Aún no hay reseñas</h3>
                    <p class="text-sm text-slate-400 mb-6">Sé el primero en calificar nuestra cafetería</p>
                    <a href="{{ route('client.dashboard') }}"
                       class="inline-flex items-center space-x-2 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 transition hover:from-emerald-600 hover:to-emerald-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span>Dejar una Reseña</span>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-800/50 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                <p>&copy; {{ now()->year }} Healthy Glow Wellness. Todos los derechos reservados.</p>
                <div class="flex flex-wrap gap-6">
                    <a href="#" class="transition hover:text-emerald-400">Política de bienestar</a>
                    <a href="#" class="transition hover:text-emerald-400">Términos</a>
                    <a href="#" class="transition hover:text-emerald-400">Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
