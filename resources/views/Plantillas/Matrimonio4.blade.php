<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | The Movie</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;700&family=Bungee+Shade&family=Syne:wght@400;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --electric-orange: #ff5f1f;
            --deep-midnight: #0a0e1a;
            --soft-cream: #f0ede5;
        }

        h1, h2, h3 { font-family: 'Syne', sans-serif; font-weight: 800; }
        .font-display { font-family: 'Bungee Shade', cursive; }
        body { 
            font-family: 'Space Grotesk', sans-serif; 
            background-color: var(--deep-midnight); 
            color: var(--soft-cream);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .snap-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            overflow-x: hidden;
        }

        /* Ajustes responsivos para las secciones */
        .section-creative {
            min-height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            padding: 2rem 1rem;
        }
        @media (min-width: 768px) {
            .section-creative { height: 100vh; padding: 0; }
        }

        /* Texto que se mueve de fondo */
        .scrolling-text {
            position: absolute;
            white-space: nowrap;
            font-size: 8vh;
            font-weight: 800;
            opacity: 0.05;
            z-index: 0;
            animation: marquee 20s linear infinite;
            pointer-events: none;
        }
        @media (min-width: 768px) {
            .scrolling-text { font-size: 15vh; }
        }

        @keyframes marquee {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }

        /* El "Marco de Película" para la foto */
        .photo-frame {
            position: relative;
            width: 100%;
            max-width: 300px;
            height: 350px;
            border: 2px solid var(--electric-orange);
            transform: rotate(-3deg);
            transition: all 0.5s ease;
        }
        @media (min-width: 768px) {
            .photo-frame { height: 400px; }
        }

        .photo-frame:hover {
            transform: rotate(0deg) scale(1.05);
            box-shadow: 0 0 30px var(--electric-orange);
        }

        /* Botón Futurista Responsivo */
        .btn-neo {
            background: var(--electric-orange);
            color: var(--deep-midnight);
            padding: 1rem 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            clip-path: polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0% 100%);
            transition: 0.3s;
            cursor: pointer;
            border: none;
            width: 100%;
            text-align: center;
            display: inline-block;
        }
        @media (min-width: 768px) {
            .btn-neo { padding: 1.5rem 3rem; clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%); width: auto; }
        }

        .btn-neo:hover {
            clip-path: polygon(0 0, 90% 0, 100% 100%, 10% 100%);
            letter-spacing: 2px;
        }
        @media (min-width: 768px) {
            .btn-neo:hover { letter-spacing: 3px; }
        }

        /* Contador estilo cronómetro retro responsivo */
        .retro-counter {
            display: flex;
            gap: 10px;
            background: rgba(255, 95, 31, 0.1);
            padding: 15px;
            border-radius: 0 30px 0 30px;
            border: 1px solid var(--electric-orange);
            justify-content: center;
        }
        @media (min-width: 768px) {
            .retro-counter { gap: 20px; padding: 20px; border-radius: 0 50px 0 50px; justify-content: flex-start; }
        }

        /* Ocultar Scrollbar */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* Animación Fade In */
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .animate-pop { animation: popIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes popIn { from { opacity: 0; transform: scale(0.97); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '20:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: EL POSTER (HOME) --}}
    <section class="section-creative !p-0">
        <div class="scrolling-text uppercase">Save the date • {{ $evento->nombre_evento }} • Save the date</div>
        
        <div class="z-10 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-center max-w-6xl px-4 md:px-6 w-full mt-10 md:mt-0">
            <div class="photo-frame mx-auto md:mx-0 order-2 md:order-1 bg-[#111]">
                {{-- AQUÍ SOLO USAMOS LA FOTO LOCAL DEL DISEÑO --}}
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                @endif
                <div class="absolute -top-3 -left-3 md:-top-5 md:-left-5 bg-[#ff5f1f] text-black font-bold px-3 md:px-4 py-1 text-[10px] md:text-xs uppercase">Estreno mundial</div>
            </div>

            <div class="space-y-4 md:space-y-6 order-1 md:order-2 text-center md:text-left">
                <h1 class="text-5xl sm:text-6xl md:text-9xl leading-[0.9] uppercase tracking-tighter italic break-words">
                    {{ str_replace(' y ', ' + ', $evento->nombre_evento) }}
                </h1>
                <p class="text-lg md:text-2xl text-[#ff5f1f] font-bold">UNA HISTORIA DE AMOR REAL</p>
                
                <div class="retro-counter mt-6 md:mt-10 w-[95%] md:w-auto mx-auto md:mx-0">
                    <div class="text-center min-w-[50px]">
                        <span id="days" class="text-3xl md:text-4xl block font-bold tracking-tighter">00</span>
                        <span class="text-[8px] md:text-[10px] uppercase opacity-50 font-bold tracking-widest">Días</span>
                    </div>
                    <div class="text-center border-l border-orange-500/30 pl-2 md:pl-4 min-w-[50px]">
                        <span id="hours" class="text-3xl md:text-4xl block font-bold tracking-tighter">00</span>
                        <span class="text-[8px] md:text-[10px] uppercase opacity-50 font-bold tracking-widest">Hrs</span>
                    </div>
                    <div class="text-center border-l border-orange-500/30 pl-2 md:pl-4 min-w-[50px]">
                        <span id="minutes" class="text-3xl md:text-4xl block font-bold tracking-tighter">00</span>
                        <span class="text-[8px] md:text-[10px] uppercase opacity-50 font-bold tracking-widest">Min</span>
                    </div>
                    <div class="text-center border-l border-orange-500/30 pl-2 md:pl-4 min-w-[50px]">
                        <span id="seconds" class="text-3xl md:text-4xl block font-bold text-[#ff5f1f]">00</span>
                        <span class="text-[8px] md:text-[10px] uppercase opacity-50 font-bold tracking-widest">Seg</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: LA TRAMA (HISTORIA) --}}
    <section class="section-creative bg-[#0c1221]">
        <div class="max-w-4xl px-4 md:px-8 text-center space-y-6 md:space-y-8">
            <span class="font-display text-3xl md:text-6xl text-orange-500 opacity-20 block">Sinopsis</span>
            <h2 class="text-4xl sm:text-5xl md:text-7xl font-extrabold uppercase italic">¿Cómo empezó todo?</h2>
            <p class="text-base sm:text-lg md:text-3xl font-light leading-relaxed tracking-tight text-stone-400">
                "{{ $evento->biografia_resumen }}"
            </p>
            <div class="w-16 md:w-20 h-1 md:h-2 bg-[#ff5f1f] mx-auto mt-6 md:mt-10"></div>
        </div>
    </section>

    {{-- SECCIÓN 3: LOCACIÓN (CO-PRODUCTION) --}}
    <section class="section-creative !p-0 block md:flex h-auto md:h-screen">
        <div class="grid grid-cols-1 md:grid-cols-2 w-full h-full">
            <div class="bg-[#ff5f1f] flex flex-col justify-center p-8 sm:p-12 md:p-24 text-black min-h-[50vh] md:min-h-full">
                <h2 class="text-5xl md:text-8xl font-black uppercase italic mb-4 md:mb-8 text-center md:text-left">Locación</h2>
                <p class="text-xl md:text-2xl font-bold mb-8 md:mb-10 tracking-tighter text-center md:text-left">{{ $evento->ubicacion_texto }}</p>
                @if($evento->google_maps_url)
                <div class="w-full flex justify-center md:justify-start">
                    <a href="{{ $evento->google_maps_url }}" target="_blank" class="text-black border-2 border-black px-6 md:px-8 py-3 w-full md:w-max font-bold hover:bg-black hover:text-[#ff5f1f] transition text-center">
                        VER MAPA DE RODAJE
                    </a>
                </div>
                @endif
            </div>
            <div class="relative overflow-hidden min-h-[50vh] md:min-h-full">
                @if($evento->fotosGaleria->count() > 1)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" class="absolute inset-0 w-full h-full object-cover grayscale">
                @endif
                <div class="absolute inset-0 bg-orange-500/20 mix-blend-multiply"></div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCION (THE EXTRAS) --}}
    <section class="section-creative bg-black !p-0 block md:flex h-auto md:h-screen">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 w-full h-full items-stretch">
            
            {{-- BLOQUE TRIVIA CINEMA --}}
            <div class="p-8 md:p-16 border-b md:border-b-0 md:border-r border-orange-500/20 flex flex-col justify-center items-center group cursor-pointer hover:bg-[#ff5f1f] transition-all duration-500 min-h-[50vh] md:min-h-full">
                <h3 class="text-4xl sm:text-5xl md:text-7xl font-black uppercase italic group-hover:text-black transition-colors text-center">TRIVIA</h3>
                <p class="text-orange-500 group-hover:text-black mt-2 md:mt-4 font-bold tracking-widest uppercase mb-4 md:mb-6 text-xs md:text-base text-center transition-colors">Casting de invitados</p>
                <div id="wrapper-btn-trivia" class="w-full max-w-[250px] md:max-w-xs flex flex-col gap-3">
                    @if($yaComenzo)
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full py-3 md:py-2 bg-transparent text-white border border-white font-bold text-xs uppercase tracking-wider hover:bg-black hover:text-[#ff5f1f] transition">Jugar Ahora</button>
                        <button onclick="verRanking()" class="w-full py-3 md:py-2 bg-transparent text-white border-b border-white/50 font-bold text-xs uppercase tracking-wider hover:text-black hover:border-black transition">Ver Posiciones</button>
                    @else
                        <button id="btn-time-trivia" disabled class="w-full py-3 md:py-2 bg-stone-800 text-stone-500 text-[10px] md:text-xs font-bold uppercase tracking-wider cursor-not-allowed">
                            <i class="fas fa-lock mr-1"></i> Bloqueado hasta el estreno
                        </button>
                    @endif
                </div>
            </div>

            {{-- BLOQUE MURO CINEMA --}}
            <div class="p-8 md:p-16 flex flex-col justify-center items-center group cursor-pointer hover:bg-white transition-all duration-500 min-h-[50vh] md:min-h-full">
                <h3 class="text-4xl sm:text-5xl md:text-7xl font-black uppercase italic text-white group-hover:text-black transition-colors text-center">MURO</h3>
                <p class="text-stone-500 group-hover:text-black mt-2 md:mt-4 font-bold tracking-widest uppercase italic mb-4 md:mb-6 text-xs md:text-base text-center transition-colors">Palabras de la crítica</p>
                <div id="wrapper-btn-muro" class="w-full max-w-[250px] md:max-w-xs flex flex-col gap-3">
                    @if($yaComenzo)
                        <button onclick="solicitarAccesoVerificacion('muro')" class="w-full py-3 md:py-2 bg-transparent text-white border border-black font-bold text-xs uppercase tracking-wider hover:bg-black hover:text-white transition group-hover:border-black group-hover:text-black">Escribir Crítica</button>
                        <button onclick="mostrarMuroVisual()" class="w-full py-3 md:py-2 bg-[#ff5f1f] text-black border border-[#ff5f1f] font-bold text-xs uppercase tracking-wider hover:bg-orange-600 transition">Ver Críticas</button>
                    @else
                        <button id="btn-time-muro" disabled class="w-full py-3 md:py-2 bg-stone-800 text-stone-500 text-[10px] md:text-xs font-bold uppercase tracking-wider cursor-not-allowed">
                            <i class="fas fa-lock mr-1"></i> Bloqueado hasta el estreno
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </section>

    {{-- SECCIÓN OCULTA: MURO DE RECUERDOS (CRÍTICAS) --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[#0c1221]/98 backdrop-blur-md overflow-y-auto w-full h-full text-white">
        <div class="max-w-6xl w-full mx-auto px-4 md:px-6 py-12 md:py-16 text-center min-h-screen flex flex-col relative z-10">
            
            <div class="mb-10 md:mb-16 animate-pop">
                <h2 class="text-4xl sm:text-5xl md:text-7xl font-display text-[#ff5f1f]">Las Críticas</h2>
                <p class="text-stone-400 mt-2 md:mt-4 text-xs md:text-base tracking-widest uppercase">Lo que dice el público</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 flex-grow items-start">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="bg-[#111625] border border-stone-800 p-5 md:p-6 relative group hover:border-[#ff5f1f] transition duration-300 flex flex-col text-left h-full">
                        
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="mb-4 overflow-hidden border border-stone-700 shrink-0">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" 
                                     class="w-full h-40 md:h-56 object-cover grayscale group-hover:grayscale-0 transition duration-500">
                            </div>
                        @endif
                        
                        <div class="flex flex-col flex-grow justify-between space-y-3 md:space-y-4">
                            <p class="text-sm md:text-lg text-stone-300 font-light italic leading-relaxed break-words">
                                "{{ $item->contenido_texto }}"
                            </p>
                            
                            <div class="pt-3 md:pt-4 border-t border-stone-800 flex justify-between items-center mt-auto">
                                <span class="text-[#ff5f1f] font-bold uppercase tracking-wider text-[10px] md:text-xs truncate pr-2">
                                    {{ $item->nombre_autor }}
                                </span>
                                <div class="flex gap-1 text-orange-500 text-[10px] md:text-xs shrink-0">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 md:py-20 border border-dashed border-stone-800 bg-[#111625] mx-4">
                        <p class="text-stone-500 text-sm md:text-lg">Aún no hay críticas registradas. ¡Sé el primero en calificar este evento!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 md:mt-16 pb-8 w-full flex justify-center">
                <button onclick="ocultarMuroVisual()" class="border border-[#ff5f1f] text-[#ff5f1f] px-6 md:px-8 py-3 text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-[#ff5f1f] hover:text-black transition inline-block w-full max-w-xs">
                    Cerrar Críticas
                </button>
            </div>
            
        </div>
    </section>

    {{-- SECCIÓN 4.5: METRAJE EXCLUSIVO (TIEMPO REAL CLOUD) CON SOPORTE DE VIDEO --}}
    <section class="section-creative bg-[#050811] !h-auto py-20 min-h-[60vh] !block">
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-20 mx-auto">
            
            <div class="text-center mb-8 md:mb-12 w-full">
                <span class="font-display text-2xl md:text-4xl text-orange-500 opacity-30 block mb-2">Director's Cut</span>
                <h2 class="text-4xl sm:text-5xl md:text-7xl font-extrabold uppercase italic text-white drop-shadow-md">Detrás de Escenas</h2>
                <div class="w-16 md:w-20 h-1 md:h-2 bg-[#ff5f1f] mx-auto mt-6"></div>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 bg-[#0a0e1a] p-4 md:p-6 border border-stone-800 rounded-none shadow-[0_0_15px_rgba(255,95,31,0.05)] gap-4">
                <span id="contador-seleccionadas" class="font-black italic text-xl md:text-2xl text-[#ff5f1f] tracking-widest uppercase">
                    0 Tomas Seleccionadas
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border border-[#ff5f1f] text-[#ff5f1f] hover:bg-[#ff5f1f] hover:text-black transition uppercase tracking-widest px-6 py-3 w-full md:w-auto rounded-none">
                        <i class="fas fa-download mr-2"></i> Extraer Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-neo !w-full md:!w-auto text-[10px] md:text-xs !py-3">
                        <i class="fas fa-film mr-2"></i> Descargar Todo
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
                                'etiqueta' => 'RODAJE OFICIAL'
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
                            'etiqueta' => 'TOMA DE FANS'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 w-full max-h-[60vh] overflow-y-auto hide-scroll p-2">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer border-2 border-transparent hover:border-[#ff5f1f]/80 transition-all duration-300 overflow-hidden bg-black flex items-center justify-center rounded-none" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/30 hover:bg-black/10 transition">
                                <i class="fas fa-play-circle text-4xl text-white/80 group-hover:text-[#ff5f1f] group-hover:scale-110 transition drop-shadow-[0_0_15px_rgba(0,0,0,0.9)]"></i>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[#ff5f1f]/20 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-2 right-2 bg-black text-[#ff5f1f] rounded-none w-6 h-6 md:w-8 md:h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 border border-[#ff5f1f] shadow-[0_0_10px_rgba(255,95,31,0.5)] z-30 pointer-events-none">
                            <i class="fas fa-check text-[10px] md:text-sm"></i>
                        </div>

                        <div class="absolute bottom-2 left-2 right-2 bg-black/90 text-[#ff5f1f] text-[7px] md:text-[9px] px-2 py-1.5 font-mono uppercase tracking-[0.2em] border border-stone-800 truncate text-left z-30 pointer-events-none">
                            @if($foto['esVideo'])
                                <i class="fas fa-video mr-1"></i>
                            @else
                                <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera-retro' }} mr-1"></i>
                            @endif
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border border-dashed border-stone-700 p-10 bg-[#0a0e1a]">
                        <p class="text-stone-500 font-bold uppercase tracking-widest text-sm md:text-lg">NO HAY METRAJE DISPONIBLE AÚN.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP (THE END) --}}
    <section class="section-creative relative">
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 md:px-6 w-full max-w-4xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <h2 class="font-display text-6xl sm:text-8xl md:text-[150px] mb-6 md:mb-10 text-orange-500 leading-none">FIN</h2>
                <p class="text-lg sm:text-xl md:text-4xl font-bold uppercase tracking-tighter mb-8 md:mb-12 italic leading-tight text-white/90">¿Contamos con tu presencia en el estreno?</p>
                
                <div id="contenedorBotonPrincipalRSVP" class="w-full flex justify-center">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-neo w-full max-w-xs md:max-w-md">
                            Confirmar Asistencia
                        </button>
                    @else
                        <div class="px-4 md:px-8 py-3 md:py-4 border-2 border-dashed border-[#ff5f1f] text-[10px] md:text-xs font-bold uppercase tracking-wider text-[#ff5f1f] w-full max-w-xs md:max-w-md mx-auto bg-black/40 shadow-lg">
                            Código de Entrada (QR) Obligatorio
                        </div>
                    @endif
                </div>
                
                <div class="mt-12 md:mt-20 flex flex-wrap justify-center gap-4 md:gap-10 text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.4em] opacity-40 text-white">
                    <span>CINE: {{ $evento->id_plantilla }}</span>
                    <span class="hidden sm:inline">•</span>
                    <span>FILA: {{ $invitado->mesa_asignada ?? 'X' }}</span>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-50 hover:opacity-100 transition-all duration-300 group cursor-pointer">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-white/50 mb-1.5 font-medium">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono naranja --}}
                        <i class="fas fa-glass-cheers text-[11px] md:text-xs text-orange-500"></i>
                        {{-- Eventify blanco que pasa a naranja en hover --}}
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-white/80 group-hover:text-orange-500 transition-colors" style="font-family: 'Playfair Display', serif;">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO Y CORE DE JUEGO DE TRIVIA --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div id="wrapper-dinamico-modal" class="bg-[#111625] text-white rounded-none max-w-xl w-[95%] md:w-full p-6 md:p-8 text-center shadow-2xl border-2 border-[#ff5f1f] max-h-[95vh] overflow-y-auto font-sans-body">
        
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-orange-500/20 pb-3 md:pb-4 text-left">
                <h3 class="text-lg md:text-xl font-black tracking-wide uppercase italic text-stone-100"><i class="fas fa-key text-[#ff5f1f] mr-2"></i> Verificación de Elenco</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[#ff5f1f] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-4 md:space-y-6 text-left">
                <p class="text-[10px] md:text-xs text-stone-400 font-light leading-relaxed font-mono">Para acceder a la sala, introduce el **Código de Pase Personal** que se te entregó en pantalla al confirmar tu boleto.</p>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#ff5f1f] mb-1 md:mb-2">Clave de Boleto</label>
                    <input type="text" id="inputCodigoIngreso" placeholder="Ej: JON-4819" class="w-full border border-stone-700 bg-black/60 p-2 md:p-3 rounded-none text-xs md:text-sm font-mono tracking-widest outline-none uppercase focus:border-[#ff5f1f] text-stone-200">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="w-full bg-[#ff5f1f] text-black py-3 md:py-3.5 rounded-none font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition shadow-lg block mt-2 md:mt-4">
                    Validar Entrada
                </button>
            </div>
        </div>

    </div>
</div>

{{-- MODAL RANKING DE TRIVIA (THE BOX OFFICE) --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div class="bg-[#0c1221] border-2 border-[#ff5f1f] w-full max-w-2xl p-6 md:p-8 text-center shadow-[0_0_20px_rgba(255,95,31,0.2)] md:shadow-[0_0_40px_rgba(255,95,31,0.2)] relative max-h-[95vh] flex flex-col font-sans">
        
        <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-orange-500/30 pb-3 md:pb-4 shrink-0 text-left">
            <h3 class="text-xl md:text-2xl font-black italic uppercase tracking-wider md:tracking-widest text-stone-100">
                <i class="fas fa-ticket-alt text-[#ff5f1f] mr-2"></i> LA TAQUILLA
            </h3>
            <button onclick="cerrarModalRanking()" class="text-stone-500 hover:text-[#ff5f1f] transition"><i class="fas fa-times text-2xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-1 md:pr-2 space-y-2 md:space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-film fa-spin text-4xl text-[#ff5f1f]"></i>
            </div>
        </div>

        <div class="mt-4 md:mt-6 pt-3 md:pt-4 shrink-0">
            <button onclick="cerrarModalRanking()" class="w-full py-3 md:py-4 border border-[#ff5f1f] text-[#ff5f1f] font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-[#ff5f1f] hover:text-black transition">
                CERRAR TAQUILLA
            </button>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO PARA EL MURO DE DESEOS DE BODAS (LA CRÍTICA) --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
    <div class="bg-[#111625] text-white rounded-none max-w-md w-full p-6 md:p-8 text-center shadow-2xl border-2 border-[#ff5f1f] max-h-[95vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-orange-500/20 pb-3 md:pb-4 text-left">
            <h3 class="text-lg md:text-xl font-black tracking-wide uppercase italic text-stone-100">Redactar Crítica</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-stone-400 hover:text-[#ff5f1f] transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-4 md:space-y-5 text-left">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#ff5f1f] mb-1 md:mb-2">Nombre del Actor</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border border-stone-800 bg-black/40 p-2 md:p-3 rounded-none text-xs md:text-sm outline-none text-stone-400 font-mono">
            </div>
             <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#ff5f1f] mb-1 md:mb-2">Rol en el elenco *</label>
                <select name="vinculo_autor" required class="w-full border border-stone-700 bg-black/60 p-2 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-[#ff5f1f] text-stone-200 font-mono cursor-pointer">
                    <option value="" disabled selected>Seleccione...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero">Compañero de trabajo</option>
                    <option value="Conocido">Conocido</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#ff5f1f] mb-1 md:mb-2">Tu Reseña / Mensaje *</label>
                <textarea name="contenido" required rows="3" class="w-full border border-stone-700 bg-black/60 p-2 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-[#ff5f1f] text-stone-200 font-mono" placeholder="¡Excelente producción!"></textarea>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#ff5f1f] mb-1 md:mb-2">Foto Detrás de Escenas (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" class="w-full border border-stone-700 bg-black/60 p-1 md:p-2 rounded-none text-[10px] md:text-sm outline-none text-stone-400 font-mono cursor-pointer">
            </div>

            <button type="submit" id="btnPublicarMuro" class="w-full bg-[#ff5f1f] text-black py-3 md:py-3.5 rounded-none font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition shadow-lg block mt-2 md:mt-4">
                Publicar Reseña
            </button>
        </form>
    </div>
</div>

{{-- MODAL PÚBLICO PARA REGISTRO DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
    <div class="bg-[#111625] text-white rounded-none max-w-md w-full p-6 md:p-8 text-center shadow-2xl border-2 border-[#ff5f1f] max-h-[95vh] overflow-y-auto">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-orange-500/20 pb-3 md:pb-4 text-left">
                <h3 class="text-lg md:text-xl font-black tracking-wide uppercase italic text-stone-100"><i class="fas fa-ticket-alt mr-2 text-[#ff5f1f]"></i> Pase de Entrada</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-[#ff5f1f] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-4 md:space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/40 p-4 md:p-5 rounded-none border-l-4 border-[#ff5f1f] space-y-3 md:space-y-4">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-[#ff5f1f] block">Actor Principal</span>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold uppercase tracking-wider text-stone-400 mb-1">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-stone-700 bg-black/60 p-2 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-[#ff5f1f] text-stone-200 font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold uppercase tracking-wider text-stone-400 mb-1">Correo de Contacto</label>
                        <input type="email" id="inputEmailPrincipal" class="w-full border border-stone-700 bg-black/60 p-2 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-[#ff5f1f] text-stone-200 font-mono" placeholder="actor@cine.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-3 md:space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2 md:py-3 border border-dashed border-orange-500/40 text-orange-400 rounded-none text-[10px] md:text-xs font-bold uppercase tracking-wider hover:bg-orange-500/5 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus text-[8px] md:text-[10px]"></i> Registrar Elenco Extra
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full bg-[#ff5f1f] text-black py-3 md:py-4 rounded-none font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition shadow-lg block mt-2">
                    Confirmar Boleto
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO CINEMA --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-stone-500 hover:text-[#ff5f1f] transition z-50 bg-black/40 w-12 h-12 rounded-full flex items-center justify-center border border-stone-800">
        <i class="fas fa-times text-2xl drop-shadow-md"></i>
    </button>
    <div class="w-full max-w-4xl bg-[#050505] overflow-hidden shadow-[0_20px_50px_rgba(255,95,31,0.2)] border-2 border-[#ff5f1f]" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
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
        const horaEvento = "{{ $evento->hora ?? '20:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='text-xl md:text-2xl font-black italic text-orange-500 uppercase text-center w-full'>¡EN CARTELERA!</p>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full py-3 md:py-2 bg-transparent text-white border border-white font-bold text-xs uppercase tracking-wider hover:bg-black hover:text-[#ff5f1f] transition mb-3">Jugar Ahora</button>
                        <button onclick="verRanking()" class="w-full py-3 md:py-2 bg-transparent text-white border-b border-white/50 font-bold text-xs uppercase tracking-wider hover:text-black hover:border-black transition">Ver Posiciones</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="w-full py-3 md:py-2 bg-transparent text-white border border-black font-bold text-xs uppercase tracking-wider hover:bg-black hover:text-white transition group-hover:border-black group-hover:text-black mb-3">Escribir Crítica</button>
                        <button onclick="mostrarMuroVisual()" class="w-full py-3 md:py-2 bg-[#ff5f1f] text-black border border-[#ff5f1f] font-bold text-xs uppercase tracking-wider hover:bg-orange-600 transition">Ver Críticas</button>
                    `;
                }
                return;
            }

            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
            document.getElementById('days').innerText = Math.floor(gap / day).toString().padStart(2, '0');
            document.getElementById('hours').innerText = Math.floor((gap % day) / hour).toString().padStart(2, '0');
            document.getElementById('minutes').innerText = Math.floor((gap % hour) / minute).toString().padStart(2, '0');
            document.getElementById('seconds').innerText = Math.floor((gap % minute) / second).toString().padStart(2, '0');
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
        document.getElementById('wrapper-dinamico-modal').className = "bg-[#111625] text-white rounded-none max-w-xl w-[95%] md:w-full p-6 md:p-8 text-center shadow-2xl border-2 border-[#ff5f1f] max-h-[95vh] overflow-y-auto font-sans-body";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-orange-500/20 pb-3 md:pb-4 text-left">
                    <h3 class="text-lg md:text-xl font-black tracking-wide uppercase italic text-stone-100"><i class="fas fa-key text-[#ff5f1f] mr-2"></i> Verificación de Elenco</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[#ff5f1f] transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-4 md:space-y-6 text-left">
                    <p class="text-[10px] md:text-xs text-stone-400 font-light leading-relaxed font-mono">Para acceder a la sala, introduce el **Código de Pase Personal** que se te entregó en pantalla al confirmar tu boleto.</p>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#ff5f1f] mb-1 md:mb-2">Clave de Boleto</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="Ej: JON-4819" class="w-full border border-stone-700 bg-black/60 p-2 md:p-3 rounded-none text-sm font-mono tracking-widest outline-none uppercase focus:border-[#ff5f1f] text-stone-200">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="w-full bg-[#ff5f1f] text-black py-3 md:py-3.5 rounded-none font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition shadow-lg block mt-2">
                        Validar Entrada
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
        btnVerificar.classList.add('opacity-70', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> VALIDANDO TICKET...';

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
                    wrapper.innerHTML = `
                        <div class="py-4 md:py-6 text-center space-y-4 md:space-y-6 animate-pop font-mono">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto border border-amber-500/30">
                                <i class="fas fa-exclamation-triangle text-xl md:text-2xl text-amber-500"></i>
                            </div>
                            <div class="space-y-1 md:space-y-2">
                                <h3 class="text-lg md:text-xl font-bold uppercase italic text-stone-100">Boleto Ya Canjeado</h3>
                                <p class="text-[10px] md:text-xs text-stone-400 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                            </div>
                            <div class="pt-2 md:pt-4 space-y-2 md:space-y-3">
                                <button onclick="verRanking()" class="w-full py-2.5 bg-[#ff5f1f] text-black text-[10px] md:text-xs font-bold uppercase tracking-wider rounded-none hover:bg-orange-600 transition">Ver Posiciones en Taquilla</button>
                                <button onclick="cerrarModalFiltro()" class="w-full py-2.5 bg-transparent border border-stone-600 text-stone-400 hover:text-white hover:border-white text-[10px] md:text-xs font-bold uppercase tracking-wider rounded-none transition">Salir de Sala</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Invitado" };
                }
            }

            if (!response.ok) { alert(data.message || "Entrada Inválida."); throw new Error("invalid_code"); }
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Invitado" ? data.nombre_invitado : "Elenco";
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => { 
            if (err.message !== "already_handled") console.error("Fallo:", err); 
            if (btnVerificar) {
                btnVerificar.disabled = false;
                btnVerificar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnVerificar.innerHTML = txtOriginalVerificar;
            }
        });
    }

    function abrirModalMuroBoda() { document.getElementById('modalMuroBoda').classList.remove('hidden'); }
    function cerrarModalMuroBoda() { document.getElementById('modalMuroBoda').classList.add('hidden'); }

    function enviarRecuerdoMemorial(event, eventoId) {
        event.preventDefault();
        const botonPublicar = document.getElementById('btnPublicarMuro');
        const textoOriginal = botonPublicar.innerHTML;
        
        botonPublicar.disabled = true;
        botonPublicar.classList.add('opacity-70', 'cursor-not-allowed');
        botonPublicar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> PUBLICANDO CRÍTICA...';

        const formData = new FormData(event.target);
        fetch(`/invitacion/memorial/${eventoId}/recuerdo`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
            body: formData
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert(data.message || "Error en validación.");
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Fallo.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                document.getElementById('modalMuroBoda').firstElementChild.innerHTML = `
                    <div class="py-6 md:py-8 text-center space-y-4 md:space-y-6 animate-pop font-mono">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50/10 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30">
                            <i class="fas fa-check text-xl md:text-2xl text-emerald-400"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl font-bold uppercase italic text-stone-100">¡Crítica Publicada!</h3>
                            <p class="text-[10px] md:text-xs text-stone-400 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="w-full bg-[#ff5f1f] text-black py-2.5 md:py-3.5 rounded-none font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition mt-3 md:mt-4">
                            Cerrar
                        </button>
                    </div>
                `;
            }
        }).catch(error => {
            console.error(error);
            if (botonPublicar) {
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
            }
        });
    }

    function montarPantallaInicioJuego() {
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-4 md:space-y-6 animate-pop font-mono">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto border border-[#ff5f1f]/30">
                    <i class="fas fa-video text-lg md:text-xl text-[#ff5f1f]"></i>
                </div>
                <span class="text-[10px] md:text-xs uppercase tracking-widest text-[#ff5f1f] font-bold block">Prueba de Elenco</span>
                <h1 class="text-xl md:text-2xl font-black italic tracking-wide text-stone-100">¡Acceso Concedido, ${datosInvitadoValidado.nombre.toUpperCase()}!</h1>
                <p class="text-stone-400 text-[10px] md:text-xs leading-relaxed font-light px-1 md:px-2">Responde las <strong class="text-[#ff5f1f] font-bold">${bancoPreguntas.length} interrogantes</strong> en el menor tiempo posible para liderar los créditos.</p>
                <button onclick="comenzarJuegoModal()" class="w-full bg-[#ff5f1f] text-black py-3 md:py-4 rounded-none font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition shadow-lg block mt-2">ENCENDER CÁMARAS</button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="pantalla-juego" class="space-y-4 md:space-y-6 text-left animate-pop font-mono">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-semibold uppercase tracking-widest text-stone-500 border-b border-stone-800 pb-2 md:pb-4">
                    <span id="info-progreso">Escena 1 de X</span>
                    <span class="text-[#ff5f1f]"><i class="fas fa-stopwatch mr-1"></i> RODAJE: <span id="info-cronometro" class="font-bold text-xs md:text-sm">0s</span></span>
                </div>
                <h2 id="texto-pregunta" class="text-base md:text-lg font-bold text-stone-200 leading-snug uppercase tracking-tight">Cargando escena...</h2>
                <div class="space-y-2 md:space-y-3 pt-1 md:pt-2">
                    <button onclick="seleccionarOpcionModal('a')" class="w-full text-left p-3 md:p-4 border border-stone-800 bg-black/40 hover:bg-white/5 hover:border-stone-500 transition text-xs md:text-sm flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-stone-900 flex items-center justify-center text-[10px] md:text-xs font-black text-[#ff5f1f] border border-stone-700 shrink-0">A</span>
                        <span id="texto-opcion-a" class="break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" class="w-full text-left p-3 md:p-4 border border-stone-800 bg-black/40 hover:bg-white/5 hover:border-stone-500 transition text-xs md:text-sm flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-stone-900 flex items-center justify-center text-[10px] md:text-xs font-black text-[#ff5f1f] border border-stone-700 shrink-0">B</span>
                        <span id="texto-opcion-b" class="break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" class="w-full text-left p-3 md:p-4 border border-stone-800 bg-black/40 hover:bg-white/5 hover:border-stone-500 transition text-xs md:text-sm flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-stone-900 flex items-center justify-center text-[10px] md:text-xs font-black text-[#ff5f1f] border border-stone-700 shrink-0">C</span>
                        <span id="texto-opcion-c" class="break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" class="w-full text-left p-3 md:p-4 border border-stone-800 bg-black/40 hover:bg-white/5 hover:border-stone-500 transition text-xs md:text-sm flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-stone-900 flex items-center justify-center text-[10px] md:text-xs font-black text-[#ff5f1f] border border-stone-700 shrink-0">D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-stone-500 font-mono text-[10px] md:text-xs">No hay guión de preguntas estructurado.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `Escena ${preguntaActualIndex + 1} de ${bancoPreguntas.length}`;
        document.getElementById('texto-pregunta').innerText = q.pregunta.toUpperCase();
        document.getElementById('texto-opcion-a').innerText = q.opcion_a;
        document.getElementById('texto-opcion-b').innerText = q.opcion_b;
        document.getElementById('texto-opcion-c').innerText = q.opcion_c;
        document.getElementById('texto-opcion-d').innerText = q.opcion_d;
    }

    function seleccionarOpcionModal(opcionElegida) {
        if (opcionElegida === bancoPreguntas[preguntaActualIndex].respuesta_correcta) { puntajeAcumulado += parseInt(bancoPreguntas[preguntaActualIndex].puntos); }
        preguntaActualIndex++;
        if (preguntaActualIndex < bancoPreguntas.length) renderizarPreguntaModal();
        else finalizarTriviaModal();
    }

    function finalizarTriviaModal() {
        clearInterval(intervaloCronometro);
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div class="text-center space-y-4 md:space-y-6 py-6 md:py-4 animate-pop font-mono">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-white/5 flex items-center justify-center mx-auto border border-stone-800"><i class="fas fa-spinner fa-spin text-lg md:text-xl text-stone-400"></i></div>
                <h3 class="text-lg md:text-xl font-bold uppercase italic text-stone-200">Guardando Metraje...</h3>
            </div>
        `;
        fetch('/invitacion/registrar-participacion-trivia', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ evento_id: "{{ $evento->evento_id }}", invitado_id: datosInvitadoValidado.id, nombre_jugador: datosInvitadoValidado.nombre, puntaje: puntajeAcumulado, tiempo_segundos: segundosTranscurridos })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                document.getElementById('wrapper-dinamico-modal').innerHTML = `
                    <div class="text-center space-y-6 md:space-y-8 py-2 md:py-4 animate-pop font-mono">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50/10 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30 mb-2 md:mb-4 shadow-xl"><i class="fas fa-trophy text-xl md:text-2xl text-emerald-400"></i></div>
                        <h3 class="text-xl md:text-2xl font-black uppercase italic tracking-wide text-[#ff5f1f]">¡Corte! Rodaje Exitoso</h3>
                        <div class="grid grid-cols-2 gap-3 md:gap-4 bg-black/50 p-4 md:p-5 border border-stone-800 max-w-xs mx-auto text-left text-[10px] md:text-xs">
                            <div class="border-r border-stone-800 pr-2"><span class="block text-[8px] md:text-[9px] uppercase font-bold text-stone-500 mb-1">SCORE TOTAL</span><span class="text-base md:text-lg font-black text-stone-200">${puntajeAcumulado} pts</span></div>
                            <div class="text-left pl-2"><span class="block text-[8px] md:text-[9px] uppercase font-bold text-stone-500 mb-1">TIEMPO RECORD</span><span class="text-base md:text-lg font-black text-stone-200">${segundosTranscurridos} seg</span></div>
                        </div>
                        <div class="space-y-2 md:space-y-3 pt-2">
                            <button onclick="verRanking()" class="w-full bg-[#ff5f1f] text-black py-2.5 md:py-3 font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition">VER LA TAQUILLA</button>
                            <button onclick="cerrarModalFiltro()" class="w-full bg-transparent border border-stone-600 text-stone-400 py-2.5 md:py-3 font-black text-[10px] md:text-xs uppercase tracking-widest hover:text-white hover:border-white transition">SALIR DEL SET</button>
                        </div>
                    </div>
                `;
            }
        });
    }

    // --- LÓGICA DEL RANKING (THE BOX OFFICE) ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-film fa-spin text-4xl text-[#ff5f1f]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-stone-500 text-center font-mono text-xs md:text-sm mt-10">La taquilla está vacía. Sé el primero.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-base md:text-xl text-stone-600 font-black mr-2 md:mr-4 w-4 md:w-6 inline-block text-center shrink-0">#${index + 1}</span>`;
                        let resplandor = 'border-stone-800 bg-[#111625]';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-star text-yellow-500 text-lg md:text-xl mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                            resplandor = 'border-[#ff5f1f]/50 shadow-[0_0_10px_rgba(255,95,31,0.15)] md:shadow-[0_0_15px_rgba(255,95,31,0.15)] bg-orange-500/5 relative scale-[1.02] z-10';
                        } else if(index === 1) {
                            medalla = '<i class="fas fa-star text-gray-400 text-base md:text-lg mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                            resplandor = 'border-stone-600 bg-stone-800/30';
                        } else if(index === 2) {
                            medalla = '<i class="fas fa-star text-amber-700 text-base md:text-lg mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-3 md:p-4 animate-pop mb-2 md:mb-3 rounded-sm">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-bold uppercase tracking-wider text-xs md:text-sm text-stone-200 truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[#ff5f1f] font-black text-lg md:text-xl leading-none">${jugador.puntaje_total} <span class="text-[8px] md:text-[10px] text-stone-500">PTS</span></span>
                                    <span class="block text-[8px] md:text-[9px] text-stone-500 tracking-widest uppercase mt-1">${jugador.tiempo_empleado} SEG</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 font-bold text-center mt-10 text-[10px] md:text-xs uppercase">Error de taquilla.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 font-bold text-center mt-10 text-[10px] md:text-xs uppercase">Fallo de conexión estelar.</p>';
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
        div.className = "bg-black/60 p-4 md:p-5 border-l-2 md:border-l-4 border-stone-500 space-y-3 md:space-y-4 animate-fade-in";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-stone-800 pb-2">
                <span class="text-[8px] md:text-[10px] uppercase tracking-widest font-bold text-stone-400"><i class="fas fa-users mr-1"></i> Elenco Extra #${contadorAcompanantes}</span>
                <button type="button" onclick="document.getElementById('acompanante_row_${contadorAcompanantes}').remove()" class="text-rose-400 hover:text-rose-300 text-[10px] md:text-xs font-bold uppercase"><i class="fas fa-trash-alt mr-1"></i> Eliminar</button>
            </div>
            <div><label class="block text-[10px] md:text-xs font-bold uppercase tracking-wider text-stone-400 mb-1">Nombre Completo *</label><input type="text" class="input-nombre-acompanante w-full border border-stone-700 bg-black/40 p-2.5 md:p-3 rounded-none text-xs md:text-sm outline-none focus:border-[#ff5f1f] text-stone-200 font-mono" required></div>
        `;
        document.getElementById('contenedorAcompanantes').appendChild(div);
    }

    function abrirModalAsistencia() { document.getElementById('modalAsistencia').classList.remove('hidden'); }
    function cerrarModalAsistencia() { document.getElementById('modalAsistencia').classList.add('hidden'); }

    function enviarDatosAsistencia(event, eventoId) {
        event.preventDefault();
        
        const btnConfirmar = document.getElementById('btnConfirmarAsistencia');
        const txtOriginalConfirmar = btnConfirmar.innerHTML;
        
        btnConfirmar.disabled = true;
        btnConfirmar.classList.add('opacity-70', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-ticket-alt fa-spin mr-2"></i> EMITIENDO BOLETOS...';

        const nodosNombres = document.querySelectorAll('.input-nombre-acompanante');
        const listaAcompanantes = Array.from(nodosNombres).map((input) => ({ nombre: input.value.trim(), email: '' })).filter(acomp => acomp.nombre !== "");
        
        const dataPayload = {
            token_acceso: document.getElementById('inputHiddenToken').value,
            nombre_invitado: document.getElementById('inputNombrePrincipal').value.trim(),
            email: document.getElementById('inputEmailPrincipal').value.trim(),
            acompanantes: listaAcompanantes
        };

        fetch('/invitacion/confirmar-asistencia', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(dataPayload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success || data.already_registered) {
                document.getElementById('cuerpoInternoModalAsistencia').innerHTML = `
                    <div class="py-6 md:py-8 px-2 text-center space-y-6 md:space-y-8 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50/10 rounded-full flex items-center justify-center mx-auto border border-emerald-500/40"><i class="fas fa-ticket text-xl md:text-2xl text-emerald-400"></i></div>
                        <h3 class="text-xl md:text-2xl font-black uppercase italic tracking-wide text-[#ff5f1f]">Pases Emitidos</h3>
                        <p class="text-[10px] md:text-xs text-stone-400 font-light">Guarda tus tickets individuales para el acceso a las salas de votación y críticas del Muro.</p>
                        <div class="bg-black/80 border-2 border-dashed border-stone-700 p-4 md:p-5 text-left space-y-3 md:space-y-4">
                            ${data.codigos ? data.codigos.map(item => `
                                <div class="flex justify-between items-center pt-2 border-t border-stone-800">
                                    <span class="text-stone-300 font-bold text-xs md:text-sm truncate pr-2">${item.nombre.toUpperCase()}:</span> 
                                    <span class="bg-[#ff5f1f] px-2 md:px-3 py-1 text-[9px] md:text-[11px] font-black text-black font-mono tracking-widest shrink-0">${item.codigo}</span>
                                </div>
                            `).join('') : '<p class="text-stone-400 text-xs md:text-sm">'+data.message+'</p>'}
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-[#ff5f1f] text-black py-2.5 md:py-3 font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-orange-600 transition-all">INGRESAR A SALA</button>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error(error);
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA (METRAJE CLOUD) ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-transparent', 'border-[#ff5f1f]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[#ff5f1f]', 'border-transparent');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} TOMAS SELECCIONADAS`;
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
            alert("Director, seleccione al menos una toma del metraje.");
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
            alert("No hay metraje en los servidores.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>