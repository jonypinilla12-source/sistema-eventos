@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-6">
        <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 transition text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Configuración del Evento</h1>
    </div>

    <form action="{{ route('eventos.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border p-8 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre del Evento</label>
                <input type="text" name="nombre_evento" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Anfitrión Responsable</label>
                <select name="anfitrion_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition" required>
                    <option value="">Seleccionar usuario...</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->usuario_id }}">{{ $u->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tipo de Evento</label>
                <select id="tipo_evento_id" name="tipo_evento_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition" required>
                    <option value="">Seleccionar tipo...</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t->tipo_evento_id }}">{{ $t->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha del Evento</label>
                <input type="date" name="fecha_principal" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Hora del Evento</label>
                <input type="time" name="hora" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">
            </div>

            <div id="div_nacimiento" style="display: none;">
                <label class="block text-sm font-semibold text-indigo-600 mb-2">Fecha de Nacimiento (Solo Memorial)</label>
                <input type="date" name="fecha_nacimiento" class="w-full px-4 py-3 rounded-xl border border-indigo-200 bg-indigo-50 outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        <hr class="border-slate-100">

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Biografía o Resumen Informativo</label>
            <textarea name="biografia_resumen" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ubicación (Nombre del lugar)</label>
                <input type="text" name="ubicacion_texto" placeholder="Ej: Parroquia Central" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Link Google Maps</label>
                <input type="url" name="google_maps_url" placeholder="https://goo.gl/maps/..." class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        {{-- SECCIÓN DINÁMICA: Solo aparece si eligen Matrimonio --}}
        <div id="seccion_plantillas_matrimonio" class="hidden space-y-6 pt-4">
            <label class="block text-sm font-semibold text-slate-700 mb-4">Seleccionar Diseño (Vista Previa)</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                
                {{-- Plantilla 1: Editorial --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio" class="peer sr-only" checked>
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-slate-100 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla1.png') }}" alt="Editorial" class="w-full h-full object-cover">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Editorial</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Minimalista</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 2: Gala Real --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio2" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-slate-900 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla2.png') }}" alt="Gala Real" class="w-full h-full object-cover">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Gala Real</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Negro y Oro</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 3: Boho Chic --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio3" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-orange-50 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla3.png') }}" alt="Boho Chic" class="w-full h-full object-cover">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Boho Chic</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Orgánico</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 4: Cinema --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio4" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-blue-900 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla4.png') }}" alt="Cinema" class="w-full h-full object-cover">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Estreno</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Cinematográfico</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 5: Pop Art --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio5" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-yellow-400 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla5.png') }}" alt="Pop Art" class="w-full h-full object-cover border-2 border-black">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Pop Art</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Cómic Retro</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 6: UCM/MARVEL --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio6" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-yellow-400 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla6.png') }}" alt="UCM/MARVEL" class="w-full h-full object-cover border-2 border-black">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">UCM</p>
                            <p class="text-[10px] text-slate-500 leading-tight">MARVEL</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 7: DC --}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio7" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-yellow-400 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla7.png') }}" alt="DC" class="w-full h-full object-cover border-2 border-black">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">DC</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Superhéroes</p>
                        </div>
                    </div>
                </label>

                {{-- Plantilla 8:--}}
                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio8" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-yellow-400 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla8.png') }}" alt="DC" class="w-full h-full object-cover border-2 border-black">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Romance</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Minimalista</p>
                        </div>
                    </div>
                </label>

                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio9" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-yellow-400 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla9.png') }}" alt="DC" class="w-full h-full object-cover border-2 border-black">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Magia</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Encantadora</p>
                        </div>
                    </div>
                </label>

                <label class="relative group cursor-pointer">
                    <input type="radio" name="id_plantilla" value="matrimonio10" class="peer sr-only">
                    <div class="overflow-hidden rounded-2xl border-2 border-slate-100 bg-white p-2 transition-all peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-100 shadow-sm hover:shadow-md">
                        <div class="aspect-[3/4] rounded-xl bg-yellow-400 mb-3 overflow-hidden">
                            <img src="{{ asset('img/plantillas/plantilla10.png') }}" alt="Jardin" class="w-full h-full object-cover border-2 border-black">
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <p class="font-bold text-sm text-slate-800">Jardin</p>
                            <p class="text-[10px] text-slate-500 leading-tight">Natural</p>
                        </div>
                    </div>
                </label>

            </div>
        </div>

        {{-- SECCIÓN DINÁMICA: PLANTILLAS DE MEMORIAL --}}
        <div id="seccion_plantillas_memorial" class="hidden space-y-6 pt-4 border-t">
            <label class="block text-sm font-semibold text-slate-700 mb-4">Seleccionar Diseño de Memorial</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Memorial 1 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial.png') }}" class="aspect-[3/4] object-cover rounded-lg grayscale">
                        <p class="text-center text-[10px] mt-1 font-bold">Paz Eterna</p>
                    </div>
                </label>

                {{-- Memorial 2 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial2" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial2.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Legado de Luz</p>
                    </div>
                </label>

                {{-- Memorial 3 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial3" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial3.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Bosque del Recuerdo</p>
                    </div>
                </label>

                {{-- Memorial 4 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial4" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial4.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Cielo Estrellado</p>
                    </div>
                </label>

                {{-- Memorial 5 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial5" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial5.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Luz eterna</p>
                    </div>
                    </div>
                </label>

                {{-- Memorial 6 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial6" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial6.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Minimalista Noir</p>
                    </div>
                    </div>
                </label>

                {{-- Memorial 7 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Memorial7" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Memorial7.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Baby/Infantil</p>
                    </div>
                    </div>
                </label>

            </div>
        </div>

        {{-- SECCIÓN DINÁMICA: PLANTILLAS CORPORATIVAS --}}
        <div id="seccion_plantillas_corporativas" class="hidden space-y-6 pt-4 border-t">
            <label class="block text-sm font-semibold text-slate-700 mb-4">Seleccionar Diseño de Evento</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Evento 1 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Corporativo" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Corporativo.png') }}" class="aspect-[3/4] object-cover rounded-lg grayscale">
                        <p class="text-center text-[10px] mt-1 font-bold">Business Summit (Estándar/Moderno)</p>
                    </div>
                </label>

                {{-- Evento 2 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Corporativo2" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Corporativo2.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Vista Zen (Minimalista/Relajante)</p>
                    </div>
                </label>

                {{-- Evento 3 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Corporativo3" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Corporativo3.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Cyber Tech (Estilo Terminal/Hacker)</p>
                    </div>
                </label>

                {{-- Evento 4 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Corporativo4" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Corporativo4.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Gala Ejecutiva (Lujo Negro y Oro)</p>
                    </div>
                    </div>
                </label>

                {{-- Evento 5 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Corporativo5" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Corporativo5.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Innovación SaaS (Estilo Apple/Mesh)</p>
                    </div>
                    </div>
                </label>

                {{-- Evento 6 --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" name="id_plantilla" value="Corporativo6" class="peer sr-only">
                    <div class="overflow-hidden rounded-xl border-2 peer-checked:border-indigo-600 transition-all p-1">
                        <img src="{{ asset('img/plantillas/Corporativo6.png') }}" class="aspect-[3/4] object-cover rounded-lg">
                        <p class="text-center text-[10px] mt-1 font-bold">Startup Creativa (Divertido/Team Building)</p>
                    </div>
                    </div>
                </label>
                
            </div>
        </div>



        

        <div class="pt-6 border-t flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition-all">
                Crear Evento Completo
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('tipo_evento_id').addEventListener('change', function() {
        // Obtenemos el texto de la opción seleccionada
        const texto = this.options[this.selectedIndex].text.toLowerCase();
        
        const campoNacimiento = document.getElementById('div_nacimiento');
        const seccionMatrimonio = document.getElementById('seccion_plantillas_matrimonio');
        const seccionMemorial = document.getElementById('seccion_plantillas_memorial');
        const seccionCorporativo = document.getElementById('seccion_plantillas_corporativas');

        // Reset: Ocultar todo primero usando display none
        campoNacimiento.style.display = 'none';
        
        // Usamos style.display para asegurar que se muestren/oculten sin importar Tailwind
        seccionMatrimonio.style.display = 'none';
        seccionMemorial.style.display = 'none';
        seccionCorporativo.style.display = 'none';

        // Lógica para Memorial
        if (texto.includes('memorial')) {
            campoNacimiento.style.display = 'block';
            seccionMemorial.style.display = 'block';
            // Quitamos hidden por si acaso está puesto
            seccionMemorial.classList.remove('hidden');
        } 
        
        // Lógica para Matrimonio
        else if (texto.includes('matrimonio')) {
            seccionMatrimonio.style.display = 'block';
            seccionMatrimonio.classList.remove('hidden');
        }

        // Lógica para Corporativo (Asegúrate que el texto en el select diga "Corporativo")
        else if (texto.includes('corporativo') || texto.includes('evento')) {
            seccionCorporativo.style.display = 'block';
            seccionCorporativo.classList.remove('hidden');
        }
    });
</script>
@endsection