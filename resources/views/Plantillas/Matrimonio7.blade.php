<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | UNITE</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto+Condensed:wght@400;700;900&family=Bangers&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --dc-blue: #0047AB; /* Azul Superman */
            --dc-red: #ED1D24; /* Rojo Flash/Superman */
            --dc-gold: #FDE12D; /* Dorado Wonder Woman / Batman */
            --dc-dark: #07090F; /* Noche de Gotham */
            --riddler-green: #00FF41; /* Verde Baticomputadora / Acertijo */
            --joker-purple: #4B0082; /* Morado Joker */
            --joker-green: #39FF14; /* Verde Tóxico Joker */
        }

        h1, h2, h3, .font-dc { font-family: 'Bebas Neue', sans-serif; letter-spacing: 2px; }
        .font-joker { font-family: 'Bangers', cursive; letter-spacing: 4px; }
        body { font-family: 'Roboto Condensed', sans-serif; background-color: var(--dc-dark); color: white; scroll-behavior: smooth; overflow-x: hidden; }

        .snap-container { height: 100vh; overflow-y: scroll; scroll-snap-type: y mandatory; overflow-x: hidden; }
        
        /* Ajuste de sección para evitar desbordamientos en móvil */
        .section-dc { min-height: 100vh; width: 100%; display: flex; justify-content: center; align-items: center; position: relative; scroll-snap-align: start; overflow: hidden; background-color: var(--dc-dark); border-bottom: 3px solid var(--dc-blue); padding: 2rem 1rem; }

        /* Textura oscura estilo cómic/malla de traje */
        .mesh-bg {
            background-image: 
                linear-gradient(45deg, rgba(255,255,255,0.02) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.02) 75%, rgba(255,255,255,0.02)), 
                linear-gradient(45deg, rgba(255,255,255,0.02) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.02) 75%, rgba(255,255,255,0.02));
            background-size: 20px 20px;
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
        }

        /* Lluvia de Gotham para Batman */
        .bat-rain {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="100"><line x1="10" y1="0" x2="0" y2="30" stroke="rgba(255,255,255,0.15)" stroke-width="1"/></svg>');
            animation: rainDrop 0.4s linear infinite;
            position: absolute; inset: 0; z-index: 1; pointer-events: none;
        }
        @keyframes rainDrop { from { background-position: 0 0; } to { background-position: -20px 100px; } }

        /* Textura Joker */
        .joker-bg {
            background-color: var(--joker-purple);
            background-image: repeating-linear-gradient(45deg, transparent, transparent 40px, rgba(57, 255, 20, 0.1) 40px, rgba(57, 255, 20, 0.1) 80px);
        }

        /* Badge estilo Justice League */
        .dc-badge {
            background-color: var(--dc-blue); color: white; padding: 4px 12px; font-family: 'Bebas Neue', sans-serif; text-transform: uppercase; letter-spacing: 2px; display: inline-block; border: 2px solid white; box-shadow: 4px 4px 0px rgba(0,0,0,0.5);
        }

        /* Botón Estilo DC - Ajuste responsivo del clip-path y font-size */
        .btn-dc {
            background: var(--dc-blue); color: white; padding: 12px 20px; font-size: 1.2rem; font-family: 'Bebas Neue', sans-serif; text-transform: uppercase; letter-spacing: 2px; transition: all 0.3s ease; position: relative; display: inline-block; cursor: pointer; border: 2px solid var(--dc-blue); box-shadow: 6px 6px 0px rgba(0,0,0,0.8); clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px); width: 100%; text-align: center;
        }
        @media (min-width: 768px) {
            .btn-dc { font-size: 1.5rem; padding: 12px 35px; clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px); letter-spacing: 3px; }
        }
        .btn-dc:hover { background: var(--dc-gold); color: black; border-color: var(--dc-gold); transform: translate(-2px, -2px); box-shadow: 8px 8px 0px rgba(0,0,0,1); }
        .btn-dc:disabled { opacity: 0.7; cursor: not-allowed; transform: none; box-shadow: 6px 6px 0px rgba(0,0,0,0.8); }

        /* Botón Estilo Joker - Ajustes responsivos */
        .btn-joker {
            background: var(--joker-green); color: var(--joker-purple); padding: 12px 20px; font-size: 1.4rem; font-family: 'Bangers', cursive; text-transform: uppercase; letter-spacing: 2px; transition: all 0.1s ease; border: 3px solid black; box-shadow: 6px 6px 0px black; cursor: pointer; transform: rotate(-2deg); width: 100%; text-align: center;
        }
        @media (min-width: 768px) {
            .btn-joker { font-size: 1.8rem; padding: 12px 35px; letter-spacing: 4px; border-width: 4px; box-shadow: 8px 8px 0px black; }
        }
        .btn-joker:hover { transform: scale(1.05) rotate(2deg); background: white; }
        .btn-joker:disabled { opacity: 0.7; cursor: not-allowed; transform: rotate(-2deg); }

        /* Baticomputadora HUD (Riddler) */
        .bat-hud { border: 2px solid var(--riddler-green); background-color: rgba(0, 20, 0, 0.95); position: relative; }
        .bat-hud::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0, 255, 65, 0.05) 2px, rgba(0, 255, 65, 0.05) 4px); pointer-events: none; }
        
        .animate-pop { animation: popIn 0.3s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        /* Ocultar Scrollbar para el Ranking */
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

    {{-- SECCIÓN 1: INICIO (SUPERMAN / JUSTICE LEAGUE) --}}
    <section class="section-dc !p-0">
        {{-- Símbolo de la Casa de El (Superman) al fondo --}}
        <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] md:w-[900px] md:h-[900px] opacity-10 pointer-events-none" viewBox="0 0 100 100">
            <polygon points="0,25 100,25 50,95" fill="var(--dc-red)"/>
            <polygon points="8,30 92,30 50,88" fill="var(--dc-gold)"/>
        </svg>

        <div class="mesh-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--dc-dark)] via-transparent to-transparent z-0"></div>
        
        <div class="z-10 text-center max-w-5xl px-4 flex flex-col items-center w-full">
            <div class="dc-badge text-xl md:text-3xl mb-6 md:mb-8 transform hover:scale-105 transition mt-8 md:mt-0">
                <i class="fas fa-shield-alt mr-2"></i> LIGA DE LA JUSTICIA
            </div>
            
            <h1 class="text-6xl sm:text-8xl md:text-[140px] leading-[0.9] mb-4 text-white font-dc uppercase tracking-widest drop-shadow-[0_5px_15px_rgba(0,71,171,0.6)] w-full break-words">
                {{ $evento->nombre_evento }}
            </h1>

            <div class="border-y-2 border-[var(--dc-gold)]/50 py-2 mb-8 md:mb-12 w-full max-w-lg mx-auto text-stone-300">
                <p class="text-sm md:text-xl font-bold uppercase tracking-[0.2em] md:tracking-[0.4em] text-[var(--dc-gold)]">EL DÍA DE LA ESPERANZA: <br class="block md:hidden"> {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d.m.Y') }}</p>
            </div>

            {{-- CONTADOR ÉPICO --}}
            <div id="countdown" class="flex gap-2 sm:gap-4 md:gap-8 bg-black/60 border-2 border-white/10 p-4 md:p-6 backdrop-blur-md shadow-[4px_4px_0px_rgba(0,0,0,0.8)] md:shadow-[8px_8px_0px_rgba(0,0,0,0.8)] w-[90%] md:w-auto mx-auto justify-center">
                <div class="text-center min-w-[50px] md:min-w-[60px]">
                    <span id="days" class="text-4xl md:text-7xl font-dc text-white drop-shadow-md">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-stone-400 mt-1">Días</span>
                </div>
                <div class="text-center border-l border-white/20 pl-2 sm:pl-4 md:pl-8 min-w-[50px] md:min-w-[60px]">
                    <span id="hours" class="text-4xl md:text-7xl font-dc text-white drop-shadow-md">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-stone-400 mt-1">Hrs</span>
                </div>
                <div class="text-center border-l border-white/20 pl-2 sm:pl-4 md:pl-8 min-w-[50px] md:min-w-[60px]">
                    <span id="minutes" class="text-4xl md:text-7xl font-dc text-white drop-shadow-md">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-stone-400 mt-1">Min</span>
                </div>
                <div class="text-center border-l border-[var(--dc-red)] pl-2 sm:pl-4 md:pl-8 text-[var(--dc-red)] min-w-[50px] md:min-w-[60px]">
                    <span id="seconds" class="text-4xl md:text-7xl font-dc">00</span>
                    <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-[var(--dc-red)] mt-1">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: ORÍGENES (BATMAN - GOTHAM CITY) --}}
    <section class="section-dc bg-[#020305]">
        {{-- BATI-SEÑAL EN EL FONDO --}}
        <svg class="absolute top-10 right-10 w-[300px] h-[300px] md:w-[500px] md:h-[500px] opacity-[0.15] animate-pulse" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="45" fill="#FDE12D"/>
            <path d="M20,50 Q30,30 40,45 L45,35 L47,20 L50,30 L53,20 L55,35 L60,45 Q70,30 80,50 Q65,80 50,65 Q35,80 20,50 Z" fill="#000"/>
        </svg>

        <div class="bat-rain"></div>
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center z-10 relative">
            <div class="relative border-2 md:border-4 border-stone-800 p-1 md:p-2 bg-black transform rotate-2 hover:rotate-0 transition duration-500 shadow-[5px_5px_0px_rgba(253,225,45,0.2)] md:shadow-[10px_10px_0px_rgba(253,225,45,0.2)] w-full max-w-[300px] md:max-w-none mx-auto order-2 md:order-1">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-[300px] md:h-[500px] object-cover grayscale hover:grayscale-0 transition duration-700 filter contrast-125">
                @endif
                <div class="absolute -bottom-4 -left-2 md:-left-4 bg-black text-[var(--dc-gold)] border-2 border-[var(--dc-gold)] px-2 md:px-4 py-1 font-dc text-lg md:text-2xl whitespace-nowrap">
                    ARCHIVOS DE GOTHAM
                </div>
            </div>
            
            <div class="space-y-4 md:space-y-6 bg-black/80 md:bg-black/60 p-6 md:p-8 border-l-4 border-[var(--dc-gold)] backdrop-blur-sm order-1 md:order-2">
                <h2 class="text-5xl md:text-8xl font-dc text-white tracking-wider">EL ORIGEN</h2>
                <div class="h-1 w-16 md:w-24 bg-[var(--dc-gold)]"></div>
                <p class="text-sm md:text-lg leading-relaxed text-stone-300 font-light italic">
                    "{{ $evento->biografia_resumen }}"
                </p>
                <div class="flex items-center gap-2 md:gap-3 text-stone-500 font-bold uppercase tracking-widest text-[10px] md:text-xs mt-4">
                    <i class="fas fa-bat"></i> Clasificado: Nivel Caballero Oscuro
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN (WONDER WOMAN - LAZO DE LA VERDAD) --}}
    <section class="section-dc overflow-hidden">
        {{-- LAZO DORADO BRILLANTE --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30">
            <div class="w-[400px] h-[150px] md:w-[800px] md:h-[300px] rounded-full border-[3px] md:border-[6px] border-[var(--dc-gold)] animate-[spin_10s_linear_infinite] shadow-[0_0_20px_var(--dc-gold)] md:shadow-[0_0_40px_var(--dc-gold)] transform rotate-45"></div>
            <div class="absolute w-[150px] h-[400px] md:w-[300px] md:h-[800px] rounded-full border-[1px] md:border-[2px] border-yellow-200 animate-[spin_8s_linear_infinite_reverse] shadow-[0_0_10px_white] md:shadow-[0_0_20px_white]"></div>
        </div>

        <div class="mesh-bg"></div>
        <div class="text-center z-10 px-4 md:px-6 w-[90%] max-w-4xl mx-auto bg-[#05070a]/80 p-8 md:p-12 backdrop-blur-md border-y-4 border-[var(--dc-gold)] shadow-2xl">
            <div class="text-[var(--dc-gold)] text-4xl md:text-6xl mb-4 md:mb-6"><i class="fas fa-star animate-pulse"></i></div>
            <h2 class="text-4xl sm:text-5xl md:text-7xl mb-4 md:mb-8 font-dc text-white tracking-widest drop-shadow-[0_0_10px_var(--dc-gold)] leading-tight">
                {{ $evento->ubicacion_texto }}
            </h2>
            
            <p class="text-stone-300 text-xs md:text-base mb-6 md:mb-10 font-bold tracking-[0.1em] md:tracking-[0.3em] uppercase">Coordenadas de Themyscira Confirmadas</p>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-dc !bg-[var(--dc-gold)] !text-black !border-[var(--dc-gold)] hover:!bg-white hover:!text-[var(--dc-dark)] max-w-xs">
                    ACTIVAR RADAR GPS <i class="fas fa-location-arrow ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES (THE RIDDLER Y THE JOKER) --}}
    <section class="section-dc bg-[#020202] !p-0 block md:flex md:flex-row h-auto md:h-screen overflow-y-auto md:overflow-hidden">
        {{-- En móvil se apilan, en escritorio se ponen lado a lado --}}
        
        {{-- BLOQUE TRIVIA (THE RIDDLER / BATICOMPUTADORA) --}}
        <div class="flex flex-col justify-center items-center bg-[#001100] border-b md:border-b-0 md:border-r border-[var(--riddler-green)]/30 group p-8 md:p-12 space-y-6 md:space-y-8 w-full md:w-1/2 min-h-[50vh] md:min-h-full relative overflow-hidden bat-hud">
            {{-- Signos de interrogación flotantes --}}
            <div class="absolute top-5 left-5 text-[var(--riddler-green)] opacity-10 text-6xl md:text-9xl font-bold rotate-12">?</div>
            <div class="absolute bottom-5 right-5 text-[var(--riddler-green)] opacity-10 text-6xl md:text-9xl font-bold -rotate-12">?</div>
            
            <div class="text-center z-10 w-full">
                <i class="fas fa-question text-4xl md:text-6xl text-[var(--riddler-green)] mb-4 md:mb-6 animate-pulse drop-shadow-[0_0_15px_rgba(0,255,65,1)]"></i>
                <h3 class="text-5xl md:text-8xl mb-2 font-dc text-[var(--riddler-green)] tracking-widest drop-shadow-[0_0_10px_rgba(0,255,65,0.5)]">EL ACERTIJO</h3>
                <p class="text-[10px] md:text-sm font-bold text-[var(--riddler-green)] uppercase tracking-[0.2em] md:tracking-[0.4em] mb-4 opacity-70">Desafío Intelectual</p>
            </div>
            <div id="wrapper-btn-trivia" class="w-full max-w-[250px] md:max-w-xs text-center z-10">
                @if($yaComenzo)
                    <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full py-3 md:py-4 border-2 border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-xl md:text-2xl tracking-widest hover:bg-[var(--riddler-green)] hover:text-black transition shadow-[0_0_15px_rgba(0,255,65,0.4)]">RESOLVER ENIGMA</button>
                    <button onclick="verRanking()" class="w-full py-2 md:py-3 mt-3 md:mt-4 bg-transparent border border-[var(--riddler-green)]/50 text-[var(--riddler-green)] font-dc text-lg md:text-xl tracking-widest hover:bg-[var(--riddler-green)] hover:text-black transition">VER RANKING</button>
                @else
                    <button id="btn-time-trivia" disabled class="w-full py-3 md:py-4 border-2 border-stone-800 text-stone-600 font-dc text-xl md:text-2xl tracking-widest cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i> ENCRIPTADO
                    </button>
                @endif
            </div>
        </div>

        {{-- BLOQUE MURO (THE JOKER) --}}
        <div class="flex flex-col justify-center items-center joker-bg group p-8 md:p-12 space-y-6 md:space-y-8 w-full md:w-1/2 min-h-[50vh] md:min-h-full relative overflow-hidden">
            <div class="absolute top-5 left-2 font-joker text-[var(--joker-green)] opacity-20 text-4xl md:text-6xl transform -rotate-12">HA HA HA</div>
            <div class="absolute bottom-10 right-2 font-joker text-[var(--joker-green)] opacity-20 text-5xl md:text-8xl transform rotate-12">HA HA HA</div>
            
            <div class="text-center z-10 bg-black/40 p-4 md:p-8 border-2 md:border-4 border-[var(--joker-green)] shadow-[5px_5px_0px_#000] md:shadow-[10px_10px_0px_#000] transform rotate-1 w-full max-w-[300px] md:max-w-none">
                <h3 class="text-5xl md:text-8xl mb-2 font-joker text-[var(--joker-green)] tracking-widest drop-shadow-[2px_2px_0px_#000] md:drop-shadow-[4px_4px_0px_#000]">LA LOCURA</h3>
                <p class="text-xs md:text-lg font-bold text-white uppercase tracking-wider md:tracking-widest mb-2 md:mb-4">Deja tu chiste o mensaje</p>
            </div>
            
            <div id="wrapper-btn-muro" class="w-full max-w-[250px] md:max-w-xs text-center flex flex-col gap-3 md:gap-4 z-10">
                @if($yaComenzo)
                    <button onclick="solicitarAccesoVerificacion('muro')" class="btn-joker w-full !text-xl md:!text-2xl">¡AÑADIR CAOS!</button>
                    <button onclick="mostrarMuroVisual()" class="w-full py-2 md:py-3 bg-black text-[var(--joker-green)] border-2 md:border-4 border-[var(--joker-green)] font-joker text-xl md:text-2xl tracking-widest hover:bg-[var(--joker-green)] hover:text-black transition mt-2 md:mt-4 transform rotate-1">VER EL MANICOMIO</button>
                @else
                    <button id="btn-time-muro" disabled class="w-full py-3 md:py-4 bg-stone-900 text-stone-600 font-dc text-lg md:text-xl tracking-widest cursor-not-allowed border border-stone-800">
                        <i class="fas fa-lock mr-2"></i> ASILO CERRADO
                    </button>
                @endif
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: MURO / ARCHIVOS (CAPA FLOTANTE JOKER) --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] joker-bg overflow-y-auto">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="font-joker text-[var(--joker-green)] opacity-10 text-[6rem] md:text-[10rem] absolute top-10 md:top-20 left-2 md:left-10 -rotate-12">HAHA</div>
            <div class="font-joker text-[var(--joker-green)] opacity-10 text-[8rem] md:text-[12rem] absolute bottom-20 md:bottom-40 right-2 md:right-10 rotate-12">HAHA</div>
        </div>

        <div class="relative max-w-7xl w-full mx-auto p-4 md:p-8 pt-16 md:pt-24 pb-16 z-10">
            <div class="text-center mb-10 md:mb-16 bg-black/60 border-2 md:border-4 border-[var(--joker-green)] p-4 md:p-8 shadow-[8px_8px_0px_#000] md:shadow-[15px_15px_0px_#000] transform -rotate-1 inline-block mx-auto max-w-[90%]">
                <h2 class="text-4xl sm:text-6xl md:text-9xl font-joker text-[var(--joker-green)] tracking-widest drop-shadow-[2px_2px_0px_#000] md:drop-shadow-[4px_4px_0px_#000]">EL MURO DEL CAOS</h2>
                <p class="font-bold text-white tracking-[0.1em] md:tracking-[0.3em] uppercase mt-2 font-dc text-lg md:text-2xl">Sonríe para la foto...</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 items-start w-full px-2">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="bg-[var(--joker-purple)] text-white p-4 md:p-6 flex flex-col relative shadow-[6px_6px_0px_#000] md:shadow-[10px_10px_0px_#000] border-2 md:border-4 border-[var(--joker-green)] transform hover:-translate-y-2 hover:rotate-2 transition duration-300 w-full">
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="border-2 md:border-4 border-black mb-4 bg-black transform -rotate-2">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" 
                                     class="w-full h-40 md:h-48 object-cover filter contrast-150 saturate-150">
                            </div>
                        @endif
                        <div class="flex-grow bg-white text-black p-3 md:p-4 border border-black transform rotate-1 overflow-hidden">
                            <h4 class="font-joker text-2xl md:text-3xl mb-2 leading-none text-[var(--joker-purple)] break-words">"{{ Str::limit($item->contenido_texto, 25, '') }}..."</h4>
                            <p class="font-bold text-xs md:text-sm mb-2 md:mb-4 italic break-words">
                                "{{ $item->contenido_texto }}"
                            </p>
                        </div>
                        <div class="mt-3 md:mt-4 pt-2 text-right">
                            <span class="text-[10px] md:text-[12px] font-bold text-[var(--joker-green)] tracking-wider md:tracking-widest uppercase font-dc">Loco: {{ $item->nombre_autor }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border-2 md:border-4 border-[var(--joker-green)] p-8 md:p-16 text-center bg-black/80 shadow-[5px_5px_0px_#000] md:shadow-[10px_10px_0px_#000] mx-4">
                        <p class="text-3xl md:text-5xl font-joker text-[var(--joker-green)] tracking-widest">¿Por qué tan serios? Aún no hay mensajes.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12 md:mt-20 mb-10 px-4 flex justify-center">
                <button onclick="ocultarMuroVisual()" class="btn-joker w-full max-w-xs text-xl md:text-2xl">
                    <i class="fas fa-times mr-2"></i> ESCAPAR 
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: EVIDENCIA VISUAL UNIFICADA (TIEMPO REAL CLOUD ONEDRIVE) --}}
    <section class="section-dc bg-[#04060b] !h-auto py-20 min-h-[60vh]">
        <div class="mesh-bg"></div>
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-20 mx-auto">
            
            <div class="text-center mb-8">
                <div class="dc-badge text-sm md:text-xl mb-3 shadow-[0_0_15px_rgba(0,71,171,0.4)]">BASE DE DATOS SECRETA</div>
                <h2 class="text-4xl sm:text-5xl md:text-7xl font-dc uppercase text-white tracking-widest drop-shadow-md">METRAJE DE LA ATALAYA</h2>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-6 bg-black/80 p-4 md:p-6 border-2 border-[var(--dc-blue)] shadow-[0_0_20px_rgba(0,71,171,0.2)] gap-4">
                <span id="contador-seleccionadas" class="font-dc text-2xl text-[var(--dc-gold)] tracking-widest animate-pulse">
                    0 EXPEDIENTES SELECCIONADOS
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-xs font-bold border-2 border-[var(--dc-gold)] text-[var(--dc-gold)] px-6 py-3 hover:bg-[var(--dc-gold)] hover:text-black transition uppercase tracking-wider w-full md:w-auto">
                        <i class="fas fa-download mr-2"></i> Extraer Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-dc !w-full md:!w-auto text-sm !py-3">
                        <i class="fas fa-cloud-download-alt mr-2"></i> Extraer Todo
                    </button>
                </div>
            </div>

            @php
                $galeriaUnificada = collect();

                // Cargamos las fotos de OneDrive en tiempo real (Leídas desde la subcarpeta "Fotos")
                if(isset($fotosNubeRealtime)) {
                    foreach($fotosNubeRealtime as $fotoCloud) {
                        $galeriaUnificada->push([
                            'url' => $fotoCloud['url'],
                            'esVideo' => $fotoCloud['esVideo'] ?? false,
                            'etiqueta' => $fotoCloud['etiqueta']
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full max-h-[60vh] overflow-y-auto hide-scroll p-2">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer border-2 border-stone-800 hover:border-[var(--dc-blue)] transition overflow-hidden bg-black flex items-center justify-center shadow-lg" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/20 hover:bg-black/10 transition">
                                <i class="fas fa-play-circle text-5xl text-white/80 group-hover:text-[var(--dc-gold)] group-hover:scale-110 transition drop-shadow-[0_0_15px_rgba(0,0,0,0.9)]"></i>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover opacity-70" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover filter contrast-110">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[var(--dc-blue)]/20 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-2 right-2 bg-black text-[var(--dc-gold)] rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 border-2 border-[var(--dc-gold)] shadow-[0_0_10px_var(--dc-gold)] z-30 pointer-events-none">
                            <i class="fas fa-check text-xs"></i>
                        </div>

                        <div class="absolute bottom-2 left-2 right-2 bg-black/90 text-white text-[8px] md:text-[10px] px-2 py-1 font-dc tracking-widest border border-[var(--dc-blue)]/50 truncate text-center z-30 pointer-events-none flex items-center justify-center">
                            @if($foto['esVideo'])
                                <i class="fas fa-video text-purple-400 mr-2"></i>
                            @else
                                <i class="fas fa-cloud text-[var(--dc-blue)] mr-2"></i>
                            @endif
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border-2 border-dashed border-stone-800 p-10 bg-black/40">
                        <p class="text-stone-500 font-dc text-2xl tracking-widest">SISTEMA AUXILIAR: RECUERDOS COMPROMETIDOS EN LA NUBE</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP (THE FLASH) --}}
    <section class="section-dc bg-[var(--dc-red)] relative">
        {{-- RAYOS DE THE FLASH EN EL FONDO --}}
        <svg class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
            <polygon points="60,0 30,50 50,50 40,100 70,50 50,50" fill="var(--dc-gold)"/>
            <polygon points="20,0 0,40 15,40 5,100 30,45 15,45" fill="var(--dc-gold)"/>
        </svg>

        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 z-10 w-full max-w-3xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <div class="text-[var(--dc-gold)] text-6xl md:text-8xl mb-4 md:mb-6 drop-shadow-[4px_4px_0px_#000]">
                    <i class="fas fa-bolt"></i>
                </div>
                <h2 class="text-6xl sm:text-7xl md:text-[140px] mb-4 md:mb-6 font-dc uppercase leading-none drop-shadow-[4px_4px_0px_#000] md:drop-shadow-[6px_6px_0px_#000] text-white">ÚNETE A LA LIGA</h2>
                <p class="text-sm md:text-xl text-white font-bold mb-8 md:mb-12 tracking-widest md:tracking-[0.3em] uppercase bg-black inline-block px-4 py-2 border-2 border-[var(--dc-gold)] mx-auto">No llegues tarde. Confirma rápido.</p>
                
                <div id="contenedorBotonPrincipalRSVP" class="w-full flex justify-center">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-dc !bg-[var(--dc-gold)] !text-black !border-black shadow-[6px_6px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] text-xl sm:text-2xl md:text-3xl px-8 md:px-12 py-3 md:py-4 hover:!bg-white w-full max-w-xs md:max-w-md mx-auto">
                            CONFIRMAR ESTATUS
                        </button>
                    @else
                        <div class="px-4 md:px-8 py-3 md:py-4 border-2 md:border-4 border-black text-black bg-[var(--dc-gold)] font-dc text-xl md:text-3xl uppercase tracking-wider md:tracking-widest shadow-[4px_4px_0px_rgba(0,0,0,1)] md:shadow-[8px_8px_0px_rgba(0,0,0,1)] max-w-xs md:max-w-md mx-auto">
                            ACREDITACIÓN DE HÉROE REQUERIDA
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-col items-center gap-4 mt-12 md:mt-16 w-full px-2">
                    <div class="bg-black px-4 md:px-8 py-2 md:py-3 border-2 border-[var(--dc-gold)] text-white text-sm md:text-lg font-dc uppercase tracking-wider md:tracking-[0.3em] shadow-[2px_2px_0px_rgba(0,0,0,1)] md:shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                        SECTOR ASIGNADO: <span class="text-[var(--dc-gold)]">{{ $invitado->mesa_asignada ?? 'PENDIENTE' }}</span>
                    </div>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-white/50 mb-1.5 font-bold">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        <i class="fas fa-glass-cheers text-[11px] md:text-xs text-white/50 group-hover:text-[var(--dc-gold)] transition-colors"></i>
                        <span class="font-dc text-sm md:text-xl tracking-widest text-white/80 group-hover:text-[var(--dc-gold)] transition-colors">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>
    
</div>

{{-- MODAL GLOBAL DE FILTRO Y CUESTIONARIO (WAYNE ENTERPRISES / BATCOMPUTER) --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div id="wrapper-dinamico-modal" class="bg-[#020305] border-2 md:border-4 border-stone-700 w-full max-w-xl p-6 md:p-8 text-center shadow-[0_0_20px_rgba(255,255,255,0.1)] md:shadow-[0_0_50px_rgba(255,255,255,0.1)] relative overflow-hidden max-h-[95vh] overflow-y-auto">
        
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b-2 border-stone-800 pb-4">
                <h3 class="text-xl md:text-3xl font-dc text-white uppercase tracking-widest"><i class="fas fa-id-badge text-stone-500 mr-2"></i> WAYNE ENTERPRISES</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
            </div>
            <div class="space-y-4 md:space-y-6 text-left">
                <p class="text-xs md:text-sm font-bold text-stone-400 uppercase tracking-wider md:tracking-widest">Ingresa tu código de Metahumano para acceder a la red segura.</p>
                <div>
                    <input type="text" id="inputCodigoIngreso" placeholder="EJ: WAYNE-01" class="w-full border-2 border-stone-700 bg-black p-3 md:p-4 text-xl md:text-2xl font-dc tracking-widest outline-none uppercase text-white focus:border-white transition text-center shadow-inner">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="w-full bg-white text-black font-dc text-xl md:text-2xl py-3 md:py-4 hover:bg-stone-300 transition uppercase tracking-widest">
                    INICIAR ENLACE SEGURO
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO: MURO DE DESEOS (JOKER STYLE) --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div class="bg-[var(--joker-purple)] text-white border-2 md:border-4 border-[var(--joker-green)] w-full max-w-md p-6 md:p-8 text-left shadow-[6px_6px_0px_#000] md:shadow-[12px_12px_0px_#000] relative overflow-y-auto max-h-[95vh] transform md:rotate-1">
        
        <div class="flex justify-between items-center mb-6 md:mb-8 border-b-2 md:border-b-4 border-black pb-4">
            <h3 class="text-2xl md:text-4xl font-joker text-[var(--joker-green)] uppercase tracking-widest drop-shadow-[1px_1px_0px_#000] md:drop-shadow-[2px_2px_0px_#000]"><i class="fas fa-mask"></i> AÑADIR LOCURA</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-white hover:text-[var(--joker-green)] transition"><i class="fas fa-times text-2xl md:text-3xl drop-shadow-[1px_1px_0px_#000]"></i></button>
        </div>
        
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            
            <div>
                <label class="block text-[10px] md:text-[12px] font-joker tracking-widest text-white mb-1 drop-shadow-[1px_1px_0px_#000]">Nombre del Cómplice</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border-2 md:border-4 border-black bg-black p-2 md:p-3 text-sm font-bold outline-none text-[var(--joker-green)] uppercase">
            </div>
             <div>
                <label class="block text-[10px] md:text-[12px] font-joker tracking-widest text-white mb-1 drop-shadow-[1px_1px_0px_#000]">Banda Criminal *</label>
                <select name="vinculo_autor" required class="w-full border-2 md:border-4 border-black bg-white p-2 md:p-3 text-sm font-bold outline-none text-black cursor-pointer uppercase">
                    <option value="" disabled selected>Seleccionar...</option>
                    <option value="Familiar">Familia</option>
                    <option value="Amigo/a">Aliado / Amigo</option>
                    <option value="Compañero">Liga de Trabajo</option>
                    <option value="Conocido/a">Civil</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] md:text-[12px] font-joker tracking-widest text-white mb-1 drop-shadow-[1px_1px_0px_#000]">El Chiste *</label>
                <textarea name="contenido" rows="3" required class="w-full border-2 md:border-4 border-black bg-white p-2 md:p-3 text-sm font-bold outline-none focus:bg-[var(--joker-green)] text-black resize-none" placeholder="HAHAHAHA..."></textarea>
            </div>

            <div>
                <label class="block text-[10px] md:text-[12px] font-joker tracking-widest text-white mb-1 drop-shadow-[1px_1px_0px_#000]">Foto (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" class="w-full text-[10px] md:text-xs text-white border-2 md:border-4 border-black p-2 font-bold cursor-pointer bg-black">
            </div>

            <button type="submit" id="btnPublicarMuroBoda" class="btn-joker w-full mt-2 md:mt-4 !block !text-xl md:!text-2xl !py-3">
                SOLTAR GAS RISA
            </button>
        </form>
    </div>
</div>

{{-- MODAL ASISTENCIA (JUSTICE LEAGUE) --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4">
    <div class="bg-[var(--dc-dark)] border-2 md:border-4 border-[var(--dc-blue)] max-w-md w-full p-6 md:p-8 text-center shadow-[5px_5px_0px_rgba(0,71,171,0.5)] md:shadow-[10px_10px_0px_rgba(0,71,171,0.5)] max-h-[95vh] overflow-y-auto relative">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b-2 border-white/20 pb-4">
                <h3 class="text-2xl md:text-4xl font-dc text-[var(--dc-blue)] uppercase tracking-wider md:tracking-widest drop-shadow-md text-left">LLAMADO ACCIÓN</h3>
                <button onclick="cerrarModalAsistencia()" class="text-white/50 hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-4 md:space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/50 border-2 border-[var(--dc-blue)] p-4 md:p-5 space-y-3 md:space-y-4 shadow-inner">
                    <span class="text-[10px] md:text-[12px] font-dc uppercase tracking-widest text-[var(--dc-gold)] block mb-1 md:mb-2"><i class="fas fa-bolt mr-1"></i> Miembro Fundador</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="NOMBRE DE HÉROE *" required class="w-full border-b-2 border-white/30 bg-transparent py-2 text-xs md:text-sm font-bold outline-none focus:border-[var(--dc-gold)] text-white uppercase placeholder-stone-500">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" placeholder="CORREO ELECTRÓNICO" class="w-full border-b-2 border-white/30 bg-transparent py-2 text-xs md:text-sm font-bold outline-none focus:border-[var(--dc-gold)] text-white placeholder-stone-500">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-3 md:space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2 md:py-3 bg-black border-2 border-dashed border-[var(--dc-blue)] text-white font-dc text-lg md:text-xl uppercase tracking-wider md:tracking-widest hover:bg-[var(--dc-blue)] hover:border-solid transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> AGREGAR SIDEKICK
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-dc w-full text-2xl md:text-3xl !py-3 md:!py-4 mt-4 md:mt-6 block text-center">
                    CONFIRMAR UNIÓN
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA (THE RIDDLER LEADERBOARD) --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="bat-hud w-full max-w-2xl p-6 md:p-8 text-center shadow-[0_0_20px_rgba(0,255,65,0.4)] md:shadow-[0_0_50px_rgba(0,255,65,0.4)] relative max-h-[95vh] flex flex-col">
        
        <div class="flex justify-between items-center mb-4 md:mb-6 border-b-2 border-[var(--riddler-green)]/30 pb-4 shrink-0 text-left">
            <h3 class="text-2xl md:text-3xl font-dc text-[var(--riddler-green)] uppercase tracking-wider md:tracking-widest drop-shadow-[0_0_5px_var(--riddler-green)] md:drop-shadow-[0_0_10px_var(--riddler-green)]">
                <i class="fas fa-trophy mr-2"></i> POSICIONES
            </h3>
            <button onclick="cerrarModalRanking()" class="text-[var(--riddler-green)] hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-2 space-y-2 md:space-y-3 flex-grow text-left hide-scroll" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--riddler-green)]"></i>
            </div>
        </div>

        <div class="mt-4 md:mt-6 pt-4 border-t-2 border-[var(--riddler-green)]/30 shrink-0">
            <button onclick="cerrarModalRanking()" class="w-full py-3 md:py-4 border-2 border-[var(--riddler-green)] text-black bg-[var(--riddler-green)] font-dc text-xl md:text-2xl tracking-widest hover:bg-transparent hover:text-[var(--riddler-green)] transition shadow-[0_0_10px_rgba(0,255,65,0.4)] md:shadow-[0_0_15px_rgba(0,255,65,0.4)]">
                SALIR DE LA RED
            </button>
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
        const horaEvento = "{{ $evento->hora ?? '18:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<div class='dc-badge text-xl md:text-3xl shadow-lg !bg-[var(--dc-gold)] !text-black !border-black'>LA LIGA ESTÁ REUNIDA</div>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `<button onclick="solicitarAccesoVerificacion('trivia')" class="w-full py-3 md:py-4 border-2 border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-xl md:text-2xl tracking-widest hover:bg-[var(--riddler-green)] hover:text-black transition shadow-[0_0_10px_rgba(0,255,65,0.4)]">RESOLVER ENIGMA</button>`;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="btn-joker w-full !text-xl md:!text-2xl">¡AÑADIR CAOS!</button>
                        <button onclick="mostrarMuroVisual()" class="w-full py-2 md:py-3 bg-black text-[var(--joker-green)] border-2 md:border-4 border-[var(--joker-green)] font-joker text-xl md:text-2xl tracking-widest hover:bg-[var(--joker-green)] hover:text-black transition mt-3 md:mt-4 transform rotate-1">VER MANICOMIO</button>
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
        document.getElementById('wrapper-dinamico-modal').className = "bg-[#020305] border-2 md:border-4 border-stone-700 w-full max-w-xl p-6 md:p-8 text-center shadow-[0_0_20px_rgba(255,255,255,0.1)] md:shadow-[0_0_50px_rgba(255,255,255,0.1)] relative overflow-hidden max-h-[95vh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 md:mb-8 border-b-2 border-stone-800 pb-4">
                    <h3 class="text-xl md:text-3xl font-dc text-white uppercase tracking-widest"><i class="fas fa-id-badge text-stone-500 mr-2"></i> WAYNE ENTERPRISES</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
                </div>
                <div class="space-y-4 md:space-y-6 text-left">
                    <p class="text-xs md:text-sm font-bold text-stone-400 uppercase tracking-wider md:tracking-widest">Ingresa tu código de Metahumano para acceder a la red segura.</p>
                    <div>
                        <input type="text" id="inputCodigoIngreso" placeholder="EJ: WAYNE-01" class="w-full border-2 border-stone-700 bg-black p-3 md:p-4 text-xl md:text-2xl font-dc tracking-widest outline-none uppercase text-white focus:border-white transition text-center shadow-inner">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="w-full bg-white text-black font-dc text-xl md:text-2xl py-3 md:py-4 hover:bg-stone-300 transition uppercase tracking-widest">
                        INICIAR ENLACE SEGURO
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
        
        // Animación de carga para el botón de verificar código
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-70', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> DESENCRIPTANDO...';

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
                    wrapper.className = "bat-hud w-full max-w-xl p-6 md:p-8 text-center shadow-[0_0_30px_rgba(0,255,65,0.4)]";
                    wrapper.innerHTML = `
                        <div class="py-6 md:py-8 text-center space-y-4 md:space-y-6 animate-pop">
                            <i class="fas fa-lock text-5xl md:text-6xl text-[var(--riddler-green)] mb-2 md:mb-4 drop-shadow-[0_0_10px_var(--riddler-green)]"></i>
                            <h3 class="text-2xl md:text-4xl font-dc text-[var(--riddler-green)] tracking-widest">ENIGMA RESUELTO</h3>
                            <p class="text-xs md:text-sm font-bold text-[var(--riddler-green)]/80 uppercase px-2 md:px-4">${data.message}</p>
                            <div class="pt-4 md:pt-6">
                                <button onclick="cerrarModalFiltro()" class="px-6 md:px-8 py-2 md:py-3 border border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-lg md:text-xl hover:bg-[var(--riddler-green)] hover:text-black transition">CERRAR TERMINAL</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Héroe" };
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Héroe" ? data.nombre_invitado : "Cómplice";
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => { 
            if (err.message !== "already_handled") {
                console.error("Fallo:", err); 
            }
            // Restaurar botón en caso de error
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
        
        // Animación de carga para enviar el muro del Joker
        botonPublicar.disabled = true;
        botonPublicar.classList.add('opacity-50', 'cursor-not-allowed');
        botonPublicar.innerHTML = `<i class="fas fa-circle-notch fa-spin mr-2"></i> COCINANDO BROMA...`;

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
                alert(data.message || "La broma falló.");
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-50', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Validation fail");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const modalInterior = document.getElementById('modalMuroBoda').firstElementChild;
                modalInterior.innerHTML = `
                    <div class="py-8 md:py-10 text-center space-y-4 md:space-y-6 animate-pop text-white">
                        <h3 class="text-4xl md:text-6xl font-joker text-[var(--joker-green)] tracking-widest drop-shadow-[2px_2px_0px_#000]">¡HAHAHA!</h3>
                        <p class="text-sm md:text-xl font-bold px-2 md:px-4 font-dc">${data.message}</p>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="btn-joker w-full mt-6 md:mt-8 !text-xl md:!text-2xl !py-3">VOLVER A SOMBRAS</button>
                    </div>
                `;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.className = "bat-hud w-full max-w-xl p-6 md:p-8 text-center shadow-[0_0_30px_rgba(0,255,65,0.4)]";
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 md:space-y-8 animate-pop">
                <i class="fas fa-question text-[var(--riddler-green)] text-5xl md:text-7xl animate-pulse drop-shadow-[0_0_10px_var(--riddler-green)]"></i>
                <div class="text-xl md:text-3xl font-dc text-[var(--riddler-green)] tracking-[0.2em] md:tracking-[0.3em] uppercase">SISTEMA ENCRIPTADO</div>
                <h1 class="text-3xl md:text-5xl font-dc text-white uppercase">OBJETIVO: ${datosInvitadoValidado.nombre.toUpperCase()}</h1>
                <p class="text-[var(--riddler-green)] text-xs md:text-sm font-bold tracking-wider md:tracking-widest leading-relaxed px-2 md:px-4">He preparado <strong class="text-white text-base md:text-lg">${bancoPreguntas.length} acertijos</strong>. El tiempo corre. ¿Aceptas el reto o huyes?</p>
                <button onclick="comenzarJuegoModal()" class="w-full py-3 md:py-4 border-2 border-[var(--riddler-green)] text-black bg-[var(--riddler-green)] font-dc text-2xl md:text-3xl tracking-widest hover:bg-transparent hover:text-[var(--riddler-green)] transition">RESOLVER AHORA</button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-4 md:space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-[10px] md:text-sm font-bold uppercase tracking-wider md:tracking-[0.3em] text-[var(--riddler-green)] border-b-2 border-[var(--riddler-green)]/30 pb-3 md:pb-4">
                    <span id="info-progreso">ENIGMA 1 DE X</span>
                    <span><i class="fas fa-stopwatch mr-1"></i> <span id="info-cronometro" class="font-mono text-white text-base md:text-lg">0</span> s</span>
                </div>
                <h2 id="texto-pregunta" class="text-xl sm:text-2xl md:text-3xl font-dc text-white uppercase tracking-wider leading-snug">Cargando enigma...</h2>
                <div class="space-y-2 md:space-y-3 pt-2 md:pt-4">
                    <button onclick="seleccionarOpcionModal('a')" id="btn-opcion-a" class="w-full text-left p-3 md:p-4 border-2 border-[var(--riddler-green)]/30 bg-black hover:bg-[var(--riddler-green)]/20 hover:border-[var(--riddler-green)] transition flex items-center space-x-3 md:space-x-4 text-[var(--riddler-green)]">
                        <span class="w-6 h-6 md:w-8 md:h-8 border border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-lg md:text-xl flex items-center justify-center shrink-0">A</span>
                        <span id="texto-opcion-a" class="font-bold tracking-wider md:tracking-widest text-white text-xs md:text-sm break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" id="btn-opcion-b" class="w-full text-left p-3 md:p-4 border-2 border-[var(--riddler-green)]/30 bg-black hover:bg-[var(--riddler-green)]/20 hover:border-[var(--riddler-green)] transition flex items-center space-x-3 md:space-x-4 text-[var(--riddler-green)]">
                        <span class="w-6 h-6 md:w-8 md:h-8 border border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-lg md:text-xl flex items-center justify-center shrink-0">B</span>
                        <span id="texto-opcion-b" class="font-bold tracking-wider md:tracking-widest text-white text-xs md:text-sm break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" id="btn-opcion-c" class="w-full text-left p-3 md:p-4 border-2 border-[var(--riddler-green)]/30 bg-black hover:bg-[var(--riddler-green)]/20 hover:border-[var(--riddler-green)] transition flex items-center space-x-3 md:space-x-4 text-[var(--riddler-green)]">
                        <span class="w-6 h-6 md:w-8 md:h-8 border border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-lg md:text-xl flex items-center justify-center shrink-0">C</span>
                        <span id="texto-opcion-c" class="font-bold tracking-wider md:tracking-widest text-white text-xs md:text-sm break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" id="btn-opcion-d" class="w-full text-left p-3 md:p-4 border-2 border-[var(--riddler-green)]/30 bg-black hover:bg-[var(--riddler-green)]/20 hover:border-[var(--riddler-green)] transition flex items-center space-x-3 md:space-x-4 text-[var(--riddler-green)]">
                        <span class="w-6 h-6 md:w-8 md:h-8 border border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-lg md:text-xl flex items-center justify-center shrink-0">D</span>
                        <span id="texto-opcion-d" class="font-bold tracking-wider md:tracking-widest text-white text-xs md:text-sm break-words">Opción D</span>
                    </button>
                </div>
            </div>
        `;
        tiempoInicio = Date.now();
        intervaloCronometro = setInterval(() => {
            segundosTranscurridos = Math.floor((Date.now() - tiempoInicio) / 1000);
            const crono = document.getElementById('info-cronometro');
            if(crono) crono.innerText = segundosTranscurridos;
        }, 1000);
        renderizarPreguntaModal();
    }

    function renderizarPreguntaModal() {
        if(bancoPreguntas.length === 0) {
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-[var(--riddler-green)] font-dc uppercase text-lg">Sin datos en el servidor.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `ENIGMA ${preguntaActualIndex + 1} DE ${bancoPreguntas.length}`;
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
                <i class="fas fa-lock fa-bounce text-5xl md:text-6xl text-[var(--riddler-green)]"></i>
                <h3 class="text-2xl md:text-3xl font-dc text-[var(--riddler-green)] uppercase tracking-widest">DESENCRIPTANDO...</h3>
            </div>
        `;
        const payload = {
            evento_id: "{{ $evento->evento_id }}", invitado_id: datosInvitadoValidado.id, nombre_jugador: datosInvitadoValidado.nombre, puntaje: puntajeAcumulado, tiempo_segundos: segundosTranscurridos
        };
        fetch('/invitacion/registrar-participacion-trivia', {
            method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') }, body: JSON.stringify(payload)
        }).then(res => res.json()).then(data => {
            if (data && data.success) {
                wrapper.innerHTML = `
                    <div class="text-center space-y-6 md:space-y-8 py-2 md:py-4 animate-pop">
                        <i class="fas fa-check-square text-5xl md:text-6xl text-[var(--riddler-green)] mb-1 md:mb-2 drop-shadow-[0_0_10px_var(--riddler-green)]"></i>
                        <h3 class="text-3xl sm:text-4xl md:text-5xl font-dc text-white uppercase tracking-widest">ENIGMA RESUELTO</h3>
                        <p class="text-[10px] md:text-sm font-bold text-[var(--riddler-green)] tracking-wider md:tracking-[0.2em] uppercase">Puntuación inyectada en la base de datos.</p>
                        <div class="flex justify-center gap-3 md:gap-6 mt-4 md:mt-6">
                            <div class="text-center border-2 border-[var(--riddler-green)] p-3 md:p-4 bg-black w-24 md:w-32">
                                <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-1">SCORE</span>
                                <span class="text-2xl md:text-4xl font-dc text-[var(--riddler-green)]">${puntajeAcumulado}</span>
                            </div>
                            <div class="text-center border-2 border-[var(--riddler-green)] p-3 md:p-4 bg-black w-24 md:w-32">
                                <span class="block text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-stone-500 mb-1">TIME</span>
                                <span class="text-2xl md:text-4xl font-dc text-[var(--riddler-green)]">${segundosTranscurridos}s</span>
                            </div>
                        </div>
                        <button onclick="cerrarModalFiltro()" class="w-full py-3 md:py-4 border-2 border-[var(--riddler-green)] text-[var(--riddler-green)] font-dc text-xl md:text-2xl tracking-widest hover:bg-[var(--riddler-green)] hover:text-black transition mt-6 md:mt-8">CERRAR TERMINAL</button>
                    </div>
                `;
            }
        }).catch(err => { wrapper.innerHTML = `<p class="text-red-500 font-bold uppercase">Error de red.</p>`; });
    }

    let contadorAcompanantes = 0;
    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-black/50 border border-white/20 p-4 md:p-5 space-y-3 md:space-y-4 shadow-inner relative animate-fade-in";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-[var(--dc-gold)]/30 pb-2">
                <span class="text-[8px] md:text-[10px] font-bold uppercase tracking-widest text-white">Sidekick #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-[var(--dc-red)] hover:text-white text-[8px] md:text-[10px] font-bold uppercase transition"><i class="fas fa-times"></i></button>
            </div>
            <input type="text" class="input-nombre-acompanante w-full border-b-2 border-white/30 bg-transparent py-2 text-xs md:text-sm font-bold outline-none focus:border-[var(--dc-gold)] text-white uppercase placeholder-stone-400" placeholder="NOMBRE DE HÉROE *" required>
            <input type="email" class="input-email-acompanante w-full border-b-2 border-white/30 bg-transparent py-2 text-xs md:text-sm font-bold outline-none focus:border-[var(--dc-gold)] text-white placeholder-stone-400" placeholder="CORREO (OPCIONAL)">
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
        
        // Animación de carga en el botón de confirmar RSVP
        btnConfirmar.disabled = true;
        btnConfirmar.classList.add('opacity-70', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-cog fa-spin mr-2"></i> REGISTRANDO EN LA ATALAYA...';

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
                        <div class="dc-badge text-2xl md:text-3xl mb-2"><i class="fas fa-shield-alt"></i> ESTATUS CONFIRMADO</div>
                        <p class="text-xs md:text-sm font-light text-stone-300 px-2 md:px-4">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-dc mt-6 md:mt-8 w-full !text-xl md:!text-2xl">CERRAR PANTALLA</button>
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
                    <div class="py-4 text-center space-y-6 md:space-y-8 animate-fade-in">
                        <h3 class="text-3xl md:text-5xl font-dc text-[var(--dc-gold)] uppercase tracking-widest drop-shadow-md">ACCESO CONCEDIDO</h3>
                        <p class="text-[10px] md:text-xs text-stone-300 font-bold tracking-wider md:tracking-[0.2em] uppercase">Credenciales de la Atalaya generadas.</p>
                        <div class="bg-black border-2 border-[var(--dc-blue)] p-4 md:p-5 text-left shadow-2xl">
                            <p class="text-[8px] md:text-[10px] uppercase font-bold tracking-widest text-white border-b-2 border-[var(--dc-blue)] pb-2 mb-3 md:mb-4">CÓDIGOS DE ACCESO</p>
                            <div class="space-y-3 md:space-y-4">
                                ${data.codigos.map(item => `
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-[10px] md:text-xs text-stone-400 uppercase tracking-wider md:tracking-widest">${item.nombre}</span> 
                                        <span class="bg-[var(--dc-gold)] text-black px-2 md:px-3 py-1 font-dc text-lg md:text-xl tracking-widest border border-black">${item.codigo}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-dc w-full text-xl md:text-2xl !py-3 md:!py-4">FINALIZAR</button>
                    </div>
                `;
                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-4 md:px-8 py-3 md:py-4 border-2 md:border-4 border-black text-[var(--dc-gold)] bg-black font-dc text-2xl md:text-3xl uppercase tracking-wider md:tracking-widest shadow-[4px_4px_0px_#000] md:shadow-[6px_6px_0px_#000] w-full max-w-xs md:max-w-md mx-auto">
                        ASISTENCIA CONFIRMADA
                    </div>
                `;
            }
        }).catch(error => { 
            if (error.message !== "already_handled") {
                alert("Error en comunicación."); 
            }
            // Restaurar botón en caso de error
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- LÓGICA DEL RANKING ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-circle-notch fa-spin text-4xl text-[var(--riddler-green)]"></i></div>';

        // Llama a tu servidor para traer los puntajes
        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-[var(--riddler-green)] text-center font-dc text-lg md:text-xl mt-10">NO HAY REGISTROS AÚN. SÉ EL PRIMERO.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-lg md:text-xl text-stone-500 font-dc mr-3 md:mr-4 w-6 text-center">#${index + 1}</span>`;
                        let resplandor = '';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-trophy text-[var(--dc-gold)] text-2xl md:text-3xl mr-3 md:mr-4 drop-shadow-[0_0_10px_var(--dc-gold)] w-6 text-center"></i>';
                            resplandor = 'border-[var(--dc-gold)] shadow-[0_0_10px_rgba(253,225,45,0.3)] md:shadow-[0_0_15px_rgba(253,225,45,0.3)] bg-[var(--dc-gold)]/10 text-[var(--dc-gold)]';
                        } else if(index === 1) {
                            medalla = '<i class="fas fa-medal text-gray-300 text-xl md:text-2xl mr-3 md:mr-4 w-6 text-center"></i>';
                            resplandor = 'border-gray-400 bg-gray-400/10 text-white';
                        } else if(index === 2) {
                            medalla = '<i class="fas fa-medal text-amber-600 text-xl md:text-2xl mr-3 md:mr-4 w-6 text-center"></i>';
                            resplandor = 'border-amber-700 bg-amber-700/10 text-white';
                        } else {
                            resplandor = 'border-[var(--riddler-green)]/30 bg-black text-white';
                        }

                        html += `
                            <div class="flex justify-between items-center border-2 ${resplandor} p-3 md:p-4 animate-fade-in mb-2 md:mb-3">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-bold uppercase tracking-wider text-sm md:text-lg truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[var(--riddler-green)] font-dc text-xl md:text-2xl leading-none">${jugador.puntaje_total} PTS</span>
                                    <span class="block text-[8px] md:text-[10px] text-stone-400 tracking-widest uppercase mt-1">${jugador.tiempo_empleado} SEG</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-500 font-bold text-center mt-10">ERROR EN LA RED.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-500 font-bold text-center mt-10">FALLO DE COMUNICACIÓN CON LA ATALAYA.</p>';
        });
    }

    function cerrarModalRanking() {
        document.getElementById('modalRanking').classList.add('hidden');
    }

    // --- SISTEMA MULTIMEDIA S.H.I.E.L.D / WAYNE CORPS (ATALAYA) ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-stone-800', 'border-[var(--dc-blue)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--dc-blue)]', 'border-stone-800');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} EXPEDIENTES SELECCIONADOS`;
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
            alert("Héroe, debes seleccionar al menos un expediente.");
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
            alert("No hay registros en la base de datos de la Atalaya.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>