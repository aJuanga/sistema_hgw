@if(Auth::user()->isJefa())
<x-jefa-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] bg-gradient-to-r from-emerald-600 to-amber-600 bg-clip-text text-transparent font-bold">Gestión de Pedidos</p>
            <h1 class="text-4xl font-bold text-gray-900">Pedidos</h1>
            <p class="text-base text-gray-600">Administra y monitorea todos los pedidos del sistema</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @include('orders.partials.content')
</x-jefa-layout>
@elseif(Auth::user()->isEmpleado())
<x-employee-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">Gestión</p>
            <h1 class="text-4xl font-bold text-slate-900">Pedidos</h1>
            <p class="text-base text-slate-600">Administra y monitorea todos los pedidos del sistema</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @include('orders.partials.content')
</x-employee-layout>
@elseif(Auth::user()->isAdmin())
<x-admin-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 font-semibold">Gestión</p>
            <h1 class="text-4xl font-bold text-gray-900">Pedidos</h1>
            <p class="text-base text-gray-600">Administra y monitorea todos los pedidos del sistema</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @include('orders.partials.content')
</x-admin-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">Gestión</p>
            <h1 class="text-4xl font-bold text-slate-900">Pedidos</h1>
            <p class="text-base text-slate-600">Administra y monitorea todos los pedidos del sistema</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @include('orders.partials.content')
</x-app-layout>
@endif
