@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-slate-800">Gestión de Usuarios</h1>

    <div class="bg-white p-6 rounded-xl shadow-sm border mb-8">
        <form action="{{ route('usuarios.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select name="rol_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->rol_id }}">{{ $rol->nombre_rol }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 shadow-sm transition">
                    <i class="fas fa-user-plus mr-2"></i> Crear Usuario
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4 text-xs font-bold uppercase text-slate-500">Nombre</th>
                    <th class="p-4 text-xs font-bold uppercase text-slate-500">Email</th>
                    <th class="p-4 text-xs font-bold uppercase text-slate-500">Rol</th>
                    <th class="p-4 text-xs font-bold uppercase text-slate-500 text-center">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($usuarios as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-slate-700">{{ $user->nombre }}</td>
                    <td class="p-4 text-slate-500">{{ $user->email }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-md bg-purple-100 text-purple-700 text-xs font-bold">
                            {{ $user->rol->nombre_rol }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="{{ $user->estado ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas fa-circle text-[10px] mr-1"></i>
                            {{ $user->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection