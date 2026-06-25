@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-slate-800">Gestión de Roles</h1>

    <div class="bg-white p-6 rounded-xl shadow-sm border mb-6">
        <form action="{{ route('roles.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="nombre_rol" placeholder="Ej: Administrador, Editor..." class="flex-1 border rounded-lg px-4" required>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Guardar Rol</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre del Rol</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $rol)
                <tr class="border-b">
                    <td class="p-4">{{ $rol->rol_id }}</td>
                    <td class="p-4 font-medium">{{ $rol->nombre_rol }}</td>
                    <td class="p-4 text-center">
                        <form action="{{ route('roles.destroy', $rol->rol_id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection