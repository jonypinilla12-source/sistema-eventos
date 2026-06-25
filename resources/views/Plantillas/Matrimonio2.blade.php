<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Invitación de Gala</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Great+Vibes&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --oro-champagne: #e3c5a8;
            --negro-etiqueta: #050505;
        }

        h1, h2, h3, .font-titular { font-family: 'Cinzel', serif; }
        .font-firma { font-family: 'Great Vibes', cursive; }
        body { 
            font-family: 'Montserrat', sans-serif; 
            background-color: var(--negro-etiqueta); 
            color: white; 
            scroll-behavior: smooth; 
            overflow-x: hidden; 
        }

        /* svh asegura que en móviles la barra de direcciones no tape el contenido */
        .snap-container {
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        .seccion-gala {
            min-height: 100svh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            overflow: hidden;
            background: radial-gradient(circle at center, #151515 0%, #050505 100%);
            padding: 4rem 1.5rem;
        }
        @media (min-width: 768px) {
            .seccion-gala { padding: 0 2rem; }
        }

        .texto-oro {
            background: linear-gradient(to bottom, #f9f1ea 0%, #e3c5a8 50%, #b59372 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Botón de Gala Mejorado */
        .btn-gala {
            position: relative;
            padding: 1rem 1.5rem;
            border: 1px solid var(--oro-champagne);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.7rem;
            background: transparent;
            color: var(--oro-champagne);
            transition: all 0.5s ease;
            cursor: pointer;
            border-radius: 2px;
            width: 100%;
            text-align: center;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
        }
        @media (min-width: 768px) {
            .btn-gala { padding: 1.2rem 3rem; letter-spacing: 5px; font-size: 0.75rem; width: auto; }
        }

        .btn-gala:hover {
            color: var(--negro-etiqueta);
            background: var(--oro-champagne);
            box-shadow: 0 0 25px rgba(227, 197, 168, 0.2);
            letter-spacing: 4px;
        }
        @media (min-width: 768px) {
            .btn-gala:hover { letter-spacing: 6px; }
        }
        .btn-gala:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .divisor-oro {
            width: 60px;
            height: 1px;
            background: var(--oro-champagne);
            margin: 1.5rem auto;
            position: relative;
        }
        @media (min-width: 768px) {
            .divisor-oro { width: 100px; margin: 2.5rem auto; }
        }

        .divisor-oro::after {
            content: '✦';
            position: absolute;
            top: -11px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--oro-champagne);
            background: transparent;
            font-size: 1rem;
            text-shadow: 0 0 10px #050505;
        }

        @keyframes fundidoLento {
            from { opacity: 0.25; transform: scale(1.05); }
            to { opacity: 0.45; transform: scale(1); }
        }
        .img-fondo-suave { animation: fundidoLento 15s infinite alternate ease-in-out; }
        
        .animate-pop { animation: popIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes popIn { 
            0% { opacity: 0; transform: translateY(15px) scale(0.98); } 
            100% { opacity: 1; transform: translateY(0) scale(1); } 
        }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '21:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: BIENVENIDA --}}
    <section class="seccion-gala !p-0">
        <div class="absolute inset-0 z-0">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                     class="w-full h-full object-cover img-fondo-suave">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-[#050505]"></div>
        </div>

        <div class="z-10 text-center px-4 w-full max-w-5xl mx-auto flex flex-col items-center justify-center h-full">
            <span class="font-firma text-3xl md:text-5xl tracking-wide texto-oro mb-3 md:mb-6 block drop-shadow-lg">Bienvenidos a la celebración de</span>
            
            <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl texto-oro font-bold mb-4 md:mb-8 tracking-tighter leading-tight drop-shadow-xl px-2">
                {{ $evento->nombre_evento }}
            </h1>
            
            <div class="divisor-oro"></div>

            <p class="text-base sm:text-xl md:text-2xl font-light tracking-[0.2em] md:tracking-[0.4em] mb-10 md:mb-16 text-stone-200">
                {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d.m.Y') }}
            </p>

            {{-- CONTADOR ELEGANTE --}}
            <div id="countdown" class="grid grid-cols-4 gap-2 sm:gap-6 md:gap-12 w-full max-w-3xl">
                <div class="flex flex-col items-center">
                    <span id="days" class="text-3xl sm:text-4xl md:text-6xl font-light texto-oro">00</span>
                    <span class="text-[8px] md:text-xs uppercase tracking-[0.1em] md:tracking-[0.3em] text-stone-400 mt-2">Días</span>
                </div>
                <div class="flex flex-col items-center">
                    <span id="hours" class="text-3xl sm:text-4xl md:text-6xl font-light text-stone-200">00</span>
                    <span class="text-[8px] md:text-xs uppercase tracking-[0.1em] md:tracking-[0.3em] text-stone-400 mt-2">Horas</span>
                </div>
                <div class="flex flex-col items-center">
                    <span id="minutes" class="text-3xl sm:text-4xl md:text-6xl font-light text-stone-200">00</span>
                    <span class="text-[8px] md:text-xs uppercase tracking-[0.1em] md:tracking-[0.3em] text-stone-400 mt-2">Min</span>
                </div>
                <div class="flex flex-col items-center border-l border-white/10">
                    <span id="seconds" class="text-3xl sm:text-4xl md:text-6xl font-light text-[#e3c5a8]">00</span>
                    <span class="text-[8px] md:text-xs uppercase tracking-[0.1em] md:tracking-[0.3em] text-stone-400 mt-2">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: HISTORIA --}}
    <section class="seccion-gala">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
            
            <div class="space-y-6 md:space-y-8 text-center lg:text-left order-2 lg:order-1 px-4 sm:px-8">
                <p class="font-firma text-4xl md:text-6xl texto-oro">Nuestra Historia</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl leading-tight font-titular">Un camino hacia el siempre</h2>
                <div class="divisor-oro lg:ml-0 hidden lg:block"></div>
                <p class="text-stone-300 leading-relaxed text-sm md:text-lg font-light tracking-wide italic">
                    "{!! nl2br(e($evento->biografia_resumen)) !!}"
                </p>
            </div>

            <div class="relative group order-1 lg:order-2 w-full max-w-[280px] sm:max-w-xs lg:max-w-md mx-auto">
                @if($evento->fotosGaleria->count() > 1)
                    <div class="aspect-[3/4] w-full overflow-hidden rounded-t-full rounded-b-md shadow-2xl border border-white/5 relative z-10">
                        <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" 
                             class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 scale-105 group-hover:scale-100">
                    </div>
                @else
                    <div class="aspect-[3/4] w-full bg-stone-900 rounded-t-full border border-white/5 flex items-center justify-center relative z-10">
                        <i class="fa-solid fa-heart text-stone-800 text-6xl"></i>
                    </div>
                @endif
                {{-- Adorno decorativo --}}
                <div class="absolute -bottom-4 -left-4 lg:-bottom-8 lg:-left-8 bg-black border border-[#e3c5a8]/30 p-6 lg:p-8 backdrop-blur-md z-20 shadow-2xl">
                    <p class="font-firma text-2xl lg:text-4xl texto-oro">Amor</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="seccion-gala bg-[#080808]">
        <div class="text-center px-4 w-full max-w-4xl mx-auto flex flex-col items-center">
            <p class="font-firma text-4xl md:text-6xl texto-oro mb-2 md:mb-4">El Escenario</p>
            <h2 class="text-3xl sm:text-5xl md:text-6xl mb-6 md:mb-10 tracking-widest uppercase font-titular">Lugar del Evento</h2>
            
            <div class="w-[1px] h-12 md:h-20 bg-gradient-to-b from-[#e3c5a8] to-transparent mb-6 md:mb-10"></div>
            
            <p class="text-base sm:text-lg md:text-2xl text-stone-300 font-extralight mb-10 md:mb-16 leading-relaxed italic">
                {{ $evento->ubicacion_texto }}
            </p>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center mt-4">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-gala w-full sm:w-auto max-w-xs">
                    Ver Ubicación <i class="fa-solid fa-diamond-turn-right ml-3 text-[10px]"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES --}}
    <section class="seccion-gala !py-20 h-auto min-h-[100svh]">
        <div class="max-w-6xl w-full px-4 text-center flex flex-col justify-center h-full">
            <h2 class="text-3xl sm:text-4xl md:text-5xl mb-12 md:mb-16 tracking-[0.2em] font-titular font-light uppercase">Dinámicas de la Noche</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-12">
                
                {{-- BLOQUE TRIVIA --}}
                <div class="p-8 md:p-12 border border-white/10 shadow-2xl bg-[#030303] hover:border-[#e3c5a8]/40 transition-colors flex flex-col justify-between items-center min-h-[280px] md:min-h-[350px]">
                    <div>
                        <h3 class="font-firma text-4xl md:text-5xl texto-oro mb-2 md:mb-4">Trivia Real</h3>
                        <p class="text-stone-500 font-light text-[10px] md:text-xs mb-8 tracking-widest uppercase">¿Cuánto nos conoces?</p>
                    </div>
                    <div id="wrapper-btn-trivia" class="w-full flex flex-col items-center gap-4 mt-auto">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('trivia')" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.3em] text-white hover:text-[#e3c5a8] transition font-medium pb-1 border-b border-transparent hover:border-[#e3c5a8]">Comenzar Juego</button>
                            <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.3em] text-[#e3c5a8] transition font-medium pb-1 mt-2">Ver Posiciones</button>
                        @else
                            <button id="btn-time-trivia" disabled class="text-[10px] uppercase tracking-[0.2em] text-stone-600 font-medium">
                                <i class="fas fa-lock mr-2"></i> Disponible en el Evento
                            </button>
                        @endif
                    </div>
                </div>

                {{-- BLOQUE MURO --}}
                <div class="p-8 md:p-12 border border-white/10 shadow-2xl bg-[#030303] hover:border-[#e3c5a8]/40 transition-colors flex flex-col justify-between items-center min-h-[280px] md:min-h-[350px]">
                    <div>
                        <h3 class="font-firma text-4xl md:text-5xl texto-oro mb-2 md:mb-4">Muro de Deseos</h3>
                        <p class="text-stone-500 font-light text-[10px] md:text-xs mb-8 tracking-widest uppercase">Deja un mensaje</p>
                    </div>
                    <div id="wrapper-btn-muro" class="w-full flex flex-col items-center gap-4 mt-auto">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('muro')" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.3em] text-white hover:text-[#e3c5a8] transition font-medium pb-1 border-b border-transparent hover:border-[#e3c5a8]">Escribir Saludo</button>
                            <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.3em] text-[#e3c5a8] transition font-medium pb-1 mt-2">Ver Muro <i class="fa-solid fa-arrow-right ml-1"></i></button>
                        @else
                            <button id="btn-time-muro" disabled class="text-[10px] uppercase tracking-[0.2em] text-stone-600 font-medium">
                                <i class="fas fa-lock mr-2"></i> Disponible en el Evento
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: GALERÍA DE GALA (TIEMPO REAL CLOUD) --}}
    <section class="seccion-gala bg-[#050505] !h-auto py-20 min-h-[100svh] !block">
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 mx-auto">
            
            <div class="text-center mb-10 w-full">
                <p class="font-firma text-3xl md:text-5xl texto-oro mb-3">Momentos Inolvidables</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-titular uppercase tracking-widest text-white drop-shadow-md">Galería de Gala</h2>
                <div class="divisor-oro"></div>
            </div>

            <div class="w-full flex flex-col lg:flex-row justify-between items-center mb-8 bg-[#111] p-5 md:p-6 border border-[#e3c5a8]/20 rounded-sm gap-6 shadow-xl">
                <span id="contador-seleccionadas" class="font-titular text-lg md:text-xl text-[#e3c5a8] tracking-widest">
                    0 SELECCIONADAS
                </span>
                <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-semibold border border-[#e3c5a8] text-[#e3c5a8] hover:bg-[#e3c5a8] hover:text-black transition uppercase tracking-[0.2em] px-6 py-3 w-full sm:w-auto text-center rounded-sm">
                        <i class="fas fa-download mr-2"></i> Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-gala !w-full sm:!w-auto !py-3">
                        <i class="fas fa-cloud-download-alt mr-2"></i> Extraer Todo
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
                                'etiqueta' => 'OFICIAL'
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
                            'etiqueta' => $fotoCloud['etiqueta']
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5 w-full max-h-[65vh] overflow-y-auto hide-scroll pb-4">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer border-2 border-transparent hover:border-[#e3c5a8]/50 transition-all duration-300 overflow-hidden bg-[#111] flex items-center justify-center rounded-sm aspect-square md:aspect-[4/5]" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/20 hover:bg-black/10 transition">
                                <i class="fas fa-play-circle text-4xl text-white/80 group-hover:text-[#e3c5a8] group-hover:scale-110 transition drop-shadow-md"></i>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700 opacity-70" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[#e3c5a8]/10 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-2 right-2 bg-[#050505] text-[#e3c5a8] rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 border border-[#e3c5a8] z-30 pointer-events-none">
                            <i class="fas fa-check text-[10px]"></i>
                        </div>

                        <div class="absolute bottom-2 left-2 right-2 bg-black/80 text-[#e3c5a8] text-[8px] md:text-[9px] px-2 py-1.5 font-sans uppercase tracking-[0.2em] border border-[#e3c5a8]/30 truncate text-center z-30 pointer-events-none rounded-sm">
                            <i class="fas {{ $foto['esVideo'] ? 'fa-video' : ($foto['esNube'] ? 'fa-cloud' : 'fa-camera-retro') }} mr-1"></i>
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border border-dashed border-white/10 p-12 bg-[#111] rounded-sm">
                        <p class="text-stone-500 font-titular tracking-widest uppercase">Galería vacía. Esperando recuerdos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 6: RSVP --}}
    <section class="seccion-gala bg-[#080808] relative">
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 w-full max-w-4xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO (Con my-auto se centra verticalmente) --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <p class="font-firma text-4xl md:text-6xl texto-oro mb-6 md:mb-8 drop-shadow-md">Por favor, confirma tu asistencia</p>
                <h2 class="text-5xl sm:text-6xl md:text-8xl lg:text-9xl mb-10 md:mb-16 tracking-tighter font-titular font-bold text-white">R.S.V.P</h2>
                
                <div id="contenedorBotonPrincipalRSVP" class="flex justify-center w-full mt-4">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-gala w-full max-w-xs sm:max-w-md">
                            Confirmar Asistencia
                        </button>
                    @else
                        <div class="px-6 py-4 border border-white/10 text-[9px] sm:text-[10px] md:text-xs tracking-[0.2em] md:tracking-[0.3em] uppercase text-stone-400 w-full max-w-xs sm:max-w-md bg-black/40 text-center leading-relaxed">
                            Código QR Obligatorio para Acceso
                        </div>
                    @endif
                </div>
                
                <div class="mt-16 md:mt-24 opacity-40 uppercase text-[8px] md:text-[10px] tracking-[0.3em] md:tracking-[0.4em] space-y-4 text-white">
                    <p>Mesa Reservada: <span class="texto-oro font-bold">{{ $invitado->mesa_asignada ?? 'Pronto disponible' }}</span></p>
                    <p>Código de Vestimenta: Etiqueta Rigurosa / Gala</p>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-300 group cursor-pointer">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-stone-500 mb-1.5 font-medium">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono dorado --}}
                        <i class="fas fa-glass-cheers text-[11px] md:text-xs texto-oro"></i>
                        {{-- Eventify en blanco que pasa a dorado en hover --}}
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-white group-hover:text-yellow-500 transition-colors" style="font-family: 'Playfair Display', serif;">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- ================================================================= --}}
{{-- MODALES (CÓDIGO LÓGICO INTACTO, SOLO MEJORAS CSS Y ESPACIOS)  --}}
{{-- ================================================================= --}}

{{-- MOSTRAR MURO VISUAL DESEOS DE BODA --}}
<section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[#050505] overflow-y-auto w-full h-[100svh]">
    <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 py-12 md:py-16 text-center min-h-[100svh] flex flex-col relative z-10">
        
        <div class="mb-8 md:mb-12 animate-pop mt-6">
            <i class="fas fa-comment-dots text-[#e3c5a8] text-3xl md:text-4xl mb-4 md:mb-6 block"></i>
            <h2 class="text-3xl sm:text-4xl md:text-6xl text-white font-titular tracking-widest uppercase mb-4">Muro de Deseos</h2>
            <div class="divisor-oro"></div>
            <p class="font-firma text-2xl md:text-4xl text-[#e3c5a8] tracking-wide mt-4">Los mensajes de nuestros invitados</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 flex-grow items-start w-full pb-10">
            @forelse($interaccionesAprobadas ?? [] as $item)
                <div class="p-6 md:p-8 bg-[#111] rounded-xl border border-white/5 shadow-2xl flex flex-col text-left transition-all duration-500 hover:-translate-y-2 hover:border-[#e3c5a8]/40 h-full">
                    
                    @if($item->url_onedrive)
                        @php
                            $directImgUrl = $item->url_onedrive;
                            if (str_contains($directImgUrl, '1drv.ms')) {
                                $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                            } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                            }
                        @endphp
                        <div class="mb-5 overflow-hidden rounded-lg border border-white/10 shadow-sm shrink-0 aspect-[4/3] w-full">
                            <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" 
                                 class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                        </div>
                    @endif
                    
                    <p class="text-sm text-stone-300 font-light italic leading-relaxed flex-grow mb-6 break-words hyphens-auto">
                        "{{ $item->contenido_texto }}"
                    </p>
                    
                    <div class="pt-4 border-t border-white/5 flex items-center justify-between mt-auto">
                        <span class="text-[9px] md:text-[10px] uppercase tracking-[0.1em] font-bold text-[#e3c5a8] truncate pr-2">
                            {{ $item->nombre_autor }}
                        </span>
                        <i class="fas fa-star text-[#e3c5a8] text-[10px] shrink-0"></i>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 bg-[#111] rounded-xl border border-white/5 mx-2">
                    <i class="fa-regular fa-folder-open text-stone-600 text-4xl mb-4"></i>
                    <p class="text-stone-500 italic font-light tracking-wide">Aún no hay mensajes en la galería de gala.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-auto pb-10 flex justify-center w-full">
            <button onclick="ocultarMuroVisual()" class="btn-gala w-full max-w-xs">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </button>
        </div>
    </div>
</section>

{{-- MODAL GLOBAL DE FILTRO Y CUESTIONARIO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div id="wrapper-dinamico-modal" class="bg-[#111] rounded-sm max-w-xl w-[95%] sm:w-full p-6 md:p-10 text-center shadow-2xl border border-white/10 max-h-[90svh] overflow-y-auto">
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4 text-left">
                <h3 class="text-sm md:text-base tracking-widest uppercase font-titular text-stone-200">
                    <i class="fas fa-key text-[#e3c5a8] mr-2"></i> Código Requerido
                </h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition p-2"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-6 text-left">
                <p class="text-xs md:text-sm text-stone-400 font-light leading-relaxed">Para interactuar en las dinámicas, ingresa el **Código de Pase Personal** que se te asignó al confirmar asistencia.</p>
                <div>
                    <label class="block text-[10px] md:text-xs uppercase tracking-widest text-stone-500 mb-2">Introduce tu Clave</label>
                    <input type="text" id="inputCodigoIngreso" placeholder="Ej: GALA-2841" class="w-full border border-white/20 bg-black/60 p-3 md:p-4 rounded-sm text-sm font-mono tracking-widest outline-none uppercase focus:border-[#e3c5a8] text-stone-200">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="btn-gala w-full mt-4">
                    Verificar Credencial
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="bg-[#111] border border-[#e3c5a8]/30 w-full max-w-2xl p-6 md:p-10 text-center shadow-2xl relative max-h-[90svh] flex flex-col font-sans">
        
        <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4 shrink-0 text-left">
            <h3 class="text-lg md:text-2xl font-titular uppercase tracking-widest text-[#e3c5a8]">
                <i class="fas fa-crown mr-2"></i> Cuadro de Honor
            </h3>
            <button onclick="cerrarModalRanking()" class="text-stone-500 hover:text-white transition p-2"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-2 space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-hourglass-half fa-spin text-3xl md:text-4xl text-[#e3c5a8]"></i>
            </div>
        </div>

        <div class="mt-6 pt-4 shrink-0">
            <button onclick="cerrarModalRanking()" class="btn-gala w-full">
                Cerrar Galería
            </button>
        </div>
    </div>
</div>

{{-- MODAL REDACCIÓN DE MENSAJES --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="bg-[#050505] text-white w-[95%] sm:w-full max-w-md p-6 md:p-10 border border-[#e3c5a8]/30 shadow-2xl max-h-[90svh] overflow-y-auto">
        <div class="flex justify-between items-center mb-8 border-b border-white/10 pb-4 text-left">
            <h3 class="text-sm md:text-base uppercase tracking-[0.2em] font-titular text-[#e3c5a8]">Redactar Saludo</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-stone-500 hover:text-white transition p-2"><i class="fas fa-times text-xl"></i></button>
        </div>

        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" class="space-y-5 text-left">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            <div>
                <label class="block text-[10px] md:text-xs font-bold uppercase tracking-[0.1em] text-[#e3c5a8]/80 mb-2">Nombre</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border border-white/10 bg-black/50 p-3 text-sm outline-none text-white font-light focus:border-[#e3c5a8]">
            </div>
            <div>
                <label class="block text-[10px] md:text-xs font-bold uppercase tracking-[0.1em] text-[#e3c5a8]/80 mb-2">Rol en el evento</label>
                <select name="vinculo_autor" required class="w-full border border-white/10 bg-[#050505] p-3 text-sm outline-none text-white focus:border-[#e3c5a8] cursor-pointer">
                    <option value="" disabled selected>Seleccione...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero">Compañero de trabajo</option>
                    <option value="Conocido">Conocido</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] md:text-xs font-bold uppercase tracking-[0.1em] text-[#e3c5a8]/80 mb-2">Tu Mensaje</label>
                <textarea name="contenido" required rows="4" class="w-full border border-white/10 bg-black/50 p-3 text-sm outline-none focus:border-[#e3c5a8] text-white font-light leading-relaxed" placeholder="Escribe tus deseos..."></textarea>
            </div>
            <div>
                <label class="block text-[10px] md:text-xs font-bold uppercase tracking-[0.1em] text-[#e3c5a8]/80 mb-2">Recuerdo Visual (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" class="w-full border border-white/10 bg-black/50 p-2 text-xs text-white/50 file:border-0 file:bg-[#e3c5a8] file:text-black file:px-4 file:py-2 file:font-bold file:mr-4 cursor-pointer rounded-sm">
            </div>
            <button type="submit" id="btnPublicarMuro" class="btn-gala w-full mt-4">Publicar Deseo</button>
        </form>
    </div>
</div>

{{-- MODAL PÚBLICO PARA REGISTRO DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="bg-[#111] text-white rounded-sm max-w-md w-[95%] sm:w-full p-6 md:p-10 text-center shadow-2xl border border-white/10 max-h-[90svh] overflow-y-auto">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4 text-left">
                <h3 class="text-sm md:text-base tracking-widest uppercase font-light font-titular text-[#e3c5a8]">Registro de Gala</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-500 hover:text-white transition p-2"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/60 p-5 rounded-sm border border-white/5 space-y-4">
                    <span class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] font-bold text-stone-400 block pb-2 border-b border-white/5"><i class="fas fa-user-tie mr-2"></i> Invitado Principal</span>
                    <div>
                        <label class="block text-[10px] md:text-xs uppercase tracking-widest text-stone-500 mb-2">Nombre Completo</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-white/20 bg-transparent p-3 rounded-sm text-sm outline-none focus:border-[#e3c5a8] text-stone-200">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs uppercase tracking-widest text-stone-500 mb-2">Correo (Opcional)</label>
                        <input type="email" id="inputEmailPrincipal" class="w-full border border-white/20 bg-transparent p-3 rounded-sm text-sm outline-none focus:border-[#e3c5a8] text-stone-200" placeholder="correo@ejemplo.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-4 border border-dashed border-white/20 text-stone-400 rounded-sm text-[10px] md:text-xs uppercase tracking-[0.2em] hover:bg-white/[0.05] hover:text-white transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Añadir Acompañante
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-gala w-full mt-6">
                    Confirmar Puesto
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO GALA --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-stone-500 hover:text-[#e3c5a8] transition z-50 p-2">
        <i class="fas fa-times text-3xl md:text-4xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-[#050505] p-2 md:p-3 shadow-2xl border border-[#e3c5a8]/30 rounded-sm" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80svh] bg-black"></video>
    </div>
</div>

<script>
    let moduloObjetivo = '';
    let bancoPreguntas = [];
    let preguntaActualIndex = 0;
    let puntajeAcumulado = 0;
    let tiempoInicio;
    let intervaloCronometro;
    let segundosTranscurridos = 0;
    let datosInvitadoValidado = { id: null, nombre: '', codigo: '' };

    document.addEventListener('DOMContentLoaded', function() {
        const fechaEvento = "{{ $evento->fecha_principal }}";
        const horaEvento = "{{ $evento->hora ?? '21:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='texto-oro text-2xl md:text-4xl font-firma py-10 text-center w-full'>¡La fiesta ha comenzado!</p>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.4em] text-white hover:text-[#e3c5a8] transition font-medium pb-1 border-b border-transparent hover:border-[#e3c5a8]">Comenzar Juego</button>
                        <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.4em] text-[#e3c5a8] transition font-medium pb-1 mt-2">Ver Posiciones</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.4em] text-white hover:text-[#e3c5a8] transition font-medium pb-1 border-b border-transparent hover:border-[#e3c5a8]">Escribir Saludo</button>
                        <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.4em] text-[#e3c5a8] transition font-medium pb-1 mt-2">Ver Muro <i class="fa-solid fa-arrow-right ml-1"></i></button>
                    `;
                }
                return;
            }

            document.getElementById('days').innerText = Math.floor(gap / d).toString().padStart(2, '0');
            document.getElementById('hours').innerText = Math.floor((gap % d) / h).toString().padStart(2, '0');
            document.getElementById('minutes').innerText = Math.floor((gap % h) / m).toString().padStart(2, '0');
            document.getElementById('seconds').innerText = Math.floor((gap % m) / s).toString().padStart(2, '0');
        };

        setInterval(updateCountdown, 1000);
        updateCountdown();
    });

    function mostrarMuroVisual() {
        const muro = document.getElementById('seccionMuroMensajes');
        muro.classList.remove('hidden');
        setTimeout(() => { muro.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 50);
    }

    function ocultarMuroVisual() {
        const muro = document.getElementById('seccionMuroMensajes');
        muro.previousElementSibling.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(() => { muro.classList.add('hidden'); }, 600);
    }

    function solicitarAccesoVerificacion(modulo) {
        moduloObjetivo = modulo;
        document.getElementById('wrapper-dinamico-modal').className = "bg-[#111] rounded-sm max-w-xl w-[95%] md:w-full p-6 md:p-10 text-center shadow-2xl border border-white/10 max-h-[90svh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4 text-left">
                    <h3 class="text-sm md:text-base tracking-widest uppercase font-light font-titular text-stone-200"><i class="fas fa-key text-[#e3c5a8] mr-2"></i> Código de Gala</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition p-2"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-6 text-left">
                    <p class="text-xs md:text-sm text-stone-400 font-light leading-relaxed">Para interactuar en las dinámicas, ingresa el **Código de Pase Personal** que se te asignó al confirmar asistencia.</p>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-stone-500 mb-2">Introduce tu Clave</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="Ej: GALA-2841" class="w-full border border-white/20 bg-black/60 p-3 md:p-4 rounded-sm text-sm font-mono tracking-widest outline-none uppercase focus:border-[#e3c5a8] text-stone-200">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="btn-gala w-full mt-4">
                        Verificar Credencial
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() { document.getElementById('modalFiltroAcceso').classList.add('hidden'); }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("Por favor, introduce un código válido."); return; }

        const btnVerificar = document.getElementById('btnVerificarCodigo');
        const txtOriginalVerificar = btnVerificar.innerHTML;
        
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> VERIFICANDO...';

        fetch(`/invitacion/validar-pase-trivia`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
        })
        .then(async response => {
            const data = await response.status === 422 || response.status === 404 || response.status === 200 ? await response.json() : {};
            
            if (response.status === 422 && data.already_played) {
                if (moduloObjetivo === 'trivia') {
                    const wrapper = document.getElementById('wrapper-dinamico-modal');
                    wrapper.className = "bg-[#111] rounded-sm max-w-xl w-[95%] md:w-full p-6 md:p-10 text-center shadow-2xl border border-white/10 max-h-[90svh] overflow-y-auto";
                    wrapper.innerHTML = `
                        <div class="py-6 text-center space-y-6 animate-pop">
                            <i class="fas fa-glass-cheers text-4xl text-[#e3c5a8] mb-4"></i>
                            <h3 class="text-xl font-titular uppercase tracking-widest text-stone-200">Participación Registrada</h3>
                            <p class="text-sm font-light text-stone-400 px-4 leading-relaxed">Tu puntuación ya forma parte de los registros de la noche.</p>
                            <div class="pt-6 space-y-4">
                                <button onclick="verRanking()" class="btn-gala w-full">Ver Cuadro de Honor</button>
                                <button onclick="cerrarModalFiltro()" class="w-full border border-stone-700 text-stone-400 hover:text-white py-3 transition text-[10px] uppercase tracking-widest">Cerrar Ventana</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Invitado" };
                }
            }
            if (!response.ok) { alert(data.message || "Pase inválido."); throw new Error("invalid_code"); }
            return data;
        })
        .then(data => {
            if(data && data.success) {
                datosInvitadoValidado = { id: data.invitado_id, nombre: data.nombre_invitado, codigo: codigo };

                if(moduloObjetivo === 'trivia') {
                    bancoPreguntas = data.preguntas;
                    preguntaActualIndex = 0; puntajeAcumulado = 0; segundosTranscurridos = 0;
                    montarPantallaInicioJuego();
                } else if(moduloObjetivo === 'muro') {
                    cerrarModalFiltro();
                    document.getElementById('hiddenCodigoMuro').value = codigo;
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Invitado" ? data.nombre_invitado : "Tu Familia/Amigos";
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => { 
            if (err.message !== "already_handled") console.error("Fallo filtro acceso:", err);
            if (btnVerificar) {
                btnVerificar.disabled = false;
                btnVerificar.classList.remove('opacity-50', 'cursor-not-allowed');
                btnVerificar.innerHTML = txtOriginalVerificar;
            }
        });
    }

    function abrirModalMuroBoda() { document.getElementById('modalMuroBoda').classList.remove('hidden'); }
    function cerrarModalMuroBoda() { document.getElementById('modalMuroBoda').classList.add('hidden'); }

    function enviarRecuerdoMemorial(event, eventoId){
        event.preventDefault();
        const botonPublicar = document.getElementById('btnPublicarMuro');
        const textoOriginal = botonPublicar.innerHTML;

        botonPublicar.disabled = true;
        botonPublicar.classList.add('cursor-not-allowed', 'opacity-50');
        botonPublicar.innerHTML = `<i class="fas fa-envelope fa-fade mr-2"></i> SELLANDO...`;

        const formData = new FormData(event.target);
        fetch(`/invitacion/memorial/${eventoId}/recuerdo`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: formData
        })
        .then(async response =>{
            const data = await response.json();
            if(!response.ok){
                alert(data.message || "Error al verificar la clave.");
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('cursor-not-allowed', 'opacity-50');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Fallo en la validación del código.");
            }
            return data;
        })
        .then(data =>{
            if (data.success) {
                document.getElementById('modalMuroBoda').firstElementChild.innerHTML = `
                    <div class="py-10 text-center space-y-6 animate-pop">
                        <div class="w-16 h-16 bg-[#e3c5a8]/10 rounded-full flex items-center justify-center mx-auto border border-[#e3c5a8]/30">
                            <i class="fas fa-check text-2xl text-[#e3c5a8]"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-titular uppercase tracking-widest text-stone-100">¡Mensaje Publicado!</h3>
                            <p class="text-xs text-stone-400 font-light px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="btn-gala w-full mt-6">
                            Cerrar
                        </button>
                    </div>
                `;
            }
        }).catch(error => {
            console.error("Error al enviar el recuerdo:", error);
            if (botonPublicar) {
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('cursor-not-allowed', 'opacity-50');
                botonPublicar.innerHTML = textoOriginal;
            }
        });
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 animate-pop">
                <i class="fas fa-gamepad text-3xl md:text-4xl text-[#e3c5a8] mb-4"></i>
                <span class="text-[10px] md:text-xs uppercase tracking-[0.2em] text-[#e3c5a8] font-light block">Trivia del Evento</span>
                <h1 class="text-2xl md:text-3xl font-titular text-white">¡Hola, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-stone-400 text-xs md:text-sm leading-relaxed px-4 font-light">Demuestra qué tanto conoces a los anfitriones. Responderás un total de <strong class="text-white">${bancoPreguntas.length} preguntas</strong>. ¡El tiempo es clave para el ranking!</p>
                
                <button onclick="comenzarJuegoModal()" class="btn-gala w-full mt-6">
                    Comenzar a Jugar
                </button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-semibold uppercase tracking-[0.2em] text-stone-500 border-b border-white/10 pb-4">
                    <span id="info-progreso">Pregunta 1 de X</span>
                    <span class="text-[#e3c5a8]"><i class="fas fa-clock mr-2"></i><span id="info-cronometro" class="font-mono text-sm">0s</span></span>
                </div>

                <h2 id="texto-pregunta" class="text-lg md:text-xl font-titular text-white leading-relaxed">Cargando pregunta...</h2>

                <div class="space-y-3 pt-4">
                    <button onclick="seleccionarOpcionModal('a')" class="w-full text-left p-4 bg-black/40 border border-white/10 hover:border-[#e3c5a8] transition-colors text-xs md:text-sm flex items-center space-x-4 text-stone-300 group">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-[#e3c5a8] border border-[#e3c5a8]/50 group-hover:bg-[#e3c5a8] group-hover:text-black transition-colors shrink-0">A</span>
                        <span id="texto-opcion-a" class="break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" class="w-full text-left p-4 bg-black/40 border border-white/10 hover:border-[#e3c5a8] transition-colors text-xs md:text-sm flex items-center space-x-4 text-stone-300 group">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-[#e3c5a8] border border-[#e3c5a8]/50 group-hover:bg-[#e3c5a8] group-hover:text-black transition-colors shrink-0">B</span>
                        <span id="texto-opcion-b" class="break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" class="w-full text-left p-4 bg-black/40 border border-white/10 hover:border-[#e3c5a8] transition-colors text-xs md:text-sm flex items-center space-x-4 text-stone-300 group">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-[#e3c5a8] border border-[#e3c5a8]/50 group-hover:bg-[#e3c5a8] group-hover:text-black transition-colors shrink-0">C</span>
                        <span id="texto-opcion-c" class="break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" class="w-full text-left p-4 bg-black/40 border border-white/10 hover:border-[#e3c5a8] transition-colors text-xs md:text-sm flex items-center space-x-4 text-stone-300 group">
                        <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-[#e3c5a8] border border-[#e3c5a8]/50 group-hover:bg-[#e3c5a8] group-hover:text-black transition-colors shrink-0">D</span>
                        <span id="texto-opcion-d" class="break-words">Opción D</span>
                    </button>
                </div>
            </div>
        `;
        tiempoInicio = Date.now();
        intervaloCronometro = setInterval(() => {
            segundosTranscurridos = Math.floor((Date.now() - tiempoInicio) / 1000);
            const crono = document.getElementById('info-cronometro');
            if(crono) crono.innerText = segundosTranscurridos + 's';
        }, 1000);
        renderizarPreguntaModal();
    }

    function renderizarPreguntaModal() {
        if(bancoPreguntas.length === 0) {
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-8 text-stone-400 text-sm font-light">Este evento no cuenta con preguntas de trivia configuradas.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `Pregunta ${preguntaActualIndex + 1} de ${bancoPreguntas.length}`;
        document.getElementById('texto-pregunta').innerText = q.pregunta;
        document.getElementById('texto-opcion-a').innerText = q.opcion_a;
        document.getElementById('texto-opcion-b').innerText = q.opcion_b;
        document.getElementById('texto-opcion-c').innerText = q.opcion_c;
        document.getElementById('texto-opcion-d').innerText = q.opcion_d;
    }

    function seleccionarOpcionModal(opcionElegida) {
        const q = bancoPreguntas[preguntaActualIndex];
        if (opcionElegida === q.respuesta_correcta) {
            puntajeAcumulado += parseInt(q.puntos);
        }

        preguntaActualIndex++;
        if (preguntaActualIndex < bancoPreguntas.length) {
            renderizarPreguntaModal();
        } else {
            finalizarTriviaModal();
        }
    }

    function finalizarTriviaModal() {
        clearInterval(intervaloCronometro);
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        
        wrapper.innerHTML = `
            <div class="text-center space-y-6 py-10 animate-pop">
                <i class="fas fa-spinner fa-spin text-4xl text-[#e3c5a8]"></i>
                <h3 class="text-xl font-titular uppercase text-white">Sincronizando puntuación...</h3>
                <p class="text-xs text-stone-500 font-light">Guardando tu récord en el servidor del evento.</p>
            </div>
        `;

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        const payload = {
            evento_id: "{{ $evento->evento_id }}",
            invitado_id: datosInvitadoValidado.id, 
            nombre_jugador: datosInvitadoValidado.nombre, 
            puntaje: puntajeAcumulado,
            tiempo_segundos: segundosTranscurridos
        };

        fetch('/invitacion/registrar-participacion-trivia', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': tokenCsrf },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                wrapper.innerHTML = `
                    <div class="text-center space-y-6 py-6 animate-pop">
                        <div class="w-16 h-16 bg-[#e3c5a8]/10 rounded-full flex items-center justify-center mx-auto border border-[#e3c5a8]/30 mb-4 shadow-xl">
                            <i class="fas fa-trophy text-2xl text-[#e3c5a8]"></i>
                        </div>
                        <h3 class="text-2xl font-titular uppercase text-white tracking-widest">¡Completado!</h3>
                        <p class="text-sm text-stone-400 max-w-xs mx-auto leading-relaxed">Tus respuestas han sido procesadas de forma exitosa.</p>
                        
                        <div class="grid grid-cols-2 gap-4 bg-black/40 p-5 border border-white/5 rounded-sm max-w-xs mx-auto text-left">
                            <div class="border-r border-white/10 pr-2">
                                <span class="block text-[9px] uppercase font-bold tracking-widest text-[#e3c5a8] mb-1">Puntaje</span>
                                <span class="text-xl font-bold text-white">${puntajeAcumulado} <span class="text-[9px] text-stone-500 font-normal">pts</span></span>
                            </div>
                            <div class="text-left pl-2">
                                <span class="block text-[9px] uppercase font-bold tracking-widest text-[#e3c5a8] mb-1">Tiempo</span>
                                <span class="text-xl font-bold text-white">${segundosTranscurridos} <span class="text-[9px] text-stone-500 font-normal">seg</span></span>
                            </div>
                        </div>

                        <div class="pt-6 space-y-4">
                            <button onclick="verRanking()" class="btn-gala w-full">Ver Cuadro de Honor</button>
                            <button onclick="cerrarModalFiltro()" class="w-full bg-transparent border border-stone-700 text-stone-400 hover:text-white py-3 rounded-sm text-[10px] uppercase tracking-[0.2em] transition">Terminar</button>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            wrapper.innerHTML = `<p class="text-red-500 font-bold text-sm mt-8"><i class="fas fa-exclamation-triangle mr-2"></i> Error al guardar la puntuación.</p>`;
        });
    }

    // --- LÓGICA DEL RANKING ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-hourglass-half fa-spin text-4xl text-[#e3c5a8]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-stone-500 text-center font-light italic mt-10 text-sm">La lista de honor aún no tiene registros.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-lg text-stone-600 font-titular mr-4 w-6 text-center shrink-0">#${index + 1}</span>`;
                        let resplandor = 'border-white/5 bg-black/40 text-stone-300';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-crown text-[#e3c5a8] text-2xl mr-4 w-6 text-center shrink-0 drop-shadow-md"></i>';
                            resplandor = 'border-[#e3c5a8]/40 bg-[#e3c5a8]/5 text-white scale-[1.02] z-10 relative shadow-[0_0_15px_rgba(227,197,168,0.1)]';
                        } else if(index === 1) {
                            medalla = '<i class="fas fa-medal text-stone-300 text-xl mr-4 w-6 text-center shrink-0"></i>';
                            resplandor = 'border-stone-400/30 bg-white/5 text-stone-200';
                        } else if(index === 2) {
                            medalla = '<i class="fas fa-medal text-amber-700 text-xl mr-4 w-6 text-center shrink-0"></i>';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-4 animate-pop mb-3 rounded-sm">
                                <div class="flex items-center truncate pr-4">
                                    ${medalla}
                                    <span class="font-light tracking-widest text-xs md:text-sm uppercase truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block font-bold text-lg md:text-xl leading-none text-[#e3c5a8]">${jugador.puntaje_total} <span class="text-[9px] text-stone-500 font-normal">PTS</span></span>
                                    <span class="block text-[9px] text-stone-500 tracking-widest uppercase mt-1 border-t border-white/10 pt-1">${jugador.tiempo_empleado} SEG</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 text-center mt-10 text-xs uppercase tracking-widest">Error al cargar la lista.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 text-center mt-10 text-xs uppercase tracking-widest">Fallo de conexión.</p>';
        });
    }

    function cerrarModalRanking() {
        document.getElementById('modalRanking').classList.add('hidden');
    }

    let contadorAcompanantes = 0;
    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-white/5 p-4 md:p-5 rounded-sm border border-white/10 space-y-4 relative animate-pop";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-white/10 pb-2">
                <span class="text-[9px] md:text-[10px] uppercase tracking-widest font-bold text-stone-400">Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-stone-500 hover:text-rose-400 text-[10px] font-bold transition">
                    <i class="fas fa-trash-alt"></i> Quitar
                </button>
            </div>
            <div>
                <input type="text" class="input-nombre-acompanante w-full border border-white/20 bg-transparent p-3 rounded-sm text-sm outline-none focus:border-[#e3c5a8] text-stone-200" placeholder="Nombre Completo *" required>
            </div>
            <div>
                <input type="email" class="input-email-acompanante w-full border border-white/20 bg-transparent p-3 rounded-sm text-sm outline-none focus:border-[#e3c5a8] text-stone-200" placeholder="Correo (Opcional)">
            </div>
        `;
        document.getElementById('contenedorAcompanantes').appendChild(div);
    }
    function removerCampoAcompanante(id) { document.getElementById(`acompanante_row_${id}`)?.remove(); }
    
    function abrirModalAsistencia() { document.getElementById('modalAsistencia').classList.remove('hidden'); }
    function cerrarModalAsistencia() { document.getElementById('modalAsistencia').classList.add('hidden'); }

    function enviarDatosAsistencia(event, eventoId) {
        event.preventDefault();
        
        const btnConfirmar = document.getElementById('btnConfirmarAsistencia');
        const txtOriginalConfirmar = btnConfirmar.innerHTML;
        
        btnConfirmar.disabled = true;
        btnConfirmar.classList.add('opacity-50', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> PROCESANDO...';

        const nodosNombres = document.querySelectorAll('.input-nombre-acompanante');
        const nodosEmails = document.querySelectorAll('.input-email-acompanante');
        const listaAcompanantes = Array.from(nodosNombres).map((input, index) => {
            return {
                nombre: input.value.trim(),
                email: nodosEmails[index]?.value.trim() || ''
            };
        }).filter(a => a.nombre !== "");
        
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
                btnConfirmar.classList.remove('opacity-50', 'cursor-not-allowed');
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
                    <div class="py-8 px-2 text-center space-y-6 animate-pop">
                        <i class="fas fa-exclamation-triangle text-4xl text-[#e3c5a8] mb-2"></i>
                        <h3 class="text-xl font-titular uppercase tracking-widest text-stone-200">Registro Existente</h3>
                        <p class="text-xs text-stone-400 font-light leading-relaxed">${data.message}</p>
                        <div class="p-4 bg-black/40 border border-white/5 rounded-sm text-[10px] text-stone-500 text-left leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i> Si necesitas modificar los cupos reservados, por favor contacta directamente a los anfitriones.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-gala w-full mt-4">
                            Entendido
                        </button>
                    </div>
                `;
                throw new Error("already_handled");
            }

            if (!response.ok) {
                throw new Error("Error en el Servidor Laravel.");
            }
            return data;
        })
        .then(data => {
            if (data && data.success) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                
                contenedorModal.innerHTML = `
                    <div class="py-8 px-2 text-center space-y-6 animate-pop">
                        <i class="fas fa-check text-4xl text-[#e3c5a8] mb-2 border border-[#e3c5a8]/30 p-4 rounded-full"></i>
                        
                        <h3 class="text-2xl font-titular uppercase tracking-widest text-stone-100">¡Plaza Confirmada!</h3>
                        <p class="text-[10px] text-stone-400 font-light uppercase tracking-widest">Pases Personales de Gala</p>

                        <div class="bg-black border border-[#e3c5a8]/20 rounded-sm p-5 text-left space-y-4 shadow-xl">
                            <div class="text-xs space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t border-white/10' : ''}">
                                        <span class="font-sans font-light text-stone-300 truncate pr-2 uppercase tracking-wide">${item.nombre}</span> 
                                        <span class="bg-[#e3c5a8] px-3 py-1.5 rounded-sm text-[10px] font-bold text-black font-mono tracking-[0.2em] shrink-0">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[9px] text-stone-500 italic leading-relaxed px-4">Utiliza estos códigos en el Muro de Deseos o en la Trivia durante la velada.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="btn-gala w-full mt-4">
                            Guardar y Cerrar
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-8 py-4 border border-[#e3c5a8]/50 text-[10px] md:text-xs tracking-[0.3em] uppercase text-[#e3c5a8] w-full max-w-xs md:max-w-md mx-auto bg-[#e3c5a8]/5 rounded-sm animate-pop font-light mt-4">
                        <i class="fas fa-check mr-2"></i> Asistencia Confirmada
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("Ocurrió un inconveniente al procesar tu RSVP.");
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-50', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    function playPreview(elemento) {
        const vid = elemento.querySelector('.vid-preview');
        if(vid) { vid.play().catch(e => console.log('Autoplay prevenido por navegador')); }
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

    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('border-[#e3c5a8]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('border-[#e3c5a8]');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} SELECCIONADAS`;
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
            alert("Por favor, selecciona al menos un recuerdo para descargar.");
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
            alert("La galería aún está vacía.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>