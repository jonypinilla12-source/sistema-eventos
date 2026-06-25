@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 transition text-sm flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Volver al listado
            </a>
            <h1 class="text-2xl font-bold text-slate-800 mt-2">Gestionar Itinerario</h1>
            <p class="text-slate-500 text-sm">Evento: <span class="font-semibold text-indigo-600">{{ $evento->nombre_evento }}</span></p>
        </div>
        
        <button type="button" onclick="agregarFila()" class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl hover:bg-indigo-100 transition font-bold text-sm flex items-center">
            <i class="fas fa-plus mr-2"></i> Agregar Actividad
        </button>
    </div>

    @if(session('exito'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
            {{ session('exito') }}
        </div>
    @endif

    <form action="{{ route('eventos.itinerario.guardar', $evento->evento_id) }}" method="POST">
        @csrf
        <div id="contenedor-itinerario" class="space-y-4">
            {{-- Cargamos los hitos existentes si los hay --}}
            @forelse($evento->itinerarios as $item)
                <div class="fila-itinerario grid grid-cols-1 md:grid-cols-12 gap-4 bg-white p-5 rounded-2xl border shadow-sm items-start relative group">
                    <div class="md:col-span-3">
                        <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Hora</label>
                        <input type="time" name="hora[]" value="{{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 outline-none focus:border-indigo-500 text-sm" required>
                    </div>
                    <div class="md:col-span-8">
                        <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Actividad / Hito</label>
                        <input type="text" name="actividad[]" value="{{ $item->actividad }}" placeholder="Ej: Bienvenida, Almuerzo, Charla..." class="w-full px-3 py-2 rounded-lg border border-slate-200 outline-none focus:border-indigo-500 text-sm" required>
                        <input type="text" name="descripcion[]" value="{{ $item->descripcion }}" placeholder="Descripción opcional..." class="w-full mt-2 px-3 py-1.5 rounded-lg border border-slate-100 outline-none focus:border-indigo-500 text-xs bg-slate-50">
                    </div>
                    <div class="md:col-span-1 flex justify-center pt-6">
                        <button type="button" onclick="eliminarFila(this)" class="text-slate-300 hover:text-red-500 transition p-2">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            @empty
                {{-- Si no hay nada, mostramos una fila vacía para empezar --}}
                <div id="estado-vacio" class="text-center py-12 bg-slate-50 rounded-2xl border-2 border-dashed">
                    <i class="fas fa-clock text-4xl text-slate-200 mb-4"></i>
                    <p class="text-slate-400">No hay actividades programadas.<br>Haz clic en "Agregar Actividad" para comenzar.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10 flex justify-center">
            <button type="submit" class="bg-indigo-600 text-white px-12 py-3 rounded-2xl font-bold hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all transform active:scale-95">
                Guardar Itinerario Completo
            </button>
        </div>
    </form>
</div>

{{-- Template oculto para las nuevas filas --}}
<template id="plantilla-fila">
    <div class="fila-itinerario grid grid-cols-1 md:grid-cols-12 gap-4 bg-white p-5 rounded-2xl border shadow-sm items-start animate-fade-in">
        <div class="md:col-span-3">
            <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Hora</label>
            <input type="time" name="hora[]" class="w-full px-3 py-2 rounded-lg border border-slate-200 outline-none focus:border-indigo-500 text-sm" required>
        </div>
        <div class="md:col-span-8">
            <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Actividad / Hito</label>
            <input type="text" name="actividad[]" placeholder="Ej: Bienvenida, Almuerzo..." class="w-full px-3 py-2 rounded-lg border border-slate-200 outline-none focus:border-indigo-500 text-sm" required>
            <input type="text" name="descripcion[]" placeholder="Descripción opcional..." class="w-full mt-2 px-3 py-1.5 rounded-lg border border-slate-100 outline-none focus:border-indigo-500 text-xs bg-slate-50">
        </div>
        <div class="md:col-span-1 flex justify-center pt-6">
            <button type="button" onclick="eliminarFila(this)" class="text-slate-300 hover:text-red-500 transition p-2">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
</template>

<script>
    function agregarFila() {
        const contenedor = document.getElementById('contenedor-itinerario');
        const estadoVacio = document.getElementById('estado-vacio');
        
        if (estadoVacio) {
            estadoVacio.remove();
        }

        const plantilla = document.getElementById('plantilla-fila').content.cloneNode(true);
        contenedor.appendChild(plantilla);
    }

    function eliminarFila(btn) {
        if(confirm('¿Estás seguro de quitar esta actividad?')) {
            btn.closest('.fila-itinerario').remove();
        }
    }
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection