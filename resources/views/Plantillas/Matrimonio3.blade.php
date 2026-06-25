<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Boda Boho</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Quicksand:wght@300;500;600;700&family=Carattere&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --boho-earth: #bc8567;
            --boho-sand: #f4eee8;
            --boho-clay: #4a3728;
        }

        h1, h2, h3, .font-serif { font-family: 'DM Serif Display', serif; }
        .font-hand { font-family: 'Carattere', cursive; }
        body { font-family: 'Quicksand', sans-serif; background-color: var(--boho-sand); color: var(--boho-clay); scroll-behavior: smooth; overflow-x: hidden; }
        h1 { font-size: 3rem; }
        @media (min-width: 768px) { h1 { font-size: 5rem; } }

        .snap-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        .section-boho {
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            padding: 2rem 1rem;
        }

        .arch-frame {
            border-radius: 100px 100px 0 0;
            overflow: hidden;
            height: 40vh;
            box-shadow: 10px 10px 30px #d9d4cf, -10px -10px 30px #ffffff;
        }
        @media (min-width: 768px) {
            .arch-frame { height: 70vh; border-radius: 500px 500px 0 0; box-shadow: 20px 20px 60px #d9d4cf, -20px -20px 60px #ffffff; }
        }

        .btn-boho {
            background-color: var(--boho-earth);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 50px 5px 50px 5px;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            width: 100%;
            text-align: center;
            display: inline-block;
        }
        @media (min-width: 768px) {
            .btn-boho { padding: 1rem 2.5rem; letter-spacing: 2px; width: auto; }
        }

        .btn-boho:hover {
            transform: scale(1.05) rotate(-1deg);
            background-color: var(--boho-clay);
        }
        .btn-boho:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            background-color: var(--boho-earth);
        }

        .fade-in { animation: fadeIn 1.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .circle-unit {
            border: 1px solid rgba(188, 133, 103, 0.3);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        @media (min-width: 768px) {
            .circle-unit { width: 80px; height: 80px; }
        }

        .animate-pop { animation: popIn 0.4s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.97); } to { opacity: 1; transform: scale(1); } }

        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '17:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: INTRO (EL ARCO PRINCIPAL) --}}
    <section class="section-boho !pt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 max-w-6xl items-center w-full">
            <div class="arch-frame h-[45vh] md:h-[70vh] relative fade-in w-full max-w-[350px] mx-auto md:max-w-none order-2 md:order-1">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-orange-900/10"></div>
            </div>
            
            <div class="text-center md:text-left space-y-4 md:space-y-6 px-2 md:px-4 order-1 md:order-2">
                <p class="font-hand text-4xl md:text-5xl text-[#bc8567]">Nos casamos</p>
                <h1 class="text-4xl sm:text-5xl md:text-8xl leading-tight md:leading-none uppercase break-words">{{ $evento->nombre_evento }}</h1>
                <p class="text-sm md:text-xl tracking-wider md:tracking-widest border-b border-orange-200 pb-2 md:pb-4 inline-block">
                    {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d.m.Y') }}
                </p>
                
                {{-- CONTADOR EN LÍNEA --}}
                <div id="countdown" class="flex justify-center md:justify-start gap-2 sm:gap-4 mt-6 md:mt-8">
                    <div class="circle-unit">
                        <span id="days" class="text-lg md:text-2xl font-serif">00</span>
                        <span class="text-[8px] md:text-[9px] uppercase tracking-tighter">Días</span>
                    </div>
                    <div class="circle-unit">
                        <span id="hours" class="text-lg md:text-2xl font-serif">00</span>
                        <span class="text-[8px] md:text-[9px] uppercase tracking-tighter">Hrs</span>
                    </div>
                    <div class="circle-unit">
                        <span id="minutes" class="text-lg md:text-2xl font-serif">00</span>
                        <span class="text-[8px] md:text-[9px] uppercase tracking-tighter">Min</span>
                    </div>
                    <div class="circle-unit bg-white border-none shadow-sm text-orange-600">
                        <span id="seconds" class="text-lg md:text-2xl font-serif">00</span>
                        <span class="text-[8px] md:text-[9px] uppercase tracking-tighter font-bold">Seg</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: HISTORIA (Mosaico Moderno) --}}
    <section class="section-boho">
        <div class="max-w-6xl grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-4 h-auto md:h-[80vh] w-full">
            <div class="col-span-1 md:col-span-5 flex flex-col justify-center p-6 md:p-8 bg-white/50 backdrop-blur-sm rounded-3xl text-center md:text-left">
                <h2 class="text-4xl md:text-5xl mb-4 md:mb-6 italic">Nuestra Historia</h2>
                <p class="text-sm md:text-lg leading-relaxed font-light text-orange-900/70 italic">
                    "{{ $evento->biografia_resumen }}"
                </p>
                <p class="font-hand text-3xl md:text-4xl mt-4 md:mt-6 text-orange-300">- Siempre juntos</p>
            </div>
            
            <div class="hidden md:block col-span-4 arch-frame h-full mt-10">
                {{-- AQUÍ SOLO USAMOS LA FOTO LOCAL DEL DISEÑO --}}
                @if($evento->fotosGaleria->count() > 1)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" class="w-full h-full object-cover">
                @endif
            </div>
            <div class="col-span-1 md:col-span-3 arch-frame h-32 md:h-1/2 self-center md:self-end mb-4 md:mb-10 bg-orange-100 p-4 md:p-8 flex items-center justify-center text-center rounded-3xl md:rounded-[100px_100px_0_0]">
                 <p class="text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.3em] font-bold text-orange-400">VIVE EL AMOR</p>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="section-boho">
        <div class="bg-white rounded-[40px] md:rounded-[200px] p-8 sm:p-12 md:p-24 text-center w-full max-w-4xl shadow-xl relative mx-2">
            <div class="absolute -top-5 -right-5 md:-top-10 md:-right-10 w-20 h-20 md:w-32 md:h-32 bg-orange-100 rounded-full z-0 opacity-50"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl sm:text-5xl md:text-7xl mb-6 md:mb-8 leading-tight">¿Dónde será el gran día?</h2>
                <p class="text-sm sm:text-xl md:text-2xl font-light mb-8 md:mb-12 text-orange-800/60 leading-relaxed italic px-2">
                    {{ $evento->ubicacion_texto }}
                </p>
                
                @if($evento->google_maps_url)
                <div class="w-full flex justify-center">
                    <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-boho inline-block max-w-xs">
                        Abrir Mapa <i class="fa-solid fa-leaf ml-2"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES --}}
    <section class="section-boho">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 w-full max-w-5xl">
            
            {{-- BLOQUE TRIVIA BOHO CHIC --}}
            <div class="bg-[#e9dcc9] p-8 md:p-12 rounded-[30px] md:rounded-[50px] shadow-sm flex flex-col justify-between h-auto md:h-80 items-center md:items-start text-center md:text-left">
                <div>
                    <h3 class="text-3xl md:text-4xl mb-3 md:mb-4 italic">El Juego</h3>
                    <p class="font-light text-sm md:text-base">Descubre cuánto sabes de nuestra locura en esta trivia interactiva.</p>
                </div>
                <div id="wrapper-btn-trivia" class="w-full flex flex-col items-center md:items-start gap-2 mt-6 md:mt-0">
                    @if($yaComenzo)
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="mt-2 md:mt-4 text-xs md:text-sm font-bold uppercase tracking-widest text-[#4a3728] border-b-2 border-white inline-block w-max transition hover:text-orange-800">Empezar Juego</button>
                        <button onclick="verRanking()" class="mt-3 md:mt-4 text-xs md:text-sm font-bold uppercase tracking-widest text-[#bc8567] border-b-2 border-[#bc8567] inline-block w-max transition hover:text-[#4a3728]">Ver Posiciones</button>
                    @else
                        <button id="btn-time-trivia" disabled class="mt-4 md:mt-8 text-xs md:text-sm font-bold uppercase tracking-widest text-stone-400 cursor-not-allowed inline-block">
                            <i class="fas fa-lock mr-1"></i> Disponible en el Evento
                        </button>
                    @endif
                </div>
            </div>

            {{-- BLOQUE MURO BOHO CHIC --}}
            <div class="bg-white p-8 md:p-12 rounded-[30px] md:rounded-[50px] shadow-sm flex flex-col justify-between border-2 border-[#f4eee8] h-auto md:h-80 items-center md:items-start text-center md:text-left">
                <div>
                    <h3 class="text-3xl md:text-4xl mb-3 md:mb-4 italic">Tus Palabras</h3>
                    <p class="font-light text-sm md:text-base">Déjanos un mensaje en nuestro libro de visitas digital.</p>
                </div>
                <div id="wrapper-btn-muro" class="w-full flex flex-col sm:flex-row items-center md:items-start justify-center md:justify-start gap-4 sm:gap-6 mt-6 md:mt-0">
                    @if($yaComenzo)
                        <button onclick="solicitarAccesoVerificacion('muro')" class="mt-2 md:mt-8 text-xs md:text-sm font-bold uppercase tracking-widest text-[#bc8567] border-b-2 border-orange-100 inline-block w-max transition hover:text-[#4a3728]">Dejar Mensaje</button>
                        <button onclick="mostrarMuroVisual()" class="mt-2 md:mt-8 text-xs md:text-sm font-bold uppercase tracking-widest text-[#4a3728] border-b-2 border-white inline-block w-max transition hover:text-orange-800">Ver Muro</button>
                    @else
                        <button id="btn-time-muro" disabled class="mt-4 md:mt-8 text-xs md:text-sm font-bold uppercase tracking-widest text-stone-400 cursor-not-allowed inline-block">
                            <i class="fas fa-lock mr-1"></i> Disponible en el Evento
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: MURO VISUAL DE DESEOS --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[#f4eee8]/98 backdrop-blur-md overflow-y-auto w-full h-full text-[#4a3728]">
        <div class="max-w-6xl w-full mx-auto px-4 md:px-6 py-12 md:py-16 text-center min-h-screen flex flex-col relative z-10">
            
            <div class="mb-10 md:mb-12 animate-pop">
                <i class="fa-solid fa-feather-alt text-[#bc8567] text-2xl md:text-3xl mb-3 md:mb-4 block"></i>
                <h2 class="text-4xl sm:text-5xl md:text-7xl font-serif italic mb-2">Muro de Deseos</h2>
                <p class="font-hand text-3xl md:text-4xl text-[#bc8567]">Compartiendo el amor de nuestros invitados</p>
                <div class="w-16 md:w-24 h-[1px] bg-[#bc8567]/40 mx-auto mt-4 md:mt-6"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 flex-grow items-start w-full">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="p-6 md:p-8 bg-white rounded-[25px] md:rounded-[35px] border border-stone-200/60 shadow-sm flex flex-col text-left transition-all duration-500 hover:-translate-y-2 hover:border-[#bc8567]/40 hover:shadow-[0_15px_30px_rgba(188,133,103,0.1)] w-full">
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="mb-4 md:mb-6 overflow-hidden rounded-[15px] md:rounded-[25px] border border-stone-100 shadow-sm">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" class="w-full h-40 md:h-56 object-cover transition-all duration-700 hover:scale-105">
                            </div>
                        @endif
                        
                        <p class="text-base md:text-lg text-[#4a3728] font-serif italic leading-relaxed flex-grow mb-4 md:mb-6 break-words">"{{ $item->contenido_texto }}"</p>
                        
                        <div class="pt-3 md:pt-4 border-t border-stone-100 flex items-center justify-between">
                            <span class="text-[9px] md:text-[11px] uppercase tracking-wider md:tracking-widest font-bold text-[#bc8567] truncate pr-2">{{ $item->nombre_autor }}</span>
                            <i class="fas fa-heart text-[#bc8567] opacity-40 text-[10px] md:text-xs shrink-0"></i>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 md:py-20 bg-white rounded-[30px] md:rounded-[40px] border border-dashed border-stone-300/80 mx-2">
                        <i class="fa-regular fa-comment-dots text-stone-300 text-3xl md:text-4xl mb-3 md:mb-4"></i>
                        <p class="text-stone-500 italic font-light text-sm md:text-lg">Aún no hay deseos en el muro. ¡Sé el primero!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 md:mt-16 pb-8 flex justify-center w-full">
                <button onclick="ocultarMuroVisual()" class="btn-boho inline-block max-w-xs">
                    <i class="fas fa-arrow-left mr-2 text-[10px]"></i> Volver al inicio
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: GALERÍA DE RECUERDOS (TIEMPO REAL CLOUD) --}}
    <section class="section-boho !h-auto py-20 min-h-[60vh] !block">
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-20 mx-auto">
            
            <div class="text-center mb-8 md:mb-12 w-full">
                <h2 class="text-3xl sm:text-4xl md:text-5xl text-[#4a3728] font-serif mb-2 md:mb-4">Capturando Momentos</h2>
                <div class="flex items-center justify-center gap-3 md:gap-4 text-rose-300">
                    <div class="h-[1px] w-8 md:w-12 bg-[#bc8567]/30"></div>
                    <i class="fa-solid fa-camera-retro text-[#bc8567] text-[10px] md:text-xs"></i>
                    <div class="h-[1px] w-8 md:w-12 bg-[#bc8567]/30"></div>
                </div>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 bg-white border border-stone-200 p-4 md:p-6 rounded-[20px] md:rounded-[30px] shadow-sm gap-4">
                <div class="text-center md:text-left">
                    <span id="contador-seleccionadas" class="font-serif italic text-xl md:text-2xl text-[#bc8567]">
                        0 seleccionadas
                    </span>
                    <p class="text-[9px] md:text-[10px] text-stone-400 uppercase tracking-widest mt-1">Haz clic en las fotos para descargar</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border border-[#bc8567] text-[#bc8567] px-6 py-2.5 md:py-3 hover:bg-[#bc8567] hover:text-white transition uppercase tracking-widest rounded-full w-full md:w-auto">
                        <i class="fas fa-download mr-2"></i> Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-boho !w-full md:!w-auto !py-3">
                        <i class="fas fa-cloud-download-alt mr-2"></i> Descargar Todo
                    </button>
                </div>
            </div>

            @php
                $galeriaUnificada = collect();

                // 🔥 MAGIA: SOLO cargamos las fotos de OneDrive en tiempo real
                if(isset($fotosNubeRealtime)) {
                    foreach($fotosNubeRealtime as $fotoCloud) {
                        $galeriaUnificada->push([
                            'url' => $fotoCloud['url'],
                            'esVideo' => $fotoCloud['esVideo'] ?? false,
                            'etiqueta' => 'Recuerdo de Invitado'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll p-2">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer border border-stone-100 rounded-[20px] md:rounded-[25px] overflow-hidden hover:shadow-xl transition-all duration-300 bg-white" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/10 hover:bg-black/20 transition">
                                <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition shadow-lg">
                                    <i class="fas fa-play text-[#bc8567] ml-1"></i>
                                </div>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover group-hover:scale-105 transition-transform duration-700">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[#4a3728]/30 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-3 right-3 bg-white text-[#bc8567] rounded-full w-6 h-6 md:w-8 md:h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none border border-stone-200">
                            <i class="fas fa-check text-[10px] md:text-sm"></i>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-[#4a3728]/80 to-transparent pt-8 pb-3 px-3 text-white text-[8px] md:text-[9px] uppercase tracking-widest truncate text-center z-30 pointer-events-none">
                            @if($foto['esVideo'])
                                <i class="fas fa-video mr-1"></i>
                            @else
                                <i class="fas fa-cloud mr-1"></i>
                            @endif
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border border-dashed border-[#bc8567]/30 p-10 bg-white rounded-[30px]">
                        <i class="fa-regular fa-images text-3xl text-stone-300 mb-3"></i>
                        <p class="text-stone-500 font-serif italic text-xl">Aún no hay memorias guardadas en la nube.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP --}}
    <section class="section-boho relative">
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 w-full max-w-4xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO (Con my-auto se centra verticalmente) --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <p class="font-hand text-5xl md:text-6xl text-[#bc8567] mb-6 md:mb-8 drop-shadow-sm">Te esperamos</p>
                <h2 class="text-4xl sm:text-5xl md:text-8xl mb-10 md:mb-12 uppercase tracking-tighter leading-tight text-stone-800">Confirma tu Asistencia</h2>
                
                <div id="contenedorBotonPrincipalRSVP" class="flex justify-center w-full">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-boho w-full max-w-xs md:max-w-md">
                            Confirmar RSVP
                        </button>
                    @else
                        <div class="px-6 md:px-8 py-3 md:py-4 border border-dashed border-[#bc8567]/30 text-[10px] md:text-xs tracking-wider md:tracking-widest uppercase text-stone-500 w-full max-w-xs md:max-w-md mx-auto rounded-[20px] bg-white/50 leading-relaxed shadow-sm">
                            Código QR Requerido para Confirmación
                        </div>
                    @endif
                </div>
                
                <div class="mt-12 md:mt-16 flex flex-wrap justify-center gap-4 md:gap-10 opacity-70 text-[8px] md:text-[10px] font-bold uppercase tracking-[0.1em] md:tracking-[0.2em] text-stone-600">
                    <span>Mesa {{ $invitado->mesa_asignada ?? '00' }}</span>
                    <span class="hidden sm:inline text-stone-300">•</span>
                    <span>Dress Code: Boho Chic</span>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-300 group cursor-pointer">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-stone-400 mb-1.5 font-medium">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono en tono tierra/terracota --}}
                        <i class="fas fa-glass-cheers text-[11px] md:text-xs text-[#bc8567]"></i>
                        {{-- Eventify oscuro que pasa a tono tierra en hover --}}
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-stone-600 group-hover:text-[#bc8567] transition-colors">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>
</div>

{{-- MODAL GLOBAL DE FILTRO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-[#4a3728]/80 backdrop-blur-sm p-4">
    <div id="wrapper-dinamico-modal" class="bg-[#f4eee8] rounded-[30px] md:rounded-[40px] max-w-xl w-[95%] md:w-full p-6 md:p-8 text-center shadow-2xl border-4 border-white/60 max-h-[95vh] overflow-y-auto text-[#4a3728]">
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-[#bc8567]/20 pb-3 md:pb-4 text-left">
                <h3 class="text-lg md:text-xl font-serif italic text-[#4a3728]"><i class="fas fa-key text-[#bc8567] mr-2"></i> Código Requerido</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[#bc8567] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-4 md:space-y-5 text-left">
                <p class="text-xs md:text-sm text-stone-600 font-light leading-relaxed">Para ingresar a las interacciones de la noche, introduce el **Código de Pase Personal** que se te entregó en la pantalla al confirmar asistencia.</p>
                <div>
                    <label class="block text-[10px] md:text-xs font-bold uppercase tracking-wide text-stone-500 mb-1 md:mb-2">Introduce tu Clave</label>
                    <input type="text" id="inputCodigoIngreso" placeholder="Ej: JON-4812" class="w-full border border-stone-200 bg-[#fbf9f6] p-3 md:p-3.5 rounded-xl text-xs md:text-sm font-mono tracking-widest outline-none uppercase focus:border-[#bc8567] text-[#4a3728]">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="w-full btn-boho text-center block shadow-md mt-2">Validar Credencial</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-[#4a3728]/80 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[30px] md:rounded-[40px] max-w-2xl w-[95%] md:w-full p-6 md:p-8 text-center shadow-[0_10px_30px_rgba(74,55,40,0.2)] md:shadow-[0_20px_60px_rgba(74,55,40,0.2)] relative max-h-[95vh] flex flex-col font-sans border-4 border-[#f4eee8]">
        
        <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-[#bc8567]/20 pb-3 md:pb-4 shrink-0 text-left">
            <h3 class="text-2xl md:text-3xl font-serif italic text-[#4a3728]">
                <i class="fas fa-crown mr-2 text-[#bc8567]"></i> Cuadro de Honor
            </h3>
            <button onclick="cerrarModalRanking()" class="text-stone-400 hover:text-[#bc8567] transition"><i class="fas fa-times text-xl md:text-2xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-1 md:pr-2 space-y-2 md:space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-leaf fa-spin text-3xl md:text-4xl text-[#bc8567]"></i>
            </div>
        </div>

        <div class="mt-4 md:mt-6 pt-2 md:pt-4 shrink-0">
            <button onclick="cerrarModalRanking()" class="w-full py-3 md:py-4 border border-[#bc8567] text-[#bc8567] rounded-full font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-[#bc8567] hover:text-white transition">
                Cerrar el cuadro
            </button>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO PARA EL MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[75] hidden flex items-center justify-center bg-[#4a3728]/60 backdrop-blur-md p-4">
    <div class="bg-[#f4eee8] rounded-[30px] md:rounded-[40px] max-w-md w-full p-6 md:p-8 text-center shadow-2xl border-4 border-white/80 max-h-[95vh] overflow-y-auto">
        <div class="mb-6 md:mb-8 text-center relative">
            <h3 class="text-2xl md:text-3xl font-serif italic text-[#4a3728]">Deja tus mejores deseos</h3>
            <div class="w-12 md:w-16 h-1 bg-[#bc8567] mx-auto mt-3 md:mt-4 rounded-full"></div>
            <button onclick="cerrarModalMuroBoda()" class="absolute -top-2 right-0 md:top-0 md:-right-2 text-[#bc8567] hover:text-[#4a3728] transition text-xl"><i class="fas fa-times"></i></button>
        </div>

        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{$evento->evento_id}}')" enctype="multipart/form-data" class="space-y-4 md:space-y-6 text-left">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#bc8567] mb-1 md:mb-2 ml-1">Nombre</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" class="w-full border border-[#bc8567]/20 bg-white/50 p-3 md:p-4 rounded-xl md:rounded-2xl text-xs md:text-sm outline-none text-[#4a3728] font-medium shadow-inner" readonly>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#bc8567] mb-1 md:mb-2 ml-1">Rol en el evento *</label>
                <select name="vinculo_autor" required class="w-full border border-[#bc8567]/20 bg-white/50 p-3 md:p-4 rounded-xl md:rounded-2xl text-xs md:text-sm outline-none text-[#4a3728] cursor-pointer focus:border-[#bc8567] transition">
                    <option value="" disabled selected>Seleccione...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero">Compañero de trabajo</option>
                    <option value="Conocido">Conocido</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#bc8567] mb-1 md:mb-2 ml-1">Tu Mensaje *</label>
                <textarea name="contenido" required rows="3" class="w-full border border-[#bc8567]/20 bg-white/50 p-3 md:p-4 rounded-xl md:rounded-2xl text-xs md:text-sm outline-none focus:border-[#bc8567] text-[#4a3728] leading-relaxed shadow-inner" placeholder="Escribe aquí tus mejores deseos..."></textarea>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#bc8567] mb-1 md:mb-2 ml-1">Foto (Opcional)</label>
                <div class="relative">
                    <input type="file" name="archivo" accept="image/*" class="w-full border border-[#bc8567]/20 bg-white/50 p-2 md:p-3 rounded-xl md:rounded-2xl text-[10px] md:text-sm text-stone-600 file:mr-2 md:file:mr-4 file:py-1 md:file:py-2 file:px-2 md:file:px-4 file:rounded-full file:border-0 file:text-[10px] md:file:text-xs file:font-bold file:bg-[#bc8567] file:text-white hover:file:bg-[#4a3728] cursor-pointer">
                </div>
            </div>
            <button type="submit" id="btnPublicarMuro" class="w-full bg-[#bc8567] hover:bg-[#4a3728] text-white py-3 md:py-4 rounded-[30px_5px_30px_5px] md:rounded-[50px_5px_50px_5px] font-bold uppercase tracking-widest transition shadow-lg mt-2 text-xs md:text-sm">Publicar Deseo</button>
        </form>
    </div>
</div>

{{-- MODAL PÚBLICO PARA REGISTRO DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-[#4a3728]/80 backdrop-blur-sm p-4">
    <div class="bg-[#f4eee8] text-[#4a3728] rounded-[30px] md:rounded-[40px] max-w-md w-[95%] md:w-full p-6 md:p-8 text-center shadow-2xl border-4 border-white/60 max-h-[95vh] overflow-y-auto">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-[#bc8567]/20 pb-3 md:pb-4 text-left">
                <h3 class="text-xl md:text-2xl font-serif italic text-[#4a3728]">Registro de Asistencia</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-[#bc8567] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-4 md:space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-white p-4 md:p-5 rounded-[20px] md:rounded-[25px] shadow-sm border border-stone-200/60 space-y-3 md:space-y-4">
                    <span class="text-[10px] uppercase tracking-wider font-bold text-[#bc8567] block"><i class="fas fa-feather-alt mr-1"></i> Invitado Principal</span>
                    <div>
                        <label class="block text-[10px] md:text-xs font-medium text-stone-600 mb-1">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-stone-200 bg-[#fbf9f6] p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-[#bc8567] text-[#4a3728]">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-medium text-stone-600 mb-1">Correo Electrónico (Opcional)</label>
                        <input type="email" id="inputEmailPrincipal" class="w-full border border-stone-200 bg-[#fbf9f6] p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-[#bc8567] text-[#4a3728]" placeholder="ejemplo@correo.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-3 md:space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2.5 md:py-3 border-2 border-dashed border-[#bc8567]/40 text-[#bc8567] rounded-xl text-[10px] md:text-xs font-medium uppercase tracking-wider hover:bg-white/60 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus text-[8px] md:text-[10px]"></i> ¿Vienes acompañado? Añadir persona
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full btn-boho mt-2 md:mt-4 text-center block shadow-md text-xs md:text-sm !py-3 md:!py-4">Confirmar mi Lugar</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO BOHO CHIC --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-[#4a3728]/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-white/50 hover:text-white transition z-50 bg-black/20 w-12 h-12 rounded-full flex items-center justify-center backdrop-blur-sm">
        <i class="fas fa-times text-2xl drop-shadow-md"></i>
    </button>
    <div class="w-full max-w-4xl bg-white rounded-2xl md:rounded-[40px] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-[8px] border-[#f4eee8]" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-stone-100"></video>
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
        const horaEvento = "{{ $evento->hora ?? '17:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='text-xl md:text-2xl font-serif text-[#bc8567] italic px-4 text-center w-full'>¡Ya empezó la fiesta!</p>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="mt-2 md:mt-4 text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#4a3728] border-b-2 border-white inline-block w-max transition hover:text-orange-800">Empezar Juego</button>
                        <button onclick="verRanking()" class="mt-3 md:mt-4 text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#bc8567] border-b-2 border-[#bc8567] inline-block w-max transition hover:text-[#4a3728]">Ver Posiciones</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `<button onclick="solicitarAccesoVerificacion('muro')" class="mt-2 md:mt-8 text-[10px] md:text-sm font-bold uppercase tracking-widest text-[#bc8567] border-b-2 border-orange-100 inline-block w-max transition hover:text-[#4a3728]">Dejar Mensaje</button>`;
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
        document.getElementById('wrapper-dinamico-modal').className = "bg-[#f4eee8] rounded-[30px] md:rounded-[40px] max-w-xl w-[95%] md:w-full p-6 md:p-8 text-center shadow-2xl border-4 border-white/60 max-h-[95vh] overflow-y-auto text-[#4a3728]";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-[#bc8567]/20 pb-3 md:pb-4 text-left">
                    <h3 class="text-lg md:text-xl font-serif italic text-[#4a3728]"><i class="fas fa-key text-[#bc8567] mr-2"></i> Código Requerido</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[#bc8567] transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-4 md:space-y-5 text-left">
                    <p class="text-xs md:text-sm text-stone-600 font-light leading-relaxed">Para ingresar a las interacciones de la noche, introduce el **Código de Pase Personal** que se te entregó en la pantalla al confirmar asistencia.</p>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold uppercase tracking-wide text-stone-500 mb-1 md:mb-2">Introduce tu Clave</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="Ej: JON-4812" class="w-full border border-stone-200 bg-[#fbf9f6] p-3 md:p-3.5 rounded-xl text-xs md:text-sm font-mono tracking-widest outline-none uppercase focus:border-[#bc8567] text-[#4a3728]">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="w-full btn-boho text-center block shadow-md mt-2">Validar Credencial</button>
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
        btnVerificar.innerHTML = '<i class="fas fa-leaf fa-spin mr-2"></i> Verificando...';

        fetch(`/invitacion/validar-pase-trivia`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
        })
        .then(async response => {
            const data = await response.status === 422 || response.status === 404 || response.status === 200 ? await response.json() : {};
                
            if (response.status === 422 && data.already_played) {
                if(moduloObjetivo === 'trivia') {
                    const wrapper = document.getElementById('wrapper-dinamico-modal');
                    wrapper.innerHTML = `
                        <div class="py-4 md:py-6 text-center space-y-4 md:space-y-6 animate-pop">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto border border-amber-200 shadow-sm">
                                <i class="fas fa-exclamation-circle text-xl md:text-2xl text-amber-500"></i>
                            </div>
                            <div class="space-y-1 md:space-y-2">
                                <h3 class="text-lg md:text-xl font-serif italic text-[#4a3728]">Trivia Ya Completada</h3>
                                <p class="text-[10px] md:text-sm text-stone-600 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                            </div>
                            <div class="pt-2 md:pt-4 space-y-2 md:space-y-3">
                                <button onclick="verRanking()" class="w-full py-2.5 md:py-3 bg-[#bc8567] text-white text-[10px] md:text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-[#4a3728] transition shadow-md">Ver el Cuadro de Honor</button>
                                <button onclick="cerrarModalFiltro()" class="w-full py-2.5 md:py-3 bg-stone-100 text-stone-600 text-[10px] md:text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-stone-200 transition">Regresar</button>
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
                btnVerificar.classList.remove('opacity-70', 'cursor-not-allowed');
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
        botonPublicar.classList.add('cursor-not-allowed', 'opacity-70');
        botonPublicar.innerHTML = `<i class="fas fa-heart fa-beat text-orange-200 mr-2"></i> Enviando deseo...`;

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
                botonPublicar.classList.remove('cursor-not-allowed', 'opacity-70');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Fallo en la validación.");
            }
            return data;
        })
        .then(data =>{
            if (data.success) {
                document.getElementById('modalMuroBoda').firstElementChild.innerHTML = `
                    <div class="py-6 md:py-8 text-center space-y-4 md:space-y-6 animate-pop font-mono">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50/50 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30">
                            <i class="fas fa-check text-xl md:text-2xl text-emerald-500"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl font-bold uppercase italic text-[#4a3728]">¡Deseo Compartido!</h3>
                            <p class="text-[10px] md:text-xs text-stone-400 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="w-full bg-[#bc8567] text-white py-2.5 md:py-3.5 rounded-full font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-[#4a3728] transition mt-3 md:mt-4 shadow-md">
                            Cerrar ventana
                        </button>
                    </div>
                `;
            }
        }).catch(error => {
            console.error("Error al enviar el recuerdo:", error);
            if (botonPublicar) {
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('cursor-not-allowed', 'opacity-70');
                botonPublicar.innerHTML = textoOriginal;
            }
        });
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-4 md:space-y-6 animate-pop font-mono">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto shadow-xs border border-amber-100">
                    <i class="fas fa-gamepad text-lg md:text-xl text-amber-500"></i>
                </div>
                <span class="text-[10px] md:text-xs uppercase tracking-widest text-amber-600 font-bold block">Trivia Familiar</span>
                <h1 class="text-2xl md:text-3xl font-serif text-slate-800">¡Hola, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-slate-500 text-[10px] md:text-sm leading-relaxed px-1 md:px-2">Demuestra qué tanto conoces a los anfitriones. Responderás un total de <strong class="text-slate-700">${bancoPreguntas.length} preguntas</strong> de trivia. ¡Cada segundo cuenta para el ranking!</p>
                
                <button onclick="comenzarJuegoModal()" class="w-full bg-slate-800 text-white py-3 md:py-4 rounded-lg md:rounded-xl font-bold uppercase tracking-wider text-[10px] md:text-xs hover:bg-slate-900 transition shadow-md mt-2">
                    Comenzar a Jugar
                </button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-4 md:space-y-6 text-left animate-pop font-mono">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-semibold uppercase tracking-wider text-slate-400 border-b pb-2 md:pb-4">
                    <span id="info-progreso">Pregunta 1 de X</span>
                    <span class="text-amber-600"><i class="fas fa-clock mr-1"></i> Tiempo: <span id="info-cronometro" class="font-mono text-xs md:text-sm font-bold">0s</span></span>
                </div>

                <h2 id="texto-pregunta" class="text-base md:text-xl font-serif text-slate-800 leading-snug">Cargando pregunta...</h2>

                <div class="space-y-2 md:space-y-3 pt-1 md:pt-2">
                    <button onclick="seleccionarOpcionModal('a')" id="btn-opcion-a" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">A</span>
                        <span id="texto-opcion-a" class="break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" id="btn-opcion-b" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">B</span>
                        <span id="texto-opcion-b" class="break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" id="btn-opcion-c" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">C</span>
                        <span id="texto-opcion-c" class="break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" id="btn-opcion-d" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-slate-400 text-[10px] md:text-xs font-mono">Este evento no cuenta con preguntas de trivia configuradas.</p>`;
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
            <div class="text-center space-y-4 md:space-y-6 py-6 md:py-8 animate-pop">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto border">
                    <i class="fas fa-spinner fa-spin text-lg md:text-xl text-slate-400"></i>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-slate-800">Sincronizando puntuación...</h3>
                <p class="text-[10px] md:text-xs text-slate-400 font-light">Guardando tu récord en el servidor del evento.</p>
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
                    <div class="text-center space-y-4 md:space-y-6 py-2 md:py-4 animate-pop">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto border border-emerald-100 mb-2 md:mb-4 shadow-sm">
                            <i class="fas fa-trophy text-xl md:text-2xl text-emerald-500"></i>
                        </div>
                        <h3 class="text-xl md:text-2xl font-serif text-slate-800">¡Trivia Completada!</h3>
                        <p class="text-[10px] md:text-sm text-slate-500 max-w-xs mx-auto leading-relaxed px-2">Tus respuestas han sido procesadas de forma exitosa.</p>
                        
                        <div class="grid grid-cols-2 gap-3 md:gap-4 bg-slate-50 p-3 md:p-4 border border-slate-100 rounded-lg md:rounded-xl max-w-xs mx-auto text-left">
                            <div class="border-r pr-2">
                                <span class="block text-[8px] md:text-[10px] uppercase font-bold text-slate-400 mb-1">Puntaje Total</span>
                                <span class="text-lg md:text-xl font-black text-slate-800">${puntajeAcumulado} pts</span>
                            </div>
                            <div class="text-left pl-2">
                                <span class="block text-[8px] md:text-[10px] uppercase font-bold text-slate-400 mb-1">Tiempo Récord</span>
                                <span class="text-lg md:text-xl font-black text-slate-800">${segundosTranscurridos} seg</span>
                            </div>
                        </div>

                        <div class="pt-2 md:pt-4 space-y-2 md:space-y-3">
                            <button onclick="verRanking()" class="w-full bg-slate-800 text-white py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-slate-900 transition shadow-md">Ver el Cuadro de Honor</button>
                            <button onclick="cerrarModalFiltro()" class="w-full bg-stone-100 text-stone-600 py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-stone-200 transition">Terminar</button>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            wrapper.innerHTML = `<p class="text-red-500 font-bold text-xs md:text-sm"><i class="fas fa-exclamation-triangle mr-1"></i> Error al guardar la puntuación.</p>`;
        });
    }

    // --- LÓGICA DEL RANKING (DISEÑO BOHO) ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-leaf fa-spin text-3xl md:text-4xl text-[#bc8567]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-[#bc8567] text-center font-serif text-lg md:text-xl mt-10 italic">Aún no hay participantes en el cuadro de honor.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-base md:text-lg text-stone-400 font-bold mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0">#${index + 1}</span>`;
                        let resplandor = 'border-stone-100 bg-white text-[#4a3728]';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-crown text-yellow-500 text-xl md:text-2xl mr-2 md:mr-4 w-4 md:w-6 text-center drop-shadow-sm shrink-0"></i>';
                            resplandor = 'border-[#bc8567]/30 shadow-[0_3px_10px_rgba(188,133,103,0.15)] md:shadow-[0_5px_15px_rgba(188,133,103,0.15)] bg-orange-50/50 scale-[1.02] z-10 relative';
                        } else if(index === 1) {
                            medalla = '<i class="fas fa-medal text-gray-400 text-lg md:text-xl mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                            resplandor = 'border-stone-200 bg-stone-50';
                        } else if(index === 2) {
                            medalla = '<i class="fas fa-medal text-amber-700 text-lg md:text-xl mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-3 md:p-4 animate-pop mb-2 md:mb-3 rounded-xl md:rounded-2xl">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-bold uppercase tracking-wider text-xs md:text-sm truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[#bc8567] font-black text-lg md:text-xl leading-none">${jugador.puntaje_total} <span class="text-[8px] md:text-[10px] text-stone-400 font-normal">pts</span></span>
                                    <span class="block text-[8px] md:text-[9px] text-stone-400 tracking-widest uppercase mt-1 border-t border-stone-100 pt-1">${jugador.tiempo_empleado} seg</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 font-bold text-center mt-10 text-[10px] md:text-xs uppercase">Error al obtener los datos.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 font-bold text-center mt-10 text-[10px] md:text-xs uppercase">Fallo de conexión.</p>';
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
        div.className = "bg-white p-4 md:p-5 rounded-[20px] md:rounded-[25px] shadow-sm border border-stone-200/60 space-y-3 md:space-y-4 relative animate-fade-in";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-stone-100 pb-2">
                <span class="text-[8px] md:text-[10px] uppercase tracking-wider font-bold text-stone-400"><i class="fas fa-user-friends mr-1"></i> Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="document.getElementById('acompanante_row_${contadorAcompanantes}').remove()" class="text-rose-400 hover:text-rose-600 text-[10px] md:text-xs font-medium transition"><i class="fas fa-trash-alt mr-1"></i> Quitar</button>
            </div>
            <div><label class="block text-[10px] md:text-xs font-medium text-stone-600 mb-1">Nombre Completo *</label><input type="text" class="input-nombre-acompanante w-full border border-stone-200 bg-[#fbf9f6] p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-[#bc8567] text-[#4a3728]" required></div>
            <div><label class="block text-[10px] md:text-xs font-medium text-stone-600 mb-1">Correo Electrónico (Opcional)</label><input type="email" class="input-email-acompanante w-full border border-stone-200 bg-[#fbf9f6] p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-[#bc8567] text-[#4a3728]"></div>
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
        btnConfirmar.classList.add('opacity-80', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-leaf fa-spin mr-2"></i> Confirmando lugares...';

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
                btnConfirmar.classList.remove('opacity-80', 'cursor-not-allowed');
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
                    <div class="py-6 px-2 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto border border-amber-200">
                            <i class="fas fa-exclamation-triangle text-xl md:text-2xl text-amber-500"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl font-serif italic text-[#4a3728]">Asistencia Ya Confirmada</h3>
                            <p class="text-[10px] md:text-sm text-stone-500 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="p-3 md:p-4 bg-amber-50/50 border border-amber-100 rounded-xl text-[10px] md:text-xs text-amber-800 text-left leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i> Si necesitas modificar los cupos reservados o realizar algún cambio, por favor contacta directamente a los novios.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-stone-800 text-white py-2 md:py-2.5 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-stone-700 transition shadow-md mt-2">
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
                    <div class="py-4 md:py-6 px-2 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto border border-emerald-200">
                            <i class="fas fa-check text-xl md:text-2xl text-emerald-500"></i>
                        </div>
                        
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-xl md:text-2xl font-serif italic text-[#4a3728]">¡Todo Listo!</h3>
                            <p class="text-[10px] md:text-sm text-stone-500 font-light px-1 md:px-2">Guarda tus códigos de acceso individuales para participar en las dinámicas.</p>
                        </div>

                        <div class="bg-white border border-stone-200 rounded-[20px] md:rounded-[25px] p-4 md:p-5 text-left space-y-3 md:space-y-4 shadow-sm">
                            <p class="text-[8px] md:text-[10px] uppercase font-bold tracking-widest text-[#bc8567] border-b border-stone-100 pb-1.5 md:pb-2">
                                <i class="fas fa-ticket-alt mr-1"></i> Pases Personales
                            </p>
                            <div class="text-[10px] md:text-xs space-y-2 md:space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-2 md:pt-3 border-t border-dashed border-stone-100' : ''}">
                                        <span class="font-sans font-medium text-stone-700 truncate pr-2">${item.nombre}:</span> 
                                        <span class="bg-[#4a3728] px-2 md:px-3 py-0.5 md:py-1 rounded-md md:rounded-lg text-[9px] md:text-[11px] font-bold text-[#f4eee8] font-mono tracking-widest shadow-sm shrink-0">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[9px] md:text-[10px] text-stone-400 italic leading-relaxed px-2 md:px-4">Utiliza estos códigos en el Muro de Deseos o en la Trivia de Pareja durante el evento.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-[#bc8567] text-white py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-[#4a3728] transition shadow-md mt-2">
                            Entendido
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-8 py-3 md:py-4 border border-emerald-500/30 text-[10px] md:text-xs tracking-widest uppercase text-emerald-600 w-full max-w-xs md:max-w-md mx-auto bg-emerald-500/5 rounded-[15px] md:rounded-[20px] animate-fade-in font-bold">
                        <i class="fas fa-check-circle mr-1 md:mr-2"></i> ¡Asistencia Confirmada!
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
                btnConfirmar.classList.remove('opacity-80', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA BOHO CHIC ---
    
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
            elemento.classList.add('ring-2', 'ring-[#bc8567]', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-2', 'ring-[#bc8567]', 'ring-offset-2');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} seleccionadas`;
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
            alert("Por favor, selecciona al menos una memoria para descargar.");
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