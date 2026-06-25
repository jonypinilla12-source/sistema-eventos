@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tipos de Eventos</h1>
        <a href="{{ route('tipos.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition shadow-sm">
            + Nuevo Tipo
        </a>
    </div>

    @if(session('exito'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm animate-pulse">
            {{ session('exito') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold tracking-wider border-b">
                    <th class="py-4 px-6 text-left">ID</th>
                    <th class="py-4 px-6 text-left">Nombre de Categoría</th>
                    <th class="py-4 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($tipos as $tipo)
                <tr class="border-b border-gray-100 hover:bg-indigo-50/30 transition">
                    <td class="py-4 px-6 text-left whitespace-nowrap font-medium text-gray-900">
                        {{ $tipo->tipo_evento_id }}
                    </td>
                    <td class="py-4 px-6 text-left">
                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold">
                            {{ $tipo->nombre }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{ route('tipos.edit', $tipo->tipo_evento_id) }}" class="text-purple-500 hover:text-purple-700 transform hover:scale-125 transition" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>

                            <form action="{{ route('tipos.destroy', $tipo->tipo_evento_id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transform hover:scale-125 transition" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <p class="text-gray-400 text-xs mt-6 italic">
        * Estos tipos definen el comportamiento de las plantillas del sistema.
    </p>
</div>
@endsection