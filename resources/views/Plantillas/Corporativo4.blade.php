<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Executive Summit</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --exec-dark: #0a0a0a;
            --exec-surface: #141414;
            --exec-gold: #C5A059;
            --exec-gold-light: #E8D09E;
            --exec-text: #F3F4F6;
            --exec-muted: #9CA3AF;
        }

        body { font-family: 'Montserrat', sans-serif; background-color: var(--exec-dark); color: var(--exec-text); scroll-behavior: smooth; overflow-x: hidden; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }

        .snap-container {
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }

        .section-exec {
            min-height: 100svh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            padding: 4rem 1.5rem;
        }

        /* Degradado metálico sutil de fondo */
        .metallic-bg {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
        }

        /* Líneas decorativas doradas */
        .gold-line-v { width: 1px; background: linear-gradient(to bottom, transparent, var(--exec-gold), transparent); }
        .gold-line-h { height: 1px; background: linear-gradient(to right, transparent, var(--exec-gold), transparent); }

        .btn-exec {
            background-color: transparent;
            color: var(--exec-gold-light);
            padding: 14px 32px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: all 0.4s ease;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            border: 1px solid var(--exec-gold);
            width: 100%;
        }
        @media (min-width: 768px) { .btn-exec { width: auto; font-size: 0.85rem; padding: 16px 40px; } }

        .btn-exec:hover {
            background-color: var(--exec-gold);
            color: var(--exec-dark);
            box-shadow: 0 10px 25px rgba(197, 160, 89, 0.2);
        }

        .btn-exec-solid {
            background-color: var(--exec-gold);
            color: var(--exec-dark);
        }
        .btn-exec-solid:hover {
            background-color: var(--exec-gold-light);
        }

        /* Formularios y Cajas VIP */
        .vip-panel {
            background: var(--exec-surface);
            border: 1px solid rgba(197, 160, 89, 0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .input-exec {
            width: 100%; border: none; border-bottom: 1px solid rgba(197, 160, 89, 0.3);
            background: transparent; padding: 12px 0; font-size: 0.9rem; outline: none;
            color: var(--exec-text); transition: border-color 0.3s;
        }
        .input-exec:focus { border-bottom-color: var(--exec-gold); }
        .input-exec::placeholder { color: var(--exec-muted); font-weight: 300; }

        .animate-fade-in { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '09:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: HERO / PORTADA VIP --}}
    <section class="section-exec !p-0">
        <div class="metallic-bg"></div>
        <div class="absolute inset-0 z-0">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                     class="w-full h-full object-cover opacity-20 filter grayscale mix-blend-screen">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[var(--exec-dark)] via-transparent to-[var(--exec-dark)]/50"></div>
        </div>
        
        <div class="z-10 w-full max-w-5xl px-4 flex flex-col items-center justify-center text-center">
            <span class="text-[9px] md:text-xs text-[var(--exec-gold)] uppercase tracking-[0.4em] font-semibold border-b border-[var(--exec-gold)]/50 pb-2 mb-8 animate-fade-in">
                EXECUTIVE SUMMIT 2026
            </span>
            
            <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-serif font-light leading-tight mb-8 text-[var(--exec-text)] tracking-wide animate-fade-in" style="animation-delay: 0.2s">
                {{ $evento->nombre_evento }}
            </h1>
            
            <div class="gold-line-h w-24 mb-10 mx-auto animate-fade-in" style="animation-delay: 0.4s"></div>
            
            {{-- CONTADOR LUXURY --}}
            <div id="countdown" class="flex justify-center gap-6 md:gap-12 animate-fade-in" style="animation-delay: 0.6s">
                <div class="text-center">
                    <span id="days" class="text-3xl md:text-5xl font-serif text-[var(--exec-gold-light)] block mb-1">00</span>
                    <span class="text-[8px] md:text-[10px] text-[var(--exec-muted)] uppercase tracking-widest">Días</span>
                </div>
                <div class="gold-line-v h-12 md:h-16 mt-2"></div>
                <div class="text-center">
                    <span id="hours" class="text-3xl md:text-5xl font-serif text-[var(--exec-gold-light)] block mb-1">00</span>
                    <span class="text-[8px] md:text-[10px] text-[var(--exec-muted)] uppercase tracking-widest">Hrs</span>
                </div>
                <div class="gold-line-v h-12 md:h-16 mt-2"></div>
                <div class="text-center">
                    <span id="minutes" class="text-3xl md:text-5xl font-serif text-[var(--exec-gold-light)] block mb-1">00</span>
                    <span class="text-[8px] md:text-[10px] text-[var(--exec-muted)] uppercase tracking-widest">Min</span>
                </div>
                <div class="gold-line-v h-12 md:h-16 mt-2"></div>
                <div class="text-center">
                    <span id="seconds" class="text-3xl md:text-5xl font-serif text-[var(--exec-gold)] opacity-70 block mb-1">00</span>
                    <span class="text-[8px] md:text-[10px] text-[var(--exec-muted)] uppercase tracking-widest">Seg</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: AGENDA Y PROPÓSITO --}}
    <section class="section-exec bg-[var(--exec-surface)]">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start px-4 md:px-8">
            
            {{-- Propósito --}}
            <div class="space-y-6 md:space-y-8 animate-fade-in">
                <h2 class="text-3xl md:text-5xl font-serif text-white">El Propósito</h2>
                <div class="gold-line-h w-16"></div>
                <p class="text-sm md:text-lg text-[var(--exec-muted)] leading-relaxed font-light">
                    {{ $evento->biografia_resumen }}
                </p>
                <div class="pt-6">
                    <p class="text-[10px] md:text-xs text-[var(--exec-gold)] uppercase tracking-[0.3em] font-semibold mb-2">Locación Oficial</p>
                    <p class="text-white font-serif italic text-lg">{{ $evento->ubicacion_texto }}</p>
                    <p class="text-[10px] text-[var(--exec-muted)] uppercase tracking-widest mt-2">{{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d F, Y') }}</p>
                </div>
                
                @if($evento->google_maps_url)
                    <div class="pt-4">
                        <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-exec !w-auto !py-3">
                            <i class="fa-solid fa-map-pin mr-2"></i> Direcciones
                        </a>
                    </div>
                @endif
            </div>

            {{-- Agenda --}}
            <div class="vip-panel p-6 md:p-10 relative animate-fade-in" style="animation-delay: 0.2s">
                <div class="absolute top-0 right-0 w-16 h-16 border-t border-r border-[var(--exec-gold)] opacity-30"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 border-b border-l border-[var(--exec-gold)] opacity-30"></div>
                
                <h3 class="text-xs md:text-sm font-semibold text-[var(--exec-gold)] mb-8 uppercase tracking-[0.4em] flex items-center gap-4">
                    <span class="gold-line-h flex-grow"></span> Agenda <span class="gold-line-h flex-grow"></span>
                </h3>

                <div class="space-y-6 max-h-[50vh] overflow-y-auto hide-scroll pr-2">
                    @forelse($evento->itinerarios as $item)
                        <div class="flex gap-6 items-start group">
                            <div class="min-w-[60px] text-right">
                                <span class="text-[var(--exec-gold-light)] font-serif text-lg md:text-xl block leading-none">
                                    {{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}
                                </span>
                            </div>
                            <div class="gold-line-v h-auto flex-shrink-0 relative group-hover:bg-[var(--exec-gold-light)] transition-colors">
                                <div class="absolute top-1 -left-1 w-2 h-2 rounded-full bg-[var(--exec-gold)] shadow-[0_0_10px_rgba(197,160,89,0.5)]"></div>
                            </div>
                            <div class="flex-1 pb-6">
                                <h4 class="text-sm md:text-base font-medium text-white uppercase tracking-wider mb-1">
                                    {{ $item->actividad }}
                                </h4>
                                @if($item->descripcion)
                                    <p class="text-xs md:text-sm text-[var(--exec-muted)] font-light leading-relaxed">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-[var(--exec-muted)] italic text-center py-8 text-sm">Agenda en estructuración.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: ARCHIVO VISUAL (CLOUD ONEDRIVE) --}}
    <section class="section-exec !h-auto min-h-screen py-20 !block">
        <div class="max-w-7xl mx-auto px-4 md:px-6 w-full flex flex-col items-center">
            
            <div class="text-center space-y-4 mb-12 md:mb-16">
                <span class="text-[var(--exec-gold)] text-[10px] md:text-xs font-semibold uppercase tracking-[0.4em]">Cobertura Oficial</span>
                <h2 class="text-3xl md:text-5xl font-serif text-white">Galería Ejecutiva</h2>
                <div class="gold-line-h w-16 mx-auto"></div>
            </div>

            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 vip-panel p-4 md:p-6 gap-4 animate-fade-in">
                    <div class="text-center md:text-left">
                        <span id="contador-seleccionadas" class="font-serif italic text-xl md:text-2xl text-[var(--exec-gold-light)]">
                            0 Archivos Seleccionados
                        </span>
                        <p class="text-[9px] md:text-[10px] text-[var(--exec-muted)] uppercase tracking-[0.2em] mt-1">Marque las imágenes para descargar</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="btn-exec w-full md:w-auto !py-3 !text-[10px]">
                            <i class="fas fa-download mr-2"></i> Descargar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-exec btn-exec-solid w-full md:w-auto !py-3 !text-[10px]">
                            <i class="fas fa-cloud-download-alt mr-2"></i> Archivo Completo
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
                                    'etiqueta' => 'PRENSA OFICIAL'
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
                                'etiqueta' => 'APORTE ASISTENTES'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll pb-6 animate-fade-in">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer border border-[var(--exec-surface)] hover:border-[var(--exec-gold)] transition-all duration-300 bg-black aspect-square md:aspect-[4/5] overflow-hidden" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            @if($foto['esVideo'])
                                <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/40 hover:bg-black/20 transition">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-md group-hover:scale-110 transition border border-white/20">
                                        <i class="fas fa-play text-white ml-1"></i>
                                    </div>
                                </button>
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover grayscale opacity-60 transition duration-700 group-hover:grayscale-0 group-hover:opacity-100" muted loop playsinline preload="metadata"></video>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-full object-cover grayscale opacity-70 group-hover:scale-105 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                            @endif
                            
                            <div class="overlay absolute inset-0 bg-[var(--exec-gold)]/10 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-screen"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-[var(--exec-gold)] text-[var(--exec-dark)] rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent pt-10 pb-3 px-3 text-[var(--exec-gold)] text-[8px] md:text-[9px] uppercase tracking-widest text-center z-30 pointer-events-none font-semibold">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video mr-1 opacity-70"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} mr-1 opacity-70"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16 border border-dashed border-[var(--exec-muted)]/30 bg-[var(--exec-surface)]">
                            <i class="fa-regular fa-image text-3xl text-[var(--exec-muted)] mb-3"></i>
                            <p class="text-[var(--exec-muted)] font-light text-xs md:text-sm tracking-[0.2em] uppercase">El registro visual se encuentra vacío.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl vip-panel p-10 md:p-16 text-center mx-auto" id="locked-gallery-msg">
                    <i class="fas fa-lock text-3xl md:text-4xl text-[var(--exec-gold)] mb-6 opacity-80"></i>
                    <h3 class="text-xl md:text-2xl font-serif text-white mb-3">Acceso Restringido</h3>
                    <p class="text-[var(--exec-muted)] font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-8">
                        Por políticas de privacidad, el repositorio visual se habilitará <strong class="text-[var(--exec-gold)]">1 hora posterior</strong> al inicio protocolar del evento.
                    </p>
                    <button onclick="window.location.reload()" class="btn-exec !py-3 !text-[10px]">
                        <i class="fas fa-sync-alt mr-2"></i> Validar Estatus
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: RSVP (ACREDITACIÓN VIP) --}}
    <section class="section-exec bg-[var(--exec-surface)]">
        <div class="text-center space-y-6 md:space-y-8 max-w-3xl w-full px-4 animate-fade-in">
            <i class="fa-solid fa-gem text-4xl text-[var(--exec-gold)] opacity-80"></i>
            <h2 class="text-4xl md:text-6xl font-serif uppercase tracking-widest text-white">Acreditación</h2>
            <div class="gold-line-h w-16 mx-auto"></div>
            
            <p class="text-[var(--exec-muted)] max-w-lg mx-auto font-light text-sm md:text-base leading-relaxed">
                Asegure su cupo en este encuentro exclusivo. La validación es obligatoria para la generación de credenciales de acceso al recinto.
            </p>
            
            <div id="contenedorBotonPrincipalRSVP" class="pt-6 w-full flex justify-center">
                @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                    <button onclick="abrirModalAsistencia()" class="btn-exec btn-exec-solid w-full max-w-xs md:max-w-md !py-4 shadow-xl">
                        CONFIRMAR ASISTENCIA
                    </button>
                @else
                    <div class="px-6 py-4 border border-[var(--exec-gold)]/30 text-[10px] md:text-xs font-semibold uppercase tracking-widest text-[var(--exec-gold)] w-full max-w-xs md:max-w-md mx-auto bg-black/40">
                        Código de Invitación Requerido
                    </div>
                @endif
            </div>
            
            <div class="pt-10 flex flex-col items-center gap-3 text-[9px] md:text-[10px] font-semibold text-[var(--exec-muted)] uppercase tracking-[0.3em]">
                <p>Categoría Asignada: <span class="text-[var(--exec-gold-light)]">{{ $invitado->mesa_asignada ?? 'POR DEFINIR' }}</span></p>
                <p>Dress Code: Business Formal / Etiqueta</p>
            </div>

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

{{-- MODAL REPRODUCTOR DE VIDEO CORPORATIVO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/50 hover:text-[var(--exec-gold)] transition z-50">
        <i class="fas fa-times text-2xl md:text-3xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black border border-[var(--exec-gold)]/30 shadow-[0_0_50px_rgba(0,0,0,0.8)]" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

{{-- MODAL PÚBLICO DE ASISTENCIA - EXECUTIVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
    <div class="vip-panel w-full max-w-md p-8 md:p-10 text-center animate-fade-in relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[var(--exec-gold)] to-transparent opacity-50"></div>
        
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-8 border-b border-[var(--exec-gold)]/20 pb-4 text-left">
                <h3 class="text-lg md:text-xl font-serif text-[var(--exec-text)] tracking-wider"><i class="fa-solid fa-id-card text-[var(--exec-gold)] mr-2 text-sm"></i> Formulario VIP</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-500 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/40 p-5 border border-white/5 space-y-5">
                    <span class="text-[9px] md:text-[10px] uppercase tracking-widest font-semibold text-[var(--exec-gold)] block">Titular Principal</span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Nombre y Apellido *" required class="input-exec">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" class="input-exec" placeholder="Correo Corporativo (Opcional)">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 border border-dashed border-[var(--exec-muted)]/50 text-[var(--exec-muted)] text-[10px] md:text-xs font-semibold uppercase tracking-widest hover:text-white hover:border-[var(--exec-gold)] transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Registrar Acompañante
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-exec btn-exec-solid w-full !py-3.5 mt-6">
                    PROCESAR ACREDITACIÓN
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
                document.getElementById('countdown').innerHTML = "<p class='text-lg md:text-xl font-serif text-[var(--exec-gold)] uppercase tracking-[0.3em]'>El Summit ha Comenzado</p>";
                
                // Lógica de desbloqueo dinámico de galería si el usuario tiene la web abierta
                if (gap <= -3600000) {
                    const lockedGallery = document.getElementById('locked-gallery-msg');
                    if(lockedGallery) {
                        lockedGallery.innerHTML = `
                            <div class="w-16 h-16 bg-[var(--exec-gold)]/10 border border-[var(--exec-gold)]/30 rounded-full flex items-center justify-center mx-auto mb-6 transition hover:scale-105">
                                <i class="fas fa-unlock-alt text-xl text-[var(--exec-gold)]"></i>
                            </div>
                            <h3 class="text-xl md:text-2xl font-serif text-white mb-3 tracking-widest">Archivo Desbloqueado</h3>
                            <p class="text-[var(--exec-muted)] font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-8">
                                El material visual de la conferencia ya se encuentra disponible para los asistentes.
                            </p>
                            <button onclick="window.location.reload()" class="btn-exec !py-3">
                                <i class="fas fa-sync-alt mr-2"></i> Acceder al Repositorio
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
        div.className = "bg-black/30 p-5 border border-white/5 space-y-5 relative animate-fade-in";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-white/10 pb-2">
                <span class="text-[9px] uppercase tracking-widest font-semibold text-[var(--exec-muted)]">Colaborador #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-red-400 hover:text-red-500 text-[10px] font-bold uppercase tracking-widest transition">
                    Remover
                </button>
            </div>
            <div>
                <input type="text" class="input-nombre-acompanante input-exec" placeholder="Nombre y Apellido *" required>
            </div>
            <div>
                <input type="email" class="input-email-acompanante input-exec" placeholder="Correo Corporativo (Opcional)">
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
        btnConfirmar.classList.add('opacity-50', 'cursor-not-allowed');
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
                    <div class="py-8 text-center space-y-6 animate-fade-in">
                        <i class="fas fa-info-circle text-4xl text-[var(--exec-gold)] opacity-80"></i>
                        <h3 class="text-xl md:text-2xl uppercase tracking-widest text-white font-serif">Registro Existente</h3>
                        <p class="text-xs md:text-sm text-[var(--exec-muted)] font-light px-2 leading-relaxed">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-exec w-full mt-4">
                            Cerrar Ventana
                        </button>
                    </div>
                `;
                throw new Error("already_handled");
            }

            if (!response.ok) {
                throw new Error("Error en el Servidor.");
            }
            return data;
        })
        .then(data => {
            if (data && data.success) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                
                contenedorModal.innerHTML = `
                    <div class="py-6 text-center space-y-6 animate-fade-in">
                        <div class="w-16 h-16 bg-[var(--exec-gold)]/10 rounded-full flex items-center justify-center mx-auto border border-[var(--exec-gold)]/30">
                            <i class="fas fa-check text-2xl text-[var(--exec-gold)]"></i>
                        </div>
                        
                        <div class="space-y-2">
                            <h3 class="text-xl md:text-2xl font-serif text-white tracking-widest uppercase">Acreditación Exitosa</h3>
                            <p class="text-[10px] md:text-xs text-[var(--exec-muted)] font-light">Sus credenciales han sido procesadas correctamente.</p>
                        </div>

                        <div class="bg-black/50 border border-white/10 rounded-xl p-5 text-left space-y-4">
                            <p class="text-[9px] uppercase font-semibold tracking-widest text-[var(--exec-gold)] border-b border-white/10 pb-2">
                                <i class="fas fa-key mr-1"></i> Códigos de Acceso (VIP)
                            </p>
                            <div class="text-xs space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t border-white/5' : ''}">
                                        <span class="font-sans font-light tracking-wide text-[var(--exec-muted)] uppercase">${item.nombre}:</span> 
                                        <span class="bg-[var(--exec-gold)]/20 border border-[var(--exec-gold)] px-3 py-1 rounded text-[10px] font-bold text-[var(--exec-gold)] tracking-widest">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <button onclick="cerrarModalAsistencia()" class="btn-exec btn-exec-solid w-full !py-3.5 mt-4">
                            FINALIZAR PROCESO
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 py-4 border border-[var(--exec-gold)]/50 text-[10px] md:text-xs uppercase tracking-widest text-[var(--exec-gold)] max-w-xs md:max-w-md mx-auto bg-[var(--exec-gold)]/10 animate-fade-in text-center font-semibold">
                        <i class="fas fa-check mr-2"></i> Acreditación Verificada
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("Ocurrió un error en el sistema de acreditación.");
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-50', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-[var(--exec-surface)]', 'border-[var(--exec-gold)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--exec-gold)]', 'border-[var(--exec-surface)]');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} Archivos Seleccionados`;
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
            alert("Atención: Seleccione al menos un elemento para iniciar la transferencia.");
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
            alert("No hay archivos disponibles en el repositorio.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>