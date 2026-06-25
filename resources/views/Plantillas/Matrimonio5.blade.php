<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | ¡BOOM!</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --pop-yellow: #ffde17;
            --pop-blue: #29abe2;
            --pop-red: #ff0000;
        }

        h1, h2, h3, .font-comic { font-family: 'Bangers', cursive; letter-spacing: 2px; }
        body { font-family: 'Comic Neue', sans-serif; background-color: white; color: black; scroll-behavior: smooth; overflow-x: hidden; }

        /* Ajuste svh para evitar que la barra del móvil tape contenido */
        .snap-container {
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            overflow-x: hidden;
        }

        .section-pop {
            min-height: 100svh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            overflow: hidden;
            border-bottom: 8px solid black;
            padding: 2rem 1rem;
        }
        @media (min-width: 768px) {
            .section-pop { border: 8px solid black; border-bottom: none; }
        }

        /* Fondo de puntos Ben-Day */
        .dots-bg {
            background-image: radial-gradient(#000 15%, transparent 15%);
            background-size: 20px 20px;
            opacity: 0.1;
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* Burbujas de texto estilo cómic */
        .speech-bubble {
            background: white;
            border: 3px solid black;
            padding: 12px;
            position: relative;
            box-shadow: 4px 4px 0px black;
        }
        @media (min-width: 768px) {
            .speech-bubble { border-width: 4px; padding: 20px; box-shadow: 10px 10px 0px black; }
        }

        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 20px;
            border-width: 12px 12px 0;
            border-style: solid;
            border-color: black transparent;
        }
        @media (min-width: 768px) {
            .speech-bubble::after { bottom: -20px; left: 50px; border-width: 20px 20px 0; }
        }

        /* Botón POP Responsivo */
        .btn-pop {
            background: var(--pop-red);
            color: white;
            border: 3px solid black;
            padding: 12px 20px;
            font-size: 1.2rem;
            font-family: 'Bangers';
            text-transform: uppercase;
            box-shadow: 4px 4px 0px var(--pop-blue);
            transition: 0.2s;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            width: 100%;
        }
        @media (min-width: 768px) {
            .btn-pop { border-width: 4px; padding: 15px 40px; font-size: 1.5rem; box-shadow: 8px 8px 0px var(--pop-blue); width: auto; }
        }

        .btn-pop:hover {
            transform: translate(-4px, -4px);
            box-shadow: 8px 8px 0px black;
        }
        @media (min-width: 768px) {
            .btn-pop:hover { box-shadow: 12px 12px 0px black; }
        }
        
        .btn-pop:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: 4px 4px 0px var(--pop-blue);
        }

        /* Marcos de fotos con ángulo */
        .pop-frame {
            border: 4px solid black;
            box-shadow: 8px 8px 0px var(--pop-yellow);
            transform: rotate(-2deg);
        }
        @media (min-width: 768px) {
            .pop-frame { border-width: 6px; box-shadow: 15px 15px 0px var(--pop-yellow); }
        }

        .animate-fade-in { animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        .animate-pop { animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.8) rotate(-3deg); } to { opacity: 1; transform: scale(1) rotate(0deg); } }
        
        /* Ocultar Scrollbar */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '20:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: ¡EL GRAN DÍA! --}}
    <section class="section-pop bg-[#29abe2] !p-0">
        <div class="dots-bg"></div>
        
        <div class="z-10 text-center max-w-5xl px-4 flex flex-col items-center w-full justify-center h-full">
            <div class="bg-white border-2 md:border-4 border-black px-4 md:px-6 py-2 rotate-[-5deg] mb-6 md:mb-8 shadow-[4px_4px_0px_#ff0000] md:shadow-[10px_10px_0px_#ff0000]">
                <p class="font-comic text-lg md:text-2xl uppercase italic">¡Increíble pero cierto!</p>
            </div>
            
            <h1 class="text-5xl sm:text-7xl md:text-[100px] lg:text-[120px] leading-none mb-6 text-white drop-shadow-[4px_4px_0px_rgba(0,0,0,1)] md:drop-shadow-[8px_8px_0px_rgba(0,0,0,1)] w-full break-words">
                {{ $evento->nombre_evento }}
            </h1>

            <div class="speech-bubble mb-10 transform rotate-2 w-[90%] md:max-w-2xl mx-auto">
                <p class="text-base sm:text-lg md:text-2xl font-bold italic">¡SE CASAN EL {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d.m.Y') }}!</p>
            </div>

            {{-- CONTADOR TIPO EXPLOSIÓN --}}
            <div id="countdown" class="flex flex-wrap gap-3 sm:gap-6 md:gap-8 bg-white border-2 md:border-4 border-black p-4 md:p-6 shadow-[6px_6px_0px_#ffde17] md:shadow-[10px_10px_0px_#ffde17] w-full max-w-xs sm:max-w-md md:max-w-max mx-auto justify-center">
                <div class="text-center min-w-[50px] md:min-w-[70px]">
                    <span id="days" class="text-3xl sm:text-5xl md:text-6xl font-comic">00</span>
                    <span class="block text-[10px] md:text-xs font-bold uppercase italic">Días</span>
                </div>
                <div class="text-center border-l-2 md:border-l-4 border-black pl-3 sm:pl-6 min-w-[50px] md:min-w-[70px]">
                    <span id="hours" class="text-3xl sm:text-5xl md:text-6xl font-comic">00</span>
                    <span class="block text-[10px] md:text-xs font-bold uppercase italic">Hrs</span>
                </div>
                <div class="text-center border-l-2 md:border-l-4 border-black pl-3 sm:pl-6 min-w-[50px] md:min-w-[70px]">
                    <span id="minutes" class="text-3xl sm:text-5xl md:text-6xl font-comic">00</span>
                    <span class="block text-[10px] md:text-xs font-bold uppercase italic text-black">Min</span>
                </div>
                <div class="text-center border-l-2 md:border-l-4 border-black pl-3 sm:pl-6 text-red-600 min-w-[50px] md:min-w-[70px]">
                    <span id="seconds" class="text-3xl sm:text-5xl md:text-6xl font-comic">00</span>
                    <span class="block text-[10px] md:text-xs font-bold uppercase italic text-black">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: LA HISTORIA (COMIC STRIP) --}}
    <section class="section-pop bg-[#ffde17]">
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center px-4">
            <div class="pop-frame aspect-square md:aspect-[3/4] bg-white relative w-full max-w-sm mx-auto order-2 md:order-1 overflow-hidden">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-stone-200 flex items-center justify-center">
                        <i class="fa-solid fa-camera text-4xl text-stone-400"></i>
                    </div>
                @endif
                <div class="absolute top-0 right-0 bg-red-600 text-white font-comic px-3 md:px-4 py-1 md:py-2 border-l-2 md:border-l-4 border-b-2 md:border-b-4 border-black uppercase text-base md:text-xl">
                    ¡AMOR!
                </div>
            </div>
            
            <div class="space-y-4 md:space-y-6 order-1 md:order-2 text-center md:text-left">
                <h2 class="text-4xl sm:text-5xl md:text-7xl uppercase italic drop-shadow-[2px_2px_0px_white] md:drop-shadow-[4px_4px_0px_white]">Nuestra Historia</h2>
                <div class="bg-white border-2 md:border-4 border-black p-5 md:p-8 relative text-left">
                    <p class="text-sm sm:text-base md:text-xl leading-relaxed font-bold italic text-gray-800">
                        "{!! nl2br(e($evento->biografia_resumen)) !!}"
                    </p>
                    <div class="absolute -top-4 -right-4 md:-top-6 md:-right-6 w-12 h-12 md:w-16 md:h-16 bg-blue-400 rounded-full border-2 md:border-4 border-black flex items-center justify-center shadow-md md:shadow-lg">
                        <i class="fa-solid fa-bolt text-white text-xl md:text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN (ZAP!) --}}
    <section class="section-pop bg-white">
        <div class="dots-bg"></div>
        <div class="text-center z-10 px-4 w-full">
            <div class="mb-6 md:mb-10 inline-block bg-red-600 text-white text-5xl md:text-8xl px-8 md:px-12 py-3 md:py-4 border-2 md:border-4 border-black rotate-[3deg] shadow-[6px_6px_0px_#29abe2] md:shadow-[15px_15px_0px_#29abe2]">
                ¡DÓNDE!
            </div>
            <h2 class="text-xl sm:text-3xl md:text-4xl mb-8 md:mb-12 italic font-bold uppercase max-w-3xl mx-auto bg-white border-2 md:border-4 border-black p-5 md:p-8 w-full shadow-md">
                {{ $evento->ubicacion_texto }}
            </h2>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center mt-6">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-pop max-w-xs md:max-w-none">
                    ¡GUIAME AL EVENTO!
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES (KAPOW!) --}}
    <section class="section-pop bg-[#ff0000] !p-0 block md:flex md:flex-row min-h-[100svh]">
        
        {{-- BLOQUE TRIVIA POP ART --}}
        <div class="flex flex-col justify-center items-center bg-white border-b-4 md:border-b-0 md:border-r-8 border-black group p-6 md:p-12 space-y-6 w-full md:w-1/2 min-h-[50svh] md:min-h-full">
            <div class="text-center">
                <h3 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl mb-2 md:mb-4 group-hover:scale-110 transition">¡TRIVIA!</h3>
                <p class="text-sm md:text-xl font-bold uppercase italic border-b-2 md:border-b-4 border-black inline-block pb-1">Pon a prueba tu mente</p>
            </div>
            <div id="wrapper-btn-trivia" class="w-full max-w-xs text-center flex flex-col gap-4 mt-4">
                @if($yaComenzo)
                    <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full py-3 bg-black text-white border-2 md:border-4 border-black text-base md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_var(--pop-blue)] hover:bg-gray-900 transition">¡REVOLVER ACERTIJOS!</button>
                    <button onclick="verRanking()" class="w-full py-3 bg-[#ffde17] text-black border-2 md:border-4 border-black text-base md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_#000] hover:bg-yellow-400 transition">¡VER TABLERO MÁGICO!</button>
                @else
                    <button id="btn-time-trivia" disabled class="w-full py-3 bg-stone-200 text-stone-500 border-2 md:border-4 border-stone-300 font-comic text-base uppercase cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i> BLOQUEADO
                    </button>
                @endif
            </div>
        </div>

        {{-- BLOQUE MURO POP ART --}}
        <div class="flex flex-col justify-center items-center bg-[#ffde17] group p-6 md:p-12 space-y-6 w-full md:w-1/2 min-h-[50svh] md:min-h-full">
            <div class="text-center">
                <h3 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl mb-2 md:mb-4 group-hover:scale-110 transition">¡MURO!</h3>
                <p class="text-sm md:text-xl font-bold uppercase italic border-b-2 md:border-b-4 border-black inline-block pb-1">Escribe tu mensaje</p>
            </div>
            <div id="wrapper-btn-muro" class="w-full max-w-xs text-center flex flex-col gap-4 mt-4">
                @if($yaComenzo)
                    <button onclick="solicitarAccesoVerificacion('muro')" class="w-full py-3 bg-white text-black border-2 md:border-4 border-black text-base md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_#ff0000] hover:bg-stone-50 transition">¡DETONAR MENSAJE!</button>
                    <button onclick="mostrarMuroVisual()" class="w-full py-3 bg-black text-white border-2 md:border-4 border-black text-base md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_#29abe2] hover:bg-gray-900 transition">¡VER RECUERDOS!</button>
                @else
                    <button id="btn-time-muro" disabled class="w-full py-3 bg-stone-300 text-stone-500 border-2 md:border-4 border-stone-400 font-comic text-base uppercase cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i> BLOQUEADO
                    </button>
                @endif
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: LIBRO DE DESEOS --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-stone-50 overflow-y-auto w-full min-h-[100svh]">
        <div class="max-w-7xl w-full mx-auto px-4 md:px-8 text-center pt-10 md:pt-16 pb-16 flex flex-col min-h-full">
            <h2 class="text-4xl sm:text-6xl md:text-8xl font-comic mb-8 md:mb-16 uppercase italic drop-shadow-[3px_3px_0px_#ffde17] md:drop-shadow-[6px_6px_0px_#ffde17]">Bóveda de Recuerdos</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 items-start w-full">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="pop-memory-card bg-white border-4 md:border-8 border-black p-5 md:p-6 shadow-[6px_6px_0px_#000] md:shadow-[12px_12px_0px_#000] rotate-[-1deg] hover:rotate-0 transition duration-300 hover:scale-105 group relative overflow-hidden flex flex-col w-full h-full">
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="aspect-[4/3] border-2 md:border-4 border-black p-1 bg-gray-100 mb-4 md:mb-6 shadow-[3px_3px_0px_#29abe2] transform rotate-1 group-hover:rotate-0 transition relative overflow-hidden">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover">
                                <div class="absolute -top-2 -left-2 bg-red-600 text-white border border-black font-comic px-3 py-1 rotate-[-10deg] uppercase text-[10px]">¡FOTO!</div>
                            </div>
                        @endif
                        <div class="text-left space-y-4 flex-grow flex flex-col">
                            <p class="font-comic text-xl md:text-2xl italic leading-tight text-black break-words flex-grow">"{{ $item->contenido_texto }}"</p>
                            <div class="inline-block self-start bg-[#ff0000] text-white px-3 py-1 font-bold uppercase italic border-2 border-black text-[10px] transform -rotate-1 shadow-[2px_2px_0px_#000] mt-auto">
                                - {{ $item->nombre_autor }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border-4 md:border-8 border-black p-8 md:p-10 shadow-[5px_5px_0px_#ff0000] md:shadow-[10px_10px_0px_#ff0000] mx-2">
                        <p class="text-2xl md:text-4xl font-comic uppercase italic">Aún no hay mensajes en la base secreta. <br>¡Sé el primero en detonar uno!</p>
                    </div>
                @endforelse
            </div>

            <div class="w-full flex justify-center mt-auto pt-10">
                <button onclick="ocultarMuroVisual()" class="bg-black text-white py-3 md:py-4 px-8 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[4px_4px_0px_#ffde17] hover:bg-gray-900 transition flex items-center gap-2 w-full max-w-xs md:max-w-md justify-center">
                    <i class="fas fa-eye-slash"></i> OCULTAR BÓVEDA
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: ARCHIVOS MULTIMEDIA --}}
    <section class="section-pop bg-[#29abe2] !h-auto py-20 min-h-[100svh] !block">
        <div class="dots-bg"></div>
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-16 mx-auto">
            
            <div class="text-center mb-10 w-full">
                <div class="inline-block bg-[#ffde17] border-2 md:border-4 border-black px-6 py-2 rotate-[-3deg] shadow-[4px_4px_0px_#000] md:shadow-[6px_6px_0px_#000] mb-4">
                    <p class="font-comic text-xl md:text-3xl uppercase">¡CÁMARA, ACCIÓN!</p>
                </div>
                <h2 class="text-4xl sm:text-6xl md:text-7xl font-comic uppercase text-white drop-shadow-[3px_3px_0px_#000]">VIÑETAS Y VIDEOS</h2>
            </div>

            <div class="w-full flex flex-col lg:flex-row justify-between items-center mb-8 bg-white border-2 md:border-4 border-black p-5 md:p-6 shadow-[6px_6px_0px_#000] md:shadow-[10px_10px_0px_#000] gap-4 transform rotate-1">
                <span id="contador-seleccionadas" class="font-comic text-2xl md:text-3xl text-red-600 tracking-wider">
                    0 SELECCIONADAS
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border-2 md:border-4 border-black bg-[#ffde17] text-black px-6 py-3 hover:bg-black hover:text-[#ffde17] transition uppercase tracking-widest w-full sm:w-auto">
                        <i class="fas fa-download mr-2"></i> BAJAR SELECCIÓN
                    </button>
                    <button onclick="descargarTodas()" class="btn-pop !w-full sm:!w-auto !py-3">
                        <i class="fas fa-cloud-download-alt mr-2"></i> ¡BAJAR TODO!
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
                                'etiqueta' => 'TOMA OFICIAL'
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
                            'etiqueta' => '¡FLASH INVITADO!'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6 w-full max-h-[65vh] overflow-y-auto hide-scroll p-2 pb-6">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item aspect-square md:aspect-[4/5] relative group cursor-pointer border-2 md:border-4 border-black hover:scale-105 hover:rotate-2 transition-all duration-300 overflow-hidden bg-white shadow-[4px_4px_0px_#000] md:shadow-[6px_6px_0px_#000]" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/30 hover:bg-black/10 transition">
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-[#ffde17] border-2 md:border-4 border-black rounded-full flex items-center justify-center shadow-[2px_2px_0px_#000] group-hover:scale-110 transition rotate-[-5deg]">
                                    <i class="fas fa-play text-red-600 text-xl md:text-2xl ml-1"></i>
                                </div>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-full object-cover filter contrast-125 saturate-110">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[#ffde17]/60 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-multiply"></div>
                        
                        <div class="check-icon absolute -top-2 -right-2 bg-[#ff0000] text-white border-2 border-black w-10 h-10 md:w-12 md:h-12 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-[2px_2px_0px_#000] z-30 pointer-events-none font-comic text-sm rotate-[15deg]">
                            ¡SÍ!
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-white border-t-2 md:border-t-4 border-black text-black text-[8px] md:text-[11px] px-2 py-1.5 font-bold uppercase truncate text-center z-30 pointer-events-none font-comic">
                            <i class="fas {{ $foto['esVideo'] ? 'fa-video text-blue-500' : ($foto['esNube'] ? 'fa-cloud text-blue-500' : 'fa-camera-retro text-red-500') }} mr-1"></i>
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border-4 border-black p-10 bg-white shadow-[8px_8px_0px_#000] rotate-[-2deg] mx-2">
                        <p class="text-black font-comic text-2xl md:text-4xl">¡CRACK! ¡LA GALERÍA ESTÁ VACÍA!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP (¡SÍ!) --}}
    {{-- SECCIÓN 5: RSVP (¡SÍ!) --}}
    <section class="section-pop bg-white relative">
        <div class="dots-bg"></div>
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 z-10 w-full flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <h2 class="text-5xl sm:text-7xl md:text-[120px] lg:text-[150px] mb-8 md:mb-12 drop-shadow-[4px_4px_0px_#29abe2] md:drop-shadow-[10px_10px_0px_#29abe2] leading-none">¿VIENES?</h2>
                
                <div id="contenedorBotonPrincipalRSVP" class="flex justify-center w-full">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-pop mb-8 md:mb-12 text-lg sm:text-xl md:text-3xl w-full max-w-sm sm:max-w-md">
                            ¡CONFIRMAR ASISTENCIA!
                        </button>
                    @else
                        <div class="px-4 md:px-8 py-4 border-2 md:border-4 border-black font-bold uppercase tracking-wider text-black w-full max-w-xs md:max-w-md bg-[#ffde17] shadow-[4px_4px_0px_#000] md:shadow-[8px_8px_0px_#000] text-xs md:text-base">
                            ¡CÓDIGO QR OBLIGATORIO!
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-col items-center gap-4 mt-6 md:mt-8">
                    <div class="bg-black text-white px-6 md:px-8 py-3 font-bold uppercase tracking-widest text-[10px] md:text-xs italic border-2 border-black">
                        TU MESA: {{ $invitado->mesa_asignada ?? 'POR DEFINIR' }}
                    </div>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ESTILO POP ART 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] font-bold uppercase tracking-[0.4em] text-gray-500 mb-1.5 font-sans">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono que pasa a rojo --}}
                        <i class="fas fa-bolt text-[11px] md:text-xs text-black group-hover:text-[#ff0000] transition-colors"></i>
                        {{-- Texto Eventify que pasa a azul --}}
                        <span class="font-comic italic text-sm md:text-base font-bold tracking-widest text-black group-hover:text-[#29abe2] transition-colors" style="font-family: 'Bangers', cursive; letter-spacing: 2px;">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div id="wrapper-dinamico-modal" class="bg-white border-4 md:border-8 border-black max-w-xl w-[95%] sm:w-full p-6 md:p-10 text-center shadow-[8px_8px_0px_var(--pop-yellow)] md:shadow-[15px_15px_0px_var(--pop-yellow)] max-h-[90svh] overflow-y-auto">
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 border-b-2 md:border-b-4 border-black pb-3 text-left">
                <h3 class="text-xl md:text-3xl font-comic text-black uppercase tracking-wide"><i class="fas fa-key text-red-600 mr-2"></i> CLAVE REQUERIDA</h3>
                <button onclick="cerrarModalFiltro()" class="text-gray-400 hover:text-black transition p-2"><i class="fas fa-times text-2xl"></i></button>
            </div>
            <div class="space-y-6 text-left">
                <p class="text-xs md:text-sm font-medium font-sans text-gray-700 leading-relaxed">¡Para interactuar en la base secreta de la noche introduce tu **Código de Pase Personal** que se te entregó al confirmar asistencia!</p>
                <div>
                    <label class="block text-[10px] md:text-xs font-bold uppercase italic text-black mb-2">Introduce tu Clave Onomatopeya</label>
                    <input type="text" id="inputCodigoIngreso" placeholder="Ej: JON-4819" class="w-full border-2 md:border-4 border-black bg-white p-3 text-sm md:text-base font-mono tracking-widest font-bold outline-none uppercase focus:bg-yellow-50 text-black">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="w-full bg-black text-white py-3 md:py-4 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[4px_4px_0px_#ff0000] hover:bg-gray-900 transition mt-2">
                    ¡VERIFICAR CREDENCIAL!
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white border-4 md:border-8 border-black w-full max-w-2xl p-6 md:p-8 text-center shadow-[10px_10px_0px_#29abe2] relative max-h-[90svh] flex flex-col">
        
        <div class="flex justify-between items-center mb-6 border-b-2 md:border-b-4 border-black pb-4 shrink-0 text-left">
            <h3 class="text-2xl sm:text-3xl md:text-4xl font-comic text-black uppercase tracking-widest drop-shadow-[2px_2px_0px_#ffde17]">
                <i class="fas fa-trophy mr-2 text-[#ff0000]"></i> SALÓN DE LA FAMA
            </h3>
            <button onclick="cerrarModalRanking()" class="text-gray-400 hover:text-black transition p-2"><i class="fas fa-times text-2xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-2 space-y-4 flex-grow hide-scroll font-sans" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-spinner fa-spin text-4xl text-[#29abe2]"></i>
            </div>
        </div>

        <div class="mt-6 pt-4 shrink-0">
            <button onclick="cerrarModalRanking()" class="w-full py-4 border-2 md:border-4 border-black text-white bg-[#ff0000] font-comic text-xl md:text-2xl uppercase tracking-widest hover:bg-red-700 transition shadow-[4px_4px_0px_#000]">
                ¡CERRAR EL TABLERO!
            </button>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO CÓMIC --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white hover:text-red-500 transition z-50 bg-black border-2 border-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center shadow-[4px_4px_0px_#ffde17]">
        <i class="fas fa-times text-xl md:text-2xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-white border-4 md:border-8 border-black p-2 shadow-[8px_8px_0px_#29abe2]" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80svh] bg-black border-2 border-black"></video>
    </div>
</div>

{{-- MODAL MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white border-4 md:border-8 border-black max-w-md w-full p-6 md:p-8 text-center shadow-[8px_8px_0px_var(--pop-blue)] max-h-[90svh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6 border-b-2 md:border-b-4 border-black pb-3 text-left">
            <h3 class="text-2xl md:text-3xl font-comic text-black uppercase tracking-wide">DETONAR MENSAJE</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-gray-400 hover:text-black transition p-2"><i class="fas fa-times text-2xl"></i></button>
        </div>
        
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-5 text-left">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            <div>
                <label class="block text-[10px] md:text-xs font-bold uppercase italic text-black mb-2">Nombre del Aliado</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border-2 md:border-4 border-black bg-stone-100 p-3 text-xs md:text-sm font-bold outline-none text-slate-500">
            </div>
             <div>
                <label class="block text-[10px] md:text-xs font-bold uppercase italic text-black mb-2">Su Vínculo / Relación *</label>
                <select id="vinculo_autor" name="vinculo_autor" required class="w-full border-2 md:border-4 border-black bg-stone-100 p-3 text-xs md:text-sm font-bold outline-none text-slate-700 cursor-pointer">
                    <option value="" disabled selected>Seleccione una opción...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Hermano/a">Hermano / Hermana</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero de Trabajo">Compañero de trabajo</option>
                    <option value="Vecino/a">Vecino / Vecina</option>
                    <option value="Conocido/a">Conocido / Allegado</option>
                </select>
            </div>
            <div id="grupoTextoBoda">
                <label class="block text-[10px] md:text-xs font-bold uppercase italic text-black mb-2">Tu Mensaje Explosivo *</label>
                <textarea name="contenido" id="contenidoTextoBoda" rows="4" required class="w-full border-2 md:border-4 border-black bg-white p-3 text-xs md:text-sm font-bold outline-none focus:bg-yellow-50 text-black leading-relaxed" placeholder="¡Felicidades en esta tremenda aventura! BOOM!"></textarea>
            </div>
            <div id="grupoArchivoBoda">
                <label class="block text-[10px] md:text-xs font-bold uppercase italic text-black mb-2">Adjuntar Fotografía (Opcional)</label>
                <input type="file" name="archivo" id="archivoImagenBoda" accept="image/*" class="w-full border-2 md:border-4 border-black bg-white p-2 text-[10px] md:text-xs font-bold outline-none text-black cursor-pointer">
            </div>
            <button type="submit" id="btnPublicarMuroBoda" class="w-full bg-[#ff0000] text-white py-3 border-2 md:border-4 border-black font-comic text-xl md:text-2xl uppercase shadow-[4px_4px_0px_#29abe2] hover:bg-red-700 transition block mt-4">
                ¡ENVIAR DETONACIÓN!
            </button>
        </form>
    </div>
</div>

{{-- MODAL ASISTENCIA POP ART --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white border-4 md:border-8 border-black max-w-md w-full p-6 md:p-8 text-center shadow-[10px_10px_0px_var(--pop-yellow)] max-h-[90svh] overflow-y-auto animate-fade-in">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b-2 md:border-b-4 border-black pb-3 text-left">
                <h3 class="text-2xl md:text-3xl font-comic text-black uppercase tracking-wide"><i class="fa-solid fa-mask text-red-600 mr-2"></i> REGISTRO POP</h3>
                <button onclick="cerrarModalAsistencia()" class="text-gray-400 hover:text-black transition p-2"><i class="fas fa-times text-2xl"></i></button>
            </div>
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-[#29abe2]/10 p-4 md:p-5 border-2 md:border-4 border-black shadow-[4px_4px_0px_#000] space-y-4">
                    <span class="text-[10px] md:text-xs font-bold uppercase italic text-blue-600 block"><i class="fas fa-star mr-2"></i> Líder del Escuadrón</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Nombre Completo *" required class="w-full border-2 md:border-4 border-black bg-white p-3 text-xs md:text-sm font-bold outline-none focus:bg-yellow-50 text-black">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" class="w-full border-2 md:border-4 border-black bg-white p-3 text-xs md:text-sm font-bold outline-none focus:bg-yellow-50 text-black" placeholder="Correo (Opcional)">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 md:py-4 bg-[#ffde17] border-2 md:border-4 border-black text-black font-comic text-lg uppercase tracking-wider hover:bg-yellow-300 transition flex items-center justify-center gap-2 shadow-[3px_3px_0px_#000]">
                    <i class="fas fa-plus-circle"></i> ¡Traigo un Aliado!
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full bg-[#ff0000] text-white border-2 md:border-4 border-black font-comic text-xl md:text-2xl py-3 md:py-4 mt-6 block shadow-[4px_4px_0px_var(--pop-blue)] hover:translate-y-[-2px] hover:translate-x-[-2px] hover:shadow-[6px_6px_0px_black] transition">
                    ¡CONFIRMAR ASISTENCIA!
                </button>
            </form>
        </div>
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
        // Usamos el formato estandar para que no falle en iOS
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='text-3xl md:text-5xl font-comic text-red-600 p-4'>¡EL SHOW COMENZÓ!</p>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full py-3 bg-black text-white border-2 md:border-4 border-black text-sm md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_var(--pop-blue)] hover:bg-gray-900 transition mb-4">¡REVOLVER ACERTIJOS!</button>
                        <button onclick="verRanking()" class="w-full py-3 bg-[#ffde17] text-black border-2 md:border-4 border-black text-sm md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_#000] hover:bg-yellow-400 transition">¡VER TABLERO MÁGICO!</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="w-full py-3 bg-white text-black border-2 md:border-4 border-black text-sm md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_#ff0000] hover:bg-stone-50 transition mb-4">¡DETONAR MENSAJE!</button>
                        <button onclick="mostrarMuroVisual()" class="w-full py-3 bg-black text-white border-2 md:border-4 border-black text-sm md:text-lg font-comic uppercase tracking-wider shadow-[4px_4px_0px_#29abe2] hover:bg-gray-900 transition">¡VER RECUERDOS!</button>
                    `;
                }
                return;
            }

            // CORRECCIÓN MATEMÁTICA DEL ERROR DE LAS HORAS
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
        setTimeout(() => { muro.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
    }

    function ocultarMuroVisual() {
        const muro = document.getElementById('seccionMuroMensajes');
        muro.previousElementSibling.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(() => { muro.classList.add('hidden'); }, 500);
    }

    function solicitarAccesoVerificacion(modulo) {
        moduloObjetivo = modulo;
        document.getElementById('wrapper-dinamico-modal').className = "bg-white border-4 md:border-8 border-black max-w-xl w-[95%] sm:w-full p-6 md:p-10 text-center shadow-[10px_10px_0px_var(--pop-yellow)] max-h-[90svh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 border-b-2 md:border-b-4 border-black pb-3 text-left">
                    <h3 class="text-xl md:text-3xl font-comic text-black uppercase tracking-wide"><i class="fas fa-key text-red-600 mr-2"></i> CLAVE REQUERIDA</h3>
                    <button onclick="cerrarModalFiltro()" class="text-gray-400 hover:text-black transition p-2"><i class="fas fa-times text-2xl"></i></button>
                </div>
                <div class="space-y-6 text-left">
                    <p class="text-xs md:text-sm font-medium font-sans text-gray-700 leading-relaxed">¡Para interactuar en la base secreta de la noche introduce tu **Código de Pase Personal** que se te entregó al confirmar asistencia!</p>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold uppercase italic text-black mb-2">Introduce tu Clave Onomatopeya</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="Ej: JON-4819" class="w-full border-2 md:border-4 border-black bg-white p-3 text-sm md:text-base font-mono tracking-widest font-bold outline-none uppercase focus:bg-yellow-50 text-black">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="w-full bg-black text-white py-3 md:py-4 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[4px_4px_0px_#ff0000] hover:bg-gray-900 transition mt-2">
                        ¡VERIFICAR CREDENCIAL!
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
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> ¡DESCIFRANDO...!';

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/invitacion/validar-pase-trivia`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': tokenCsrf },
            body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
        })
        .then(async response => {
            const data = await response.status === 422 || response.status === 404 || response.status === 200 
                ? await response.json() 
                : {};
                
            if (response.status === 422 && data.already_played) {
                if (moduloObjetivo === 'trivia') {
                    const wrapper = document.getElementById('wrapper-dinamico-modal');
                    wrapper.innerHTML = `
                        <div class="py-6 text-center space-y-6 animate-pop font-sans">
                            <div class="inline-block bg-[#ffde17] border-2 md:border-4 border-black p-4 rounded-full shadow-[4px_4px_0px_#000]">
                                <i class="fas fa-exclamation-triangle text-4xl text-black"></i>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-3xl md:text-4xl font-comic text-red-600 uppercase italic">¡MISIÓN COMPLETA!</h3>
                                <p class="text-sm font-bold text-gray-800 px-4 leading-normal">${data.message}</p>
                            </div>
                            <div class="pt-6 space-y-4">
                                <button onclick="verRanking()" class="w-full bg-[#29abe2] text-white py-3 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[3px_3px_0px_#000] hover:bg-blue-600 transition">
                                    ¡VER EL TABLERO!
                                </button>
                                <button onclick="cerrarModalFiltro()" class="w-full bg-black text-white py-3 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[3px_3px_0px_#ff0000] hover:bg-gray-900 transition">
                                    REGRESAR AL PANEL
                                </button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Invitado" };
                }
            }

            if (!response.ok) {
                alert(data.message || "Señal de clave inválida.");
                throw new Error("invalid_code");
            }
            return data;
        })
        .then(data => {
            if(data && data.success) {
                datosInvitadoValidado = {
                    id: data.invitado_id,
                    nombre: data.nombre_invitado,
                    codigo: codigo
                };

                if(moduloObjetivo === 'trivia') {
                    bancoPreguntas = data.preguntas;
                    preguntaActualIndex = 0;
                    puntajeAcumulado = 0;
                    segundosTranscurridos = 0;
                    
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
            if (err.message !== "already_handled") {
                console.error("Fallo filtro acceso:", err);
            }
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
        
        const botonPublicar = document.getElementById('btnPublicarMuroBoda');
        const textoOriginal = botonPublicar.innerHTML;
        
        botonPublicar.disabled = true;
        botonPublicar.classList.add('opacity-70', 'cursor-not-allowed');
        botonPublicar.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> ¡DETONANDO MENSAJE...!`;

        const form = event.target;
        const formData = new FormData(form);

        fetch(`/invitacion/memorial/${eventoId}/recuerdo`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert(data.message || "Error al verificar la clave.");
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Fallo en la validación.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const modalInterior = document.getElementById('modalMuroBoda').firstElementChild;
                modalInterior.innerHTML = `
                    <div class="py-8 text-center space-y-6 animate-pop font-sans text-black">
                        <div class="inline-block bg-[#ffde17] border-2 md:border-4 border-black p-4 rounded-full shadow-[4px_4px_0px_#000]">
                            <i class="fas fa-heart text-4xl text-red-600"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-3xl md:text-4xl font-comic text-black uppercase">¡MENSAJE DETONADO!</h3>
                            <p class="text-sm font-bold text-gray-800 px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="w-full bg-black text-white py-3 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[3px_3px_0px_#ff0000] hover:bg-gray-900 transition mt-6">
                            ¡CERRAR VENTANA!
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error("Error al registrar interacción:", error);
            if (botonPublicar) {
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
            }
        });
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 animate-pop font-sans">
                <div class="inline-block bg-[#ff0000] text-white border-2 md:border-4 border-black p-4 rotate-[-3deg] font-comic text-3xl shadow-[4px_4px_0px_#000]">
                    ¡CRUNCH!
                </div>
                <h1 class="text-3xl md:text-4xl font-comic text-black uppercase">¡ATENCIÓN, ${datosInvitadoValidado.nombre.toUpperCase()}!</h1>
                <p class="text-gray-700 text-sm font-bold leading-relaxed px-4">¿Cuánto sabes de los líderes de la fiesta? Es hora de resolver el set de <strong class="text-red-600">${bancoPreguntas.length} preguntas</strong> a máxima velocidad para reclamar tu lugar en la gloria.</p>
                
                <button onclick="comenzarJuegoModal()" class="w-full bg-black text-white py-4 border-2 md:border-4 border-black font-comic text-2xl uppercase shadow-[4px_4px_0px_#ffde17] hover:bg-gray-900 transition mt-4">
                    ¡INICIAR SECUENCIA!
                </button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-6 text-left animate-pop font-sans">
                <div class="flex justify-between items-center text-xs font-bold uppercase italic text-stone-500 border-b-2 md:border-b-4 border-black pb-4">
                    <span id="info-progreso" class="text-blue-600">PÁGINA 1 DE X</span>
                    <span class="text-red-600"><i class="fas fa-clock mr-1"></i> TIEMPO: <span id="info-cronometro" class="font-mono text-base font-black text-black">0s</span></span>
                </div>

                <h2 id="texto-pregunta" class="text-2xl md:text-3xl font-comic text-black uppercase tracking-tight leading-tight">Cargando viñeta...</h2>

                <div class="space-y-3 pt-2 font-sans font-bold">
                    <button onclick="seleccionarOpcionModal('a')" id="btn-opcion-a" class="w-full text-left p-4 border-2 md:border-4 border-black bg-white shadow-[3px_3px_0px_#000] hover:bg-yellow-50 transition flex items-center space-x-4 text-black text-sm md:text-base">
                        <span class="w-8 h-8 bg-black text-white font-comic text-xl rounded-full flex items-center justify-center shadow-md shrink-0">A</span>
                        <span id="texto-opcion-a" class="break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" id="btn-opcion-b" class="w-full text-left p-4 border-2 md:border-4 border-black bg-white shadow-[3px_3px_0px_#000] hover:bg-yellow-50 transition flex items-center space-x-4 text-black text-sm md:text-base">
                        <span class="w-8 h-8 bg-black text-white font-comic text-xl rounded-full flex items-center justify-center shadow-md shrink-0">B</span>
                        <span id="texto-opcion-b" class="break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" id="btn-opcion-c" class="w-full text-left p-4 border-2 md:border-4 border-black bg-white shadow-[3px_3px_0px_#000] hover:bg-yellow-50 transition flex items-center space-x-4 text-black text-sm md:text-base">
                        <span class="w-8 h-8 bg-black text-white font-comic text-xl rounded-full flex items-center justify-center shadow-md shrink-0">C</span>
                        <span id="texto-opcion-c" class="break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" id="btn-opcion-d" class="w-full text-left p-4 border-2 md:border-4 border-black bg-white shadow-[3px_3px_0px_#000] hover:bg-yellow-50 transition flex items-center space-x-4 text-black text-sm md:text-base">
                        <span class="w-8 h-8 bg-black text-white font-comic text-xl rounded-full flex items-center justify-center shadow-md shrink-0">D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 border-2 md:border-4 border-black font-comic text-xl">No hay viñetas configuradas en este cómic.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }

        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `VIÑETA ${preguntaActualIndex + 1} DE ${bancoPreguntas.length}`;
        document.getElementById('texto-pregunta').innerText = q.pregunta.toUpperCase();
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
            <div class="text-center space-y-6 py-6 animate-pop font-mono text-black">
                <div class="w-16 h-16 bg-white border-2 md:border-4 border-black flex items-center justify-center mx-auto shadow-[4px_4px_0px_#000]">
                    <i class="fas fa-spinner fa-spin text-2xl"></i>
                </div>
                <h3 class="text-2xl font-comic uppercase tracking-wider">GUARDANDO METRAJE...</h3>
                <p class="text-xs font-bold text-gray-500">Inyectando tus puntuaciones en el tablero secreto.</p>
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
                    <div class="text-center space-y-8 py-4 animate-pop font-sans">
                        <div class="inline-block bg-emerald-500 text-white border-2 md:border-4 border-black p-4 rotate-[-4deg] font-comic text-3xl shadow-[4px_4px_0px_#000] animate-bounce">
                            ¡VICTORIA!
                        </div>
                        <h3 class="text-3xl md:text-4xl font-comic text-black uppercase tracking-tight">RODAJE COMPLETADO</h3>
                        <p class="text-sm font-bold text-gray-500 max-w-sm mx-auto leading-relaxed px-4">¡Tus respuestas onomatopeyas han sido asentadas exitosamente en la bóveda!</p>
                        
                        <div class="grid grid-cols-2 gap-4 bg-white border-2 md:border-4 border-black p-5 max-w-xs mx-auto text-left text-sm shadow-[4px_4px_0px_var(--pop-blue)]">
                            <div class="border-r-2 md:border-r-4 border-black pr-2">
                                <span class="block text-xs font-bold uppercase italic text-gray-400 mb-1">PUNTAJE</span>
                                <span class="text-2xl font-black text-black">${puntajeAcumulado} PTS</span>
                            </div>
                            <div class="text-left pl-2">
                                <span class="block text-xs font-bold uppercase italic text-gray-400 mb-1">TIEMPO</span>
                                <span class="text-2xl font-black text-black">${segundosTranscurridos} SEG</span>
                            </div>
                        </div>

                        <div class="pt-4 space-y-4">
                            <button onclick="verRanking()" class="w-full bg-[#ffde17] text-black py-3 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[3px_3px_0px_#000] hover:bg-yellow-400 transition">¡VER EL SALÓN DE LA FAMA!</button>
                            <button onclick="cerrarModalFiltro()" class="w-full bg-black text-white py-3 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[3px_3px_0px_#ff0000] hover:bg-gray-900 transition">CERRAR VIÑETA</button>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            wrapper.innerHTML = `<p class="text-red-600 font-mono font-bold text-sm"><i class="fas fa-exclamation-triangle mr-2"></i> ¡Rayos! Error en la transferencia.</p>`;
        });
    }

    // --- LÓGICA DEL RANKING (DISEÑO POP ART) ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-spinner fa-spin text-4xl text-[#29abe2]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-[#ff0000] text-center font-comic text-2xl mt-10">¡LA PIZARRA ESTÁ VACÍA! ¡JUEGA YA!</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-2xl text-black font-comic mr-4 border-2 border-black rounded-full w-10 h-10 inline-flex items-center justify-center shadow-sm shrink-0">#${index + 1}</span>`;
                        let resplandor = 'border-2 md:border-4 border-black bg-white shadow-[4px_4px_0px_#000]';
                        
                        if(index === 0) {
                            medalla = '<div class="bg-[#ffde17] border-2 border-black rounded-full w-12 h-12 inline-flex items-center justify-center mr-4 shadow-[2px_2px_0px_#000] rotate-[-5deg] shrink-0"><i class="fas fa-crown text-[#ff0000] text-2xl"></i></div>';
                            resplandor = 'border-2 md:border-4 border-black bg-[#ffde17] shadow-[6px_6px_0px_#ff0000] transform scale-[1.02] z-10 relative';
                        } else if(index === 1) {
                            medalla = '<div class="bg-gray-200 border-2 border-black rounded-full w-10 h-10 inline-flex items-center justify-center mr-4 shadow-[2px_2px_0px_#000] shrink-0"><i class="fas fa-medal text-gray-600 text-xl"></i></div>';
                        } else if(index === 2) {
                            medalla = '<div class="bg-amber-600 border-2 border-black rounded-full w-10 h-10 inline-flex items-center justify-center mr-4 shadow-[2px_2px_0px_#000] shrink-0"><i class="fas fa-medal text-white text-xl"></i></div>';
                        }

                        html += `
                            <div class="flex justify-between items-center p-4 animate-pop mb-4 ${resplandor}">
                                <div class="flex items-center truncate pr-4">
                                    ${medalla}
                                    <span class="font-black uppercase tracking-wider text-lg font-sans text-black truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-black font-comic text-3xl leading-none drop-shadow-[1px_1px_0px_#fff]">${jugador.puntaje_total} PTS</span>
                                    <span class="block text-[10px] text-gray-500 font-bold tracking-widest uppercase mt-1 border-t-2 border-black pt-1">${jugador.tiempo_empleado} SEG</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-500 font-bold text-center mt-10 text-base uppercase italic">¡ERROR EN EL SISTEMA!</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-500 font-bold text-center mt-10 text-base uppercase italic">¡SEÑAL PERDIDA!</p>';
        });
    }

    function cerrarModalRanking() {
        document.getElementById('modalRanking').classList.add('hidden');
    }

    // --- LÓGICA RSVP ---
    let contadorAcompanantes = 0;

    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const contenedor = document.getElementById('contenedorAcompanantes');
        
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-[#ff0000]/5 p-4 border-2 md:border-4 border-black shadow-[4px_4px_0px_#000] space-y-4 relative animate-fade-in";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b-2 border-black pb-2">
                <span class="text-[10px] md:text-xs font-bold uppercase italic text-red-600"><i class="fas fa-user-plus mr-2"></i> Compañero #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-red-600 hover:text-black text-xs font-bold uppercase italic transition">
                    <i class="fas fa-trash-alt mr-1"></i> Quitar
                </button>
            </div>
            <div>
                <input type="text" class="input-nombre-acompanante w-full border-2 md:border-4 border-black bg-white p-2.5 text-sm font-bold outline-none focus:bg-yellow-50 text-black" placeholder="Nombre Completo *" required>
            </div>
            <div>
                <input type="email" class="input-email-acompanante w-full border-2 md:border-4 border-black bg-white p-2.5 text-sm font-bold outline-none focus:bg-yellow-50 text-black" placeholder="Correo (Opcional)">
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
        btnConfirmar.innerHTML = '<i class="fas fa-cog fa-spin mr-2"></i> ¡REGISTRANDO HÉROE...!';
        
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
                    <div class="py-8 px-4 text-center space-y-6 animate-fade-in">
                        <div class="inline-block bg-[#ffde17] border-2 md:border-4 border-black p-4 rounded-full shadow-[4px_4px_0px_#000]">
                            <i class="fas fa-exclamation-circle text-4xl text-black"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-4xl font-comic text-red-600 uppercase italic">¡ALTO AHÍ!</h3>
                            <p class="text-sm font-bold text-gray-800 leading-normal">${data.message}</p>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-black text-white py-3 border-2 md:border-4 border-black font-comic text-xl uppercase shadow-[4px_4px_0px_#ff0000] hover:bg-gray-900 transition mt-4">
                            ¡ENTENDIDO!
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
                    <div class="py-6 px-4 text-center space-y-8 animate-fade-in">
                        <div class="inline-block bg-emerald-500 text-white border-2 md:border-4 border-black p-4 rotate-[-4deg] font-comic text-3xl shadow-[4px_4px_0px_#000] animate-bounce">
                            ¡KAPOW!
                        </div>
                        
                        <div class="space-y-2">
                            <h3 class="text-4xl font-comic text-black uppercase">¡ENTRADA REGISTRADA!</h3>
                        </div>

                        <div class="bg-[#ffde17]/10 border-2 md:border-4 border-black p-5 text-left space-y-4 shadow-[6px_6px_0px_#000]">
                            <p class="text-xs font-comic text-red-600 border-b-2 md:border-b-4 border-black pb-2 uppercase tracking-wider">
                                <i class="fas fa-mask"></i> PASES SECRETOS EMITIDOS
                            </p>
                            <div class="text-sm space-y-3 font-bold">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t-2 border-dashed border-black' : ''}">
                                        <span class="font-bold tracking-tight text-black truncate pr-4">${item.nombre.toUpperCase()}:</span> 
                                        <span class="bg-[#ffde17] border-2 border-black px-3 py-1 font-comic text-lg text-black tracking-widest shadow-[2px_2px_0px_#000] shrink-0">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <button onclick="cerrarModalAsistencia()" class="w-full bg-red-600 text-white border-2 md:border-4 border-black py-3 font-comic text-xl uppercase tracking-wider shadow-[4px_4px_0px_#000] hover:bg-red-700 transition">
                            ¡LISTO PARA LA ACCIÓN!
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-8 py-4 border-2 md:border-4 border-black text-xl font-comic uppercase text-white bg-emerald-500 shadow-[6px_6px_0px_#000] rotate-[2deg] max-w-md mx-auto">
                        ¡ASISTENCIA CONFIRMADA!
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("¡Rayos! Algo falló al enviar la señal de asistencia.");
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA POP ART ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-black', 'border-red-600');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-red-600', 'border-black');
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
            alert("¡Oye! Selecciona al menos una viñeta para descargar.");
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
            alert("¡Cáspita! No hay archivos en la base de datos.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>