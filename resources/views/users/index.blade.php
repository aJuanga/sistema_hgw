<x-app-layout>
    <x-slot name="header">
        Usuarios
    </x-slot>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Usuario
        </a>
    </div>

    <div>
        @if(session('success'))
            <div class="bg-gray-100 border border-gray-400 text-gray-900 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gray-100 border border-gray-400 text-gray-900 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm rounded">
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Telefono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Ultimo Login</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-200 text-gray-900">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @if($user->last_login)
                                        {{ $user->last_login->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-gray-400">Nunca</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-200 text-gray-900">
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-300 text-gray-700">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" class="text-gray-700 hover:text-gray-900">Editar</a>

                                    @php
                                        $userRoleSlug = $user->roles->first()->slug ?? '';
                                        $isProtected = in_array($userRoleSlug, ['jefa', 'administrador', 'empleado']);
                                    @endphp

                                    @if($isProtected)
                                        <span class="text-gray-400 text-xs">(Protegido)</span>
                                    @else
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Estas seguro de eliminar este cliente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-700 hover:text-gray-900">Eliminar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No hay usuarios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
