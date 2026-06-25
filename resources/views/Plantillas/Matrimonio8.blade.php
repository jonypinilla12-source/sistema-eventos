<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Nuestra Boda</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@200;300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --blanco-seda: #FAFAFA;
            --crema-suave: #FFF9F5;
            --rosa-polvo: #F2D5D7;
            --oro-rosa: #B76E79;
            --texto-oscuro: #4A3E3E;
            --texto-claro: #7A6F6F;
        }

        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        .font-firma { font-family: 'Great Vibes', cursive; }
        body { font-family: 'Montserrat', sans-serif; background-color: var(--crema-suave); color: var(--texto-oscuro); scroll-behavior: smooth; overflow-x: hidden; }

        .snap-container { height: 100svh; overflow-y: scroll; scroll-snap-type: y mandatory; overflow-x: hidden; }
        
        .section-romantic { 
            min-height: 100svh; 
            width: 100%; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            position: relative; 
            scroll-snap-align: start; 
            overflow: hidden; 
            background-color: var(--crema-suave); 
            padding: 4rem 1.5rem; 
        }

        /* Patrón floral o textura muy suave (opcional, aquí usamos un gradiente radial sutil) */
        .floral-bg {
            background: radial-gradient(circle at top right, rgba(242, 213, 215, 0.4) 0%, transparent 50%),
                        radial-gradient(circle at bottom left, rgba(183, 110, 121, 0.1) 0%, transparent 50%);
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
        }

        /* Divisor elegante */
        .divisor-elegante {
            width: 80px;
            height: 1px;
            background: var(--oro-rosa);
            margin: 1.5rem auto;
            position: relative;
        }
        @media (min-width: 768px) { .divisor-elegante { width: 120px; margin: 2rem auto; } }
        .divisor-elegante::after {
            content: '✦';
            position: absolute;
            top: -11px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--oro-rosa);
            background: var(--crema-suave);
            padding: 0 10px;
            font-size: 0.9rem;
        }

        /* Botón Elegante Responsivo */
        .btn-romantic {
            background: transparent; 
            color: var(--oro-rosa); 
            padding: 12px 24px; 
            font-size: 0.75rem; 
            font-family: 'Montserrat', sans-serif; 
            font-weight: 500;
            text-transform: uppercase; 
            letter-spacing: 3px; 
            transition: all 0.4s ease; 
            position: relative; 
            display: inline-block; 
            cursor: pointer; 
            border: 1px solid var(--oro-rosa); 
            width: 100%; 
            text-align: center;
            border-radius: 2px;
        }
        @media (min-width: 768px) {
            .btn-romantic { font-size: 0.85rem; padding: 15px 35px; letter-spacing: 4px; width: auto; }
        }
        .btn-romantic:hover { background: var(--oro-rosa); color: white; box-shadow: 0 10px 20px rgba(183, 110, 121, 0.2); transform: translateY(-2px); }
        .btn-romantic:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }

        .btn-romantic-solid {
            background: var(--oro-rosa); color: white; border: 1px solid var(--oro-rosa);
        }
        .btn-romantic-solid:hover {
            background: transparent; color: var(--oro-rosa);
        }

        /* Efecto fotos */
        .img-arched {
            border-radius: 200px 200px 10px 10px;
            box-shadow: 0 15px 30px rgba(183, 110, 121, 0.15);
        }

        .animate-pop { animation: popIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes popIn { 0% { opacity: 0; transform: translateY(15px) scale(0.98); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        
        .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Ocultar Scrollbar */
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

    {{-- SECCIÓN 1: INICIO (HERO) --}}
    <section class="section-romantic !p-0">
        <div class="absolute inset-0 z-0">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                     class="w-full h-full object-cover animate-fade-in" style="animation-duration: 2s;">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-white/60 via-white/40 to-[var(--crema-suave)] z-0"></div>
        </div>
        
        <div class="z-10 text-center max-w-5xl px-4 flex flex-col items-center w-full justify-center h-full">
            <span class="font-firma text-3xl md:text-5xl tracking-widest text-[var(--oro-rosa)] mb-4 md:mb-6 drop-shadow-sm">Nuestra Boda</span>
            
            <h1 class="text-5xl sm:text-6xl md:text-8xl lg:text-9xl leading-tight mb-4 text-[var(--texto-oscuro)] font-serif font-light tracking-tight w-full break-words">
                {{ $evento->nombre_evento }}
            </h1>

            <div class="divisor-elegante !bg-transparent"></div>

            <p class="text-sm md:text-lg font-light tracking-[0.3em] md:tracking-[0.5em] text-[var(--texto-claro)] uppercase mb-10 md:mb-16">
                {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d \d\e F, Y') }}
            </p>

            {{-- CONTADOR ELEGANTE --}}
            <div id="countdown" class="flex gap-4 sm:gap-8 md:gap-16 items-center justify-center w-[90%] md:w-auto mx-auto border-t border-b border-[var(--oro-rosa)]/30 py-6 md:py-8">
                <div class="text-center min-w-[50px] md:min-w-[70px]">
                    <span id="days" class="text-3xl md:text-6xl font-serif text-[var(--oro-rosa)]">00</span>
                    <span class="block text-[8px] md:text-xs font-medium uppercase tracking-[0.2em] text-[var(--texto-claro)] mt-2">Días</span>
                </div>
                <div class="text-center min-w-[50px] md:min-w-[70px]">
                    <span id="hours" class="text-3xl md:text-6xl font-serif text-[var(--texto-oscuro)]">00</span>
                    <span class="block text-[8px] md:text-xs font-medium uppercase tracking-[0.2em] text-[var(--texto-claro)] mt-2">Hrs</span>
                </div>
                <div class="text-center min-w-[50px] md:min-w-[70px]">
                    <span id="minutes" class="text-3xl md:text-6xl font-serif text-[var(--texto-oscuro)]">00</span>
                    <span class="block text-[8px] md:text-xs font-medium uppercase tracking-[0.2em] text-[var(--texto-claro)] mt-2">Min</span>
                </div>
                <div class="text-center min-w-[50px] md:min-w-[70px]">
                    <span id="seconds" class="text-3xl md:text-6xl font-serif text-[var(--oro-rosa)]">00</span>
                    <span class="block text-[8px] md:text-xs font-medium uppercase tracking-[0.2em] text-[var(--oro-rosa)] mt-2">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: HISTORIA --}}
    <section class="section-romantic bg-white">
        <div class="floral-bg"></div>
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-20 items-center z-10 px-4 md:px-8">
            <div class="relative w-full max-w-[280px] sm:max-w-xs md:max-w-md mx-auto order-2 lg:order-1">
                @if($evento->fotosGaleria->count() > 1)
                    <div class="img-arched overflow-hidden aspect-[3/4] border-8 border-white">
                        <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" class="w-full h-full object-cover hover:scale-105 transition duration-1000">
                    </div>
                @endif
                <div class="absolute -bottom-6 -right-6 md:-bottom-10 md:-right-10 bg-[var(--crema-suave)] text-[var(--oro-rosa)] border border-[var(--rosa-polvo)] px-6 py-6 md:px-8 md:py-8 rounded-full shadow-lg flex items-center justify-center">
                    <span class="font-firma text-3xl md:text-4xl">Amor</span>
                </div>
            </div>
            
            <div class="space-y-6 md:space-y-8 text-center lg:text-left order-1 lg:order-2">
                <span class="text-[10px] md:text-xs font-semibold uppercase tracking-[0.3em] text-[var(--oro-rosa)]">El comienzo del siempre</span>
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif text-[var(--texto-oscuro)] leading-tight">Nuestra Historia</h2>
                <div class="divisor-elegante lg:ml-0 !bg-transparent"></div>
                <p class="text-sm md:text-lg leading-relaxed text-[var(--texto-claro)] font-light">
                    "{!! nl2br(e($evento->biografia_resumen)) !!}"
                </p>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="section-romantic">
        <div class="floral-bg"></div>
        <div class="text-center z-10 px-4 w-[95%] max-w-4xl mx-auto bg-white p-10 md:p-16 rounded-[2rem] shadow-[0_20px_40px_rgba(183,110,121,0.05)] border border-[var(--rosa-polvo)]/50">
            <i class="fa-solid fa-rings text-4xl md:text-5xl text-[var(--oro-rosa)] mb-6"></i>
            <h2 class="text-3xl sm:text-4xl md:text-5xl mb-6 font-serif text-[var(--texto-oscuro)] tracking-wide">Dónde Celebraremos</h2>
            <div class="divisor-elegante !bg-transparent mb-8"></div>
            
            <p class="text-stone-500 text-sm md:text-xl mb-10 font-light leading-relaxed px-4">
                {{ $evento->ubicacion_texto }}
            </p>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center mt-4">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-romantic btn-romantic-solid max-w-xs md:max-w-sm rounded-full">
                    Ver en el Mapa <i class="fas fa-location-dot ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES --}}
    <section class="section-romantic bg-white !py-20 h-auto min-h-[100svh]">
        <div class="max-w-6xl w-full px-4 flex flex-col justify-center h-full mx-auto">
            <div class="text-center mb-12 md:mb-16">
                <span class="font-firma text-3xl md:text-4xl text-[var(--oro-rosa)] block mb-2">Acompáñanos</span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-serif text-[var(--texto-oscuro)]">Dinámicas de la Noche</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                {{-- BLOQUE TRIVIA --}}
                <div class="bg-[var(--crema-suave)] border border-[var(--rosa-polvo)] rounded-[2rem] p-8 md:p-12 text-center group hover:shadow-xl transition-all duration-500 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-heart text-2xl text-[var(--oro-rosa)]"></i>
                        </div>
                        <h3 class="font-serif text-2xl md:text-3xl text-[var(--texto-oscuro)] mb-3">Historia de Amor</h3>
                        <p class="text-[var(--texto-claro)] font-light text-xs md:text-sm mb-8 px-4">¿Qué tanto conoces nuestra historia? Demuéstralo en esta trivia.</p>
                    </div>
                    <div id="wrapper-btn-trivia" class="w-full max-w-xs mx-auto flex flex-col gap-3">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-romantic rounded-full">Jugar Ahora</button>
                            <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] text-[var(--texto-claro)] hover:text-[var(--oro-rosa)] transition font-medium mt-3">Ver Posiciones</button>
                        @else
                            <button id="btn-time-trivia" disabled class="btn-romantic rounded-full !border-stone-300 !text-stone-400">
                                <i class="fas fa-lock mr-2"></i> En el Evento
                            </button>
                        @endif
                    </div>
                </div>

                {{-- BLOQUE MURO --}}
                <div class="bg-[var(--crema-suave)] border border-[var(--rosa-polvo)] rounded-[2rem] p-8 md:p-12 text-center group hover:shadow-xl transition-all duration-500 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope-open-text text-2xl text-[var(--oro-rosa)]"></i>
                        </div>
                        <h3 class="font-serif text-2xl md:text-3xl text-[var(--texto-oscuro)] mb-3">Muro de Deseos</h3>
                        <p class="text-[var(--texto-claro)] font-light text-xs md:text-sm mb-8 px-4">Déjanos un mensaje, un consejo o una foto para recordar siempre.</p>
                    </div>
                    <div id="wrapper-btn-muro" class="w-full max-w-xs mx-auto flex flex-col gap-3">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('muro')" class="btn-romantic btn-romantic-solid rounded-full">Escribir Deseo</button>
                            <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] text-[var(--texto-claro)] hover:text-[var(--oro-rosa)] transition font-medium mt-3">Ver Galería <i class="fa-solid fa-arrow-right ml-1"></i></button>
                        @else
                            <button id="btn-time-muro" disabled class="btn-romantic rounded-full !border-stone-300 !text-stone-400">
                                <i class="fas fa-lock mr-2"></i> En el Evento
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: MURO DE DESEOS VISUAL --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[var(--crema-suave)] overflow-y-auto">
        <div class="relative max-w-7xl w-full mx-auto px-4 md:px-8 py-16 md:py-24 z-10 min-h-[100svh] flex flex-col">
            <div class="text-center mb-12 md:mb-16">
                <span class="font-firma text-4xl md:text-5xl text-[var(--oro-rosa)] block mb-4">Nuestros Favoritos</span>
                <h2 class="text-4xl md:text-6xl font-serif text-[var(--texto-oscuro)]">Muro de Deseos</h2>
                <div class="divisor-elegante !bg-transparent"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 items-start w-full px-2 pb-10">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg border border-[var(--rosa-polvo)]/40 hover:-translate-y-2 transition duration-300 flex flex-col h-full">
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="mb-6 rounded-xl overflow-hidden aspect-[4/3] shadow-sm">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        @endif
                        <div class="flex-grow flex flex-col">
                            <i class="fas fa-quote-left text-[var(--rosa-polvo)] text-2xl mb-2"></i>
                            <p class="font-serif text-lg md:text-xl text-[var(--texto-oscuro)] leading-relaxed italic break-words flex-grow">"{{ $item->contenido_texto }}"</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[var(--rosa-polvo)]/30 flex items-center justify-between">
                            <span class="text-[10px] md:text-xs font-bold text-[var(--texto-claro)] tracking-widest uppercase">{{ $item->nombre_autor }}</span>
                            <i class="fas fa-heart text-[var(--oro-rosa)] text-[10px]"></i>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center p-10 md:p-16 bg-white rounded-3xl border border-dashed border-[var(--oro-rosa)]/30 mx-4">
                        <i class="fa-regular fa-envelope-open text-4xl text-[var(--rosa-polvo)] mb-4 block"></i>
                        <p class="text-xl md:text-2xl font-serif text-[var(--texto-oscuro)]">El buzón espera sus deseos.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-auto flex justify-center w-full pb-8">
                <button onclick="ocultarMuroVisual()" class="btn-romantic max-w-xs rounded-full">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Inicio
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: GALERÍA VISUAL UNIFICADA --}}
    <section class="section-romantic !h-auto py-20 min-h-[100svh] !block">
        <div class="floral-bg"></div>
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-16 mx-auto relative">
            
            <div class="text-center mb-12 w-full">
                <span class="font-firma text-3xl md:text-4xl text-[var(--oro-rosa)] mb-2 block">Recuerdos</span>
                <h2 class="text-4xl md:text-5xl font-serif text-[var(--texto-oscuro)]">Nuestra Galería</h2>
                <div class="divisor-elegante !bg-transparent"></div>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-[var(--rosa-polvo)]/50 gap-4">
                <span id="contador-seleccionadas" class="font-serif text-xl text-[var(--oro-rosa)] italic">
                    0 Seleccionadas
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="btn-romantic rounded-full !w-full sm:!w-auto !py-2.5">
                        <i class="fas fa-download mr-2"></i> Bajar Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-romantic btn-romantic-solid rounded-full !w-full sm:!w-auto !py-2.5">
                        <i class="fas fa-images mr-2"></i> Bajar Todo
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
                            'etiqueta' => 'INVITADOS'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[65vh] overflow-y-auto hide-scroll pb-6">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item aspect-square md:aspect-[4/5] relative group cursor-pointer rounded-xl overflow-hidden bg-white shadow-md border-2 border-transparent hover:border-[var(--oro-rosa)] transition-all duration-300" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/10 hover:bg-black/20 transition">
                                <i class="fas fa-play text-4xl text-white/90 group-hover:text-[var(--oro-rosa)] group-hover:scale-110 transition drop-shadow-md"></i>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover opacity-90" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-full object-cover">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[var(--oro-rosa)]/10 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-3 right-3 bg-white text-[var(--oro-rosa)] rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none">
                            <i class="fas fa-check text-xs"></i>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent pt-8 pb-3 px-3 text-white text-[9px] font-medium tracking-[0.2em] uppercase truncate text-center z-30 pointer-events-none">
                            <i class="fas {{ $foto['esVideo'] ? 'fa-video' : ($foto['esNube'] ? 'fa-cloud' : 'fa-camera') }} mr-1"></i>
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center border border-dashed border-[var(--rosa-polvo)] p-12 bg-white rounded-2xl">
                        <p class="text-[var(--texto-claro)] font-serif text-xl italic">Aún no hay memorias guardadas en la colección.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP --}}
    <section class="section-romantic bg-white relative">
        <div class="floral-bg"></div>
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 z-10 w-full max-w-3xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center justify-center w-full">
                <i class="fas fa-envelope-open-text text-4xl text-[var(--oro-rosa)] mb-6"></i>
                <h2 class="text-4xl md:text-6xl mb-6 font-serif text-[var(--texto-oscuro)]">¿Nos acompañas?</h2>
                <p class="text-sm md:text-lg text-[var(--texto-claro)] font-light mb-12 max-w-lg mx-auto leading-relaxed">
                    Sería un honor para nosotros contar con tu presencia en el comienzo de nuestra vida juntos.
                </p>
                
                <div id="contenedorBotonPrincipalRSVP" class="w-full flex justify-center">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-romantic btn-romantic-solid rounded-full max-w-xs md:max-w-sm text-sm !py-4 shadow-lg">
                            Confirmar Asistencia
                        </button>
                    @else
                        <div class="px-6 md:px-8 py-3 md:py-4 border border-[var(--rosa-polvo)] text-[10px] md:text-xs tracking-[0.2em] uppercase text-[var(--texto-claro)] w-full max-w-xs md:max-w-md bg-[var(--crema-suave)] rounded-full shadow-sm">
                            Código QR Requerido
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-col items-center gap-2 mt-12 md:mt-16 text-[9px] md:text-xs uppercase tracking-[0.2em] text-[var(--texto-claro)]">
                    <p>Mesa Asignada: <span class="font-bold text-[var(--oro-rosa)]">{{ $invitado->mesa_asignada ?? 'PENDIENTE' }}</span></p>
                    <p>Código de Vestimenta: Formal / Elegante</p>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-[var(--texto-claro)] mb-1.5 font-light">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono y texto que pasan a Oro Rosa en hover --}}
                        <i class="fas fa-heart text-[10px] md:text-xs text-[var(--texto-claro)] group-hover:text-[var(--oro-rosa)] transition-colors"></i>
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-[var(--texto-claro)] group-hover:text-[var(--oro-rosa)] transition-colors">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO Y CUESTIONARIO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-white/90 backdrop-blur-md p-4">
    <div id="wrapper-dinamico-modal" class="bg-white border border-[var(--rosa-polvo)] w-full max-w-lg p-8 md:p-12 text-center shadow-[0_20px_50px_rgba(183,110,121,0.15)] rounded-3xl relative overflow-hidden max-h-[95vh] overflow-y-auto">
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--rosa-polvo)]/50 pb-4 text-left">
                <h3 class="text-xl md:text-2xl font-serif text-[var(--texto-oscuro)]"><i class="fas fa-key text-[var(--oro-rosa)] text-lg mr-2"></i> Código de Invitado</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[var(--oro-rosa)] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-6 text-left">
                <p class="text-xs md:text-sm font-light text-[var(--texto-claro)] leading-relaxed">Para interactuar, ingresa el código personal que el sistema te entregó al confirmar tu asistencia.</p>
                <div>
                    <input type="text" id="inputCodigoIngreso" placeholder="EJ: JON-4819" class="w-full border-b border-[var(--texto-claro)] bg-transparent p-3 text-sm md:text-base font-medium tracking-widest outline-none uppercase text-[var(--texto-oscuro)] focus:border-[var(--oro-rosa)] transition text-center">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="btn-romantic btn-romantic-solid rounded-full mt-4 !py-3.5">
                    Validar Acceso
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO: MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-white/90 backdrop-blur-md p-4">
    <div class="bg-white border border-[var(--rosa-polvo)] rounded-3xl w-full max-w-lg p-8 md:p-10 text-left shadow-[0_20px_50px_rgba(183,110,121,0.15)] relative overflow-y-auto max-h-[95vh]">
        <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--rosa-polvo)]/50 pb-4">
            <h3 class="text-2xl md:text-3xl font-serif text-[var(--texto-oscuro)]">Dejar un Deseo</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-stone-400 hover:text-[var(--oro-rosa)] transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            
            <div>
                <label class="block text-[10px] md:text-[11px] font-semibold uppercase tracking-widest text-[var(--texto-claro)] mb-2">Tu Nombre</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border border-[var(--rosa-polvo)] bg-[var(--crema-suave)] p-3 rounded-xl text-xs md:text-sm font-medium outline-none text-[var(--texto-oscuro)]">
            </div>
             <div>
                <label class="block text-[10px] md:text-[11px] font-semibold uppercase tracking-widest text-[var(--texto-claro)] mb-2">Relación *</label>
                <select name="vinculo_autor" required class="w-full border border-[var(--rosa-polvo)] bg-white p-3 rounded-xl text-xs md:text-sm font-medium outline-none text-[var(--texto-oscuro)] focus:border-[var(--oro-rosa)]">
                    <option value="" disabled selected>Seleccionar...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero">Compañero</option>
                    <option value="Conocido/a">Conocido</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] font-semibold uppercase tracking-widest text-[var(--texto-claro)] mb-2">Tu Mensaje *</label>
                <textarea name="contenido" rows="4" required class="w-full border border-[var(--rosa-polvo)] bg-white p-3 rounded-xl text-xs md:text-sm font-light outline-none focus:border-[var(--oro-rosa)] text-[var(--texto-oscuro)] resize-none" placeholder="Escribe tus mejores deseos..."></textarea>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] font-semibold uppercase tracking-widest text-[var(--texto-claro)] mb-2">Foto (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" class="w-full text-[10px] md:text-xs text-[var(--texto-claro)] border border-[var(--rosa-polvo)] rounded-xl p-2 bg-white file:border-0 file:bg-[var(--crema-suave)] file:text-[var(--oro-rosa)] file:px-4 file:py-2 file:rounded-lg file:font-semibold cursor-pointer">
            </div>
            <button type="submit" id="btnPublicarMuroBoda" class="btn-romantic btn-romantic-solid rounded-full w-full mt-4 !py-3">
                Publicar Mensaje
            </button>
        </form>
    </div>
</div>

{{-- MODAL ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-white/90 backdrop-blur-md p-4">
    <div class="bg-white border border-[var(--rosa-polvo)] rounded-3xl max-w-lg w-[95%] md:w-full p-6 md:p-10 text-center shadow-[0_20px_50px_rgba(183,110,121,0.15)] max-h-[95vh] overflow-y-auto animate-fade-in">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--rosa-polvo)]/50 pb-4 text-left">
                <h3 class="text-2xl md:text-3xl font-serif text-[var(--texto-oscuro)]">Registro de Asistencia</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-[var(--oro-rosa)] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-5 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-[var(--crema-suave)] p-5 rounded-2xl border border-[var(--rosa-polvo)]/50 space-y-4">
                    <span class="text-[10px] md:text-xs font-semibold uppercase tracking-widest text-[var(--oro-rosa)] block"><i class="fas fa-user mr-2"></i> Invitado Principal</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Nombre Completo *" required class="w-full border-b border-[var(--texto-claro)] bg-transparent py-2 text-sm font-medium outline-none focus:border-[var(--oro-rosa)] text-[var(--texto-oscuro)]">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" placeholder="Correo (Opcional)" class="w-full border-b border-[var(--texto-claro)] bg-transparent py-2 text-sm font-medium outline-none focus:border-[var(--oro-rosa)] text-[var(--texto-oscuro)]">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 md:py-4 bg-transparent border border-dashed border-[var(--oro-rosa)] text-[var(--oro-rosa)] rounded-xl text-xs md:text-sm font-semibold uppercase tracking-wider hover:bg-[var(--oro-rosa)] hover:text-white transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Añadir Acompañante
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-romantic btn-romantic-solid rounded-full w-full !text-sm !py-4 mt-6">
                    Confirmar Lugares
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-white/90 backdrop-blur-md p-4">
    <div class="bg-white rounded-3xl border border-[var(--rosa-polvo)] w-full max-w-lg p-6 md:p-10 text-center shadow-[0_20px_50px_rgba(183,110,121,0.15)] relative max-h-[95vh] flex flex-col">
        
        <div class="flex justify-between items-center mb-6 border-b border-[var(--rosa-polvo)]/50 pb-4 shrink-0 text-left">
            <h3 class="text-2xl font-serif text-[var(--texto-oscuro)]">
                <i class="fas fa-award mr-2 text-[var(--oro-rosa)]"></i> Ranking de Pareja
            </h3>
            <button onclick="cerrarModalRanking()" class="text-stone-400 hover:text-[var(--oro-rosa)] transition"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-2 space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-circle-notch fa-spin text-3xl text-[var(--oro-rosa)]"></i>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[var(--rosa-polvo)]/50 shrink-0">
            <button onclick="cerrarModalRanking()" class="btn-romantic btn-romantic-solid rounded-full w-full !py-3">
                Cerrar Ranking
            </button>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/50 hover:text-white transition z-50">
        <i class="fas fa-times text-3xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-lg overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
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
        const horaEvento = "{{ $evento->hora ?? '18:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<div class='text-2xl md:text-3xl font-serif text-[var(--oro-rosa)] italic py-4 text-center w-full'>Celebremos el Amor</div>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-romantic rounded-full">Jugar Ahora</button>
                        <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] text-[var(--texto-claro)] hover:text-[var(--oro-rosa)] transition font-medium mt-3">Ver Posiciones</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="btn-romantic btn-romantic-solid rounded-full">Escribir Deseo</button>
                        <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-[0.2em] text-[var(--texto-claro)] hover:text-[var(--oro-rosa)] transition font-medium mt-3">Ver Galería <i class="fa-solid fa-arrow-right ml-1"></i></button>
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
        document.getElementById('wrapper-dinamico-modal').className = "bg-white border border-[var(--rosa-polvo)] w-full max-w-lg p-8 md:p-12 text-center shadow-[0_20px_50px_rgba(183,110,121,0.15)] rounded-3xl relative overflow-hidden max-h-[95vh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--rosa-polvo)]/50 pb-4 text-left">
                    <h3 class="text-xl md:text-2xl font-serif text-[var(--texto-oscuro)]"><i class="fas fa-key text-[var(--oro-rosa)] text-lg mr-2"></i> Código de Invitado</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[var(--oro-rosa)] transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-6 text-left">
                    <p class="text-xs md:text-sm font-light text-[var(--texto-claro)] leading-relaxed">Para interactuar, ingresa el código personal que el sistema te entregó al confirmar tu asistencia.</p>
                    <div>
                        <input type="text" id="inputCodigoIngreso" placeholder="EJ: JON-4819" class="w-full border-b border-[var(--texto-claro)] bg-transparent p-3 text-sm md:text-base font-medium tracking-widest outline-none uppercase text-[var(--texto-oscuro)] focus:border-[var(--oro-rosa)] transition text-center">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="btn-romantic btn-romantic-solid rounded-full mt-4 !py-3.5">
                        Validar Acceso
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() { document.getElementById('modalFiltroAcceso').classList.add('hidden'); }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("El código es requerido."); return; }

        const btnVerificar = document.getElementById('btnVerificarCodigo');
        const txtOriginalVerificar = btnVerificar.innerHTML;
        
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Validando...';

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
                    wrapper.className = "bg-white border border-[var(--rosa-polvo)] w-full max-w-lg p-8 md:p-12 text-center shadow-2xl rounded-3xl relative";
                    wrapper.innerHTML = `
                        <div class="py-6 text-center space-y-6 animate-pop">
                            <i class="fas fa-heart text-4xl text-[var(--oro-rosa)] mb-2"></i>
                            <h3 class="text-2xl font-serif text-[var(--texto-oscuro)]">Juego Completado</h3>
                            <p class="text-sm font-light text-[var(--texto-claro)] px-4">${data.message}</p>
                            <div class="pt-6 space-y-3">
                                <button onclick="verRanking()" class="btn-romantic btn-romantic-solid rounded-full w-full">Ver Puntuaciones</button>
                                <button onclick="cerrarModalFiltro()" class="btn-romantic rounded-full w-full">Cerrar</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Invitado Especial" };
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Invitado Especial" ? data.nombre_invitado : "Invitado";
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => { 
            if (err.message !== "already_handled") { console.error("Fallo:", err); }
            if (btnVerificar) {
                btnVerificar.disabled = false;
                btnVerificar.classList.remove('opacity-50', 'cursor-not-allowed');
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
        botonPublicar.classList.add('opacity-50', 'cursor-not-allowed');
        botonPublicar.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...`;

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
                alert(data.message || "Error al verificar la clave.");
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
                    <div class="py-8 text-center space-y-6 animate-pop">
                        <div class="w-16 h-16 bg-[var(--oro-rosa)]/10 rounded-full flex items-center justify-center mx-auto border border-[var(--oro-rosa)]/30">
                            <i class="fas fa-check text-2xl text-[var(--oro-rosa)]"></i>
                        </div>
                        <h3 class="text-3xl font-serif text-[var(--texto-oscuro)]">¡Mensaje Publicado!</h3>
                        <p class="text-sm font-light text-[var(--texto-claro)] px-4 leading-relaxed">${data.message}</p>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="btn-romantic btn-romantic-solid rounded-full w-full mt-6">Aceptar</button>
                    </div>
                `;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.className = "bg-white border border-[var(--rosa-polvo)] w-full max-w-lg p-8 md:p-12 text-center shadow-2xl rounded-3xl relative";
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 animate-pop">
                <i class="fas fa-rings text-[var(--oro-rosa)] text-4xl mb-2 opacity-80"></i>
                <h1 class="text-2xl md:text-3xl font-serif text-[var(--texto-oscuro)]">¡Hola, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-[var(--texto-claro)] text-sm font-light leading-relaxed px-2">Demuestra cuánto conoces nuestra historia de amor. Responderás <strong class="text-[var(--oro-rosa)] font-medium">${bancoPreguntas.length} preguntas</strong>. ¡Diviértete!</p>
                <button onclick="comenzarJuegoModal()" class="btn-romantic btn-romantic-solid rounded-full w-full mt-4 !py-3.5">Comenzar</button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-semibold uppercase tracking-widest text-[var(--texto-claro)] border-b border-[var(--rosa-polvo)]/50 pb-4">
                    <span id="info-progreso">PREGUNTA 1 DE X</span>
                    <span class="text-[var(--oro-rosa)]"><i class="fas fa-clock mr-1"></i> <span id="info-cronometro" class="font-mono text-sm">0</span>s</span>
                </div>
                <h2 id="texto-pregunta" class="text-xl md:text-2xl font-serif text-[var(--texto-oscuro)] leading-snug">Cargando...</h2>
                <div class="space-y-3 pt-2">
                    <button onclick="seleccionarOpcionModal('a')" class="w-full text-left p-4 border border-[var(--rosa-polvo)]/60 bg-white hover:bg-[var(--crema-suave)] hover:border-[var(--oro-rosa)] rounded-xl transition flex items-center space-x-4 text-[var(--texto-oscuro)] group">
                        <span class="w-8 h-8 rounded-full border border-[var(--oro-rosa)]/30 text-[var(--oro-rosa)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--oro-rosa)] group-hover:text-white transition-colors">A</span>
                        <span id="texto-opcion-a" class="font-light text-sm break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" class="w-full text-left p-4 border border-[var(--rosa-polvo)]/60 bg-white hover:bg-[var(--crema-suave)] hover:border-[var(--oro-rosa)] rounded-xl transition flex items-center space-x-4 text-[var(--texto-oscuro)] group">
                        <span class="w-8 h-8 rounded-full border border-[var(--oro-rosa)]/30 text-[var(--oro-rosa)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--oro-rosa)] group-hover:text-white transition-colors">B</span>
                        <span id="texto-opcion-b" class="font-light text-sm break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" class="w-full text-left p-4 border border-[var(--rosa-polvo)]/60 bg-white hover:bg-[var(--crema-suave)] hover:border-[var(--oro-rosa)] rounded-xl transition flex items-center space-x-4 text-[var(--texto-oscuro)] group">
                        <span class="w-8 h-8 rounded-full border border-[var(--oro-rosa)]/30 text-[var(--oro-rosa)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--oro-rosa)] group-hover:text-white transition-colors">C</span>
                        <span id="texto-opcion-c" class="font-light text-sm break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" class="w-full text-left p-4 border border-[var(--rosa-polvo)]/60 bg-white hover:bg-[var(--crema-suave)] hover:border-[var(--oro-rosa)] rounded-xl transition flex items-center space-x-4 text-[var(--texto-oscuro)] group">
                        <span class="w-8 h-8 rounded-full border border-[var(--oro-rosa)]/30 text-[var(--oro-rosa)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--oro-rosa)] group-hover:text-white transition-colors">D</span>
                        <span id="texto-opcion-d" class="font-light text-sm break-words">Opción D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-[var(--texto-claro)] font-light text-sm">Sin datos en el servidor.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `PREGUNTA ${preguntaActualIndex + 1} DE ${bancoPreguntas.length}`;
        document.getElementById('texto-pregunta').innerText = q.pregunta;
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
            <div class="text-center space-y-4 py-10 animate-pop">
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--oro-rosa)] mb-2"></i>
                <h3 class="text-xl font-serif text-[var(--texto-oscuro)]">Guardando...</h3>
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
                    <div class="text-center space-y-6 py-4 animate-pop">
                        <i class="fas fa-check-circle text-5xl text-[var(--oro-rosa)] mb-2"></i>
                        <h3 class="text-3xl font-serif text-[var(--texto-oscuro)]">¡Terminado!</h3>
                        <p class="text-xs font-light text-[var(--texto-claro)] px-4">Gracias por participar en nuestra historia.</p>
                        <div class="flex justify-center gap-4 mt-6">
                            <div class="text-center border border-[var(--rosa-polvo)] p-4 rounded-2xl bg-[var(--crema-suave)] w-28 shadow-sm">
                                <span class="block text-[9px] font-bold uppercase tracking-widest text-[var(--texto-claro)] mb-1">Aciertos</span>
                                <span class="text-2xl font-serif text-[var(--oro-rosa)]">${puntajeAcumulado}</span>
                            </div>
                            <div class="text-center border border-[var(--rosa-polvo)] p-4 rounded-2xl bg-[var(--crema-suave)] w-28 shadow-sm">
                                <span class="block text-[9px] font-bold uppercase tracking-widest text-[var(--texto-claro)] mb-1">Tiempo</span>
                                <span class="text-2xl font-serif text-[var(--oro-rosa)]">${segundosTranscurridos}s</span>
                            </div>
                        </div>
                        <div class="pt-6 space-y-3">
                            <button onclick="cerrarModalFiltro()" class="btn-romantic btn-romantic-solid rounded-full w-full">Finalizar</button>
                        </div>
                    </div>
                `;
            }
        }).catch(err => { wrapper.innerHTML = `<p class="text-red-500 font-medium">Error de conexión.</p>`; });
    }

    let contadorAcompanantes = 0;
    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-white p-4 rounded-2xl border border-[var(--rosa-polvo)]/50 space-y-3 relative animate-fade-in shadow-sm";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-[var(--rosa-polvo)]/30 pb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-[var(--texto-claro)]">Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-red-400 hover:text-red-600 text-[10px] font-semibold uppercase transition"><i class="fas fa-times mr-1"></i> Quitar</button>
            </div>
            <input type="text" class="input-nombre-acompanante w-full border-b border-[var(--texto-claro)] bg-transparent py-2 text-sm font-medium outline-none focus:border-[var(--oro-rosa)] text-[var(--texto-oscuro)]" placeholder="Nombre Completo *" required>
            <input type="email" class="input-email-acompanante w-full border-b border-[var(--texto-claro)] bg-transparent py-2 text-sm font-medium outline-none focus:border-[var(--oro-rosa)] text-[var(--texto-oscuro)]" placeholder="Correo (Opcional)">
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
        btnConfirmar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Procesando...';

        const nodosNombres = document.querySelectorAll('.input-nombre-acompanante');
        const nodosEmails = document.querySelectorAll('.input-email-acompanante');
        const listaAcompanantes = Array.from(nodosNombres).map((input, i) => ({ nombre: input.value.trim(), email: nodosEmails[i]?.value.trim() || '' })).filter(a => a.nombre !== "");
        const dataPayload = { token_acceso: document.getElementById('inputHiddenToken').value, nombre_invitado: document.getElementById('inputNombrePrincipal').value.trim(), email: document.getElementById('inputEmailPrincipal').value.trim(), acompanantes: listaAcompanantes };

        fetch('/invitacion/confirmar-asistencia', { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify(dataPayload) })
        .then(async response => {
            const data = await response.json();
            if (response.status === 422 && data.already_registered) {
                document.getElementById('cuerpoInternoModalAsistencia').innerHTML = `
                    <div class="py-8 text-center space-y-4 animate-fade-in">
                        <i class="fas fa-info-circle text-4xl text-[var(--oro-rosa)] mb-2 opacity-80"></i>
                        <h3 class="text-2xl font-serif text-[var(--texto-oscuro)]">Asistencia Registrada</h3>
                        <p class="text-sm font-light text-[var(--texto-claro)] px-4 leading-relaxed">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-romantic rounded-full mt-6">Cerrar</button>
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
                    <div class="py-6 text-center space-y-6 animate-fade-in">
                        <i class="fas fa-check text-4xl text-[var(--oro-rosa)] mb-2"></i>
                        <h3 class="text-3xl font-serif text-[var(--texto-oscuro)]">¡Nos Vemos Pronto!</h3>
                        <p class="text-xs font-light text-[var(--texto-claro)]">Guarda este código, será tu llave digital.</p>
                        <div class="bg-[var(--crema-suave)] border border-[var(--rosa-polvo)] p-5 rounded-2xl text-left shadow-sm mt-4">
                            <p class="text-[9px] uppercase font-bold tracking-widest text-[var(--oro-rosa)] border-b border-[var(--rosa-polvo)]/50 pb-2 mb-3">Tus Códigos</p>
                            <div class="space-y-3">
                                ${data.codigos.map(item => `
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-[11px] text-[var(--texto-oscuro)] tracking-wide uppercase">${item.nombre}</span> 
                                        <span class="bg-white border border-[var(--rosa-polvo)] text-[var(--texto-oscuro)] px-3 py-1 rounded-lg text-xs font-bold tracking-widest shadow-sm">${item.codigo}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-romantic btn-romantic-solid rounded-full w-full mt-6">Aceptar</button>
                    </div>
                `;
                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-8 py-3 border border-[var(--oro-rosa)] text-[10px] md:text-xs tracking-[0.2em] uppercase text-[var(--oro-rosa)] w-full max-w-xs md:max-w-md bg-[var(--crema-suave)] rounded-full text-center">
                        <i class="fas fa-check mr-2"></i> Asistencia Confirmada
                    </div>
                `;
            }
        }).catch(error => { 
            if (error.message !== "already_handled") { alert("Error en comunicación."); }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-50', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- LÓGICA DEL RANKING ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-circle-notch fa-spin text-3xl text-[var(--oro-rosa)]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-[var(--texto-claro)] font-light text-center text-sm mt-10">Aún no hay puntuaciones registradas.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-lg text-[var(--texto-claro)] font-serif mr-4 w-6 text-center">#${index + 1}</span>`;
                        let resplandor = 'border-[var(--rosa-polvo)]/50';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-heart text-[var(--oro-rosa)] text-2xl mr-4 w-6 text-center"></i>';
                            resplandor = 'border-[var(--oro-rosa)] bg-[var(--crema-suave)] shadow-md';
                        } else if(index === 1) {
                            medalla = '<i class="fa-regular fa-heart text-[var(--oro-rosa)]/70 text-xl mr-4 w-6 text-center"></i>';
                            resplandor = 'border-[var(--rosa-polvo)] bg-white';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-4 rounded-2xl animate-fade-in mb-3">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-medium text-sm md:text-base text-[var(--texto-oscuro)] truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[var(--oro-rosa)] font-serif text-xl leading-none">${jugador.puntaje_total} <span class="text-[9px] font-sans font-medium text-[var(--texto-claro)] uppercase">pts</span></span>
                                    <span class="block text-[9px] text-[var(--texto-claro)] font-medium tracking-widest uppercase mt-1">${jugador.tiempo_empleado} seg</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-400 font-medium text-center mt-10 text-sm">Error de conexión.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-400 font-medium text-center mt-10 text-sm">Fallo de comunicación.</p>';
        });
    }

    function cerrarModalRanking() { document.getElementById('modalRanking').classList.add('hidden'); }

    // --- SISTEMA MULTIMEDIA ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-transparent', 'border-[var(--oro-rosa)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--oro-rosa)]', 'border-transparent');
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

    function playPreview(elemento) { const vid = elemento.querySelector('.vid-preview'); if(vid) { vid.play().catch(e => console.log('Autoplay prevenido')); } }
    function pausePreview(elemento) { const vid = elemento.querySelector('.vid-preview'); if(vid) { vid.pause(); } }

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
        if (seleccionadas.length === 0) { alert("Por favor, selecciona alguna foto para descargar."); return; }
        seleccionadas.forEach((item, index) => { setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000); });
        seleccionadas.forEach(item => toggleSeleccion(item));
    }

    function descargarTodas() {
        const todas = document.querySelectorAll('.foto-item');
        if (todas.length === 0) { alert("No hay recuerdos en la galería aún."); return; }
        todas.forEach((item, index) => { setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000); });
    }
</script>
</body>
</html>