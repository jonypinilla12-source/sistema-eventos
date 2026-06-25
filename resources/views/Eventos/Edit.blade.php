@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-6">
        <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 transition text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Configuración del Evento</h1>
        <p class="text-slate-500 text-sm">Editando: {{ $evento->nombre_evento }}</p>
    </div>

    {{-- Cambiamos a ROUTE UPDATE y agregamos METHOD PUT --}}
    <form action="{{ route('eventos.update', $evento->evento_id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border p-8 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- BLOQUE NOMBRE Y SLUG --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre del Evento</label>
                <input type="text" id="nombre_evento" name="nombre_evento" value="{{ $evento->nombre_evento }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">URL de la Invitación (Slug)</label>
                <input type="text" id="slug" name="slug" readonly value="{{ $evento->slug }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none focus:border-indigo-500 transition font-mono text-sm" required>
                <p class="text-[10px] text-slate-400 mt-1">Ej: tusitio.com/eventos/<strong><span id="slug-preview">{{ $evento->slug }}</span></strong></p>
            </div>

            {{-- BLOQUE ANFITRIÓN RESPONSABLE --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Anfitrión Responsable</label>
                <select name="anfitrion_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition @if(auth()->user()->rol_id != 1) bg-slate-100 text-slate-400 cursor-not-allowed @endif" required @if(auth()->user()->rol_id != 1) disabled @endif>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->usuario_id }}" {{ $evento->anfitrion_id == $u->usuario_id ? 'selected' : '' }}>
                            {{ $u->nombre }}
                        </option>
                    @endforeach
                </select>
                
                {{-- Si NO es Admin, el select está deshabilitado, así que enviamos el valor oculto --}}
                @if(auth()->user()->rol_id != 1)
                    <input type="hidden" name="anfitrion_id" value="{{ $evento->anfitrion_id }}">
                @endif
            </div>

            {{-- BLOQUE TIPO DE EVENTO --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tipo de Evento</label>
                <select id="tipo_evento_id" name="tipo_evento_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition @if(auth()->user()->rol_id != 1) bg-slate-100 text-slate-400 cursor-not-allowed @endif" required @if(auth()->user()->rol_id != 1) disabled @endif>
                    @foreach($tipos as $t)
                        <option value="{{ $t->tipo_evento_id }}" {{ $evento->tipo_evento_id == $t->tipo_evento_id ? 'selected' : '' }}>
                            {{ $t->nombre }}
                        </option>
                    @endforeach
                </select>

                {{-- Si NO es Admin, enviamos el valor oculto --}}
                @if(auth()->user()->rol_id != 1)
                    <input type="hidden" name="tipo_evento_id" value="{{ $evento->tipo_evento_id }}">
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha del Evento</label>
                <input type="date" name="fecha_principal" value="{{ $evento->fecha_principal }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Hora del Evento</label>
                <input type="time" name="hora" value="{{ \Carbon\Carbon::parse($evento->hora)->format('H:i') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">
            </div>

            {{-- Campo Nacimiento: se mostrará con el JS abajo si es Memorial --}}
            <div id="div_nacimiento" style="{{ str_contains(strtolower($evento->tipo->nombre), 'memorial') ? '' : 'display: none;' }}">
                <label class="block text-sm font-semibold text-indigo-600 mb-2">Fecha de Nacimiento (Solo Memorial)</label>
                <input type="date" name="fecha_nacimiento" value="{{ $evento->fecha_nacimiento }}" class="w-full px-4 py-3 rounded-xl border border-indigo-200 bg-indigo-50 outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        <hr class="border-slate-100">

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Biografía o Resumen Informativo</label>
            <textarea name="biografia_resumen" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">{{ $evento->biografia_resumen }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ubicación (Nombre del lugar)</label>
                <input type="text" name="ubicacion_texto" value="{{ $evento->ubicacion_texto }}" placeholder="Ej: Parroquia Central" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Link Google Maps</label>
                <input type="url" name="google_maps_url" value="{{ $evento->google_maps_url }}" placeholder="https://goo.gl/maps/..." class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        {{-- SECCIONES DE PLANTILLAS --}}
        <div id="secciones_dinamicas">
            
            {{-- MATRIMONIO --}}
            <div id="seccion_plantillas_matrimonio" class="{{ str_contains(strtolower($evento->tipo->nombre), 'matrimonio') ? '' : 'hidden' }} space-y-6 pt-4">
                <label class="block text-sm font-semibold text-slate-700 mb-4">Seleccionar Diseño</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    @php
                        $mats = [
                            ['val' => 'Matrimonio', 'nom' => 'Editorial', 'sub' => 'Minimalista', 'img' => 'plantilla1.png'],
                            ['val' => 'Matrimonio2', 'nom' => 'Gala Real', 'sub' => 'Negro y Oro', 'img' => 'plantilla2.png'],
                            ['val' => 'Matrimonio3', 'nom' => 'Boho Chic', 'sub' => 'Orgánico', 'img' => 'plantilla3.png'],
                            ['val' => 'Matrimonio4', 'nom' => 'Estreno', 'sub' => 'Cinematográfico', 'img' => 'plantilla4.png'],
                            ['val' => 'Matrimonio5', 'nom' => 'Pop Art', 'sub' => 'Cómic Retro', 'img' => 'plantilla5.png'],
                            ['val' => 'Matrimonio6', 'nom' => 'UCM', 'sub' => 'MARVEL', 'img' => 'plantilla6.png'],
                            ['val' => 'Matrimonio7', 'nom' => 'DC', 'sub' => 'Superhéroes', 'img' => 'plantilla7.png'],
                            ['val' => 'Matrimonio8', 'nom' => 'Romance Minimalista', 'sub' => 'Mágico', 'img' => 'plantilla8.png'],
                            ['val' => 'Matrimonio9', 'nom' => 'Magia', 'sub' => 'Encantadora', 'img' => 'plantilla9.png'],
                            ['val' => 'Matrimonio10', 'nom' => 'Jardin', 'sub' => 'Natural', 'img' => 'plantilla10.png']
                        ];
                    @endphp
                    @foreach($mats as $m)
                    <label class="relative group cursor-pointer">
                        <input type="radio" name="id_plantilla" value="{{ $m['val'] }}" class="peer sr-only" {{ $evento->id_plantilla == $m['val'] ? 'checked' : '' }}>
                        <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                            <div class="aspect-[3/4] rounded-xl bg-slate-100 mb-3 overflow-hidden">
                                <img src="{{ asset('img/plantillas/'.$m['img']) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="px-2 pb-2 text-center">
                                <p class="font-bold text-sm text-slate-800">{{ $m['nom'] }}</p>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- MEMORIAL --}}
            <div id="seccion_plantillas_memorial" class="{{ str_contains(strtolower($evento->tipo->nombre), 'memorial') ? '' : 'hidden' }} space-y-6 pt-4 border-t">
                <label class="block text-sm font-semibold text-slate-700 mb-4">Diseño de Memorial</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(['Memorial' => 'Paz Eterna', 
                    'Memorial2' => 'Legado de Luz', 
                    'Memorial3' => 'Bosque del Recuerdo',
                    'Memorial4' => 'Cielo Estrellado',
                    'Memorial5' => 'Luz eterna',
                    'Memorial6' => 'Minimalista Noir'] 
                    as $val => $nom)
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="id_plantilla" value="{{ $val }}" class="peer sr-only" {{ $evento->id_plantilla == $val ? 'checked' : '' }}>
                        <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                            <img src="{{ asset('img/plantillas/'.$val.'.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                            <p class="text-center text-[10px] mt-1 font-bold">{{ $nom }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- CORPORATIVO --}}
            <div id="seccion_plantillas_corporativas" class="{{ (str_contains(strtolower($evento->tipo->nombre), 'corporativo') || str_contains(strtolower($evento->tipo->nombre), 'evento')) ? '' : 'hidden' }} space-y-6 pt-4 border-t">
                <label class="block text-sm font-semibold text-slate-700 mb-4">Diseño de Evento</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(['Corporativo' => 'Business Summit (Estándar/Moderno)', 
                    'Corporativo2' => 'Vista Zen (Minimalista/Relajante)', 
                    'Corporativo3' => 'Cyber Tech (Estilo Terminal/Hacker)',
                    'Corporativo4' => 'Gala Ejecutiva (Lujo Negro y Oro)',
                    'Corporativo5' => 'Innovación SaaS (Estilo Apple/Mesh)',
                    'Corporativo6' => 'Startup Creativa (Divertido/Team Building)',] 
                        as $val => $nom)
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="id_plantilla" value="{{ $val }}" class="peer sr-only" {{ $evento->id_plantilla == $val ? 'checked' : '' }}>
                        <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                            <img src="{{ asset('img/plantillas/'.$val.'.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                            <p class="text-center text-[10px] mt-1 font-bold">{{ $nom }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="pt-6 border-t flex justify-end gap-4">
            <a href="{{ route('eventos.index') }}" class="px-10 py-3 rounded-xl font-bold border border-slate-200 text-slate-500 hover:bg-slate-50 transition">Cancelar</a>
            <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition-all">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
    // Lógica para auto-completar el Slug cuando se escribe el nombre del evento
    document.getElementById('nombre_evento').addEventListener('input', function() {
        let slug = this.value.toLowerCase().trim()
            .replace(/[áäâà]/g, 'a')
            .replace(/[éëêè]/g, 'e')
            .replace(/[íïîì]/g, 'i')
            .replace(/[óöôò]/g, 'o')
            .replace(/[úüûù]/g, 'u')
            .replace(/[ñ]/g, 'n')
            .replace(/[^a-z0-9\s-]/g, '') // Elimina caracteres especiales
            .replace(/[\s-]+/g, '-');     // Reemplaza espacios por guiones

        document.getElementById('slug').value = slug;
        document.getElementById('slug-preview').innerText = slug || '...';
    });

    // Lógica para actualizar visualmente la preview si se edita el slug manualmente
    document.getElementById('slug').addEventListener('input', function() {
        let slug = this.value.toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-');
        document.getElementById('slug-preview').innerText = slug || '...';
    });

    // Reutilizamos tu lógica de JS para las plantillas
    document.getElementById('tipo_evento_id').addEventListener('change', function() {
        const texto = this.options[this.selectedIndex].text.toLowerCase();
        
        const campoNacimiento = document.getElementById('div_nacimiento');
        const seccionMatrimonio = document.getElementById('seccion_plantillas_matrimonio');
        const seccionMemorial = document.getElementById('seccion_plantillas_memorial');
        const seccionCorporativo = document.getElementById('seccion_plantillas_corporativas');

        campoNacimiento.style.display = 'none';
        seccionMatrimonio.classList.add('hidden');
        seccionMemorial.classList.add('hidden');
        seccionCorporativo.classList.add('hidden');
        seccionMatrimonio.style.display = 'none';
        seccionMemorial.style.display = 'none';
        seccionCorporativo.style.display = 'none';

        if (texto.includes('memorial')) {
            campoNacimiento.style.display = 'block';
            seccionMemorial.style.display = 'block';
            seccionMemorial.classList.remove('hidden');
        } else if (texto.includes('matrimonio')) {
            seccionMatrimonio.style.display = 'block';
            seccionMatrimonio.classList.remove('hidden');
        } else if (texto.includes('corporativo') || texto.includes('evento')) {
            seccionCorporativo.style.display = 'block';
            seccionCorporativo.classList.remove('hidden');
        }
    });
</script>
@endsection