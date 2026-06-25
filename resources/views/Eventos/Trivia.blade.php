@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    
    {{-- Encabezado --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 transition text-sm flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i> Volver al panel
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Configuración del Juego de Trivia</h1>
            <p class="text-slate-500 text-sm">Personaliza el cuestionario interactivo para: <strong class="text-slate-700">{{ $evento->nombre_evento }}</strong></p>
        </div>
    </div>

    @if(session('exito'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
            {{ session('exito') }}
        </div>
    @endif

    <form action="{{ route('eventos.trivia.guardar', $evento->evento_id) }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Contenedor Dinámico de Preguntas --}}
        <div id="contenedor-preguntas" class="space-y-6">
            @forelse($evento->juegoPreguntas as $index => $item)
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-xs relative group card-pregunta">
                    <button type="button" onclick="eliminarPregunta(this)" class="absolute top-6 right-6 text-slate-300 hover:text-rose-500 transition">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pregunta #</label>
                            <input type="text" name="pregunta[]" value="{{ $item->pregunta }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition text-sm font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Puntaje</label>
                            <input type="number" name="puntos[]" value="{{ $item->puntos }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Opción A --}}
                        <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                            <input type="radio" name="respuesta_correcta[{{ $index }}]" value="a" {{ $item->respuesta_correcta == 'a' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <input type="text" name="opcion_a[]" value="{{ $item->opcion_a }}" placeholder="Alternativa A" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                        </div>
                        {{-- Opción B --}}
                        <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                            <input type="radio" name="respuesta_correcta[{{ $index }}]" value="b" {{ $item->respuesta_correcta == 'b' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <input type="text" name="opcion_b[]" value="{{ $item->opcion_b }}" placeholder="Alternativa B" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                        </div>
                        {{-- Opción C --}}
                        <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                            <input type="radio" name="respuesta_correcta[{{ $index }}]" value="c" {{ $item->respuesta_correcta == 'c' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <input type="text" name="opcion_c[]" value="{{ $item->opcion_c }}" placeholder="Alternativa C" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                        </div>
                        {{-- Opción D --}}
                        <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                            <input type="radio" name="respuesta_correcta[{{ $index }}]" value="d" {{ $item->respuesta_correcta == 'd' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <input type="text" name="opcion_d[]" value="{{ $item->opcion_d }}" placeholder="Alternativa D" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-400 mt-2 block italic"><i class="fas fa-info-circle mr-1"></i> Marca el círculo redondo de la alternativa que sea la correcta.</span>
                </div>
            @empty
                {{-- Estado inicial vacío --}}
                <div id="sin-preguntas" class="bg-white rounded-2xl border border-slate-100 p-12 text-center text-slate-400 font-light space-y-2 shadow-xs">
                    <i class="fa-solid fa-gamepad text-4xl block text-slate-200"></i>
                    <p class="text-sm font-semibold text-slate-500">No hay preguntas creadas para este juego</p>
                    <p class="text-xs">Presiona el botón de abajo para añadir la primera pregunta de tu cuestionario.</p>
                </div>
            @endforelse
        </div>

        {{-- Botonera inferior --}}
        <div class="pt-4 flex justify-between items-center border-t border-slate-200/60 font-sans">
            <button type="button" onclick="agregarNuevaPregunta()" class="bg-slate-800 text-white px-5 py-3 rounded-xl font-bold hover:bg-slate-900 transition text-xs shadow-md">
                <i class="fas fa-plus mr-2"></i> Agregar Pregunta
            </button>

            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition text-xs shadow-lg shadow-indigo-100">
                Guardar Cuestionario Completo
            </button>
        </div>
    </form>
</div>

<script>
    // Contador global para indexar de forma única los grupos de botones radio de la respuesta correcta
    let totalPreguntas = {{ $evento->juegoPreguntas->count() }};

    function agregarNuevaPregunta() {
        const estadoVacio = document.getElementById('sin-preguntas');
        if (estadoVacio) estadoVacio.remove();

        const contenedor = document.getElementById('contenedor-preguntas');
        
        const nuevaEstructura = document.createElement('div');
        nuevaEstructura.className = "bg-white rounded-2xl border border-slate-100 p-6 shadow-xs relative group card-pregunta animate-fade-in";
        nuevaEstructura.innerHTML = `
            <button type="button" onclick="eliminarPregunta(this)" class="absolute top-6 right-6 text-slate-300 hover:text-rose-500 transition">
                <i class="fas fa-trash-alt"></i>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pregunta #</label>
                    <input type="text" name="pregunta[]" placeholder="Escribe aquí el enunciado de la pregunta" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition text-sm font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Puntaje</label>
                    <input type="number" name="puntos[]" value="10" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none focus:border-indigo-500 transition text-sm font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                    <input type="radio" name="respuesta_correcta[${totalPreguntas}]" value="a" checked class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <input type="text" name="opcion_a[]" placeholder="Alternativa A" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                </div>
                <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                    <input type="radio" name="respuesta_correcta[${totalPreguntas}]" value="b" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <input type="text" name="opcion_b[]" placeholder="Alternativa B" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                </div>
                <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                    <input type="radio" name="respuesta_correcta[${totalPreguntas}]" value="c" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <input type="text" name="opcion_c[]" placeholder="Alternativa C" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                </div>
                <div class="flex items-center space-x-2 bg-slate-50 p-2 rounded-xl border border-slate-100">
                    <input type="radio" name="respuesta_correcta[${totalPreguntas}]" value="d" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <input type="text" name="opcion_d[]" placeholder="Alternativa D" required class="w-full bg-transparent outline-none text-sm px-2 py-1">
                </div>
            </div>
            <span class="text-xs text-slate-400 mt-2 block italic"><i class="fas fa-info-circle mr-1"></i> Marca el círculo redondo de la alternativa que sea la correcta.</span>
        `;
        
        contenedor.appendChild(nuevaEstructura);
        totalPreguntas++;
    }

    function eliminarPregunta(btn) {
        if(confirm('¿Desea remover esta pregunta del listado?')) {
            btn.closest('.card-pregunta').remove();
            
            // Si vaciaron el formulario entero, pintamos de nuevo el mensaje de alerta
            const remanentes = document.querySelectorAll('.card-pregunta');
            if(remanentes.length === 0) {
                document.getElementById('contenedor-preguntas').innerHTML = `
                    <div id="sin-preguntas" class="bg-white rounded-2xl border border-slate-100 p-12 text-center text-slate-400 font-light space-y-2 shadow-xs">
                        <i class="fa-solid fa-gamepad text-4xl block text-slate-200"></i>
                        <p class="text-sm font-semibold text-slate-500">No hay preguntas creadas para este juego</p>
                        <p class="text-xs">Presiona el botón de abajo para añadir la primera pregunta de tu cuestionario.</p>
                    </div>
                `;
            }
        }
    }
</script>
@endsection