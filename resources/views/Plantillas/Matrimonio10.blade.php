<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Jardín Encantado</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --night-sky: #0a1118;      /* Azul muy oscuro, casi negro */
            --forest-deep: #121c17;    /* Verde bosque muy oscuro */
            --fairy-gold: #e8c37d;     /* Dorado cálido de las luces */
            --rose-bloom: #d49a9e;     /* Rosa suave de las flores */
            --starlight: #f4f0ec;      /* Blanco crema para textos */
            --glass-bg: rgba(10, 17, 24, 0.6);
        }

        h1, .font-script { font-family: 'Allura', cursive; }
        h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        body { font-family: 'Quicksand', sans-serif; background-color: var(--night-sky); color: var(--starlight); scroll-behavior: smooth; overflow-x: hidden; }

        .snap-container { height: 100svh; overflow-y: scroll; scroll-snap-type: y mandatory; overflow-x: hidden; }
        
        .section-garden { 
            min-height: 100svh; 
            width: 100%; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            position: relative; 
            scroll-snap-align: start; 
            overflow: hidden; 
            padding: 4rem 1.5rem; 
            background: radial-gradient(circle at top right, var(--forest-deep) 0%, var(--night-sky) 100%);
        }

        /* EFECTO LUCIÉRNAGAS MAGICURAS */
        .firefly {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--fairy-gold);
            border-radius: 50%;
            box-shadow: 0 0 10px 2px var(--fairy-gold), 0 0 20px 2px rgba(232, 195, 125, 0.5);
            animation: fly 10s infinite alternate ease-in-out, glow 3s infinite alternate;
            pointer-events: none;
            z-index: 5;
        }
        .f1 { top: 20%; left: 10%; animation-duration: 12s; animation-delay: 0s; }
        .f2 { top: 60%; left: 80%; animation-duration: 15s; animation-delay: 2s; }
        .f3 { top: 80%; left: 20%; animation-duration: 18s; animation-delay: 1s; width: 4px; height: 4px; }
        .f4 { top: 30%; left: 70%; animation-duration: 14s; animation-delay: 3s; }
        .f5 { top: 50%; left: 40%; animation-duration: 16s; animation-delay: 5s; width: 2px; height: 2px; }

        @keyframes fly {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -40px) scale(1.5); }
            100% { transform: translate(-20px, -80px) scale(0.8); }
        }
        @keyframes glow {
            0% { opacity: 0.3; }
            100% { opacity: 1; }
        }

        /* BORDES ESTILO ARCO FLORAL */
        .arch-border {
            border-radius: 10rem 10rem 1rem 1rem;
        }

        /* TEXTOS QUE BRILLAN */
        .glow-text {
            text-shadow: 0 0 15px rgba(232, 195, 125, 0.6);
        }

        /* DIVISOR DE FAROL/ESTRELLA */
        .lantern-divider {
            width: 150px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--fairy-gold), transparent);
            margin: 2rem auto; position: relative;
        }
        .lantern-divider::after {
            content: '✦';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--fairy-gold);
            font-size: 1.2rem;
            text-shadow: 0 0 10px var(--fairy-gold);
        }

        /* BOTONES JARDÍN NOCTURNO */
        .btn-garden {
            background-color: var(--glass-bg);
            color: var(--fairy-gold);
            padding: 12px 30px;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: all 0.4s ease;
            position: relative;
            width: 100%;
            text-align: center;
            display: inline-block;
            border-radius: 50px;
            border: 1px solid var(--fairy-gold);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        @media (min-width: 768px) { .btn-garden { width: auto; font-size: 1rem; padding: 15px 50px; } }
        
        .btn-garden:hover {
            background-color: var(--fairy-gold);
            color: var(--night-sky);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(232, 195, 125, 0.4);
        }
        .btn-garden:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; border-color: #555; color: #555; }

        .btn-garden-solid {
            background-color: var(--rose-bloom);
            color: var(--night-sky);
            border: 1px solid var(--rose-bloom);
            font-weight: 700;
        }
        .btn-garden-solid:hover {
            background-color: transparent;
            color: var(--rose-bloom);
            border: 1px solid var(--rose-bloom);
            box-shadow: 0 10px 25px rgba(212, 154, 158, 0.4);
        }

        /* PANELES DE CRISTAL (Glassmorphism) */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(232, 195, 125, 0.2);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .animate-pop { animation: popIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes popIn { 0% { opacity: 0; transform: translateY(30px); filter: blur(4px); } 100% { opacity: 1; transform: translateY(0); filter: blur(0); } }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* Inputs elegantes oscuros */
        .input-dark {
            width: 100%; border: none; border-bottom: 1px solid rgba(232, 195, 125, 0.4);
            background: transparent; padding: 12px 0; font-size: 0.9rem; outline: none;
            color: var(--starlight); transition: border-color 0.3s;
        }
        .input-dark:focus { border-bottom-color: var(--fairy-gold); }
        .input-dark::placeholder { color: rgba(244, 240, 236, 0.3); font-weight: 300; }
        select.input-dark option { background: var(--night-sky); color: var(--starlight); }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="firefly f1"></div>
<div class="firefly f2"></div>
<div class="firefly f3"></div>
<div class="firefly f4"></div>
<div class="firefly f5"></div>

<div class="snap-container">

    {{-- SECCIÓN 1: BIENVENIDA (HERO) --}}
    <section class="section-garden !p-0">
        <div class="absolute inset-0 z-0">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                     class="w-full h-full object-cover animate-pop opacity-60 mix-blend-luminosity">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-[var(--night-sky)]/40 via-[var(--forest-deep)]/60 to-[var(--night-sky)]"></div>
        </div>
        
        <div class="z-10 text-center max-w-6xl px-4 flex flex-col items-center w-full justify-center h-full">
            <span class="font-script text-4xl md:text-6xl text-[var(--rose-bloom)] mb-2 drop-shadow-md animate-pop" style="animation-delay: 0.2s;">Bajo las estrellas</span>
            
            <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-9xl leading-tight mb-4 text-[var(--fairy-gold)] font-serif glow-text tracking-tight w-full break-words animate-pop" style="animation-delay: 0.4s;">
                {{ $evento->nombre_evento }}
            </h1>

            <div class="lantern-divider animate-pop" style="animation-delay: 0.6s;"></div>

            <p class="text-sm md:text-xl font-light tracking-[0.3em] md:tracking-[0.5em] text-white uppercase mb-10 md:mb-16 animate-pop" style="animation-delay: 0.8s;">
                {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d \d\e F, Y') }}
            </p>

            {{-- CONTADOR FAROLES --}}
            <div id="countdown" class="flex flex-wrap gap-4 sm:gap-6 w-full justify-center animate-pop" style="animation-delay: 1s;">
                <div class="glass-panel arch-border p-4 md:p-6 w-20 md:w-28 flex flex-col items-center justify-center border-t-2 border-t-[var(--fairy-gold)]">
                    <span id="days" class="text-3xl md:text-5xl font-serif text-[var(--starlight)]">00</span>
                    <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-[var(--fairy-gold)] mt-2 uppercase">Días</span>
                </div>
                <div class="glass-panel arch-border p-4 md:p-6 w-20 md:w-28 flex flex-col items-center justify-center border-t-2 border-t-[var(--fairy-gold)]">
                    <span id="hours" class="text-3xl md:text-5xl font-serif text-[var(--starlight)]">00</span>
                    <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-[var(--fairy-gold)] mt-2 uppercase">Hrs</span>
                </div>
                <div class="glass-panel arch-border p-4 md:p-6 w-20 md:w-28 flex flex-col items-center justify-center border-t-2 border-t-[var(--fairy-gold)]">
                    <span id="minutes" class="text-3xl md:text-5xl font-serif text-[var(--starlight)]">00</span>
                    <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-[var(--fairy-gold)] mt-2 uppercase">Min</span>
                </div>
                <div class="glass-panel arch-border p-4 md:p-6 w-20 md:w-28 flex flex-col items-center justify-center border-t-2 border-t-[var(--rose-bloom)] bg-[var(--rose-bloom)]/10">
                    <span id="seconds" class="text-3xl md:text-5xl font-serif text-[var(--rose-bloom)] glow-text">00</span>
                    <span class="text-[8px] md:text-[10px] tracking-[0.2em] text-white mt-2 uppercase">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: NUESTRA HISTORIA --}}
    <section class="section-garden">
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center z-10 px-4 md:px-8">
            <div class="space-y-6 md:space-y-8 text-center md:text-left flex flex-col md:items-start items-center order-2 md:order-1">
                <i class="fas fa-seedling text-[var(--fairy-gold)] text-3xl mb-2 opacity-80"></i>
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif text-[var(--starlight)] leading-tight">Nuestra Historia</h2>
                <div class="lantern-divider md:ml-0 !w-24"></div>
                <p class="text-lg md:text-xl leading-relaxed text-stone-300 font-light italic px-4 md:px-0">
                    "{!! nl2br(e($evento->biografia_resumen)) !!}"
                </p>
            </div>

            <div class="relative w-full max-w-[300px] sm:max-w-xs md:max-w-md mx-auto order-1 md:order-2">
                @if(isset($evento->fotosGaleria) && $evento->fotosGaleria->count() > 1)
                    <div class="arch-border overflow-hidden aspect-[3/4] border-4 border-[var(--fairy-gold)]/30 glass-panel p-2">
                        <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" class="arch-border w-full h-full object-cover opacity-90 hover:opacity-100 hover:scale-105 transition duration-1000">
                    </div>
                @else
                    <div class="arch-border aspect-[3/4] w-full glass-panel flex items-center justify-center border-4 border-[var(--fairy-gold)]/20">
                        <i class="fa-brands fa-pagelines text-8xl text-[var(--fairy-gold)] opacity-30"></i>
                    </div>
                @endif
                <div class="absolute -bottom-6 -left-6 bg-[var(--rose-bloom)] text-[var(--night-sky)] px-6 py-4 rounded-full shadow-[0_0_20px_rgba(212,154,158,0.4)] flex items-center justify-center border-2 border-white/20">
                    <span class="font-script text-3xl">Eternidad</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="section-garden">
        <div class="text-center z-10 px-6 w-[95%] max-w-3xl mx-auto glass-panel p-10 md:p-16 rounded-[3rem]">
            <i class="fa-solid fa-lantern text-5xl text-[var(--fairy-gold)] mb-6 glow-text animate-pulse"></i>
            <h2 class="text-3xl sm:text-4xl md:text-5xl mb-6 font-serif text-[var(--starlight)] tracking-wider">El Jardín Elegido</h2>
            <div class="lantern-divider"></div>
            
            <p class="text-stone-300 text-lg md:text-2xl mb-10 font-light leading-relaxed px-4 italic">
                {{ $evento->ubicacion_texto }}
            </p>
            
            @if($evento->google_maps_url)
            <div class="w-full flex justify-center mt-4">
                <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-garden max-w-xs md:max-w-sm rounded-full">
                    Guiarme con Luz <i class="fas fa-location-arrow ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES (RITUALES) --}}
    <section class="section-garden !py-20 h-auto min-h-[100svh]">
        <div class="max-w-6xl w-full px-4 flex flex-col justify-center h-full mx-auto z-10">
            <div class="text-center mb-12 md:mb-16">
                <span class="font-script text-5xl text-[var(--rose-bloom)] block mb-2 drop-shadow-md">Celebremos</span>
                <h2 class="text-3xl sm:text-4xl md:text-6xl font-serif text-[var(--fairy-gold)] tracking-widest uppercase glow-text">La Velada</h2>
                <div class="lantern-divider"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                {{-- TRIVIA --}}
                <div class="glass-panel arch-border p-8 md:p-12 text-center group hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between min-h-[350px]">
                    <div>
                        <i class="fas fa-gem text-4xl text-[var(--fairy-gold)] mb-6 drop-shadow-md group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-serif text-2xl md:text-3xl text-[var(--starlight)] mb-3 tracking-widest">Conocimiento</h3>
                        <p class="text-stone-400 font-light text-sm mb-8 px-4 italic">Un pequeño juego bajo las estrellas para ver quién conoce mejor nuestra historia.</p>
                    </div>
                    <div id="wrapper-btn-trivia" class="w-full max-w-xs mx-auto flex flex-col gap-4">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-garden btn-garden-solid rounded-full">Jugar Ahora</button>
                            <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--fairy-gold)] hover:text-white transition font-bold mt-2">Ver Puntuaciones</button>
                        @else
                            <button id="btn-time-trivia" disabled class="btn-garden rounded-full !border-stone-600 !text-stone-500">
                                <i class="fas fa-lock mr-2"></i> Magia en Pausa
                            </button>
                        @endif
                    </div>
                </div>

                {{-- MURO --}}
                <div class="glass-panel arch-border p-8 md:p-12 text-center group hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between min-h-[350px]">
                    <div>
                        <i class="fas fa-feather-alt text-4xl text-[var(--fairy-gold)] mb-6 drop-shadow-md group-hover:scale-110 transition-transform"></i>
                        <h3 class="font-serif text-2xl md:text-3xl text-[var(--starlight)] mb-3 tracking-widest">Árbol de Deseos</h3>
                        <p class="text-stone-400 font-light text-sm mb-8 px-4 italic">Escribe tus bendiciones para nosotros y cuélgalas en nuestro árbol digital.</p>
                    </div>
                    <div id="wrapper-btn-muro" class="w-full max-w-xs mx-auto flex flex-col gap-4">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('muro')" class="btn-garden rounded-full">Colgar Deseo</button>
                            <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--fairy-gold)] hover:text-white transition font-bold mt-2">Ver El Árbol <i class="fa-solid fa-arrow-right ml-1"></i></button>
                        @else
                            <button id="btn-time-muro" disabled class="btn-garden rounded-full !border-stone-600 !text-stone-500">
                                <i class="fas fa-lock mr-2"></i> Magia en Pausa
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN OCULTA: MURO DE DESEOS VISUAL --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[var(--forest-deep)] overflow-y-auto">
        <div class="relative max-w-7xl w-full mx-auto px-4 md:px-8 py-16 md:py-24 z-10 min-h-[100svh] flex flex-col">
            <div class="text-center mb-12 md:mb-16 animate-pop">
                <span class="font-script text-4xl md:text-5xl text-[var(--rose-bloom)] block mb-4">Bendiciones</span>
                <h2 class="text-4xl md:text-6xl font-serif text-[var(--fairy-gold)] tracking-widest uppercase glow-text">El Árbol de Deseos</h2>
                <div class="lantern-divider"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 items-start w-full px-2 pb-10">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="glass-panel p-6 md:p-8 rounded-2xl flex flex-col h-full animate-fade-in hover:-translate-y-2 transition-all duration-500 border-t border-t-[var(--rose-bloom)]/50">
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="mb-6 rounded-xl overflow-hidden aspect-[4/3] shadow-sm border border-white/10 p-1">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover rounded-lg hover:scale-105 transition-transform duration-700 opacity-90">
                            </div>
                        @endif
                        <div class="flex-grow flex flex-col">
                            <i class="fas fa-quote-left text-[var(--fairy-gold)]/50 text-2xl mb-2"></i>
                            <p class="font-serif text-lg md:text-xl text-stone-200 leading-relaxed italic break-words flex-grow">"{{ $item->contenido_texto }}"</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[var(--fairy-gold)]/20 flex items-center justify-between">
                            <span class="text-[10px] md:text-xs font-bold text-[var(--fairy-gold)] tracking-widest uppercase font-sans">{{ $item->nombre_autor }}</span>
                            <i class="fa-solid fa-leaf text-[var(--rose-bloom)] text-[10px]"></i>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center p-10 md:p-16 glass-panel rounded-3xl mx-2 border-dashed border-[var(--fairy-gold)]/30">
                        <i class="fa-brands fa-pagelines text-5xl text-[var(--fairy-gold)] opacity-50 mb-4 block"></i>
                        <p class="text-xl md:text-2xl font-serif text-stone-400 tracking-widest">Las ramas están vacías, sé el primero en colgar tu deseo.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-auto flex justify-center w-full pb-8">
                <button onclick="ocultarMuroVisual()" class="btn-garden max-w-xs rounded-full">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Jardín
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: ÁLBUM DE FOTOS (GALERÍA CLOUD) --}}
    <section class="section-garden !h-auto py-20 min-h-[100svh] !block">
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col items-center py-10 md:py-16 mx-auto relative">
            
            <div class="text-center mb-12 w-full">
                <span class="font-script text-4xl text-[var(--rose-bloom)] mb-2 block drop-shadow-md">Luces y Sombras</span>
                <h2 class="text-4xl md:text-5xl font-serif text-[var(--fairy-gold)] uppercase tracking-widest glow-text">Nuestra Galería</h2>
                <div class="lantern-divider"></div>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 glass-panel p-4 md:p-6 rounded-2xl gap-4">
                <span id="contador-seleccionadas" class="font-serif text-xl text-[var(--rose-bloom)] italic">
                    0 Memorias
                </span>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border border-[var(--fairy-gold)] text-[var(--fairy-gold)] px-6 py-2.5 hover:bg-[var(--fairy-gold)] hover:text-black transition uppercase tracking-widest w-full sm:w-auto rounded-full">
                        Guardar Selección
                    </button>
                    <button onclick="descargarTodas()" class="btn-garden btn-garden-solid rounded-full !w-full sm:!w-auto !py-2.5 shadow-lg">
                        <i class="fas fa-download mr-2"></i> Bajar Todo
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
                                'etiqueta' => 'LENTE OFICIAL'
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
                            'etiqueta' => 'VISTA INVITADO'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[65vh] overflow-y-auto hide-scroll pb-6">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item aspect-square md:aspect-[4/5] relative group cursor-pointer arch-border overflow-hidden glass-panel border-2 border-transparent hover:border-[var(--fairy-gold)] transition-all duration-500 p-1" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        <div class="w-full h-full arch-border overflow-hidden relative">
                            @if($foto['esVideo'])
                                <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/30 hover:bg-black/10 transition">
                                    <i class="fas fa-play text-4xl text-[var(--starlight)] group-hover:text-[var(--fairy-gold)] group-hover:scale-110 transition drop-shadow-md"></i>
                                </button>
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover opacity-80 filter sepia-[0.2]" muted loop playsinline preload="metadata"></video>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-full object-cover opacity-90 hover:opacity-100 hover:scale-105 transition duration-700">
                            @endif
                        </div>
                        
                        <div class="overlay absolute inset-0 bg-[var(--fairy-gold)]/10 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-color-dodge"></div>
                        
                        <div class="check-icon absolute top-4 right-4 bg-[var(--night-sky)] text-[var(--fairy-gold)] rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none border border-[var(--fairy-gold)]">
                            <i class="fas fa-check text-xs"></i>
                        </div>

                        <div class="absolute bottom-2 left-2 right-2 bg-black/60 backdrop-blur-md border border-[var(--fairy-gold)]/20 rounded-full py-1.5 px-2 text-[var(--fairy-gold)] text-[8px] md:text-[9px] font-bold tracking-[0.2em] uppercase truncate text-center z-30 pointer-events-none">
                            <i class="fas {{ $foto['esVideo'] ? 'fa-video text-[var(--rose-bloom)]' : ($foto['esNube'] ? 'fa-cloud' : 'fa-camera') }} mr-1"></i>
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center glass-panel p-12 rounded-3xl mx-2 border-dashed border-[var(--fairy-gold)]/30">
                        <p class="text-[var(--starlight)] font-serif text-xl italic">Aún no hay retratos en el jardín.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP (CONFIRMACIÓN) --}}
    <section class="section-garden relative">
        {{-- Contenedor Flex que ocupa el alto de la pantalla --}}
        <div class="text-center px-4 z-10 w-full max-w-3xl mx-auto flex flex-col h-full min-h-[100svh] py-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center justify-center w-full animate-pop">
                <i class="fas fa-dove text-4xl text-[var(--fairy-gold)] mb-6 opacity-80"></i>
                <h2 class="font-script title-script text-[var(--rose-bloom)] text-5xl md:text-7xl block mb-2">Sella tu</h2>
                <h2 class="text-4xl sm:text-6xl md:text-8xl mb-8 font-serif text-white uppercase tracking-widest leading-none glow-text">Presencia</h2>
                <div class="lantern-divider"></div>
                
                <p class="text-sm md:text-lg text-stone-300 font-light mb-12 max-w-md mx-auto italic">Tu compañía será la luz más brillante de nuestra noche.</p>
                
                <div id="contenedorBotonPrincipalRSVP" class="w-full flex justify-center">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="btn-garden btn-garden-solid rounded-full w-full max-w-xs md:max-w-sm text-sm !py-4 shadow-xl">
                            CONFIRMAR ASISTENCIA
                        </button>
                    @else
                        <div class="px-6 md:px-8 py-3 md:py-4 border border-[var(--fairy-gold)]/50 text-[10px] md:text-xs tracking-[0.2em] uppercase text-[var(--fairy-gold)] w-full max-w-xs md:max-w-md glass-panel rounded-full">
                            Invitación QR Requerida
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-col items-center gap-2 mt-12 md:mt-16 text-[9px] md:text-xs uppercase tracking-[0.3em] text-stone-400 font-bold px-4">
                    <p>Mesa Asignada: <span class="font-bold text-[var(--fairy-gold)]">{{ $invitado->mesa_asignada ?? 'EN EL JARDÍN' }}</span></p>
                    <p>Código de Vestimenta: Etiqueta / Gala Nocturna</p>
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ANCLADA AL FONDO 🔥 --}}
            <div class="mt-auto w-full text-center pt-10 pb-2 z-20">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-50 hover:opacity-100 transition-all duration-300 group cursor-pointer hover:-translate-y-1">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-stone-400 mb-1.5 font-light">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        {{-- Icono y texto que pasan a dorado mágico en hover --}}
                        <i class="fas fa-glass-cheers text-[10px] md:text-xs text-white/50 group-hover:text-[var(--fairy-gold)] transition-colors"></i>
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-white/80 group-hover:text-[var(--fairy-gold)] transition-colors drop-shadow-md">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
    <div id="wrapper-dinamico-modal" class="glass-panel p-8 md:p-12 text-center arch-border relative overflow-hidden max-h-[95vh] overflow-y-auto w-full max-w-lg">
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--fairy-gold)]/30 pb-4 text-left">
                <h3 class="text-xl md:text-2xl font-serif text-[var(--starlight)] tracking-widest uppercase"><i class="fas fa-key text-[var(--fairy-gold)] text-lg mr-2"></i> Palabra Mágica</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[var(--fairy-gold)] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-6 text-left">
                <p class="text-xs md:text-sm font-light text-stone-300 leading-relaxed italic">Para revelar los senderos secretos, ingresa el código personal que el sistema te entregó al confirmar tu asistencia.</p>
                <div>
                    <input type="text" id="inputCodigoIngreso" placeholder="EJ: JARDIN-4819" class="input-dark text-center tracking-[0.2em] uppercase font-serif text-lg">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="btn-garden rounded-full mt-4 !py-3.5 shadow-xl">
                    VALIDAR ACCESO
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO: MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
    <div class="glass-panel arch-border w-full max-w-lg p-8 md:p-10 text-left relative overflow-y-auto max-h-[95vh]">
        <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--fairy-gold)]/30 pb-4">
            <h3 class="text-2xl md:text-3xl font-serif text-[var(--starlight)] uppercase tracking-widest">Colgar un Deseo</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-stone-400 hover:text-[var(--fairy-gold)] transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            
            <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Tu Nombre</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="input-dark font-serif" style="background: rgba(0,0,0,0.2); padding-left:10px;">
            </div>
             <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Relación *</label>
                <select name="vinculo_autor" required class="input-dark font-serif cursor-pointer">
                    <option value="" disabled selected>Seleccionar rama familiar...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero">Compañero</option>
                    <option value="Conocido/a">Conocido</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Tu Mensaje *</label>
                <textarea name="contenido" rows="4" required class="w-full border border-[var(--fairy-gold)]/30 bg-black/40 p-4 rounded-xl text-sm font-light outline-none focus:border-[var(--fairy-gold)] text-white resize-none italic font-serif" placeholder="Que la luz siempre los acompañe..."></textarea>
            </div>
            <div>
                <label class="block text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-stone-400 mb-2">Foto (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" class="w-full text-[10px] md:text-xs text-stone-400 border border-[var(--fairy-gold)]/30 rounded-xl p-2 bg-black/40 file:border-0 file:bg-[var(--fairy-gold)] file:text-black file:px-4 file:py-2 file:rounded-full file:font-bold cursor-pointer file:mr-4">
            </div>
            <button type="submit" id="btnPublicarMuroBoda" class="btn-garden btn-garden-solid rounded-full w-full mt-4 !py-3 shadow-xl">
                DEJAR EN EL ÁRBOL
            </button>
        </form>
    </div>
</div>

{{-- MODAL ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
    <div class="glass-panel p-8 md:p-12 text-center arch-border relative overflow-hidden max-h-[95vh] overflow-y-auto animate-fade-in w-full max-w-xl">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--fairy-gold)]/30 pb-4 text-left">
                <h3 class="text-2xl md:text-3xl font-serif text-[var(--starlight)] tracking-widest uppercase">Tu Invitación</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-[var(--fairy-gold)] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-5 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/40 p-5 rounded-2xl border border-[var(--fairy-gold)]/20 space-y-4 shadow-inner">
                    <span class="text-[10px] md:text-xs font-semibold uppercase tracking-widest text-[var(--rose-bloom)] block"><i class="fas fa-star mr-2"></i> Invitado Principal</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Nombre Completo *" required class="input-dark font-serif font-bold text-lg">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" placeholder="Correo (Para enviarte la llave)" class="input-dark font-serif">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 md:py-4 bg-transparent border border-dashed border-stone-500 text-stone-400 rounded-xl text-xs md:text-sm font-bold uppercase tracking-widest hover:border-[var(--fairy-gold)] hover:text-[var(--fairy-gold)] transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Añadir Acompañante
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-garden btn-garden-solid rounded-full w-full !text-sm !py-4 mt-6 shadow-xl">
                    CONFIRMAR PRESENCIA
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL RANKING DE TRIVIA --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="glass-panel arch-border w-full max-w-2xl p-6 md:p-10 text-center relative max-h-[95vh] flex flex-col">
        
        <div class="flex justify-between items-center mb-6 border-b border-[var(--fairy-gold)]/30 pb-4 shrink-0 text-left">
            <h3 class="text-2xl md:text-3xl font-serif text-[var(--starlight)] uppercase tracking-widest">
                <i class="fas fa-star mr-2 text-[var(--fairy-gold)] animate-pulse"></i> Sabios del Jardín
            </h3>
            <button onclick="cerrarModalRanking()" class="text-stone-400 hover:text-[var(--fairy-gold)] transition"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-2 space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--fairy-gold)]"></i>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[var(--fairy-gold)]/30 shrink-0">
            <button onclick="cerrarModalRanking()" class="btn-garden rounded-full w-full !py-3">
                Cerrar Pergamino
            </button>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/50 hover:text-[var(--fairy-gold)] transition z-50">
        <i class="fas fa-times text-3xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(232,195,125,0.2)] border border-[var(--fairy-gold)]/30 p-1" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80svh] bg-black rounded-xl"></video>
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
                document.getElementById('countdown').innerHTML = "<div class='text-3xl md:text-4xl font-script text-[var(--fairy-gold)] py-6 text-center w-full glow-text'>Bajo la luna, somos uno.</div>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="btn-garden btn-garden-solid rounded-full">Jugar Ahora</button>
                        <button onclick="verRanking()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--starlight)] hover:text-[var(--fairy-gold)] transition font-medium mt-3">Ver Puntuaciones</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="btn-garden rounded-full">Escribir Deseo</button>
                        <button onclick="mostrarMuroVisual()" class="text-[10px] md:text-xs uppercase tracking-widest text-[var(--starlight)] hover:text-[var(--fairy-gold)] transition font-medium mt-3">Ver El Árbol <i class="fa-solid fa-arrow-right ml-1"></i></button>
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
        document.getElementById('wrapper-dinamico-modal').className = "glass-panel p-8 md:p-12 text-center arch-border relative overflow-hidden max-h-[95vh] overflow-y-auto w-full max-w-lg";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 md:mb-8 border-b border-[var(--fairy-gold)]/30 pb-4 text-left">
                    <h3 class="text-xl md:text-2xl font-serif text-[var(--starlight)] tracking-widest uppercase"><i class="fas fa-key text-[var(--fairy-gold)] text-lg mr-2"></i> Palabra Mágica</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-[var(--fairy-gold)] transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-6 text-left">
                    <p class="text-xs md:text-sm font-light text-stone-300 leading-relaxed italic">Para revelar los senderos secretos, ingresa el código personal que el sistema te entregó al confirmar tu asistencia.</p>
                    <div>
                        <input type="text" id="inputCodigoIngreso" placeholder="EJ: MAGIA-4819" class="input-dark text-center tracking-[0.2em] uppercase font-serif text-lg">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="btn-garden btn-garden-solid rounded-full mt-4 !py-3.5 shadow-xl">
                        ABRIR SENDERO
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() { document.getElementById('modalFiltroAcceso').classList.add('hidden'); }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("Palabra mágica requerida."); return; }

        const btnVerificar = document.getElementById('btnVerificarCodigo');
        const txtOriginalVerificar = btnVerificar.innerHTML;
        
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-moon fa-spin mr-2"></i> Verificando...';

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
                    wrapper.className = "glass-panel p-8 md:p-12 text-center arch-border border border-[var(--fairy-gold)]/50 shadow-[0_0_30px_rgba(232,195,125,0.2)] relative max-w-lg w-full";
                    wrapper.innerHTML = `
                        <div class="py-6 text-center space-y-6 animate-pop">
                            <i class="fas fa-star text-5xl text-[var(--fairy-gold)] mb-2 drop-shadow-md opacity-80 animate-pulse"></i>
                            <h3 class="text-2xl font-serif text-[var(--starlight)] uppercase tracking-widest">Ya Completado</h3>
                            <p class="text-sm font-light text-stone-300 px-4 leading-relaxed">${data.message}</p>
                            <div class="pt-6 space-y-3">
                                <button onclick="verRanking()" class="btn-garden btn-garden-solid rounded-full w-full">Ver Sabios del Jardín</button>
                                <button onclick="cerrarModalFiltro()" class="btn-garden rounded-full w-full">Cerrar</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Estrella Fugaz" };
                }
            }

            if (!response.ok) { alert(data.message || "La magia no te reconoce."); throw new Error("invalid_code"); }
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Estrella Fugaz" ? data.nombre_invitado : "Invitado";
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
        botonPublicar.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Elevando...`;

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
                alert(data.message || "Fallo en la estrella.");
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
                        <div class="w-20 h-20 bg-[var(--fairy-gold)]/10 rounded-full flex items-center justify-center mx-auto border border-[var(--fairy-gold)] glow-text">
                            <i class="fas fa-feather-alt text-3xl text-[var(--fairy-gold)]"></i>
                        </div>
                        <h3 class="text-3xl font-serif text-[var(--starlight)] uppercase tracking-widest glow-text">¡Deseo Colgado!</h3>
                        <p class="text-sm font-light text-stone-300 px-4 leading-relaxed italic">${data.message}</p>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="btn-garden btn-garden-solid rounded-full w-full mt-6">Aceptar</button>
                    </div>
                `;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.className = "glass-panel p-8 md:p-12 text-center arch-border border border-[var(--fairy-gold)]/50 shadow-[0_0_30px_rgba(232,195,125,0.2)] relative max-w-lg w-full";
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 animate-pop">
                <i class="fas fa-moon text-[var(--fairy-gold)] text-5xl mb-2 opacity-80 animate-pulse glow-text"></i>
                <h1 class="text-2xl md:text-3xl font-serif text-[var(--starlight)] uppercase tracking-widest">¡Hola, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-stone-300 text-sm font-light leading-relaxed px-2 italic">Bajo la luz de las linternas, demuestra cuánto conoces nuestra historia. Responderás <strong class="text-[var(--fairy-gold)] font-bold">${bancoPreguntas.length} acertijos</strong>.</p>
                <button onclick="comenzarJuegoModal()" class="btn-garden btn-garden-solid rounded-full w-full mt-4 !py-3.5 shadow-xl">COMENZAR LA MAGIA</button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-bold uppercase tracking-[0.3em] text-[var(--fairy-gold)] border-b border-[var(--fairy-gold)]/30 pb-4">
                    <span id="info-progreso">ACERTIJO 1 DE X</span>
                    <span class="text-[var(--starlight)]"><i class="fas fa-hourglass-half mr-1 opacity-70 text-[var(--fairy-gold)]"></i> <span id="info-cronometro" class="font-mono text-sm">0</span>s</span>
                </div>
                <h2 id="texto-pregunta" class="text-xl md:text-2xl font-serif text-[var(--starlight)] leading-snug tracking-wide">Cargando la estrella...</h2>
                <div class="space-y-3 pt-2">
                    <button onclick="seleccionarOpcionModal('a')" class="w-full text-left p-4 border border-stone-600 bg-black/40 hover:bg-[var(--fairy-gold)]/10 hover:border-[var(--fairy-gold)] rounded-xl transition flex items-center space-x-4 text-stone-300 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--fairy-gold)]/50 text-[var(--fairy-gold)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--fairy-gold)] group-hover:text-black transition-colors">A</span>
                        <span id="texto-opcion-a" class="font-light text-sm md:text-base break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" class="w-full text-left p-4 border border-stone-600 bg-black/40 hover:bg-[var(--fairy-gold)]/10 hover:border-[var(--fairy-gold)] rounded-xl transition flex items-center space-x-4 text-stone-300 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--fairy-gold)]/50 text-[var(--fairy-gold)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--fairy-gold)] group-hover:text-black transition-colors">B</span>
                        <span id="texto-opcion-b" class="font-light text-sm md:text-base break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" class="w-full text-left p-4 border border-stone-600 bg-black/40 hover:bg-[var(--fairy-gold)]/10 hover:border-[var(--fairy-gold)] rounded-xl transition flex items-center space-x-4 text-stone-300 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--fairy-gold)]/50 text-[var(--fairy-gold)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--fairy-gold)] group-hover:text-black transition-colors">C</span>
                        <span id="texto-opcion-c" class="font-light text-sm md:text-base break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" class="w-full text-left p-4 border border-stone-600 bg-black/40 hover:bg-[var(--fairy-gold)]/10 hover:border-[var(--fairy-gold)] rounded-xl transition flex items-center space-x-4 text-stone-300 group">
                        <span class="w-8 h-8 rounded-full border border-[var(--fairy-gold)]/50 text-[var(--fairy-gold)] font-serif text-sm flex items-center justify-center shrink-0 group-hover:bg-[var(--fairy-gold)] group-hover:text-black transition-colors">D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-stone-400 font-light text-sm italic">Sin secretos compartidos en el bosque.</p>`;
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
                <i class="fas fa-circle-notch fa-spin text-4xl text-[var(--fairy-gold)] mb-2"></i>
                <h3 class="text-xl font-serif text-[var(--starlight)] uppercase tracking-widest">Anotando en las estrellas...</h3>
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
                        <i class="fas fa-award text-5xl text-[var(--fairy-gold)] mb-2 drop-shadow-[0_0_15px_rgba(232,195,125,0.4)]"></i>
                        <h3 class="text-3xl md:text-4xl font-serif text-[var(--starlight)] uppercase tracking-widest glow-text">¡COMPLETADO!</h3>
                        <p class="text-xs font-light text-stone-300 px-4 leading-relaxed italic">Tu sabiduría ha iluminado la noche.</p>
                        <div class="flex justify-center gap-4 mt-6">
                            <div class="text-center border border-[var(--fairy-gold)]/30 p-4 rounded-xl bg-black/40 w-28 shadow-inner">
                                <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-[var(--fairy-gold)] mb-1">Aciertos</span>
                                <span class="text-2xl font-serif text-[var(--starlight)]">${puntajeAcumulado} <span class="text-[10px] font-sans font-light text-stone-400 uppercase">pts</span></span>
                            </div>
                            <div class="text-center border border-[var(--fairy-gold)]/30 p-4 rounded-xl bg-black/40 w-28 shadow-inner">
                                <span class="block text-[9px] font-bold uppercase tracking-[0.2em] text-[var(--fairy-gold)] mb-1">Tiempo</span>
                                <span class="text-2xl font-serif text-[var(--starlight)]">${segundosTranscurridos}s</span>
                            </div>
                        </div>
                        <div class="pt-6 space-y-3">
                            <button onclick="verRanking()" class="btn-garden btn-garden-solid rounded-full w-full shadow-xl">Ver Puntuaciones</button>
                            <button onclick="cerrarModalFiltro()" class="btn-garden rounded-full w-full">Finalizar</button>
                        </div>
                    </div>
                `;
            }
        }).catch(err => { wrapper.innerHTML = `<p class="text-red-400 font-medium">Fallo en la comunicación.</p>`; });
    }

    let contadorAcompanantes = 0;
    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-black/30 p-4 rounded-xl border border-stone-600 space-y-3 relative animate-fade-in";
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-[var(--fairy-gold)]/20 pb-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--fairy-gold)]">Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-red-400 hover:text-red-300 text-[10px] font-bold uppercase transition"><i class="fas fa-times mr-1"></i> Deshacer</button>
            </div>
            <input type="text" class="input-dark" placeholder="Nombre Completo *" required>
            <input type="email" class="input-dark" placeholder="Correo (Opcional)">
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
        btnConfirmar.innerHTML = '<i class="fas fa-star fa-spin mr-2"></i> Pactando...';

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
                        <i class="fas fa-envelope-open-text text-4xl text-[var(--fairy-gold)] mb-2 opacity-80"></i>
                        <h3 class="text-2xl font-serif text-[var(--starlight)] uppercase tracking-widest leading-tight">Ya Confirmado</h3>
                        <p class="text-sm font-light text-stone-300 px-4 leading-relaxed italic">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-garden rounded-full mt-6 w-full">Aceptar</button>
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
                        <i class="fas fa-star text-5xl text-[var(--fairy-gold)] mb-2 drop-shadow-[0_0_15px_rgba(232,195,125,0.4)] animate-pulse"></i>
                        <h3 class="text-3xl md:text-4xl font-serif text-[var(--starlight)] uppercase tracking-widest glow-text">¡Asistencia Sellada!</h3>
                        <p class="text-xs font-light text-stone-300 italic">Guarda tu llave digital de cristal.</p>
                        <div class="bg-black/50 p-5 rounded-2xl text-left border border-[var(--fairy-gold)]/30 mt-4">
                            <p class="text-[9px] uppercase font-bold tracking-[0.3em] text-[var(--fairy-gold)] border-b border-[var(--fairy-gold)]/30 pb-2 mb-3">Tus Códigos de Acceso</p>
                            <div class="space-y-3">
                                ${data.codigos.map(item => `
                                    <div class="flex justify-between items-center">
                                        <span class="font-light text-xs text-stone-200 tracking-wider uppercase">${item.nombre}</span> 
                                        <span class="bg-[var(--glass-bg)] border border-[var(--fairy-gold)] text-[var(--fairy-gold)] px-3 py-1 rounded-lg text-xs font-serif tracking-widest">${item.codigo}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-garden btn-garden-solid rounded-full w-full mt-6 shadow-xl">Aceptar Destino</button>
                    </div>
                `;
                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-8 py-3 md:py-4 border border-[var(--fairy-gold)] text-[10px] md:text-xs tracking-[0.3em] uppercase text-[var(--fairy-gold)] w-full max-w-xs md:max-w-md bg-black/40 rounded-full text-center shadow-[0_0_15px_rgba(232,195,125,0.2)]">
                        <i class="fas fa-check mr-2"></i> PACTO DE ASISTENCIA
                    </div>
                `;
            }
        }).catch(error => { 
            if (error.message !== "already_handled") { alert("El flujo se interrumpió."); }
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
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-circle-notch fa-spin text-4xl text-[var(--fairy-gold)]"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-stone-400 font-light italic text-center text-sm mt-10">Las estrellas aún no hablan.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-lg text-stone-500 font-serif mr-4 w-6 text-center">#${index + 1}</span>`;
                        let resplandor = 'border-white/10 bg-black/40';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-star text-[var(--fairy-gold)] text-2xl mr-4 w-6 text-center drop-shadow-[0_0_10px_rgba(232,195,125,0.6)] animate-pulse"></i>';
                            resplandor = 'border-[var(--fairy-gold)]/60 bg-[var(--fairy-gold)]/10 shadow-[0_0_15px_rgba(232,195,125,0.2)]';
                        } else if(index === 1) {
                            medalla = '<i class="fa-regular fa-star text-stone-300 text-xl mr-4 w-6 text-center"></i>';
                            resplandor = 'border-stone-400/50 bg-white/5';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-4 rounded-2xl animate-fade-in mb-3 hover:-translate-y-1 transition-all duration-300">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-bold text-sm md:text-base text-white tracking-widest uppercase truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block text-[var(--fairy-gold)] font-serif text-xl leading-none">${jugador.puntaje_total} <span class="text-[9px] font-sans font-light text-stone-400 uppercase">pts</span></span>
                                    <span class="block text-[9px] text-stone-400 font-bold tracking-[0.2em] uppercase mt-1">${jugador.tiempo_empleado} seg</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-400 font-medium text-center mt-10 text-sm">Fallo de lectura.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-red-400 font-medium text-center mt-10 text-sm">Interferencia arcana.</p>';
        });
    }

    function cerrarModalRanking() { document.getElementById('modalRanking').classList.add('hidden'); }

    // --- SISTEMA MULTIMEDIA ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-transparent', 'border-[var(--fairy-gold)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--fairy-gold)]', 'border-transparent');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} Destellos`;
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
        if (seleccionadas.length === 0) { alert("Debes seleccionar al menos una foto."); return; }
        seleccionadas.forEach((item, index) => { setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000); });
        seleccionadas.forEach(item => toggleSeleccion(item));
    }

    function descargarTodas() {
        const todas = document.querySelectorAll('.foto-item');
        if (todas.length === 0) { alert("No hay fotos disponibles."); return; }
        todas.forEach((item, index) => { setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000); });
    }
</script>
</body>
</html>