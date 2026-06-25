<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Noche Mágica</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --magic-dark: #0a0a16;
            --magic-purple: #1a0b2e;
            --magic-blue: #0f1c3f;
            --magic-gold: #d4af37;
            --magic-glow: rgba(212, 175, 55, 0.6);
        }

        h1, h2, h3, .font-magic { font-family: 'Cinzel Decorative', serif; }
        body { font-family: 'Cormorant Garamond', serif; background-color: var(--magic-dark); color: #e2e8f0; scroll-behavior: smooth; overflow-x: hidden; }

        .snap-container { height: 100svh; overflow-y: scroll; scroll-snap-type: y mandatory; overflow-x: hidden; }
        
        .section-magic { 
            min-height: 100svh; 
            width: 100%; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            position: relative; 
            scroll-snap-align: start; 
            overflow: hidden; 
            background: radial-gradient(circle at center, var(--magic-purple) 0%, var(--magic-dark) 100%);
            padding: 4rem 1.5rem; 
        }

        /* EFECTO 1: POLVO DE ESTRELLAS (Cielo Mágico) */
        .stars-bg {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 40px 70px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 50px 160px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 90px 40px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 130px 80px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 160px 120px, #ffffff, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 200px 200px;
            animation: twinkle 5s infinite linear;
        }
        @keyframes twinkle {
            0% { opacity: 0.5; } 50% { opacity: 1; } 100% { opacity: 0.5; }
        }

        /* EFECTO 2: NIEBLA ENCANTADA */
        .fog-bg {
            position: absolute; inset: 0; z-index: 1; pointer-events: none;
            background: radial-gradient(circle at 50% 120%, rgba(212,175,55,0.1) 0%, transparent 50%);
            filter: blur(40px);
        }

        /* EFECTO 3: LEVITACIÓN MAGNÉTICA */
        .levitate {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* EFECTO 4: TEXTO ENCANTADO Y GLOW */
        .text-glow {
            text-shadow: 0 0 10px var(--magic-glow), 0 0 20px var(--magic-glow);
            color: var(--magic-gold);
        }
        .box-glow {
            box-shadow: 0 0 15px rgba(212,175,55,0.2), inset 0 0 15px rgba(212,175,55,0.1);
            border: 1px solid rgba(212,175,55,0.3);
            background: rgba(10,10,22,0.6);
            backdrop-filter: blur(10px);
        }

        /* DIVISOR VARITA MÁGICA */
        .wand-divider {
            width: 100px; height: 2px;
            background: linear-gradient(90deg, transparent, var(--magic-gold), transparent);
            margin: 2rem auto; position: relative;
        }
        .wand-divider::before {
            content: '✧'; position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            color: var(--magic-gold); font-size: 1.2rem; text-shadow: 0 0 10px var(--magic-gold);
            animation: pulse-star 2s infinite;
        }
        @keyframes pulse-star { 0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.8; } 50% { transform: translateX(-50%) scale(1.3); opacity: 1; } }

        /* BOTONES DE CONJURO */
        .btn-magic {
            background: linear-gradient(45deg, transparent, rgba(212,175,55,0.1), transparent);
            color: var(--magic-gold);
            border: 1px solid var(--magic-gold);
            padding: 12px 25px;
            font-family: 'Cinzel Decorative', serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
            text-align: center;
            display: inline-block;
            box-shadow: 0 0 10px rgba(212,175,55,0.1);
        }
        @media (min-width: 768px) { .btn-magic { width: auto; font-size: 1rem; padding: 15px 40px; } }
        
        .btn-magic::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s ease;
        }
        .btn-magic:hover {
            background-color: rgba(212,175,55,0.2);
            box-shadow: 0 0 20px rgba(212,175,55,0.5);
            text-shadow: 0 0 5px var(--magic-gold);
        }
        .btn-magic:hover::before { left: 100%; }
        .btn-magic:disabled { opacity: 0.5; filter: grayscale(1); cursor: not-allowed; }

        .btn-magic-solid { background: var(--magic-gold); color: #000; font-weight: bold; }
        .btn-magic-solid:hover { background: #fff; color: var(--magic-gold); }

        .animate-pop { animation: popIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes popIn { 0% { opacity: 0; transform: translateY(20px) scale(0.95); filter: blur(5px); } 100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); } }
        
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

    {{-- SECCIÓN 1: INVOCACIÓN (HERO) --}}
    <section class="section-magic !p-0">
        <div class="stars-bg"></div>
        <div class="fog-bg"></div>
        
        <div class="absolute inset-0 z-0">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                     class="w-full h-full object-cover opacity-30 mix-blend-luminosity">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[var(--magic-dark)]/50 to-[var(--magic-dark)] z-0"></div>
        </div>
        
        <div class="z-10 text-center max-w-5xl px-4 flex flex-col items-center w-full justify-center h-full levitate">
            <span class="font-magic text-sm md:text-xl tracking-[0.4em] md:tracking-[0.6em] text-[var(--magic-gold)] mb-4 md:mb-6 uppercase">Un Encuentro Mágico</span>
            
            <h1 class="text-5xl sm:text-7xl md:text-[100px] leading-none mb-6 text-white font-magic text-glow w-full break-words">
                {{ $evento->nombre_evento }}
            </h1>

            <div class="wand-divider"></div>

            <p class="text-xl md:text-3xl font-light tracking-widest text-stone-300 italic mb-10 md:mb-16">
                {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d \d\e F, Y') }}
            </p>

            {{-- CONTADOR RUNAS --}}
            <div id="countdown" class="flex flex-wrap gap-4 sm:gap-6 md:gap-10 w-full justify-center">
                <div class="box-glow p-4 md:p-6 rounded-t-full w-20 md:w-28 flex flex-col items-center">
                    <span id="days" class="text-3xl md:text-5xl font-magic text-white">00</span>
                    <span class="text-[9px] md:text-xs tracking-widest text-[var(--magic-gold)] mt-2 uppercase">Lunas</span>
                </div>
                <div class="box-glow p-4 md:p-6 rounded-t-full w-20 md:w-28 flex flex-col items-center">
                    <span id="hours" class="text-3xl md:text-5xl font-magic text-white">00</span>
                    <span class="text-[9px] md:text-xs tracking-widest text-[var(--magic-gold)] mt-2 uppercase">Horas</span>
                </div>
                <div class="box-glow p-4 md:p-6 rounded-t-full w-20 md:w-28 flex flex-col items-center">
                    <span id="minutes" class="text-3xl md:text-5xl font-magic text-white">00</span>
                    <span class="text-[9px] md:text-xs tracking-widest text-[var(--magic-gold)] mt-2 uppercase">Min</span>
                </div>
                <div class="box-glow p-4 md:p-6 rounded-t-full w-20 md:w-28 flex flex-col items-center border-[var(--magic-gold)]/80">
                    <span id="seconds" class="text-3xl md:text-5xl font-magic text-white text-glow">00</span>
                    <span class="text-[9px] md:text-xs tracking-widest text-white mt-2 uppercase">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: LA PROFECÍA (HISTORIA) --}}
    <section class="section-magic bg-[var(--magic-dark)]">
        <div class="stars-bg" style="animation-direction: reverse;"></div>
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-20 items-center z-10 px-4 md:px-8">
            <div class="relative w-full max-w-[280px] sm:max-w-xs md:max-w-md mx-auto order-2 lg:order-1 levitate" style="animation-delay: 1s;">
                @if($evento->fotosGaleria->count() > 1)
                    <div class="aspect-[3/4] w-full rounded-full p-2 border-2 border-[var(--magic-gold)]/50 box-glow">
                        <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" class="w-full h-full object-cover rounded-full grayscale hover:grayscale-0 transition-all duration-1000">
                    </div>
                @else
                    <div class="aspect-[3/4] w-full rounded-full p-2 border-2 border-[var(--magic-gold)]/50 box-glow flex items-center justify-center bg-black/50">
                        <i class="fa-solid fa-moon text-6xl text-[var(--magic-gold)] opacity-50"></i>
                    </div>
                @endif
                <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[var(--magic-dark)] border border-[var(--magic-gold)] px-6 py-2 rounded-full shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                    <span class="font-magic text-lg text-[var(--magic-gold)] tracking-widest">El Relato</span>
                </div>
            </div>
            
            <div class="space-y-6 md:space-y-8 text-center lg:text-left order-1 lg:order-2">
                <span class="text-xs md:text-sm uppercase tracking-[0.4em] text-[var(--magic-gold)] opacity-80"><i class="fas fa-sparkles mr-2"></i>Escrito en las estrellas</span>
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-magic text-white leading-tight">La Profecía</h2>
                <div class="wand-divider lg:ml-0"></div>
                <p class="text-lg md:text-2xl leading-relaxed text-stone-300 font-light italic">
                    "{!! nl2br(e($evento->biografia_resumen)) !!}"
                </p>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="section-magic bg-[var(--magic-purple)]">
        <div class="stars-bg opacity-30"></div>
        <div class="text-center z-10 px-4 w-[95%] max-w-4xl mx-auto box-glow p-10 md:p-16 rounded-3xl">
            <i class="fa-brands fa-galactic-senate text-5xl md:text-6xl text-white text-glow mb-6 animate-pulse"></i>
            <h2 class="text-3xl sm:text-4xl md:text-5xl mb-6 font-magic text-[var(--magic-gold)] tracking-widest uppercase">Coordenadas Místicas</h2>
            <div class="wand-divider"></div>
            
            <p class="text-stone-300 text-lg md:text-2xl mb-10 font-light leading-relaxed px-4 italic">
                {{ $evento->ubicacion_texto }}
            </p>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center mt-4">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-magic max-w-xs md:max-w-sm rounded-full">
                    Activar Portal de Viaje <i class="fas fa-compass ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES (RITUALES) --}}
    <section class="section-magic bg-[var(--magic-dark)] !py-20 h-auto min-h-[100svh]">
        <div class="stars-bg"></div>
        <div class="max-w-6xl w-full px-4 flex flex-col justify-center h-full mx-auto z-10">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-3xl sm:text-4xl md:text-6xl font-magic text-white text-glow uppercase tracking-widest">Rituales de la Noche</h2>
                <div class="wand-divider"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                {{-- TRIVIA --}}
                <div class="box-glow rounded-3xl p-8 md:p-12 text-center group hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <i class="fas fa-hat-wizard text-5xl text-[var(--magic-gold)] mb-6 drop-shadow-md group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-magic text-2xl md:text-3xl text-white mb-3 tracking-widest">Prueba de Sabiduría</h3>
                        <p class="text-stone-400 font-light text-sm mb-8 px-4 italic">¿Eres un maestro o un aprendiz? Resuelve los acertijos que hemos preparado.</p>
                    </div>
                    <div id="wrapper-btn-trivia" class="w-full max-w-xs mx-auto flex flex-col gap-4">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-magic btn-magic-solid rounded-full">Invocar Desafío</button>
                            <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--magic-gold)] hover:text-white transition font-bold mt-2">Ver Rango de Magos</button>
                        @else
                            <button id="btn-time-trivia" disabled class="btn-magic rounded-full !border-stone-600 !text-stone-500">
                                <i class="fas fa-lock mr-2"></i> Sello Intacto
                            </button>
                        @endif
                    </div>
                </div>

                {{-- MURO --}}
                <div class="box-glow rounded-3xl p-8 md:p-12 text-center group hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <i class="fas fa-scroll text-5xl text-[var(--magic-gold)] mb-6 drop-shadow-md group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-magic text-2xl md:text-3xl text-white mb-3 tracking-widest">Grimorio de Deseos</h3>
                        <p class="text-stone-400 font-light text-sm mb-8 px-4 italic">Plasma tus mejores deseos en el pergamino eterno de esta celebración.</p>
                    </div>
                    <div id="wrapper-btn-muro" class="w-full max-w-xs mx-auto flex flex-col gap-4">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('muro')" class="btn-magic rounded-full">Escribir Conjuro</button>
                            <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--magic-gold)] hover:text-white transition font-bold mt-2">Leer Grimorio <i class="fa-solid fa-arrow-right ml-1"></i></button>
                        @else
                            <button id="btn-time-muro" disabled class="btn-magic rounded-full !border-stone-600 !text-stone-500">
                                <i class="fas fa-lock mr-2"></i> Sello Intacto
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: GRIMORIO VISUAL (MURO) --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[#0a0a16] overflow-y-auto">
        <div class="stars-bg opacity-50"></div>
        <div class="relative max-w-7xl w-full mx-auto px-4 md:px-8 py-16 md:py-24 z-10 min-h-[100svh] flex flex-col">
            <div class="text-center mb-12 md:mb-16">
                <i class="fas fa-book-journal-whills text-5xl text-[var(--magic-gold)] mb-4 text-glow"></i>
                <h2 class="text-4xl md:text-6xl font-magic text-white tracking-widest uppercase">El Gran Grimorio</h2>
                <div class="wand-divider"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 items-start w-full px-2 pb-10">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="box-glow p-6 md:p-8 rounded-2xl hover:-translate-y-2 transition duration-300 flex flex-col h-full border-t border-[var(--magic-gold)]/50">
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="mb-6 rounded-lg overflow-hidden aspect-[4/3] shadow-[0_0_10px_rgba(212,175,55,0.2)] border border-[var(--magic-gold)]/20 p-1">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 filter sepia-[0.3]">
                            </div>
                        @endif
                        <div class="flex-grow flex flex-col">
                            <p class="font-serif text-lg md:text-xl text-stone-200 leading-relaxed italic break-words flex-grow">"{{ $item->contenido_texto }}"</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[var(--magic-gold)]/20 flex items-center justify-between">
                            <span class="text-[10px] md:text-xs font-bold text-[var(--magic-gold)] tracking-widest uppercase font-magic">{{ $item->nombre_autor }}</span>
                            <i class="fas fa-sparkles text-white text-[10px]"></i>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center p-10 md:p-16 box-glow rounded-3xl mx-4 border-dashed">
                        <p class="text-xl md:text-2xl font-magic text-[var(--magic-gold)] tracking-widest">Las páginas están en blanco. Escribe el primer hechizo.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-auto flex justify-center w-full pb-8">
                <button onclick="ocultarMuroVisual()" class="btn-magic max-w-xs rounded-full">
                    <i class="fas fa-arrow-left mr-2"></i> Cerrar Grimorio
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: EL ESPEJO DE LAS ILUSIONES (GALERÍA CLOUD) --}}
    <section class="section-magic bg-[var(--magic-purple)] !h-auto py-20 min-h-[100svh] !block">
        <div class="stars-bg opacity-30"></div>
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-16 mx-auto relative">
            
            <div class="text-center mb-12 w-full">
                <i class="fas fa-gem text-3xl text-[var(--magic-gold)] mb-4 animate-pulse"></i>
                <h2 class="text-4xl md:text-5xl font-magic text-white uppercase tracking-widest text-glow">Espejo de Ilusiones</h2>
                <div class="wand-divider"></div>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 box-glow p-4 md:p-6 rounded-2xl gap-4">
                <span id="contador-seleccionadas" class="font-magic text-lg text-[var(--magic-gold)] tracking-widest">
                    0 RECUERDOS ATTRAPADOS
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border border-[var(--magic-gold)] text-[var(--magic-gold)] px-6 py-2.5 hover:bg-[var(--magic-gold)] hover:text-black transition uppercase tracking-widest w-full sm:w-auto rounded-full">
                        Extraer Reliquias
                    </button>
                    <button onclick="descargarTodas()" class="btn-magic btn-magic-solid rounded-full !w-full sm:!w-auto !py-2.5">
                        <i class="fas fa-bolt mr-2"></i> Extraer Todo
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
                                'etiqueta' => 'VISIÓN PRINCIPAL'
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
                            'etiqueta' => 'VISIÓN COMPARTIDA'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[65vh] overflow-y-auto hide-scroll pb-6">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item aspect-square md:aspect-[4/5] relative group cursor-pointer rounded-xl overflow-hidden box-glow border-2 border-transparent hover:border-[var(--magic-gold)] transition-all duration-300 p-1" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        <div class="w-full h-full rounded-lg overflow-hidden relative">
                            @if($foto['esVideo'])
                                <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/20 hover:bg-black/10 transition">
                                    <i class="fas fa-play text-4xl text-white/90 group-hover:text-[var(--magic-gold)] group-hover:scale-110 transition text-glow"></i>
                                </button>
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover opacity-80 filter sepia-[0.2]" muted loop playsinline preload="metadata"></video>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-full object-cover filter sepia-[0.2] hover:sepia-0 transition duration-700">
                            @endif
                        </div>
                        
                        <div class="overlay absolute inset-0 bg-[var(--magic-gold)]/20 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-color-dodge"></div>
                        
                        <div class="check-icon absolute top-3 right-3 bg-[var(--magic-dark)] text-[var(--magic-gold)] border border-[var(--magic-gold)] rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-[0_0_10px_var(--magic-gold)] z-30 pointer-events-none">
                            <i class="fas fa-check text-xs"></i>
                        </div>

                        <div class="absolute bottom-1 left-1 right-1 bg-black/80 backdrop-blur-sm border border-[var(--magic-gold)]/30 rounded-b-lg pt-4 pb-2 px-2 text-[var(--magic-gold)] text-[8px] md:text-[9px] font-bold tracking-[0.2em] uppercase truncate text-center z-30 pointer-events-none">
                            <i class="fas {{ $foto['esVideo'] ? 'fa-video' : ($foto['esNube'] ? 'fa-cloud' : 'fa-eye') }} mr-1"></i>
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center box-glow p-12 rounded-3xl mx-2 border-dashed">
                        <p class="text-[var(--magic-gold)] font-magic text-xl tracking-widest">El espejo no refleja nada todavía.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP (Sellar el Pacto) --}}
    <section class="section-magic bg-[var(--magic-dark)] relative">
        {{-- Efectos de fondo --}}
        <div class="stars-bg absolute inset-0 pointer-events-none"></div>
        <div class="fog-bg absolute inset-0 pointer-events-none"></div>
        
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 z-10 w-full max-w-4xl mx-auto flex flex-col h-full min-h-[100svh] py-8 relative">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO (El efecto levitate solo afecta a este bloque) --}}
            <div class="my-auto flex flex-col items-center justify-center w-full levitate">
                <i class="fas fa-moon text-4xl text-white mb-6 animate-pulse opacity-80"></i>
                <h2 class="text-4xl sm:text-6xl md:text-8xl mb-8 font-magic text-[var(--magic-gold)] text-glow uppercase tracking-widest">Sellar el Pacto</h2>
                <p class="text-sm md:text-lg text-stone-300 font-light mb-12 max-w-lg mx-auto italic">¿Atenderás a nuestro llamado en esta noche estrellada?</p>
                
                <div id="contenedorBotonPrincipalRSVP" class="w-full flex justify-center">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-magic rounded-full w-full max-w-xs md:max-w-sm text-sm !py-4 shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                            Confirmar Presencia
                        </button>
                    @else
                        <div class="px-6 md:px-8 py-3 md:py-4 border border-[var(--magic-gold)]/50 text-[10px] md:text-xs tracking-[0.2em] uppercase text-[var(--magic-gold)] w-full max-w-xs md:max-w-md box-glow rounded-full bg-black/40">
                            Amuleto QR Requerido
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-col items-center gap-2 mt-12 md:mt-16 text-[9px] md:text-xs uppercase tracking-[0.3em] text-stone-400 font-bold">
                    <p>Ubicación Asignada: <span class="text-[var(--magic-gold)] text-glow">{{ $invitado->mesa_asignada ?? 'EN LAS SOMBRAS' }}</span></p>
                    <p>Atuendo: Elegancia Oscura / Gala</p>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2 z-20">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-50 hover:opacity-100 transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-white/50 mb-1.5 font-light">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono y texto que pasan al dorado mágico en hover --}}
                        <i class="fas fa-glass-cheers text-[10px] md:text-xs text-white/50 group-hover:text-[var(--magic-gold)] transition-colors"></i>
                        <span class="font-magic text-sm md:text-lg tracking-widest text-white/80 group-hover:text-[var(--magic-gold)] transition-colors drop-shadow-md">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div id="wrapper-dinamico-modal" class="box-glow w-full max-w-lg p-8 md:p-12 text-center rounded-3xl relative overflow-hidden max-h-[95vh] overflow-y-auto">
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--magic-gold)]/30 pb-4 text-left">
                <h3 class="text-xl md:text-2xl font-magic text-[var(--magic-gold)] tracking-widest uppercase"><i class="fas fa-key text-white text-lg mr-2"></i> Llave Arcana</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-6 text-left">
                <p class="text-xs md:text-sm font-light text-stone-300 leading-relaxed italic">Para revelar los misterios, debes invocar la **Palabra de Paso** que se te otorgó al sellar tu presencia.</p>
                <div>
                    <input type="text" id="inputCodigoIngreso" placeholder="EJ: MAGIA-4819" class="w-full border-b-2 border-stone-600 bg-transparent p-3 text-sm md:text-base font-bold tracking-[0.2em] outline-none uppercase text-white focus:border-[var(--magic-gold)] transition text-center placeholder-stone-700">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="btn-magic btn-magic-solid rounded-full mt-4 !py-3.5 shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                    Desbloquear Sello
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO: MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="box-glow rounded-3xl w-full max-w-lg p-8 md:p-10 text-left relative overflow-y-auto max-h-[95vh]">
        <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--magic-gold)]/30 pb-4">
            <h3 class="text-2xl md:text-3xl font-magic text-[var(--magic-gold)] uppercase tracking-widest">Crear Conjuro</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            
            <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Hechicero/a</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border border-stone-700 bg-black/50 p-3 rounded-xl text-xs md:text-sm font-medium outline-none text-[var(--magic-gold)]">
            </div>
             <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Alianza *</label>
                <select name="vinculo_autor" required class="w-full border border-stone-700 bg-[var(--magic-dark)] p-3 rounded-xl text-xs md:text-sm font-medium outline-none text-white focus:border-[var(--magic-gold)] cursor-pointer">
                    <option value="" disabled selected>Seleccionar tribu...</option>
                    <option value="Familiar">Lazos de Sangre</option>
                    <option value="Amigo/a">Compañero de Magia</option>
                    <option value="Compañero">Alianza de Gremio</option>
                    <option value="Conocido/a">Caminante</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Palabras de Poder *</label>
                <textarea name="contenido" rows="4" required class="w-full border border-stone-700 bg-black/50 p-3 rounded-xl text-xs md:text-sm font-light outline-none focus:border-[var(--magic-gold)] text-white resize-none italic" placeholder="Que la luz los guíe..."></textarea>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Cristal Visual (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" class="w-full text-[10px] md:text-xs text-stone-400 border border-stone-700 rounded-xl p-2 bg-black/50 file:border-0 file:bg-[var(--magic-gold)] file:text-black file:px-4 file:py-2 file:rounded-lg file:font-bold cursor-pointer">
            </div>
            <button type="submit" id="btnPublicarMuroBoda" class="btn-magic btn-magic-solid rounded-full w-full mt-4 !py-3 shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                Lanzar Conjuro
            </button>
        </form>
    </div>
</div>

{{-- MODAL ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="box-glow rounded-3xl max-w-lg w-[95%] md:w-full p-6 md:p-10 text-center relative max-h-[95vh] overflow-y-auto animate-fade-in border border-[var(--magic-gold)]/50 shadow-[0_0_30px_rgba(212,175,55,0.2)]">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--magic-gold)]/30 pb-4 text-left">
                <h3 class="text-2xl md:text-3xl font-magic text-[var(--magic-gold)] tracking-widest uppercase">El Pacto</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-5 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/60 p-5 rounded-2xl border border-stone-800 space-y-4">
                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-[var(--magic-gold)] block"><i class="fas fa-hat-wizard mr-2"></i> Hechicero Supremo</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Nombre Real *" required class="w-full border-b border-stone-600 bg-transparent py-2 text-sm font-bold outline-none focus:border-[var(--magic-gold)] text-white">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" placeholder="Búho Mensajero (Correo)" class="w-full border-b border-stone-600 bg-transparent py-2 text-sm font-bold outline-none focus:border-[var(--magic-gold)] text-white">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 md:py-4 bg-transparent border border-dashed border-[var(--magic-gold)]/50 text-[var(--magic-gold)] rounded-xl text-xs md:text-sm font-bold uppercase tracking-widest hover:bg-[var(--magic-gold)]/10 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Invocar Acompañante
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-magic btn-magic-solid rounded-full w-full !text-sm !py-4 mt-6 shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                    Sellar Vínculo
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="box-glow rounded-3xl border border-[var(--magic-gold)]/50 w-full max-w-2xl p-6 md:p-10 text-center shadow-[0_0_30px_rgba(212,175,55,0.2)] relative max-h-[95vh] flex flex-col">
        
        <div class="flex justify-between items-center mb-6 border-b border-[var(--magic-gold)]/30 pb-4 shrink-0 text-left">
            <h3 class="text-2xl md:text-3xl font-magic text-[var(--magic-gold)] uppercase tracking-widest text-glow">
                <i class="fas fa-award mr-2"></i> Rango de Magos
            </h3>
            <button onclick="cerrarModalRanking()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-2 space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--magic-gold)]"></i>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[var(--magic-gold)]/30 shrink-0">
            <button onclick="cerrarModalRanking()" class="btn-magic btn-magic-solid rounded-full w-full !py-3">
                Cerrar Pergamino
            </button>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/50 hover:text-[var(--magic-gold)] transition z-50">
        <i class="fas fa-times text-3xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-lg overflow-hidden box-glow p-1" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80svh] bg-black rounded-lg"></video>
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
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<div class='text-2xl md:text-3xl font-magic text-[var(--magic-gold)] py-4 text-center w-full text-glow'>El Hechizo ha Comenzado</div>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-magic btn-magic-solid rounded-full">Invocar Desafío</button>
                        <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--magic-gold)] hover:text-white transition font-bold mt-2">Ver Rango de Magos</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="btn-magic rounded-full">Escribir Conjuro</button>
                        <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--magic-gold)] hover:text-white transition font-bold mt-2">Leer Grimorio <i class="fa-solid fa-arrow-right ml-1"></i></button>
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
        document.getElementById('wrapper-dinamico-modal').className = "box-glow border border-[var(--magic-gold)]/50 w-full max-w-lg p-8 md:p-12 text-center rounded-3xl relative overflow-hidden max-h-[95vh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--magic-gold)]/30 pb-4 text-left">
                    <h3 class="text-xl md:text-2xl font-magic text-[var(--magic-gold)] uppercase tracking-widest"><i class="fas fa-key text-white text-lg mr-2"></i> Llave Arcana</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-6 text-left">
                    <p class="text-xs md:text-sm font-light text-stone-300 leading-relaxed italic">Para revelar los misterios, debes invocar la **Palabra de Paso** que se te otorgó al sellar tu presencia.</p>
                    <div>
                        <input type="text" id="inputCodigoIngreso" placeholder="EJ: MAGIA-4819" class="w-full border-b-2 border-stone-600 bg-transparent p-3 text-sm md:text-base font-bold tracking-[0.2em] outline-none uppercase text-white focus:border-[var(--magic-gold)] transition text-center placeholder-stone-700">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="btn-magic btn-magic-solid rounded-full mt-4 !py-3.5 shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                        Desbloquear Sello
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() { document.getElementById('modalFiltroAcceso').classList.add('hidden'); }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("Conjuro incompleto."); return; }

        const btnVerificar = document.getElementById('btnVerificarCodigo');
        const txtOriginalVerificar = btnVerificar.innerHTML;
        
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Revelando...';

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
                    wrapper.className = "box-glow border border-[var(--magic-gold)]/50 w-full max-w-lg p-8 md:p-12 text-center shadow-[0_0_30px_rgba(212,175,55,0.2)] rounded-3xl relative";
                    wrapper.innerHTML = `
                        <div class="py-6 text-center space-y-6 animate-pop">
                            <i class="fas fa-scroll text-5xl text-[var(--magic-gold)] mb-2 drop-shadow-md"></i>
                            <h3 class="text-2xl md:text-3xl font-magic uppercase tracking-widest text-[var(--magic-gold)] text-glow">Prueba Completada</h3>
                            <p class="text-sm font-light text-stone-300 px-4 italic">${data.message}</p>
                            <div class="pt-6 space-y-3">
                                <button onclick="verRanking()" class="btn-magic btn-magic-solid rounded-full w-full">Ver Rango de Magos</button>
                                <button onclick="cerrarModalFiltro()" class="btn-magic rounded-full w-full">Cerrar Pergamino</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Gran Hechicero" };
                }
            }

            if (!response.ok) { alert(data.message || "Palabra de paso denegada."); throw new Error("invalid_code"); }
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Gran Hechicero" ? data.nombre_invitado : "Mago Anónimo";
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
        botonPublicar.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Invocando...`;

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
                alert(data.message || "Fallo en el hechizo.");
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
                    <div class="py-10 text-center space-y-6 animate-pop">
                        <div class="w-20 h-20 bg-[var(--magic-gold)]/10 rounded-full flex items-center justify-center mx-auto border border-[var(--magic-gold)] shadow-[0_0_20px_rgba(212,175,55,0.3)]">
                            <i class="fas fa-magic text-3xl text-[var(--magic-gold)]"></i>
                        </div>
                        <h3 class="text-3xl font-magic text-[var(--magic-gold)] tracking-widest uppercase text-glow">¡Hechizo Lanzado!</h3>
                        <p class="text-sm font-light text-stone-300 px-4 leading-relaxed italic">${data.message}</p>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="btn-magic btn-magic-solid rounded-full w-full mt-6">Cerrar Grimorio</button>
                    </div>
                `;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.className = "box-glow border border-[var(--magic-gold)]/50 w-full max-w-lg p-8 md:p-12 text-center shadow-2xl rounded-3xl relative";
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 animate-pop">
                <i class="fas fa-hat-wizard text-[var(--magic-gold)] text-5xl mb-2 drop-shadow-md"></i>
                <h1 class="text-2xl md:text-3xl font-magic text-white uppercase tracking-widest">¡Luminos, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-stone-300 text-sm font-light leading-relaxed px-2 italic">Demuestra tu conocimiento arcano. Te enfrentarás a <strong class="text-[var(--magic-gold)] font-bold">${bancoPreguntas.length} acertijos</strong>. ¡Solo el más rápido portará la corona!</p>
                <button onclick="comenzarJuegoModal()" class="btn-magic btn-magic-solid rounded-full w-full mt-4 !py-3.5 shadow-[0_0_15px_rgba(212,175,55,0.4)]">¡ABRACADABRA!</button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-bold uppercase tracking-[0.3em] text-[var(--magic-gold)] border-b border-[var(--magic-gold)]/30 pb-4">
                    <span id="info-progreso">ACERTIJO 1 DE X</span>
                    <span class="text-white"><i class="fas fa-hourglass-half mr-1 text-[var(--magic-gold)]"></i> <span id="info-cronometro" class="font-mono text-sm">0</span>s</span>
                </div>
                <h2 id="texto-pregunta" class="text-xl md:text-2xl font-magic text-white leading-snug tracking-wide">Desvelando el enigma...</h2>
                <div class="space-y-3 pt-2">
                    <button onclick="seleccionarOpcionModal('a')" class="w-full text-left p-4 border border-stone-600 bg-black/50 hover:bg-[var(--magic-gold)]/20 hover:border-[var(--magic-gold)] rounded-xl transition flex items-center space-x-4 text-stone-200 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--magic-gold)]/50 text-[var(--magic-gold)] font-magic text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--magic-gold)] group-hover:text-black transition-colors shadow-[0_0_10px_rgba(212,175,55,0.2)]">A</span>
                        <span id="texto-opcion-a" class="font-light text-sm md:text-base break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" class="w-full text-left p-4 border border-stone-600 bg-black/50 hover:bg-[var(--magic-gold)]/20 hover:border-[var(--magic-gold)] rounded-xl transition flex items-center space-x-4 text-stone-200 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--magic-gold)]/50 text-[var(--magic-gold)] font-magic text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--magic-gold)] group-hover:text-black transition-colors shadow-[0_0_10px_rgba(212,175,55,0.2)]">B</span>
                        <span id="texto-opcion-b" class="font-light text-sm md:text-base break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" class="w-full text-left p-4 border border-stone-600 bg-black/50 hover:bg-[var(--magic-gold)]/20 hover:border-[var(--magic-gold)] rounded-xl transition flex items-center space-x-4 text-stone-200 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--magic-gold)]/50 text-[var(--magic-gold)] font-magic text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--magic-gold)] group-hover:text-black transition-colors shadow-[0_0_10px_rgba(212,175,55,0.2)]">C</span>
                        <span id="texto-opcion-c" class="font-light text-sm md:text-base break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" class="w-full text-left p-4 border border-stone-600 bg-black/50 hover:bg-[var(--magic-gold)]/20 hover:border-[var(--magic-gold)] rounded-xl transition flex items-center space-x-4 text-stone-200 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--magic-gold)]/50 text-[var(--magic-gold)] font-magic text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--magic-gold)] group-hover:text-black transition-colors shadow-[0_0_10px_rgba(212,175,55,0.2)]">D</span>
                        <span id="texto-opcion-d" class="font-light text-sm md:text-base break-words">Opción D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-stone-400 font-light text-sm italic">El pergamino está vacío. No hay acertijos.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `ACERTIJO ${preguntaActualIndex + 1} DE ${bancoPreguntas.length}`;
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
            <div class="text-center space-y-6 py-10 animate-pop">
                <i class="fas fa-sparkles fa-spin text-4xl text-[var(--magic-gold)] mb-2"></i>
                <h3 class="text-xl font-magic text-white tracking-widest uppercase">Canalizando Magia...</h3>
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
                        <i class="fas fa-gem text-5xl text-[var(--magic-gold)] mb-2 drop-shadow-[0_0_15px_rgba(212,175,55,0.6)]"></i>
                        <h3 class="text-3xl md:text-4xl font-magic text-[var(--magic-gold)] uppercase tracking-widest text-glow">¡PRUEBA SUPERADA!</h3>
                        <p class="text-sm font-light text-stone-300 px-4 italic">Tu conocimiento ha quedado grabado en las estrellas.</p>
                        <div class="flex justify-center gap-4 mt-6">
                            <div class="text-center border border-[var(--magic-gold)]/50 p-4 rounded-xl bg-black/50 w-28 shadow-[0_0_10px_rgba(212,175,55,0.1)]">
                                <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-[var(--magic-gold)] mb-1">Sabiduría</span>
                                <span class="text-2xl font-magic text-white">${puntajeAcumulado}</span>
                            </div>
                            <div class="text-center border border-[var(--magic-gold)]/50 p-4 rounded-xl bg-black/50 w-28 shadow-[0_0_10px_rgba(212,175,55,0.1)]">
                                <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-[var(--magic-gold)] mb-1">Celeridad</span>
                                <span class="text-2xl font-magic text-white">${segundosTranscurridos}s</span>
                            </div>
                        </div>
                        <div class="pt-6 space-y-4">
                            <button onclick="verRanking()" class="btn-magic btn-magic-solid rounded-full w-full">Ver Rango de Magos</button>
                            <button onclick="cerrarModalFiltro()" class="btn-magic rounded-full w-full">Ocultar Pergamino</button>
                        </div>
                    </div>
                `;
            }
        }).catch(err => { wrapper.innerHTML = `<p class="text-red-500 font-medium">El hechizo falló.</p>`; });
    }

    let contadorAcompanantes = 0;
    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-black/40 p-4 rounded-2xl border border-[var(--magic-gold)]/30 space-y-3 relative animate-fade-in shadow-inner";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-[var(--magic-gold)]/20 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--magic-gold)]">Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-red-400 hover:text-red-300 text-[10px] font-bold uppercase transition"><i class="fas fa-times mr-1"></i> Deshacer</button>
            </div>
            <input type="text" class="input-nombre-acompanante w-full border-b border-stone-600 bg-transparent py-2 text-sm font-bold outline-none focus:border-[var(--magic-gold)] text-white" placeholder="Nombre Real *" required>
            <input type="email" class="input-email-acompanante w-full border-b border-stone-600 bg-transparent py-2 text-sm font-bold outline-none focus:border-[var(--magic-gold)] text-white" placeholder="Búho Mensajero (Opcional)">
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
        btnConfirmar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Invocando...';

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
                        <i class="fas fa-scroll text-4xl text-[var(--magic-gold)] mb-2 opacity-80"></i>
                        <h3 class="text-2xl font-magic text-white tracking-widest uppercase text-glow">Pacto Ya Sellado</h3>
                        <p class="text-sm font-light text-stone-300 px-4 leading-relaxed italic">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-magic rounded-full mt-6 w-full">Ocultar</button>
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
                        <i class="fas fa-star text-5xl text-[var(--magic-gold)] mb-2 drop-shadow-[0_0_15px_rgba(212,175,55,0.6)] animate-pulse"></i>
                        <h3 class="text-3xl md:text-4xl font-magic text-[var(--magic-gold)] uppercase tracking-widest text-glow">¡El Pacto Está Sellado!</h3>
                        <p class="text-xs font-light text-stone-300 italic">Conserva estos amuletos digitales, te darán acceso a los misterios de la noche.</p>
                        <div class="bg-black/60 border border-[var(--magic-gold)]/50 p-5 rounded-2xl text-left shadow-[0_0_20px_rgba(212,175,55,0.1)] mt-4">
                            <p class="text-[9px] uppercase font-bold tracking-[0.3em] text-[var(--magic-gold)] border-b border-[var(--magic-gold)]/30 pb-2 mb-3">Tus Palabras de Paso</p>
                            <div class="space-y-3">
                                ${data.codigos.map(item => `
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-xs text-stone-200 tracking-wider uppercase">${item.nombre}</span> 
                                        <span class="bg-[var(--magic-gold)]/20 border border-[var(--magic-gold)] text-[var(--magic-gold)] px-3 py-1 rounded-lg text-sm font-magic tracking-widest shadow-[0_0_10px_rgba(212,175,55,0.2)]">${item.codigo}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-magic btn-magic-solid rounded-full w-full mt-6 shadow-[0_0_15px_rgba(212,175,55,0.4)]">Aceptar Destino</button>
                    </div>
                `;
                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-8 py-4 border border-[var(--magic-gold)] text-[10px] md:text-xs tracking-[0.4em] uppercase text-[var(--magic-gold)] w-full max-w-xs md:max-w-md bg-black/60 rounded-full text-center shadow-[0_0_15px_rgba(212,175,55,0.2)]">
                        <i class="fas fa-moon mr-2"></i> PRESENCIA ASEGURADA
                    </div>
                `;
            }
        }).catch(error => { 
            if (error.message !== "already_handled") { alert("El flujo mágico se cortó."); }
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
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-circle-notch fa-spin text-4xl text-[var(--magic-gold)]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-stone-400 font-light italic text-center text-sm mt-10">El oráculo aún no ha hablado.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-lg text-stone-500 font-magic mr-4 w-6 text-center">#${index + 1}</span>`;
                        let resplandor = 'border-stone-800';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-star text-[var(--magic-gold)] text-2xl mr-4 w-6 text-center text-glow animate-pulse"></i>';
                            resplandor = 'border-[var(--magic-gold)] bg-[var(--magic-gold)]/10 shadow-[0_0_15px_rgba(212,175,55,0.2)]';
                        } else if(index === 1) {
                            medalla = '<i class="fa-regular fa-star text-stone-300 text-xl mr-4 w-6 text-center"></i>';
                            resplandor = 'border-stone-600 bg-white/5';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-4 rounded-2xl animate-fade-in mb-3">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-bold text-sm md:text-base text-white tracking-widest uppercase truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[var(--magic-gold)] font-magic text-2xl leading-none">${jugador.puntaje_total} <span class="text-[9px] font-sans font-bold text-stone-500 uppercase">pts</span></span>
                                    <span class="block text-[9px] text-stone-400 font-bold tracking-[0.2em] uppercase mt-1">${jugador.tiempo_empleado} seg</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-400 font-medium text-center mt-10 text-sm">El hechizo de visión falló.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-400 font-medium text-center mt-10 text-sm">Interferencia en la magia.</p>';
        });
    }

    function cerrarModalRanking() { document.getElementById('modalRanking').classList.add('hidden'); }

    // --- SISTEMA MULTIMEDIA ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-transparent', 'border-[var(--magic-gold)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--magic-gold)]', 'border-transparent');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} RELIQUIAS`;
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
        if (seleccionadas.length === 0) { alert("Debes seleccionar al menos una reliquia."); return; }
        seleccionadas.forEach((item, index) => { setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000); });
        seleccionadas.forEach(item => toggleSeleccion(item));
    }

    function descargarTodas() {
        const todas = document.querySelectorAll('.foto-item');
        if (todas.length === 0) { alert("El espejo de las ilusiones está vacío."); return; }
        todas.forEach((item, index) => { setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000); });
    }
</script>
</body>
</html>