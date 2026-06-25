<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Vista Zen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f2f2f0; color: #2d2d2b; scroll-behavior: smooth; }
        h1, h2, h3, h4, .font-zen { font-family: 'Tenor Sans', sans-serif; }
        
        .section-zen { 
            min-height: 100vh; 
            width: 100%; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            text-align: center; 
            padding: 80px 20px; 
            scroll-snap-align: start;
        }

        .snap-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }

        .line-divider { 
            width: 1px; 
            height: 80px; 
            background-color: #2d2d2b; 
            margin: 40px 0; 
            opacity: 0.3; 
        }

        .fade-in {
            animation: fadeIn 2s ease-in forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in { animation: smoothIn 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards; }
        @keyframes smoothIn { from { opacity: 0; transform: scale(0.98); } to { opacity: 1; transform: scale(1); } }
        
        /* Ocultar scrollbar */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    // 🔥 LÓGICA DE TIEMPO
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
    
    // La galería se habilita 1 hora después del inicio oficial
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: HERO --}}
    <section class="section-zen fade-in">
        <span class="uppercase tracking-[0.6em] text-[11px] mb-12 font-semibold opacity-70 text-stone-600">Presentación Exclusiva</span>
        
        <h1 class="text-5xl md:text-7xl font-light mb-8 tracking-[0.15em] uppercase text-stone-800 px-4">
            {{ $evento->nombre_evento }}
        </h1>
        
        <div class="line-divider"></div>
        
        <p class="max-w-2xl text-lg md:text-xl font-light leading-relaxed italic text-stone-600 px-4">
            {{ $evento->biografia_resumen }}
        </p>
        
        {{-- CONTADOR CORREGIDO --}}
        <div id="countdown" class="flex flex-wrap justify-center gap-6 md:gap-12 mt-16 px-4">
            <div class="text-center">
                <span id="days" class="text-3xl md:text-4xl block font-light text-stone-800">00</span>
                <span class="text-[9px] md:text-[10px] uppercase tracking-[0.3em] font-semibold text-stone-500">Días</span>
            </div>
            <div class="text-center">
                <span id="hours" class="text-3xl md:text-4xl block font-light text-stone-800">00</span>
                <span class="text-[9px] md:text-[10px] uppercase tracking-[0.3em] font-semibold text-stone-500">Horas</span>
            </div>
            <div class="text-center">
                <span id="minutes" class="text-3xl md:text-4xl block font-light text-stone-800">00</span>
                <span class="text-[9px] md:text-[10px] uppercase tracking-[0.3em] font-semibold text-stone-500">Minutos</span>
            </div>
            <div class="text-center">
                <span id="seconds" class="text-3xl md:text-4xl block font-light text-stone-400">00</span>
                <span class="text-[9px] md:text-[10px] uppercase tracking-[0.3em] font-semibold text-stone-400">Segundos</span>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: DETALLES E ITINERARIO --}}
    <section class="section-zen bg-white">
        <div class="max-w-4xl w-full px-6">
            
            {{-- IMAGEN ADAPTADA PARA LOGOS --}}
            <div class="mb-20">
                <div class="relative w-full h-[50vh] md:h-[60vh] bg-[#f8f8f6] flex items-center justify-center overflow-hidden shadow-sm border border-stone-100">
                    @if($evento->fotosGaleria->count() > 0)
                        <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                             class="max-w-full max-h-full object-contain p-8 transition-opacity duration-1000 hover:opacity-80">
                    @else
                        <div class="flex flex-col items-center justify-center text-stone-200">
                            <i class="fa-regular fa-image text-6xl"></i>
                        </div>
                    @endif
                </div>
            </div>
            
            <h2 class="text-2xl md:text-3xl mb-6 uppercase tracking-widest text-stone-800 font-light">La Experiencia</h2>
            <p class="text-stone-600 mb-4 italic leading-relaxed text-base md:text-lg">{{ $evento->ubicacion_texto }}</p>
            <p class="text-[10px] md:text-[12px] uppercase tracking-[0.3em] md:tracking-[0.4em] font-bold text-stone-500 mb-12">
                {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d F, Y') }}
            </p>

            {{-- BLOQUE DE ITINERARIO ZEN --}}
            <div class="max-w-2xl mx-auto my-16 md:my-20">
                <div class="line-divider !h-12 !my-12 mx-auto"></div>
                
                <h3 class="text-[10px] md:text-[11px] uppercase tracking-[0.4em] md:tracking-[0.5em] mb-12 md:mb-16 font-bold text-stone-400">Cronograma del Encuentro</h3>
                
                <div class="space-y-12 md:space-y-16">
                    @forelse($evento->itinerarios as $item)
                        <div class="flex flex-col items-center group">
                            <span class="text-[10px] md:text-[11px] font-bold tracking-[0.3em] text-stone-400 mb-3 group-hover:text-stone-800 transition-colors">
                                {{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}
                            </span>
                            <h4 class="text-lg md:text-2xl font-light uppercase tracking-[0.1em] md:tracking-[0.2em] text-stone-800">
                                {{ $item->actividad }}
                            </h4>
                            @if($item->descripcion)
                                <div class="w-8 h-px bg-stone-300 my-3 md:my-4"></div>
                                <p class="text-xs md:text-sm text-stone-500 font-light italic max-w-xs leading-relaxed">
                                    {{ $item->descripcion }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <p class="text-stone-400 italic tracking-widest text-xs md:text-sm">Los detalles se revelarán pronto.</p>
                    @endforelse
                </div>

                <div class="line-divider !h-12 !my-12 mx-auto"></div>
            </div>
            
            {{-- Botón de Acción RSVP Adaptado --}}
            <div id="contenedorBotonPrincipalRSVP" class="mt-10">
                @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                    <button onclick="abrirModalAsistencia()" class="px-8 md:px-20 py-4 md:py-5 border border-stone-800 text-[9px] md:text-[11px] font-bold uppercase tracking-[0.3em] md:tracking-[0.5em] hover:bg-stone-800 hover:text-white transition-all duration-500 w-full md:w-auto">
                        Confirmar Asistencia
                    </button>
                @else
                    <div class="px-6 md:px-10 py-4 md:py-5 border border-dashed border-stone-300 text-[8px] md:text-[10px] uppercase tracking-[0.2em] md:tracking-[0.3em] font-bold text-stone-400 max-w-md mx-auto">
                        Acreditación mediante código QR Privado
                    </div>
                @endif
            </div>

            <div class="mt-16 md:mt-20 text-[8px] md:text-[10px] uppercase tracking-[0.3em] md:tracking-[0.4em] font-bold text-stone-400 pb-10">
                ID de Acceso: {{ $invitado->token_acceso ?? 'ZEN-PRIVATE' }}
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: REGISTRO VISUAL (CLOUD ONEDRIVE) --}}
    <section class="section-zen bg-[#f2f2f0] !h-auto min-h-screen py-20 !block">
        <div class="max-w-7xl mx-auto px-4 md:px-6 w-full flex flex-col items-center">
            
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-2xl md:text-4xl uppercase tracking-[0.2em] md:tracking-[0.3em] text-stone-800 font-light mb-4 md:mb-6">Registro Visual</h2>
                <div class="h-px w-12 bg-stone-300 mx-auto"></div>
            </div>

            {{-- LÓGICA DE BLOQUEO DE GALERÍA DE 1 HORA --}}
            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-10 bg-white/50 border border-stone-200 p-4 md:p-6 shadow-sm gap-4 animate-fade-in">
                    <div class="text-center md:text-left">
                        <span id="contador-seleccionadas" class="font-zen text-lg md:text-xl text-stone-800 tracking-widest">
                            0 Seleccionadas
                        </span>
                        <p class="text-[8px] md:text-[9px] text-stone-400 uppercase tracking-widest mt-1">Seleccione para extraer archivos</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] md:tracking-[0.3em] font-bold border border-stone-800 text-stone-800 px-6 py-3 hover:bg-stone-800 hover:text-white transition w-full md:w-auto">
                            Extraer Selección
                        </button>
                        <button onclick="descargarTodas()" class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] md:tracking-[0.3em] font-bold bg-stone-800 text-white px-6 py-3 hover:bg-stone-900 transition shadow-sm w-full md:w-auto">
                            Extraer Todo
                        </button>
                    </div>
                </div>

                @php
                    $galeriaUnificada = collect();

                    if(isset($evento->fotosGaleria)) {
                        foreach($evento->fotosGaleria as $foto) {
                            if(!str_starts_with($foto->url_recurso, 'http')) {
                                $ext = strtolower(pathinfo($foto->url_recurso, PATHINFO_EXTENSION));
                                $esVideoLocal = in_array($ext, ['mp4', 'mov', 'avi', 'webm']);

                                $galeriaUnificada->push([
                                    'url' => asset('storage/' . $foto->url_recurso),
                                    'esNube' => false,
                                    'esVideo' => $esVideoLocal,
                                    'etiqueta' => 'Archivo Interno'
                                ]);
                            }
                        }
                    }

                    if(isset($fotosNubeRealtime)) {
                        foreach($fotosNubeRealtime as $fotoCloud) {
                            $galeriaUnificada->push([
                                'url' => $fotoCloud['url'],
                                'esNube' => true,
                                'esVideo' => $fotoCloud['esVideo'] ?? false,
                                'etiqueta' => 'Nube Externa'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll p-1 md:p-2 animate-fade-in">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer overflow-hidden bg-white shadow-sm border border-stone-100 transition-all duration-500 hover:shadow-md" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            @if($foto['esVideo'])
                                <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-stone-900/5 hover:bg-stone-900/10 transition">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-105 transition shadow-sm border border-stone-100">
                                        <i class="fas fa-play text-stone-800 text-xs md:text-sm ml-0.5"></i>
                                    </div>
                                </button>
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover opacity-90 transition duration-700 group-hover:opacity-100" muted loop playsinline preload="metadata"></video>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover transition-transform duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                            @endif
                            
                            <div class="overlay absolute inset-0 bg-stone-900/10 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-stone-800 text-white rounded-full w-5 h-5 md:w-6 md:h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-sm z-30 pointer-events-none">
                                <i class="fas fa-check text-[8px] md:text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-3 left-3 right-3 bg-white/95 backdrop-blur-sm text-stone-800 text-[7px] md:text-[8px] uppercase tracking-[0.2em] font-bold py-1.5 md:py-2 px-2 text-center z-30 pointer-events-none border border-stone-200/50">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video text-stone-400 mr-1"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} text-stone-400 mr-1"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center p-12 bg-white/50 border border-stone-200 rounded-sm">
                            <i class="fa-regular fa-image text-2xl md:text-3xl text-stone-300 mb-3 md:mb-4"></i>
                            <p class="text-stone-500 font-light text-xs md:text-sm tracking-widest uppercase">Repositorio visual vacío.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl bg-white/60 border border-stone-200 p-8 md:p-16 text-center shadow-sm" id="locked-gallery-msg">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-stone-100 border border-stone-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-xl md:text-2xl text-stone-400"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-light text-stone-800 mb-3 uppercase tracking-widest">Contenido Restringido</h3>
                    <p class="text-stone-500 font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-6">
                        El material fotográfico y videográfico se desbloqueará <strong class="font-semibold">1 hora después</strong> del inicio oficial del encuentro.
                    </p>
                    <button onclick="window.location.reload()" class="px-6 py-3 border border-stone-300 text-[9px] md:text-[10px] uppercase tracking-widest text-stone-500 hover:bg-stone-100 transition shadow-sm">
                        <i class="fas fa-sync-alt mr-2"></i> Refrescar Estado
                    </button>
                </div>
            @endif

            <div class="w-full text-center pt-8 pb-4 z-20">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-50 hover:opacity-100 transition-all duration-500 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-[var(--celestial-muted)] mb-1.5 font-light">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono y texto que pasan a dorado en hover --}}
                        <i class="fas fa-star text-[10px] md:text-xs text-[var(--celestial-muted)] group-hover:text-[var(--celestial-gold)] transition-colors"></i>
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-[var(--celestial-text)] group-hover:text-[var(--celestial-gold)] transition-colors drop-shadow-sm">Eventify</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

</div>

{{-- MODAL REPRODUCTOR DE VIDEO ZEN --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-stone-900/90 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-stone-400 hover:text-white transition z-50 bg-stone-800 w-10 h-10 flex items-center justify-center rounded-full">
        <i class="fas fa-times"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-sm overflow-hidden shadow-2xl border border-stone-700" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

{{-- MODAL PÚBLICO DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-stone-900/40 backdrop-blur-xs p-4">
    <div class="bg-[#fcfcfb] text-[#2d2d2b] rounded-none max-w-md w-full p-6 md:p-8 text-center shadow-xl border border-stone-200 max-h-[90vh] overflow-y-auto animate-fade-in">
        
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-stone-200 pb-3 md:pb-4">
                <h3 class="text-sm md:text-lg uppercase tracking-[0.2em] font-light text-stone-800">Confirmación de Plaza</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-stone-800 transition"><i class="fas fa-times text-lg"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-4 md:space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-white p-4 md:p-5 border border-stone-200/60 rounded-none space-y-3 md:space-y-4 shadow-sm">
                    <span class="text-[9px] md:text-[10px] uppercase tracking-[0.3em] font-semibold text-stone-400 block">Titular Principal</span>
                    <div>
                        <label class="block text-[10px] md:text-[11px] uppercase tracking-widest text-stone-500 mb-1">Nombre y Apellido *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-stone-200 bg-[#fbfbf9] p-2.5 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-stone-800 transition text-stone-800 font-light">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-[11px] uppercase tracking-widest text-stone-500 mb-1">Correo Electrónico *</label>
                        <input type="email" id="inputEmailPrincipal" required class="w-full border border-stone-200 bg-[#fbfbf9] p-2.5 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-stone-800 transition text-stone-800 font-light" placeholder="ejemplo@correo.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-3 md:space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2.5 md:py-3 border border-dashed border-stone-300 text-stone-500 text-[9px] md:text-[10px] uppercase tracking-[0.2em] font-semibold hover:bg-stone-50 hover:text-stone-800 transition flex items-center justify-center gap-2 rounded-none">
                    <i class="fas fa-plus text-[8px] md:text-[9px]"></i> Añadir Invitado Adicional
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full bg-stone-800 text-white py-3 md:py-4 font-semibold text-[10px] md:text-[11px] uppercase tracking-[0.3em] md:tracking-[0.4em] hover:bg-stone-900 shadow-sm transition-all duration-300 mt-4 md:mt-6 block text-center rounded-none cursor-pointer">
                    Confirmar Registro
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaEvento = "{{ $evento->fecha_principal }}";
        const horaEvento = "{{ $evento->hora ?? '09:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;

            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='uppercase tracking-[0.2em] md:tracking-[0.4em] font-bold text-stone-500 text-xs md:text-sm text-center w-full'>El evento ha comenzado</p>";
                
                // Lógica de desbloqueo dinámico de galería si el usuario tiene la web abierta
                if (gap <= -3600000) {
                    const lockedGallery = document.getElementById('locked-gallery-msg');
                    if(lockedGallery) {
                        lockedGallery.innerHTML = `
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-stone-800 border border-stone-900 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md transition hover:scale-105">
                                <i class="fas fa-unlock-alt text-xl md:text-2xl text-white"></i>
                            </div>
                            <h3 class="text-lg md:text-xl font-light text-stone-800 mb-3 uppercase tracking-widest">Repositorio Disponible</h3>
                            <p class="text-stone-500 font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-6">
                                El material visual ya se encuentra desbloqueado para los asistentes.
                            </p>
                            <button onclick="window.location.reload()" class="px-8 py-3 bg-stone-800 text-white text-[9px] md:text-[10px] uppercase tracking-widest hover:bg-stone-900 transition shadow-sm">
                                Visualizar Contenido
                            </button>
                        `;
                    }
                }
                return;
            }

            document.getElementById('days').innerText = Math.floor(gap / day).toString().padStart(2, '0');
            document.getElementById('hours').innerText = Math.floor((gap % day) / hour).toString().padStart(2, '0');
            document.getElementById('minutes').innerText = Math.floor((gap % hour) / minute).toString().padStart(2, '0');
            document.getElementById('seconds').innerText = Math.floor((gap % minute) / second).toString().padStart(2, '0');
        };

        setInterval(updateCountdown, 1000);
        updateCountdown();
    });

    let contadorAcompanantes = 0;

    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const contenedor = document.getElementById('contenedorAcompanantes');
        
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-white p-4 md:p-5 border border-stone-200/60 space-y-3 md:space-y-4 relative animate-fade-in shadow-sm";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-stone-100 pb-2">
                <span class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] text-stone-400">Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-stone-400 hover:text-stone-800 text-[9px] md:text-[10px] uppercase tracking-widest transition font-semibold">
                    [ Eliminar ]
                </button>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] uppercase tracking-widest text-stone-500 mb-1">Nombre Completo *</label>
                <input type="text" class="input-nombre-acompanante w-full border border-stone-200 bg-[#fbfbf9] p-2.5 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-stone-800 transition text-stone-800 font-light" required>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] uppercase tracking-widest text-stone-500 mb-1">Correo Electrónico (Opcional)</label>
                <input type="email" class="input-email-acompanante w-full border border-stone-200 bg-[#fbfbf9] p-2.5 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-stone-800 transition text-stone-800 font-light" placeholder="correo@asistente.com">
            </div>
        `;
        contenedor.appendChild(div);
    }

    function removerCampoAcompanante(id) {
        const fila = document.getElementById(`acompanante_row_${id}`);
        if (fila) fila.remove();
    }

    function abrirModalAsistencia() { document.getElementById('modalAsistencia').classList.remove('hidden'); }
    function cerrarModalAsistencia() { document.getElementById('modalAsistencia').classList.add('hidden'); }

    function enviarDatosAsistencia(event, eventoId) {
        event.preventDefault();
        
        const btnConfirmar = document.getElementById('btnConfirmarAsistencia');
        const txtOriginalConfirmar = btnConfirmar.innerHTML;
        
        btnConfirmar.disabled = true;
        btnConfirmar.classList.add('opacity-70', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Procesando...';

        const nodosNombres = document.querySelectorAll('.input-nombre-acompanante');
        const nodosEmails = document.querySelectorAll('.input-email-acompanante');
        
        const listaAcompanantes = Array.from(nodosNombres).map((input, index) => {
            return {
                nombre: input.value.trim(),
                email: nodosEmails[index]?.value.trim() || ''
            };
        }).filter(acomp => acomp.nombre !== "");

        const dataPayload = {
            token_acceso: document.getElementById('inputHiddenToken').value,
            nombre_invitado: document.getElementById('inputNombrePrincipal').value.trim(),
            email: document.getElementById('inputEmailPrincipal').value.trim(),
            acompanantes: listaAcompanantes
        };

        if (!dataPayload.token_acceso || dataPayload.token_acceso === 'INVITADO-GENERAL') {
            alert("Falta el token de acceso en la URL.");
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
            return;
        }

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/invitacion/confirmar-asistencia', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': tokenCsrf
            },
            body: JSON.stringify(dataPayload)
        })
        .then(async response => {
            const data = await response.json();
            
            if (response.status === 422 && data.already_registered) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                contenedorModal.innerHTML = `
                    <div class="py-4 md:py-6 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-stone-100 rounded-full flex items-center justify-center mx-auto border border-stone-200">
                            <i class="fas fa-info text-sm md:text-md text-stone-600"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl uppercase tracking-widest text-stone-800 font-light">Registro Existente</h3>
                            <p class="text-xs md:text-sm text-stone-500 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="p-4 md:p-5 bg-[#fbfbf9] border border-stone-200 rounded-none text-[10px] md:text-xs text-stone-600 text-left leading-relaxed">
                            Aviso: Los datos ingresados coinciden con una confirmación activa. Si requiere ajustar el número de acompañantes, coordine directamente con soporte.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-stone-800 text-white py-2.5 md:py-3 text-[10px] md:text-xs font-semibold uppercase tracking-widest hover:bg-stone-900 transition shadow-sm mt-2">
                            Entendido
                        </button>
                    </div>
                `;
                throw new Error("already_handled");
            }

            if (!response.ok) { throw new Error("Error en el Servidor."); }
            return data;
        })
        .then(data => {
            if (data && data.success) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                
                contenedorModal.innerHTML = `
                    <div class="py-4 md:py-6 text-center space-y-6 md:space-y-8 animate-fade-in">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-stone-100 rounded-full flex items-center justify-center mx-auto border border-stone-200">
                            <i class="fas fa-check text-sm md:text-base text-stone-600"></i>
                        </div>
                        
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-xl md:text-2xl uppercase tracking-[0.1em] md:tracking-[0.15em] text-stone-800 font-light">Confirmación Recibida</h3>
                            <p class="text-[10px] md:text-xs text-stone-500 font-light px-2">Sus identificadores personales han sido validados de manera correcta.</p>
                        </div>

                        <div class="bg-[#fbfbf9] border border-stone-200 rounded-none p-4 md:p-6 text-left space-y-3 md:space-y-4 shadow-inner">
                            <p class="text-[8px] md:text-[9px] uppercase font-bold tracking-[0.2em] text-stone-400 border-b border-stone-200 pb-2">
                                <i class="fas fa-key mr-1"></i> Códigos de Acceso Asignados
                            </p>
                            <div class="text-[10px] md:text-xs space-y-2 md:space-y-3">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-2 md:pt-3 border-t border-dashed border-stone-200' : ''}">
                                        <span class="font-light tracking-wide text-stone-600 truncate pr-2">${item.nombre}:</span> 
                                        <span class="bg-stone-800 px-2 md:px-3 py-1 text-[9px] md:text-[11px] font-bold text-white font-mono tracking-widest shadow-sm shrink-0">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[9px] md:text-[10px] text-stone-400 italic max-w-xs mx-auto leading-relaxed">Conserve estos identificadores para interactuar con las herramientas digitales del cronograma.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-stone-200 text-stone-800 py-2.5 md:py-3 text-[10px] md:text-xs font-semibold uppercase tracking-widest hover:bg-stone-300 transition shadow-sm rounded-none mt-2">
                            Cerrar
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-10 py-4 md:py-5 border border-stone-800 text-[9px] md:text-[11px] uppercase tracking-[0.2em] md:tracking-[0.3em] text-white max-w-xs md:max-w-md mx-auto font-bold bg-stone-800 shadow-sm animate-fade-in">
                        <i class="fas fa-check mr-2"></i> Registro Completado
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("No se pudo procesar la confirmación en el servidor.");
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA ZEN ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('ring-2', 'ring-stone-800', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-2', 'ring-stone-800', 'ring-offset-2');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} Seleccionadas`;
    }

    function playPreview(elemento) {
        const vid = elemento.querySelector('.vid-preview');
        if(vid) { vid.play().catch(e => console.log('Autoplay prevenido')); }
    }
    
    function pausePreview(elemento) {
        const vid = elemento.querySelector('.vid-preview');
        if(vid) { vid.pause(); }
    }

    function abrirReproductor(event, url) {
        event.stopPropagation(); 
        const modal = document.getElementById('modalReproductor');
        const player = document.getElementById('videoPlayerS');
        player.src = url;
        modal.classList.remove('hidden');
        player.play().catch(e => console.log('Autoplay bloqueado'));
    }

    function cerrarReproductor() {
        const modal = document.getElementById('modalReproductor');
        const player = document.getElementById('videoPlayerS');
        player.pause();
        player.src = '';
        modal.classList.add('hidden');
    }

    function forzarDescarga(url) {
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        let downloadUrl = url;
        if (downloadUrl.includes('sharepoint.com') && !downloadUrl.includes('download=1')) {
            downloadUrl += (downloadUrl.includes('?') ? '&' : '?') + 'download=1';
        }
        iframe.src = downloadUrl;
        document.body.appendChild(iframe);
        setTimeout(() => { document.body.removeChild(iframe); }, 15000);
    }

    function descargarSeleccionadas() {
        const seleccionadas = document.querySelectorAll('.foto-item.seleccionada');
        if (seleccionadas.length === 0) {
            alert("Seleccione elementos para iniciar la transferencia.");
            return;
        }
        seleccionadas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
        seleccionadas.forEach(item => toggleSeleccion(item));
    }

    function descargarTodas() {
        const todas = document.querySelectorAll('.foto-item');
        if (todas.length === 0) {
            alert("No hay archivos disponibles.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>