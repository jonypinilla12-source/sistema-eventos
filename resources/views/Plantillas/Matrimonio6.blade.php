<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | ASSEMBLE</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto+Condensed:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --marvel-red: #EC1D24;
            --marvel-dark: #101010;
            --iron-cyan: #00E5FF;
            --strange-orange: #FF7E00;
        }

        h1, h2, h3, .font-marvel { font-family: 'Anton', sans-serif; letter-spacing: 1px; }
        body { font-family: 'Roboto Condensed', sans-serif; background-color: var(--marvel-dark); color: white; scroll-behavior: smooth; overflow-x: hidden; }

        .snap-container { height: 100vh; overflow-y: scroll; scroll-snap-type: y mandatory; overflow-x: hidden; }
        
        .section-marvel { min-height: 100vh; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative; scroll-snap-align: start; overflow: hidden; background-color: var(--marvel-dark); border-bottom: 4px solid var(--marvel-red); padding: 2rem 1rem; }

        .halftone-bg {
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 8px 8px;
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
        }

        .marvel-logo-box {
            background-color: var(--marvel-red); color: white; padding: 2px 8px; font-family: 'Anton', sans-serif; text-transform: uppercase; letter-spacing: -1px; display: inline-block;
        }

        .btn-marvel {
            background: var(--marvel-red); color: white; padding: 12px 20px; font-size: 1.1rem; font-family: 'Anton', sans-serif; text-transform: uppercase; letter-spacing: 2px; transition: all 0.3s ease; position: relative; display: inline-block; cursor: pointer; clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px); width: 100%; text-align: center;
        }
        @media (min-width: 768px) {
            .btn-marvel { font-size: 1.25rem; padding: 12px 35px; clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px); }
        }
        .btn-marvel:hover { background: white; color: var(--marvel-red); transform: scale(1.05); box-shadow: 0 0 20px rgba(236, 29, 36, 0.5); }
        .btn-marvel:disabled { opacity: 0.7; cursor: not-allowed; transform: none; box-shadow: none; }

        .iron-hud { border: 1px solid var(--iron-cyan); box-shadow: 0 0 15px rgba(0, 229, 255, 0.2), inset 0 0 15px rgba(0, 229, 255, 0.1); position: relative; }
        .iron-hud::before, .iron-hud::after { content: ''; position: absolute; width: 20px; height: 20px; border: 2px solid var(--iron-cyan); }
        .iron-hud::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .iron-hud::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }
        
        .animate-pop { animation: popIn 0.3s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: INICIO (TIPO POSTER AVENGERS) --}}
    <section class="section-marvel !p-0">
        <div class="halftone-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-transparent to-[#101010] z-0"></div>
        
        <div class="z-10 text-center max-w-5xl px-4 flex flex-col items-center w-full mt-10 md:mt-0">
            <div class="flex items-center gap-2 mb-4 md:mb-6 shadow-2xl transform hover:scale-105 transition">
                <span class="text-xl md:text-2xl font-bold uppercase tracking-widest text-white">STUDIOS</span>
                <div class="marvel-logo-box text-2xl md:text-4xl">PRESENTS</div>
            </div>
            
            <h1 class="text-6xl sm:text-8xl md:text-[130px] leading-[0.9] mb-4 text-white font-marvel uppercase tracking-tighter drop-shadow-[0_10px_20px_rgba(236,29,36,0.4)] w-full break-words">
                {{ $evento->nombre_evento }}
            </h1>

            <div class="border-t border-b border-white/20 py-2 mb-8 md:mb-12 w-full max-w-lg mx-auto text-stone-400">
                <p class="text-sm md:text-lg font-bold uppercase tracking-[0.2em] md:tracking-[0.3em]">FASE 1: {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d.m.Y') }}</p>
            </div>

            {{-- CONTADOR TIPO IRON MAN J.A.R.V.I.S --}}
            <div id="countdown" class="flex gap-2 sm:gap-4 md:gap-10 iron-hud p-4 md:p-6 bg-black/60 backdrop-blur-md w-[95%] sm:w-auto mx-auto justify-center">
                <div class="text-center min-w-[50px] md:min-w-[60px]">
                    <span id="days" class="text-3xl md:text-6xl font-marvel text-[var(--iron-cyan)] drop-shadow-[0_0_8px_var(--iron-cyan)]">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-stone-400 mt-1">Días</span>
                </div>
                <div class="text-center border-l border-[var(--iron-cyan)]/30 pl-2 sm:pl-4 md:pl-6 min-w-[50px] md:min-w-[60px]">
                    <span id="hours" class="text-3xl md:text-6xl font-marvel text-[var(--iron-cyan)] drop-shadow-[0_0_8px_var(--iron-cyan)]">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-stone-400 mt-1">Hrs</span>
                </div>
                <div class="text-center border-l border-[var(--iron-cyan)]/30 pl-2 sm:pl-4 md:pl-6 min-w-[50px] md:min-w-[60px]">
                    <span id="minutes" class="text-3xl md:text-6xl font-marvel text-[var(--iron-cyan)] drop-shadow-[0_0_8px_var(--iron-cyan)]">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-stone-400 mt-1">Min</span>
                </div>
                <div class="text-center border-l border-[var(--iron-cyan)]/30 pl-2 sm:pl-4 md:pl-6 min-w-[50px] md:min-w-[60px]">
                    <span id="seconds" class="text-3xl md:text-6xl font-marvel text-white">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-[var(--iron-cyan)] mt-1">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: ORÍGENES (CAPITÁN AMÉRICA) --}}
    <section class="section-marvel bg-[#0a1128]">
        <svg class="absolute -right-16 -bottom-16 md:-right-32 md:-bottom-32 w-[300px] h-[300px] md:w-[600px] md:h-[600px] opacity-10 animate-[spin_60s_linear_infinite]" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="48" fill="#EC1D24"/>
            <circle cx="50" cy="50" r="38" fill="#ffffff"/>
            <circle cx="50" cy="50" r="28" fill="#EC1D24"/>
            <circle cx="50" cy="50" r="18" fill="#0033a0"/>
            <polygon points="50,34 54,46 66,46 56,54 60,66 50,58 40,66 44,54 34,46 46,46" fill="#ffffff"/>
        </svg>

        <div class="halftone-bg"></div>
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center z-10 relative">
            <div class="border-2 md:border-4 border-white p-1 md:p-2 bg-white/5 backdrop-blur-sm transform -rotate-2 hover:rotate-0 transition duration-500 w-full max-w-[300px] md:max-w-none mx-auto">
                {{-- AQUÍ SOLO USAMOS LA FOTO LOCAL DEL DISEÑO --}}
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-[300px] md:h-[500px] object-cover filter contrast-125 saturate-110">
                @endif
                <div class="absolute -bottom-4 -right-4 md:-bottom-5 md:-right-5 marvel-logo-box text-sm md:text-xl shadow-xl whitespace-nowrap">
                    THE FIRST AVENGER
                </div>
            </div>
            
            <div class="space-y-4 md:space-y-6 bg-black/40 md:bg-transparent p-4 md:p-0 rounded-lg">
                <h2 class="text-4xl sm:text-5xl md:text-7xl font-marvel uppercase text-white drop-shadow-md">ORIGEN DEL HÉROE</h2>
                <div class="h-1 md:h-2 w-16 md:w-24 bg-white"></div>
                <div class="bg-black/60 border-l-2 md:border-l-4 border-[var(--marvel-red)] p-4 md:p-8">
                    <p class="text-sm md:text-lg leading-relaxed text-stone-200 font-light">
                        "{{ $evento->biografia_resumen }}"
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN (DOCTOR STRANGE) --}}
    <section class="section-marvel overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20 overflow-hidden">
            <div class="w-[350px] h-[350px] md:w-[700px] md:h-[700px] rounded-full border-[4px] md:border-[8px] border-[var(--strange-orange)] border-dashed animate-[spin_20s_linear_infinite] shadow-[0_0_30px_var(--strange-orange)] md:shadow-[0_0_60px_var(--strange-orange)]"></div>
            <div class="absolute w-[330px] h-[330px] md:w-[660px] md:h-[660px] rounded-full border-[2px] md:border-[4px] border-yellow-400 border-dotted animate-[spin_15s_linear_infinite_reverse]"></div>
        </div>

        <div class="halftone-bg"></div>
        <div class="text-center z-10 w-[90%] max-w-4xl mx-auto bg-black/60 p-8 md:p-12 backdrop-blur-md border border-[var(--strange-orange)]/30 rounded-[30px] md:rounded-full">
            <div class="text-[var(--strange-orange)] text-4xl md:text-5xl mb-4"><i class="fas fa-ring animate-pulse"></i></div>
            <h2 class="text-3xl sm:text-4xl md:text-6xl mb-4 md:mb-8 font-marvel uppercase text-white drop-shadow-[0_0_10px_var(--strange-orange)] leading-tight">
                {{ $evento->ubicacion_texto }}
            </h2>
            
            <p class="text-stone-400 text-xs md:text-base mb-6 md:mb-10 font-bold tracking-[0.1em] md:tracking-widest uppercase">Coordenadas del Multiverso Establecidas</p>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-marvel !bg-[var(--strange-orange)] hover:!bg-white hover:!text-[var(--strange-orange)] max-w-xs">
                    ABRIR PORTAL GPS <i class="fas fa-map-marked-alt ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: PROTOCOLOS / INTERACCIONES --}}
    <section class="section-marvel bg-[#0a0a0a] !p-0 block md:flex md:flex-row h-auto md:h-screen overflow-y-auto md:overflow-hidden">
        
        {{-- BLOQUE TRIVIA --}}
        <div class="flex flex-col justify-center items-center bg-black/80 border-b md:border-b-0 md:border-r border-[var(--iron-cyan)]/30 group p-8 md:p-12 space-y-6 md:space-y-8 w-full md:w-1/2 min-h-[50vh] md:min-h-full relative overflow-hidden iron-hud !border-0 !box-shadow-none">
            <div class="absolute inset-0 bg-[var(--iron-cyan)] opacity-0 group-hover:opacity-10 transition duration-500"></div>
            <div class="text-center z-10 w-full">
                <i class="fas fa-crosshairs text-3xl md:text-4xl text-[var(--iron-cyan)] mb-4 animate-pulse"></i>
                <h3 class="text-4xl md:text-7xl mb-2 font-marvel text-white tracking-widest">PROTOCOLO T</h3>
                <p class="text-xs md:text-sm font-bold text-[var(--iron-cyan)] uppercase tracking-widest mb-4">Verificación Stark</p>
            </div>
            <div id="wrapper-btn-trivia" class="w-full max-w-[250px] md:max-w-xs text-center z-10">
                @if($yaComenzo)
                    <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-marvel w-full text-base md:text-lg !bg-[var(--iron-cyan)] !text-black hover:!bg-white hover:!text-black mb-3 md:mb-4">INICIAR TEST</button>
                    <button onclick="verRanking()" class="w-full py-2 md:py-3 bg-transparent border-2 border-[var(--iron-cyan)]/50 text-[var(--iron-cyan)] font-marvel text-lg md:text-xl tracking-widest hover:bg-[var(--iron-cyan)] hover:text-black transition">VER RANKING</button>
                @else
                    <button id="btn-time-trivia" disabled class="w-full py-3 md:py-4 bg-stone-900 text-stone-600 font-marvel text-lg md:text-xl uppercase cursor-not-allowed border border-stone-800">
                        <i class="fas fa-lock mr-2"></i> BLOQUEADO
                    </button>
                @endif
            </div>
        </div>

        {{-- BLOQUE MURO --}}
        <div class="flex flex-col justify-center items-center bg-[#151515] group p-8 md:p-12 space-y-6 md:space-y-8 w-full md:w-1/2 min-h-[50vh] md:min-h-full relative overflow-hidden">
            <div class="absolute inset-0 bg-[var(--marvel-red)] opacity-0 group-hover:opacity-5 transition duration-500"></div>
            <div class="text-center z-10 w-full">
                <i class="fas fa-folder-open text-3xl md:text-4xl text-[var(--marvel-red)] mb-4"></i>
                <h3 class="text-4xl md:text-7xl mb-2 font-marvel text-white tracking-widest">ARCHIVOS</h3>
                <p class="text-xs md:text-sm font-bold text-stone-400 uppercase tracking-widest mb-4">Registro de Misiones</p>
            </div>
            <div id="wrapper-btn-muro" class="w-full max-w-[250px] md:max-w-xs text-center flex flex-col gap-3 md:gap-4 z-10">
                @if($yaComenzo)
                    <button onclick="solicitarAccesoVerificacion('muro')" class="btn-marvel w-full text-base md:text-lg">AÑADIR REPORTE</button>
                    <button onclick="mostrarMuroVisual()" class="w-full py-2 md:py-3 bg-transparent text-white border border-white/30 font-marvel text-lg md:text-xl uppercase tracking-widest hover:bg-white/10 transition">VER REGISTROS</button>
                @else
                    <button id="btn-time-muro" disabled class="w-full py-3 md:py-4 bg-stone-900 text-stone-600 font-marvel text-lg md:text-xl uppercase cursor-not-allowed border border-stone-800">
                        <i class="fas fa-lock mr-2"></i> BLOQUEADO
                    </button>
                @endif
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: MURO / ARCHIVOS CLASIFICADOS (CAPA FLOTANTE) --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[var(--marvel-dark)] overflow-y-auto w-full">
        <div class="halftone-bg"></div>
        <div class="relative max-w-7xl w-full mx-auto p-4 md:p-8 pt-16 md:pt-24 pb-16 z-10">
            <div class="text-center mb-10 md:mb-16">
                <div class="marvel-logo-box text-lg md:text-2xl mb-4 shadow-[0_0_15px_rgba(236,29,36,0.4)]">S.H.I.E.L.D. DATABASE</div>
                <h2 class="text-3xl sm:text-5xl md:text-7xl font-marvel text-white uppercase tracking-widest drop-shadow-xl px-2">ARCHIVOS DESCLASIFICADOS</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 items-start w-full px-2">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="bg-[#1a1a1a] border border-white/10 p-4 md:p-6 flex flex-col relative overflow-hidden group shadow-2xl w-full">
                        <div class="absolute top-0 left-0 w-1 h-full bg-[var(--marvel-red)] scale-y-0 group-hover:scale-y-100 transition-transform origin-top duration-300"></div>
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="border border-white/20 mb-3 md:mb-4 bg-black">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" 
                                     class="w-full h-40 md:h-auto object-cover opacity-80 group-hover:opacity-100 transition duration-500">
                            </div>
                        @endif
                        <div class="flex-grow">
                            <p class="text-stone-300 leading-relaxed font-light text-xs md:text-sm mb-4 break-words">"{{ $item->contenido_texto }}"</p>
                        </div>
                        <div class="mt-2 md:mt-4 pt-3 md:pt-4 border-t border-white/10 flex justify-between items-center">
                            <span class="text-[8px] md:text-[10px] font-bold text-[var(--marvel-red)] tracking-widest uppercase">AUTORIZADO:</span>
                            <span class="text-[10px] md:text-xs text-white font-marvel uppercase tracking-wider truncate ml-2">{{ $item->nombre_autor }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border border-dashed border-white/20 p-8 md:p-16 text-center bg-black/50 backdrop-blur-sm mx-2">
                        <p class="text-lg md:text-2xl font-marvel text-stone-500 uppercase tracking-widest">Base de datos vacía. Esperando reportes.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12 md:mt-20 mb-10 px-4 flex justify-center">
                <button onclick="ocultarMuroVisual()" class="btn-marvel text-base md:text-xl shadow-[0_0_20px_rgba(236,29,36,0.3)] w-full max-w-xs">
                    <i class="fas fa-times mr-2"></i> CERRAR BASE
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: EVIDENCIA VISUAL UNIFICADA (TIEMPO REAL CLOUD) CON SOPORTE DE VIDEO --}}
    <section class="section-marvel bg-[#050505] !h-auto py-20 min-h-[60vh]">
        <div class="halftone-bg"></div>
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-20">
            
            <div class="text-center mb-8">
                <div class="marvel-logo-box text-sm md:text-xl mb-3 shadow-[0_0_15px_rgba(236,29,36,0.4)]">ARCHIVOS MULTIMEDIA</div>
                <h2 class="text-4xl sm:text-5xl md:text-7xl font-marvel uppercase text-white tracking-widest drop-shadow-md">EVIDENCIA VISUAL</h2>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-6 bg-black/80 p-4 md:p-6 border border-[var(--iron-cyan)]/30 iron-hud shadow-[0_0_15px_rgba(0,229,255,0.1)] gap-4">
                <span id="contador-seleccionadas" class="font-marvel text-2xl text-[var(--iron-cyan)] tracking-widest animate-pulse">
                    0 SELECCIONADAS
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-sm font-bold border border-white/50 text-white px-6 py-3 hover:bg-[var(--iron-cyan)] hover:text-black hover:border-[var(--iron-cyan)] transition uppercase tracking-wider w-full md:w-auto">
                        <i class="fas fa-download mr-2"></i> Extraer Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-marvel !w-full md:!w-auto text-sm !py-3">
                        <i class="fas fa-cloud-download-alt mr-2"></i> Extraer Todo
                    </button>
                </div>
            </div>

            @php
                $galeriaUnificada = collect();

                // 1. Cargamos las fotos Locales físicas de la BD
                if(isset($evento->fotosGaleria)) {
                    foreach($evento->fotosGaleria as $foto) {
                        if(!str_starts_with($foto->url_recurso, 'http')) {
                            $ext = strtolower(pathinfo($foto->url_recurso, PATHINFO_EXTENSION));
                            $esVideoLocal = in_array($ext, ['mp4', 'mov', 'avi', 'webm']);

                            $galeriaUnificada->push([
                                'url' => asset('storage/' . $foto->url_recurso),
                                'esNube' => false,
                                'esVideo' => $esVideoLocal,
                                'etiqueta' => 'LOCAL / SERVIDOR'
                            ]);
                        }
                    }
                }

                // 2. Cargamos las fotos de OneDrive en tiempo real (Con soporte para Video)
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

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 w-full max-h-[60vh] overflow-y-auto hide-scroll p-2">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer border-2 border-transparent hover:border-[var(--iron-cyan)] transition overflow-hidden bg-black flex items-center justify-center" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/20 hover:bg-black/10 transition">
                                <i class="fas fa-play-circle text-5xl text-white/80 group-hover:text-[var(--iron-cyan)] group-hover:scale-110 transition drop-shadow-[0_0_15px_rgba(0,0,0,0.9)]"></i>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover filter contrast-110 opacity-70" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover filter contrast-110">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[var(--iron-cyan)]/20 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-2 right-2 bg-black text-[var(--iron-cyan)] rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 border-2 border-[var(--iron-cyan)] shadow-[0_0_10px_var(--iron-cyan)] z-30 pointer-events-none">
                            <i class="fas fa-check"></i>
                        </div>

                        <div class="absolute bottom-2 left-2 right-2 bg-black/80 text-white text-[8px] md:text-[10px] px-2 py-1 font-marvel tracking-widest border border-[var(--iron-cyan)]/50 truncate text-center z-30 pointer-events-none">
                            @if($foto['esVideo'])
                                <i class="fas fa-video text-purple-400 mr-2"></i>
                            @else
                                <i class="fas {{ $foto['esNube'] ? 'fa-cloud text-[var(--iron-cyan)]' : 'fa-server text-[var(--marvel-red)]' }} mr-2"></i>
                            @endif
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border border-dashed border-white/20 p-10 bg-black/50">
                        <p class="text-stone-500 font-marvel text-2xl tracking-widest">SIN EVIDENCIA VISUAL REGISTRADA</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

   {{-- SECCIÓN 5: RSVP (SPIDER-MAN / ASSEMBLE) --}}
    <section class="section-marvel bg-[#0d0d0d] relative">
        {{-- SVGs de fondo decorativos --}}
        <svg class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,0 L100,100 M50,0 L50,100 M100,0 L0,100 M0,50 L100,50" stroke="white" stroke-width="0.5"/>
            <circle cx="50" cy="50" r="20" fill="none" stroke="white" stroke-width="0.5"/>
            <circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="0.5"/>
        </svg>
        <svg class="absolute top-5 right-5 md:top-10 md:right-10 w-16 h-16 md:w-24 md:h-24 opacity-20 pointer-events-none" viewBox="0 0 24 24" fill="var(--marvel-red)">
            <path d="M12,2 C11.5,4 10,6 8,7 C8.5,8 9.5,8 10.5,8 C9,10 8,13 8,16 C9,14 10.5,12 11.5,11 C11.5,13 11,16 10,19 C11,18 12,15 12,15 C12,15 13,18 14,19 C13,16 12.5,13 12.5,11 C13.5,12 15,14 16,16 C16,13 15,10 13.5,8 C14.5,8 15.5,8 16,7 C14,6 12.5,4 12,2 Z"/>
        </svg>

        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 z-10 w-full max-w-3xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <h2 class="text-6xl sm:text-7xl md:text-[130px] mb-4 md:mb-6 font-marvel uppercase leading-none drop-shadow-2xl text-white break-words">ASSEMBLE</h2>
                <p class="text-sm md:text-xl text-stone-400 font-bold mb-8 md:mb-12 tracking-[0.1em] md:tracking-[0.3em] uppercase">Vengadores, es hora de reunirse.</p>
                
                <div id="contenedorBotonPrincipalRSVP" class="w-full flex justify-center">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-marvel text-2xl md:text-3xl px-8 md:px-12 py-3 md:py-4 w-full max-w-xs md:max-w-md">
                            CONFIRMAR ESTATUS
                        </button>
                    @else
                        <div class="px-4 md:px-8 py-3 md:py-4 border border-[var(--marvel-red)] text-white bg-black/50 font-marvel text-xl md:text-2xl uppercase tracking-wider md:tracking-widest shadow-lg max-w-xs md:max-w-md mx-auto">
                            ACREDITACIÓN CLASIFICADA REQUERIDA
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-col items-center gap-4 mt-12 md:mt-16 border-t border-white/10 pt-6 md:pt-8 w-full px-2">
                    <p class="text-stone-500 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-center w-full break-words">
                        SECTOR DE BATALLA: <br class="block sm:hidden"> <span class="text-white ml-0 sm:ml-2">{{ $invitado->mesa_asignada ?? 'PENDIENTE' }}</span>
                    </p>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-50 hover:opacity-100 transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-stone-500 mb-1.5 font-medium">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono y texto que pasan al rojo de Marvel en hover --}}
                        <i class="fas fa-glass-cheers text-[11px] md:text-xs text-white/50 group-hover:text-[var(--marvel-red)] transition-colors"></i>
                        <span class="font-marvel text-sm md:text-lg tracking-widest text-white/80 group-hover:text-[var(--marvel-red)] transition-colors">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO Y CUESTIONARIO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div id="wrapper-dinamico-modal" class="bg-[#111] border border-white/10 w-full max-w-xl p-6 md:p-8 text-center shadow-2xl relative overflow-hidden max-h-[95vh] overflow-y-auto">
        <div class="absolute top-0 left-0 w-full h-1 bg-[var(--marvel-red)]"></div>
        
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-white/10 pb-4">
                <h3 class="text-xl md:text-2xl font-marvel text-white uppercase tracking-widest"><i class="fas fa-fingerprint text-[var(--marvel-red)] mr-2"></i> ACCESO RESTRINGIDO</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-4 md:space-y-6 text-left">
                <p class="text-xs md:text-sm font-light text-stone-400 leading-relaxed">Ingresa tu **Código de Identificación** para acceder a los protocolos de la misión.</p>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[var(--marvel-red)] mb-2">Código S.H.I.E.L.D.</label>
                    <input type="text" id="inputCodigoIngreso" placeholder="EJ: STARK-01" class="w-full border border-white/20 bg-black p-3 md:p-4 text-sm font-mono tracking-widest font-bold outline-none uppercase text-white focus:border-[var(--marvel-red)] transition">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="btn-marvel w-full !py-3 md:!py-4 text-lg md:text-xl mt-2">
                    INICIAR AUTENTICACIÓN
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="iron-hud w-full max-w-2xl p-6 md:p-8 text-center bg-black/90 relative max-h-[95vh] flex flex-col !border-[var(--iron-cyan)] shadow-[0_0_20px_rgba(0,229,255,0.2)] md:shadow-[0_0_30px_rgba(0,229,255,0.3)]">
        
        <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-[var(--iron-cyan)]/30 pb-4 shrink-0 text-left">
            <h3 class="text-2xl md:text-3xl font-marvel text-[var(--iron-cyan)] uppercase tracking-wider md:tracking-widest drop-shadow-[0_0_5px_var(--iron-cyan)] md:drop-shadow-[0_0_10px_var(--iron-cyan)]">
                <i class="fas fa-trophy mr-2"></i> RANKING DE AGENTES
            </h3>
            <button onclick="cerrarModalRanking()" class="text-[var(--iron-cyan)] hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-1 md:pr-2 space-y-2 md:space-y-3 flex-grow text-left hide-scroll" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--iron-cyan)]"></i>
            </div>
        </div>

        <div class="mt-4 md:mt-6 pt-4 border-t border-[var(--iron-cyan)]/30 shrink-0">
            <button onclick="cerrarModalRanking()" class="w-full py-3 border border-[var(--iron-cyan)] text-[var(--iron-cyan)] font-marvel text-lg md:text-xl tracking-widest hover:bg-[var(--iron-cyan)] hover:text-black transition shadow-[0_0_10px_rgba(0,229,255,0.2)] md:shadow-[0_0_15px_rgba(0,229,255,0.4)]">
                CERRAR PANEL
            </button>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO: MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div class="bg-[#111] border border-white/10 w-full max-w-md p-6 md:p-8 text-left shadow-2xl relative overflow-hidden max-h-[95vh] overflow-y-auto">
        <div class="absolute top-0 left-0 w-full h-1 bg-white"></div>
        
        <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-white/10 pb-3 md:pb-4">
            <h3 class="text-xl md:text-2xl font-marvel text-white uppercase tracking-widest">AÑADIR REPORTE</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-1 md:mb-2">Agente</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border-b border-white/20 bg-transparent py-2 text-xs md:text-sm font-bold outline-none text-stone-300">
            </div>
             <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-1 md:mb-2">Afiliación *</label>
                <select name="vinculo_autor" required class="w-full border-b border-white/20 bg-[#111] py-2 text-xs md:text-sm font-bold outline-none text-white focus:border-[var(--marvel-red)] cursor-pointer">
                    <option value="" disabled selected>Seleccionar...</option>
                    <option value="Familiar">Familia</option>
                    <option value="Amigo/a">Aliado / Amigo</option>
                    <option value="Compañero">Compañero de Batalla</option>
                    <option value="Conocido/a">Civil Conocido</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-1 md:mb-2">Reporte de Misión *</label>
                <textarea name="contenido" rows="3" required class="w-full border border-white/20 bg-black p-3 text-xs md:text-sm font-light outline-none focus:border-[var(--marvel-red)] text-white resize-none" placeholder="Ingresar datos..."></textarea>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-1 md:mb-2">Evidencia Visual (Opcional)</label>
                <input type="file" name="archivo" accept="image/*,video/*" class="w-full text-[10px] md:text-xs text-stone-500 file:mr-2 md:file:mr-4 file:py-1 md:file:py-2 file:px-2 md:file:px-4 file:border file:border-white/20 file:bg-transparent file:text-white file:font-marvel file:tracking-widest file:cursor-pointer hover:file:bg-white hover:file:text-black transition">
            </div>

            <button type="submit" id="btnPublicarMuroBoda" class="btn-marvel w-full !bg-white !text-black hover:!bg-transparent hover:!text-white hover:!border-white !py-3 md:!py-4 text-lg md:text-xl mt-2 md:mt-4">
                CARGAR A LA BASE DE DATOS
            </button>
        </form>
    </div>
</div>

{{-- MODAL ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div class="bg-[#111] border border-[var(--marvel-red)] max-w-md w-full p-6 md:p-8 text-center shadow-[0_0_20px_rgba(236,29,36,0.2)] md:shadow-[0_0_30px_rgba(236,29,36,0.2)] max-h-[95vh] overflow-y-auto relative">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-white/10 pb-3 md:pb-4 text-left">
                <h3 class="text-2xl md:text-3xl font-marvel text-white uppercase tracking-widest">ESTATUS DE MISIÓN</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-4 md:space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black border border-white/10 p-4 md:p-5 space-y-3 md:space-y-4 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-[var(--marvel-red)]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--marvel-red)] block mb-1 md:mb-2">Vengador Principal</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="NOMBRE COMPLETO *" required class="w-full border-b border-white/20 bg-transparent py-2 text-xs md:text-sm font-bold outline-none focus:border-white text-white uppercase">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" placeholder="CORREO ELECTRÓNICO" class="w-full border-b border-white/20 bg-transparent py-2 text-xs md:text-sm font-bold outline-none focus:border-white text-white">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-3 md:space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2 md:py-3 border border-dashed border-white/30 text-stone-400 font-marvel text-base md:text-lg uppercase tracking-wider md:tracking-widest hover:bg-white/5 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> AÑADIR REFUERZOS
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-marvel w-full text-xl md:text-2xl !py-3 md:!py-4 mt-4 md:mt-6 block text-center">
                    CONFIRMAR DEPLOY
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO CLASIFICADO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-stone-400 hover:text-[var(--marvel-red)] transition z-50">
        <i class="fas fa-times text-3xl md:text-4xl"></i>
    </button>
    <div class="w-full max-w-4xl iron-hud bg-black p-2 shadow-[0_0_30px_rgba(0,229,255,0.3)]" onclick="event.stopPropagation()">
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
        const horaEvento = "{{ $evento->hora ?? '18:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<div class='marvel-logo-box text-xl md:text-3xl shadow-lg'>EL EVENTO HA COMENZADO</div>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-marvel w-full text-base md:text-lg !bg-[var(--iron-cyan)] !text-black hover:!bg-white hover:!text-black mb-3 md:mb-4">INICIAR TEST</button>
                        <button onclick="verRanking()" class="w-full py-2 md:py-3 bg-transparent border-2 border-[var(--iron-cyan)]/50 text-[var(--iron-cyan)] font-marvel text-lg md:text-xl tracking-widest hover:bg-[var(--iron-cyan)] hover:text-black transition">VER RANKING</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="btn-marvel w-full text-base md:text-lg !bg-white !text-black hover:!bg-transparent hover:!text-white hover:!border-white">AÑADIR REPORTE</button>
                        <button onclick="mostrarMuroVisual()" class="w-full py-2 md:py-3 bg-transparent text-white border border-white/30 font-marvel text-lg md:text-xl uppercase tracking-widest hover:bg-white/10 transition mt-3 md:mt-4">VER REGISTROS</button>
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
        muro.scrollTop = 0;
    }

    function ocultarMuroVisual() {
        const muro = document.getElementById('seccionMuroMensajes');
        muro.classList.add('hidden');
    }

    function solicitarAccesoVerificacion(modulo) {
        moduloObjetivo = modulo;
        document.getElementById('wrapper-dinamico-modal').className = "bg-[#111] border border-white/10 w-full max-w-xl p-6 md:p-8 text-center shadow-2xl relative overflow-hidden max-h-[95vh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div class="absolute top-0 left-0 w-full h-1 bg-[var(--marvel-red)]"></div>
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-white/10 pb-3 md:pb-4 text-left">
                    <h3 class="text-xl md:text-2xl font-marvel text-white uppercase tracking-widest"><i class="fas fa-fingerprint text-[var(--marvel-red)] mr-2"></i> ACCESO RESTRINGIDO</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
                </div>
                <div class="space-y-4 md:space-y-6 text-left">
                    <p class="text-xs md:text-sm font-light text-stone-400 leading-relaxed">Ingresa tu **Código de Identificación** para acceder a los protocolos de la misión.</p>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[var(--marvel-red)] mb-2">Código S.H.I.E.L.D.</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="EJ: STARK-01" class="w-full border border-white/20 bg-black p-3 md:p-4 text-sm font-mono tracking-widest font-bold outline-none uppercase text-white focus:border-[var(--marvel-red)] transition">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="btn-marvel w-full !py-3 md:!py-4 text-lg md:text-xl mt-2">
                        INICIAR AUTENTICACIÓN
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() { document.getElementById('modalFiltroAcceso').classList.add('hidden'); }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("Código requerido."); return; }

        const btnVerificar = document.getElementById('btnVerificarCodigo');
        const txtOriginalVerificar = btnVerificar.innerHTML;
        
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-70', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> AUTENTICANDO...';

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/invitacion/validar-pase-trivia`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': tokenCsrf },
            body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
        })
        .then(async response => {
            const data = await response.status === 422 || response.status === 404 || response.status === 200 ? await response.json() : {};
            
            if (response.status === 422 && data.already_played) {
                if (moduloObjetivo === 'trivia') {
                    const wrapper = document.getElementById('wrapper-dinamico-modal');
                    wrapper.className = "iron-hud w-full max-w-xl p-6 md:p-8 text-center shadow-[0_0_30px_rgba(0,229,255,0.2)] md:shadow-[0_0_50px_rgba(0,229,255,0.2)] bg-black/90 !border-0";
                    wrapper.innerHTML = `
                        <div class="py-6 md:py-8 text-center space-y-4 md:space-y-6 animate-pop">
                            <i class="fas fa-shield-alt text-5xl md:text-6xl text-[var(--iron-cyan)] mb-2 md:mb-4 drop-shadow-[0_0_10px_var(--iron-cyan)]"></i>
                            <h3 class="text-2xl md:text-3xl font-marvel text-[var(--iron-cyan)] tracking-widest">PROTOCOLO COMPLETADO</h3>
                            <p class="text-xs md:text-sm font-light text-stone-300 px-2 md:px-4">${data.message}</p>
                            <div class="pt-4 md:pt-6 space-y-3 md:space-y-4">
                                <button onclick="verRanking()" class="btn-marvel w-full !bg-[var(--iron-cyan)] !text-black hover:!bg-white">VER TABLERO POSICIONES</button>
                                <button onclick="cerrarModalFiltro()" class="w-full py-2 md:py-3 border border-[var(--iron-cyan)]/50 text-[var(--iron-cyan)] font-marvel text-base md:text-lg hover:bg-[var(--iron-cyan)] hover:text-black transition">CERRAR TERMINAL</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Agente" };
                }
            }

            if (!response.ok) { alert(data.message || "Acceso Denegado."); throw new Error("invalid_code"); }
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Agente" ? data.nombre_invitado : "Aliado";
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => { 
            if (err.message !== "already_handled") {
                console.error("Fallo:", err); 
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
        botonPublicar.innerHTML = `<i class="fas fa-circle-notch fa-spin mr-2"></i> CARGANDO DATOS...`;

        const form = event.target;
        const formData = new FormData(form);

        fetch(`/invitacion/memorial/${eventoId}/recuerdo`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
            body: formData
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert(data.message || "Falla en transmisión.");
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Validation fail");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const modalInterior = document.getElementById('modalMuroBoda').firstElementChild;
                modalInterior.innerHTML = `
                    <div class="py-8 md:py-10 text-center space-y-4 md:space-y-6 animate-pop">
                        <div class="marvel-logo-box text-xl md:text-3xl mb-2 md:mb-4"><i class="fas fa-check"></i> TRANSFERENCIA EXITOSA</div>
                        <p class="text-xs md:text-sm text-stone-400 font-light px-2 md:px-4">${data.message}</p>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="btn-marvel mt-6 md:mt-8 w-full">FINALIZAR CONEXIÓN</button>
                    </div>
                `;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.classList.add('iron-hud', '!border-0', 'bg-black/90');
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 md:space-y-8 animate-pop">
                <div class="text-[var(--iron-cyan)] text-4xl md:text-5xl animate-pulse"><i class="fas fa-microchip"></i></div>
                <div class="text-xl md:text-2xl font-bold text-[var(--iron-cyan)] tracking-widest uppercase">SISTEMA J.A.R.V.I.S. EN LÍNEA</div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-marvel text-white uppercase">AGENTE ${datosInvitadoValidado.nombre.toUpperCase()}</h1>
                <p class="text-stone-300 text-xs md:text-sm font-light leading-relaxed px-2 md:px-4">El sistema ha detectado <strong class="text-[var(--iron-cyan)]">${bancoPreguntas.length} amenazas cognitivas</strong>. La velocidad es crítica. ¿Estás listo?</p>
                <button onclick="comenzarJuegoModal()" class="btn-marvel w-full text-xl md:text-2xl !py-3 md:!py-4 !bg-[var(--iron-cyan)] !text-black hover:!bg-white">INICIAR SIMULACIÓN</button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-4 md:space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-[var(--iron-cyan)] border-b border-[var(--iron-cyan)]/30 pb-3 md:pb-4">
                    <span id="info-progreso">FASE 1 DE X</span>
                    <span><i class="fas fa-stopwatch mr-1"></i> T: <span id="info-cronometro" class="font-mono text-sm text-white">0s</span></span>
                </div>
                <h2 id="texto-pregunta" class="text-xl sm:text-2xl md:text-3xl font-marvel text-white uppercase tracking-wider leading-snug">Cargando datos...</h2>
                <div class="space-y-2 md:space-y-3 pt-2 md:pt-4">
                    <button onclick="seleccionarOpcionModal('a')" id="btn-opcion-a" class="w-full text-left p-3 md:p-4 border border-[var(--iron-cyan)]/30 bg-black/50 hover:bg-[var(--iron-cyan)]/10 hover:border-[var(--iron-cyan)] transition flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-6 h-6 md:w-8 md:h-8 bg-[var(--iron-cyan)]/20 text-[var(--iron-cyan)] font-marvel text-lg md:text-xl flex items-center justify-center shrink-0">A</span>
                        <span id="texto-opcion-a" class="font-light text-xs md:text-sm break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" id="btn-opcion-b" class="w-full text-left p-3 md:p-4 border border-[var(--iron-cyan)]/30 bg-black/50 hover:bg-[var(--iron-cyan)]/10 hover:border-[var(--iron-cyan)] transition flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-6 h-6 md:w-8 md:h-8 bg-[var(--iron-cyan)]/20 text-[var(--iron-cyan)] font-marvel text-lg md:text-xl flex items-center justify-center shrink-0">B</span>
                        <span id="texto-opcion-b" class="font-light text-xs md:text-sm break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" id="btn-opcion-c" class="w-full text-left p-3 md:p-4 border border-[var(--iron-cyan)]/30 bg-black/50 hover:bg-[var(--iron-cyan)]/10 hover:border-[var(--iron-cyan)] transition flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-6 h-6 md:w-8 md:h-8 bg-[var(--iron-cyan)]/20 text-[var(--iron-cyan)] font-marvel text-lg md:text-xl flex items-center justify-center shrink-0">C</span>
                        <span id="texto-opcion-c" class="font-light text-xs md:text-sm break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" id="btn-opcion-d" class="w-full text-left p-3 md:p-4 border border-[var(--iron-cyan)]/30 bg-black/50 hover:bg-[var(--iron-cyan)]/10 hover:border-[var(--iron-cyan)] transition flex items-center space-x-3 md:space-x-4 text-stone-300">
                        <span class="w-6 h-6 md:w-8 md:h-8 bg-[var(--iron-cyan)]/20 text-[var(--iron-cyan)] font-marvel text-lg md:text-xl flex items-center justify-center shrink-0">D</span>
                        <span id="texto-opcion-d" class="font-light text-xs md:text-sm break-words">Opción D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-[var(--iron-cyan)] font-marvel uppercase text-lg md:text-xl">Sin datos en el servidor.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `FASE ${preguntaActualIndex + 1} DE ${bancoPreguntas.length}`;
        document.getElementById('texto-pregunta').innerText = q.pregunta.toUpperCase();
        document.getElementById('texto-opcion-a').innerText = q.opcion_a;
        document.getElementById('texto-opcion-b').innerText = q.opcion_b;
        document.getElementById('texto-opcion-c').innerText = q.opcion_c;
        document.getElementById('texto-opcion-d').innerText = q.opcion_d;
    }

    function seleccionarOpcionModal(opcionElegida) {
        const q = bancoPreguntas[preguntaActualIndex];
        if (opcionElegida === q.respuesta_correcta) { puntajeAcumulado += parseInt(q.puntos); }
        preguntaActualIndex++;
        if (preguntaActualIndex < bancoPreguntas.length) { renderizarPreguntaModal(); } 
        else { finalizarTriviaModal(); }
    }

    function finalizarTriviaModal() {
        clearInterval(intervaloCronometro);
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div class="text-center space-y-4 md:space-y-6 py-8 md:py-10 animate-pop">
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--iron-cyan)]"></i>
                <h3 class="text-xl md:text-2xl font-marvel text-[var(--iron-cyan)] uppercase tracking-widest">ENCRIPTANDO RESULTADOS...</h3>
            </div>
        `;
        const payload = {
            evento_id: "{{ $evento->evento_id }}", invitado_id: datosInvitadoValidado.id, nombre_jugador: datosInvitadoValidado.nombre, puntaje: puntajeAcumulado, tiempo_segundos: segundosTranscurridos
        };
        fetch('/invitacion/registrar-participacion-trivia', {
            method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') }, body: JSON.stringify(payload)
        }).then(res => res.json()).then(data => {
            if (data && data.success) {
                wrapper.className = "iron-hud w-full max-w-xl p-6 md:p-8 text-center shadow-[0_0_30px_rgba(0,229,255,0.2)] md:shadow-[0_0_50px_rgba(0,229,255,0.2)] bg-black/90 !border-0";
                wrapper.innerHTML = `
                    <div class="text-center space-y-6 md:space-y-8 py-2 md:py-4 animate-pop">
                        <div class="marvel-logo-box text-lg md:text-2xl mb-1 md:mb-2">SIMULACIÓN FINALIZADA</div>
                        <p class="text-xs md:text-sm font-light text-stone-400">Datos guardados en la red principal.</p>
                        <div class="grid grid-cols-2 gap-3 md:gap-4 bg-black border border-[var(--iron-cyan)]/30 p-4 md:p-6 mx-auto text-left">
                            <div class="border-r border-[var(--iron-cyan)]/30 pr-2 md:pr-4">
                                <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-[var(--iron-cyan)] mb-1">SCORE</span>
                                <span class="text-2xl md:text-3xl font-marvel text-white">${puntajeAcumulado}</span>
                            </div>
                            <div class="pl-2 md:pl-4">
                                <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-[var(--iron-cyan)] mb-1">TIME</span>
                                <span class="text-2xl md:text-3xl font-marvel text-white">${segundosTranscurridos}s</span>
                            </div>
                        </div>
                        <div class="pt-2 md:pt-4 space-y-3 md:space-y-4">
                            <button onclick="verRanking()" class="btn-marvel w-full !bg-[var(--iron-cyan)] !text-black hover:!bg-white text-sm md:text-lg !py-3">VER TABLERO DE POSICIONES</button>
                            <button onclick="cerrarModalFiltro()" class="w-full py-2 md:py-3 border border-[var(--iron-cyan)]/50 text-[var(--iron-cyan)] font-marvel text-base md:text-lg hover:bg-[var(--iron-cyan)] hover:text-black transition">CERRAR TERMINAL</button>
                        </div>
                    </div>
                `;
            }
        }).catch(err => { wrapper.innerHTML = `<p class="text-red-500 font-bold uppercase">Error de red.</p>`; });
    }

    // --- LÓGICA DEL RANKING (S.H.I.E.L.D. LEADERBOARD) ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-circle-notch fa-spin text-4xl text-[var(--iron-cyan)]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-[var(--iron-cyan)] text-center font-marvel text-lg md:text-xl mt-10">NO HAY DATOS EN LA BASE DE S.H.I.E.L.D.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-lg md:text-xl text-stone-500 font-marvel mr-3 md:mr-4 w-6 text-center">#${index + 1}</span>`;
                        let resplandor = 'border-white/10 bg-black text-white';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-trophy text-yellow-400 text-xl md:text-2xl mr-3 md:mr-4 w-6 text-center"></i>';
                            resplandor = 'border-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.2)] md:shadow-[0_0_15px_rgba(250,204,21,0.2)] bg-yellow-400/10 text-yellow-400';
                        } else if(index === 1) {
                            medalla = '<i class="fas fa-medal text-gray-300 text-lg md:text-xl mr-3 md:mr-4 w-6 text-center"></i>';
                            resplandor = 'border-gray-400 bg-gray-400/10 text-white';
                        } else if(index === 2) {
                            medalla = '<i class="fas fa-medal text-amber-600 text-lg md:text-xl mr-3 md:mr-4 w-6 text-center"></i>';
                            resplandor = 'border-amber-700 bg-amber-700/10 text-white';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-3 md:p-4 animate-pop mb-2 md:mb-3">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-bold uppercase tracking-wider text-sm md:text-lg truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[var(--iron-cyan)] font-marvel text-xl md:text-2xl leading-none">${jugador.puntaje_total} PTS</span>
                                    <span class="block text-[8px] md:text-[10px] text-stone-400 tracking-widest uppercase mt-1">${jugador.tiempo_empleado} SEG</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-500 font-bold text-center mt-10 text-xs md:text-base">ERROR EN LA RED.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-500 font-bold text-center mt-10 text-xs md:text-base">FALLO DE CONEXIÓN.</p>';
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
        div.className = "bg-black border border-white/10 p-4 md:p-5 space-y-3 md:space-y-4 relative animate-fade-in";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-white/10 pb-2">
                <span class="text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-stone-400">Refuerzo #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-[var(--marvel-red)] hover:text-white text-[8px] md:text-[10px] font-bold uppercase transition"><i class="fas fa-times"></i></button>
            </div>
            <input type="text" class="input-nombre-acompanante w-full border-b border-white/20 bg-transparent py-2 text-xs md:text-sm font-bold outline-none text-white uppercase placeholder-stone-600" placeholder="NOMBRE COMPLETO *" required>
            <input type="email" class="input-email-acompanante w-full border-b border-white/20 bg-transparent py-2 text-xs md:text-sm font-bold outline-none text-white placeholder-stone-600" placeholder="CORREO (OPCIONAL)">
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
        btnConfirmar.classList.add('opacity-70', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-cog fa-spin mr-2"></i> INICIANDO DEPLOY...';

        const nodosNombres = document.querySelectorAll('.input-nombre-acompanante');
        const nodosEmails = document.querySelectorAll('.input-email-acompanante');
        const listaAcompanantes = Array.from(nodosNombres).map((input, i) => ({ nombre: input.value.trim(), email: nodosEmails[i]?.value.trim() || '' })).filter(a => a.nombre !== "");
        const dataPayload = { token_acceso: document.getElementById('inputHiddenToken').value, nombre_invitado: document.getElementById('inputNombrePrincipal').value.trim(), email: document.getElementById('inputEmailPrincipal').value.trim(), acompanantes: listaAcompanantes };

        fetch('/invitacion/confirmar-asistencia', { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify(dataPayload) })
        .then(async response => {
            const data = await response.json();
            if (response.status === 422 && data.already_registered) {
                document.getElementById('cuerpoInternoModalAsistencia').innerHTML = `
                    <div class="py-6 md:py-8 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="marvel-logo-box text-xl md:text-3xl mb-2"><i class="fas fa-shield-alt"></i> ESTATUS CONFIRMADO</div>
                        <p class="text-xs md:text-sm font-light text-stone-400 px-2 md:px-4">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-marvel mt-6 md:mt-8 w-full text-base md:text-lg !py-3">CERRAR PANTALLA</button>
                    </div>
                `;
                throw new Error("already_handled");
            }
            if (!response.ok) throw new Error("Error en servidor.");
            return data;
        })
        .then(data => {
            if (data && data.success) {
                document.getElementById('cuerpoInternoModalAsistencia').innerHTML = `
                    <div class="py-2 md:py-4 text-center space-y-6 md:space-y-8 animate-fade-in">
                        <div class="marvel-logo-box text-xl md:text-3xl mb-1 md:mb-2">DEPLOY AUTORIZADO</div>
                        <p class="text-[10px] md:text-xs text-stone-400 font-light">Credenciales generadas. Guardar para protocolos de acceso.</p>
                        <div class="bg-black border border-white/10 p-4 md:p-5 text-left shadow-2xl">
                            <p class="text-[8px] md:text-[10px] uppercase font-bold tracking-widest text-[var(--marvel-red)] border-b border-white/10 pb-2 mb-3 md:mb-4">CÓDIGOS DE ACCESO</p>
                            <div class="space-y-3 md:space-y-4">
                                ${data.codigos.map(item => `
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-[10px] md:text-xs text-white uppercase truncate pr-2">${item.nombre}</span> 
                                        <span class="bg-white text-black px-2 md:px-3 py-1 font-marvel text-base md:text-lg tracking-widest shrink-0">${item.codigo}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-marvel w-full text-lg md:text-xl !py-3 md:!py-4">FINALIZAR</button>
                    </div>
                `;
                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="marvel-logo-box text-xl md:text-2xl py-3 md:py-4 w-full max-w-xs md:max-w-md shadow-lg mx-auto">ASISTENCIA CONFIRMADA</div>
                `;
            }
        }).catch(error => { 
            if (error.message !== "already_handled") {
                alert("Error en comunicación."); 
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA S.H.I.E.L.D (GALERÍA CLASIFICADA) ---
    // Reproducción en miniatura
    function playPreview(elemento) {
        const vid = elemento.querySelector('.vid-preview');
        if(vid) { vid.play().catch(e => console.log('Autoplay prevenido por navegador')); }
    }
    
    function pausePreview(elemento) {
        const vid = elemento.querySelector('.vid-preview');
        if(vid) { vid.pause(); }
    }

    // Modal Reproductor de Pantalla Completa
    function abrirReproductor(event, url) {
        event.stopPropagation(); // Evita que se seleccione el video al intentar verlo
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
            elemento.classList.replace('border-transparent', 'border-[var(--iron-cyan)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--iron-cyan)]', 'border-transparent');
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
        
        setTimeout(() => {
            document.body.removeChild(iframe);
        }, 15000);
    }

    function descargarSeleccionadas() {
        const seleccionadas = document.querySelectorAll('.foto-item.seleccionada');
        if (seleccionadas.length === 0) {
            alert("Agente, debe seleccionar al menos un archivo.");
            return;
        }
        seleccionadas.forEach((item, index) => {
            setTimeout(() => {
                forzarDescarga(item.dataset.url);
            }, index * 1000);
        });
        seleccionadas.forEach(item => toggleSeleccion(item));
    }

    function descargarTodas() {
        const todas = document.querySelectorAll('.foto-item');
        if (todas.length === 0) {
            alert("No hay archivos en la base de datos.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => {
                forzarDescarga(item.dataset.url);
            }, index * 1000);
        });
    }

</script>
</body>
</html>