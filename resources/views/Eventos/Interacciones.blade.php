@extends('layouts.app')

@section('content')
@php
    // Identificamos la naturaleza del evento para adaptar los textos de la interfaz
    $tipoEvento = strtolower($evento->tipo->nombre);
    $esMemorial = $tipoEvento === 'memorial';
    $esMatrimonio = $tipoEvento === 'matrimonio' || str_contains($tipoEvento, 'boda');

    // Seteamos los títulos dinámicos según el tipo de evento
    if ($esMemorial) {
        $subtituloSub = "Gestiona los mensajes enviados al memorial de:";
        $textoEmptyTitulo = "No hay dedicatorias registradas";
        $textoEmptyDesc = "Los lamentos que escriban los allegados aparecerán en este buzón para tu revisión.";
    } elseif ($esMatrimonio) {
        $subtituloSub = "Gestiona las felicitaciones enviadas al matrimonio de:";
        $textoEmptyTitulo = "No hay felicitaciones registradas";
        $textoEmptyDesc = "Los buenos deseos que escriban los invitados aparecerán en este buzón para tu revisión.";
    } else {
        // Opción genérica por si creas eventos corporativos o aniversarios
        $subtituloSub = "Gestiona los comentarios enviados al evento de:";
        $textoEmptyTitulo = "No hay mensajes registrados";
        $textoEmptyDesc = "Los comentarios que escriban los asistentes aparecerán en este buzón para tu revisión.";
    }
@endphp

<div class="max-w-6xl mx-auto py-6">
    
    {{-- Encabezado --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 transition text-sm flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i> Volver al panel
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Moderación del Muro de Mensajes</h1>
            <p class="text-slate-500 text-sm">{{ $subtituloSub }} <strong class="text-slate-700">{{ $evento->nombre_evento }}</strong></p>
        </div>
    </div>

    @if(session('exito'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
            {{ session('exito') }}
        </div>
    @endif

    {{-- Contenedor principal --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="font-bold text-slate-700 flex items-center">
                <i class="fa-solid fa-inbox text-indigo-500 mr-2"></i> Mensajes del Libro Digital
            </h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($evento->interacciones as $item)
                <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 transition hover:bg-slate-50/30">
                    
                    {{-- Información de la Dedicatoria --}}
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="font-bold text-slate-800 text-base">{{ $item->nombre_autor }}</span>
                            <span class="bg-slate-100 text-slate-600 text-[10px] px-2.5 py-0.5 rounded-md font-semibold font-sans">
                                {{ $item->vinculo_autor ?? 'Asistente' }}
                            </span>
                            
                            {{-- Badge de Estado --}}
                            @if($item->aprobado)
                                <span class="bg-emerald-50 text-emerald-600 text-[10px] px-2 py-0.5 rounded-md font-bold flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i> Publicado
                                </span>
                            @else
                                <span class="bg-amber-50 text-amber-600 text-[10px] px-2 py-0.5 rounded-md font-bold flex items-center animate-pulse">
                                    <i class="fas fa-clock mr-1"></i> Pendiente
                                </span>
                            @endif
                        </div>

                        <p class="text-slate-600 italic text-sm bg-slate-50/40 p-4 rounded-xl border border-dashed border-slate-100 leading-relaxed">
                            "{{ $item->contenido_texto }}"
                        </p>

                        {{-- Si adjuntó foto de OneDrive, mostramos una miniatura de control --}}
                        @if($item->url_onedrive)
                            <div class="pt-1">
                                <a href="{{ $item->url_onedrive }}" target="_blank" class="inline-flex items-center space-x-2 text-xs text-indigo-600 hover:text-indigo-800 underline font-semibold bg-indigo-50/50 px-3 py-1.5 rounded-lg border border-indigo-100 transition">
                                    <i class="fa-regular fa-image text-sm"></i>
                                    <span>Ver imagen adjunta en OneDrive</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Acciones de Moderación --}}
                    <div class="flex items-center space-x-2 w-full md:w-auto justify-end">
                        @if(!$item->aprobado)
                            {{-- Botón para Aprobar (Pasa a 1) --}}
                            <form action="{{ route('interacciones.aprobar', $item->interaccion_id) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                <button type="submit" class="w-full md:w-auto bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-700 transition flex items-center justify-center space-x-1 shadow-sm shadow-emerald-100">
                                    <i class="fas fa-check mr-1"></i>
                                    <span>Aprobar y Publicar</span>
                                </button>
                            </form>
                        @else
                            {{-- Botón para Ocultar (Pasa a 0) --}}
                            <form action="{{ route('interacciones.desaprobar', $item->interaccion_id) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                <button type="submit" class="w-full md:w-auto bg-rose-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-rose-600 transition flex items-center justify-center space-x-1 shadow-sm shadow-rose-100" title="Quitar de la vista pública">
                                    <i class="fas fa-eye-slash mr-1"></i>
                                    <span>Ocultar del Muro</span>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @empty
                {{-- SECCIÓN MODIFICADA: Textos completamente dinámicos basados en la condicional de arriba --}}
                <div class="p-12 text-center text-slate-400 font-light space-y-2">
                    <i class="fa-regular fa-comment-dots text-4xl block text-slate-200"></i>
                    <p class="text-sm font-semibold text-slate-500">{{ $textoEmptyTitulo }}</p>
                    <p class="text-xs">{{ $textoEmptyDesc }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection