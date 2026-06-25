<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Summit de Innovación</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --saas-bg: #f8fafc;
            --saas-text: #0f172a;
            --saas-muted: #64748b;
            --saas-border: rgba(226, 232, 240, 0.8);
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--saas-bg); 
            color: var(--saas-text); 
            scroll-behavior: smooth; 
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .snap-container {
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y proximity;
            scroll-behavior: smooth;
        }

        .section-saas {
            min-height: 100svh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            padding: 4rem 1.5rem;
            z-index: 10;
        }

        /* EFECTO DEGRADADO EN MALLA (MESH GRADIENT BLOBS) */
        .mesh-container {
            position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; background: #ffffff;
        }
        .blob {
            position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.6; animation: floatBlob 10s infinite alternate ease-in-out;
        }
        .blob-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: rgba(168, 85, 247, 0.4); } /* Purple */
        .blob-2 { top: 40%; right: -20%; width: 60vw; height: 60vw; background: rgba(59, 130, 246, 0.4); animation-delay: -2s; } /* Blue */
        .blob-3 { bottom: -20%; left: 20%; width: 45vw; height: 45vw; background: rgba(236, 72, 153, 0.3); animation-delay: -4s; } /* Pink */

        @media (max-width: 768px) {
            .blob { filter: blur(50px); }
            .blob-1 { width: 80vw; height: 80vw; }
            .blob-2 { width: 90vw; height: 90vw; }
        }

        @keyframes floatBlob {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        /* TARJETAS GLASSMORPHISM MODERNAS */
        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
            border-radius: 24px;
        }

        /* TEXTOS DEGRADADOS */
        .text-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* BOTONES SAAS (Píldoras limpias) */
        .btn-saas {
            background-color: var(--saas-text);
            color: white;
            padding: 14px 32px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            border-radius: 9999px; /* Forma de píldora */
            width: 100%;
            border: 1px solid transparent;
        }
        @media (min-width: 768px) { .btn-saas { width: auto; font-size: 0.9rem; padding: 14px 40px; } }

        .btn-saas:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3);
        }
        
        .btn-saas-outline {
            background-color: white;
            color: var(--saas-text);
            border: 1px solid var(--saas-border);
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .btn-saas-outline:hover {
            border-color: #cbd5e1;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        /* INPUTS MODERNOS */
        .input-saas {
            width: 100%; border: 1px solid #e2e8f0; border-radius: 12px;
            background: rgba(255,255,255,0.8); padding: 14px 16px; font-size: 0.95rem; outline: none;
            color: var(--saas-text); transition: all 0.2s; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .input-saas:focus { border-color: #3b82f6; background: white; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }

        .animate-fade-in { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
        
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

<div class="mesh-container">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

<div class="snap-container">

    {{-- SECCIÓN 1: KEYNOTE HERO --}}
    <section class="section-saas !p-0">
        <div class="z-10 w-full max-w-6xl px-6 flex flex-col justify-center items-center text-center h-full pt-10">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white/80 shadow-sm text-xs font-semibold text-blue-600 tracking-wide mb-8 animate-fade-in">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                KEYNOTE OFICIAL 2026
            </div>
            
            <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-[100px] font-extrabold tracking-tight leading-[1.05] mb-8 animate-fade-in" style="animation-delay: 0.1s">
                <span class="text-gradient">{{ $evento->nombre_evento }}</span>
            </h1>
            
            <p class="text-lg md:text-2xl text-slate-500 font-light max-w-2xl mx-auto leading-relaxed mb-12 animate-fade-in" style="animation-delay: 0.2s">
                Explorando las fronteras del conocimiento. Conéctate con líderes de la industria en una experiencia diseñada para inspirar.
            </p>
            
            {{-- CONTADOR CLEAN --}}
            <div id="countdown" class="flex justify-center gap-4 md:gap-8 animate-fade-in glass-card p-4 md:p-6 mb-10 w-full max-w-2xl" style="animation-delay: 0.3s">
                <div class="text-center w-16 md:w-24">
                    <span id="days" class="text-3xl md:text-5xl font-bold text-slate-800 tracking-tight block">00</span>
                    <span class="text-[10px] md:text-xs text-slate-400 font-medium uppercase mt-1 block">Días</span>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div class="text-center w-16 md:w-24">
                    <span id="hours" class="text-3xl md:text-5xl font-bold text-slate-800 tracking-tight block">00</span>
                    <span class="text-[10px] md:text-xs text-slate-400 font-medium uppercase mt-1 block">Hrs</span>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div class="text-center w-16 md:w-24">
                    <span id="minutes" class="text-3xl md:text-5xl font-bold text-slate-800 tracking-tight block">00</span>
                    <span class="text-[10px] md:text-xs text-slate-400 font-medium uppercase mt-1 block">Min</span>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div class="text-center w-16 md:w-24">
                    <span id="seconds" class="text-3xl md:text-5xl font-bold text-blue-500 tracking-tight block">00</span>
                    <span class="text-[10px] md:text-xs text-blue-400 font-medium uppercase mt-1 block">Seg</span>
                </div>
            </div>

            <div class="absolute bottom-8 animate-bounce text-slate-400">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: VISIÓN & AGENDA --}}
    <section class="section-saas">
        <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start px-4">
            
            {{-- Propósito --}}
            <div class="glass-card p-8 md:p-12 space-y-6 md:space-y-8 animate-fade-in flex flex-col justify-center h-full relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-bl-full blur-2xl"></div>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight">La Visión</h2>
                <p class="text-base md:text-lg text-slate-600 leading-relaxed font-light">
                    {{ $evento->biografia_resumen }}
                </p>
                <div class="pt-6 border-t border-slate-200/60 flex flex-col sm:flex-row gap-6">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Fecha</span>
                        <span class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Locación</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $evento->ubicacion_texto }}</span>
                    </div>
                </div>
                
                @if($evento->google_maps_url)
                    <div class="pt-2 relative z-10">
                        <a href="{{ $evento->google_maps_url }}" target="_blank" class="text-blue-600 font-semibold text-sm hover:text-blue-800 flex items-center transition">
                            Abrir en Google Maps <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                        </a>
                    </div>
                @endif
            </div>

            {{-- Agenda Lineal --}}
            <div class="glass-card p-8 md:p-12 animate-fade-in" style="animation-delay: 0.2s">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl md:text-2xl font-bold tracking-tight">Agenda del Día</h3>
                    <span class="text-xs font-medium bg-slate-100 text-slate-500 px-3 py-1 rounded-full">Itinerario</span>
                </div>

                <div class="space-y-6 max-h-[50vh] overflow-y-auto hide-scroll relative">
                    <div class="absolute left-[11px] top-4 bottom-4 w-px bg-slate-200"></div>
                    @forelse($evento->itinerarios as $item)
                        <div class="flex gap-6 items-start relative z-10 group">
                            <div class="w-6 h-6 rounded-full bg-white border-2 border-slate-200 flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:border-blue-500 transition-colors shadow-sm">
                                <div class="w-2 h-2 rounded-full bg-slate-300 group-hover:bg-blue-500 transition-colors"></div>
                            </div>
                            <div class="flex-1 pb-4">
                                <span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded mb-2 inline-block">
                                    {{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}
                                </span>
                                <h4 class="text-base font-semibold text-slate-800 tracking-tight leading-snug">
                                    {{ $item->actividad }}
                                </h4>
                                @if($item->descripcion)
                                    <p class="text-sm text-slate-500 font-light mt-1.5 leading-relaxed">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 italic text-center py-8 text-sm">El cronograma está siendo actualizado.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: ARCHIVO VISUAL (CLOUD ONEDRIVE) --}}
    <section class="section-saas !h-auto min-h-screen py-20 !block">
        <div class="max-w-7xl mx-auto px-4 w-full flex flex-col items-center">
            
            <div class="text-center space-y-3 mb-10 w-full animate-fade-in">
                <span class="text-blue-600 font-semibold text-xs tracking-widest uppercase block">Cloud Storage</span>
                <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight">Repositorio Digital</h2>
            </div>

            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 glass-card p-4 md:p-5 gap-4 animate-fade-in border-none shadow-sm bg-white/50">
                    <div class="text-center md:text-left flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <span id="contador-seleccionadas" class="font-bold text-sm text-slate-800 block">
                                0 Archivos Seleccionados
                            </span>
                            <p class="text-[10px] text-slate-500 font-medium">Haz clic en los recursos para exportar</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="btn-saas btn-saas-outline w-full md:w-auto !py-2.5 !px-5 !text-xs">
                            Exportar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-saas w-full md:w-auto !py-2.5 !px-5 !text-xs">
                            <i class="fas fa-cloud-download-alt"></i> Sincronizar Todo
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
                                    'etiqueta' => 'MEDIA OFICIAL'
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
                                'etiqueta' => 'MEDIA COMUNIDAD'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll pb-6 animate-fade-in">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer glass-card bg-white/40 overflow-hidden border border-white p-1 hover:border-blue-400 transition-all duration-300 aspect-square md:aspect-[4/3] flex items-center justify-center" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            <div class="w-full h-full rounded-2xl overflow-hidden relative bg-slate-100">
                                @if($foto['esVideo'])
                                    <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-slate-900/10 hover:bg-slate-900/20 transition">
                                        <div class="w-12 h-12 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition">
                                            <i class="fas fa-play text-blue-600 ml-1 text-sm"></i>
                                        </div>
                                    </button>
                                    <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover transition duration-700" muted loop playsinline preload="metadata"></video>
                                @else
                                    <img src="{{ $foto['url'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @endif
                            </div>
                            
                            <div class="overlay absolute inset-0 bg-blue-500/10 opacity-0 transition duration-300 z-20 pointer-events-none rounded-3xl"></div>
                            
                            <div class="check-icon absolute top-4 right-4 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-lg z-30 pointer-events-none">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md rounded-lg py-1.5 px-2.5 text-[8px] md:text-[9px] font-bold text-slate-700 uppercase tracking-widest z-30 pointer-events-none shadow-sm flex items-center gap-1.5 border border-white">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video text-blue-500"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} text-blue-500"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 glass-card bg-white/40 border border-dashed border-slate-300">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                <i class="fa-regular fa-image text-2xl"></i>
                            </div>
                            <p class="text-slate-500 font-medium text-sm">El repositorio está sincronizando archivos. Vuelve pronto.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl glass-card bg-white/60 p-12 md:p-16 text-center mx-auto shadow-sm" id="locked-gallery-msg">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-blue-500 shadow-sm border border-blue-100">
                        <i class="fas fa-lock text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Contenido Protegido</h3>
                    <p class="text-slate-500 font-light text-sm leading-relaxed max-w-md mx-auto mb-8">
                        Para garantizar la exclusividad del evento, los recursos multimedia se liberarán automáticamente <strong class="text-blue-600 font-semibold">1 hora posterior</strong> al inicio del Keynote.
                    </p>
                    <button onclick="window.location.reload()" class="btn-saas btn-saas-outline !py-2.5 !text-xs">
                        <i class="fas fa-sync-alt mr-2"></i> Refrescar Sistema
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: RSVP (ACREDITACIÓN DIGITAL) --}}
    <section class="section-saas">
        <div class="text-center space-y-6 md:space-y-8 max-w-3xl w-full px-4 animate-fade-in glass-card py-16 md:py-24 shadow-xl border border-white/80 bg-white/70">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto shadow-[0_10px_30px_rgba(59,130,246,0.3)] transform -rotate-3 hover:rotate-0 transition">
                <i class="fa-solid fa-qrcode text-3xl text-white"></i>
            </div>
            
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight">Acceso Exclusivo</h2>
            
            <p class="text-slate-500 max-w-md mx-auto font-light text-sm md:text-base leading-relaxed">
                Confirma tu lugar en este summit. El registro generará las credenciales digitales necesarias para el ingreso.
            </p>
            
            <div id="contenedorBotonPrincipalRSVP" class="pt-6 w-full flex justify-center">
                @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                    <button onclick="abrirModalAsistencia()" class="btn-saas w-full max-w-xs md:max-w-sm !py-4 !text-sm shadow-xl shadow-blue-900/10">
                        Completar Acreditación <i class="fa-solid fa-arrow-right ml-1"></i>
                    </button>
                @else
                    <div class="px-6 py-4 border border-slate-200 text-xs font-semibold text-slate-500 w-full max-w-xs md:max-w-md mx-auto bg-slate-50 rounded-2xl flex items-center justify-center gap-3">
                        <i class="fas fa-exclamation-circle text-amber-500"></i> Escaneo QR Requerido
                    </div>
                @endif
            </div>
            
            <div class="pt-8 flex flex-col items-center gap-2 text-[10px] font-semibold text-slate-400 uppercase tracking-widest">
                <p>Categoría: <span class="text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $invitado->mesa_asignada ?? 'POR DEFINIR' }}</span></p>
                <p>Dress Code: Smart Casual</p>
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

{{-- MODAL REPRODUCTOR DE VIDEO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-slate-900/90 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/70 hover:text-white transition z-50 bg-white/10 w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/20">
        <i class="fas fa-times text-lg"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-3xl overflow-hidden shadow-2xl border border-white/10 p-1" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black rounded-2xl"></video>
    </div>
</div>

{{-- MODAL PÚBLICO DE ASISTENCIA - SAAS --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4">
    <div class="glass-card bg-white/95 w-full max-w-md p-8 md:p-10 text-center animate-fade-in relative overflow-hidden shadow-2xl">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4 text-left">
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Registro Oficial</h3>
                <button onclick="cerrarModalAsistencia()" class="text-slate-400 hover:text-slate-700 transition w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center"><i class="fas fa-times text-sm"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-slate-50 p-5 border border-slate-200 rounded-2xl space-y-4 shadow-sm">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-blue-600 block flex items-center gap-2">
                        <i class="fas fa-user-circle"></i> Asistente Titular
                    </span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Nombre y Apellido *" required class="input-saas">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" class="input-saas" placeholder="Correo Corporativo (Opcional)">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3.5 border border-dashed border-slate-300 text-slate-500 rounded-2xl text-xs font-semibold hover:bg-slate-50 hover:text-blue-600 hover:border-blue-300 transition flex items-center justify-center gap-2 bg-white">
                    <i class="fas fa-plus"></i> Añadir Colega
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-saas w-full !py-4 mt-6 text-sm shadow-lg shadow-slate-200">
                    Procesar Credenciales
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
                document.getElementById('countdown').innerHTML = `
                    <div class="flex items-center justify-center gap-3 bg-blue-50 text-blue-600 px-6 py-3 rounded-full border border-blue-100 font-semibold text-sm">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                        EVENTO EN CURSO
                    </div>
                `;
                
                if (gap <= -3600000) {
                    const lockedGallery = document.getElementById('locked-gallery-msg');
                    if(lockedGallery) {
                        lockedGallery.innerHTML = `
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 border border-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6 transition hover:scale-105 shadow-sm transform -rotate-3">
                                <i class="fas fa-unlock-alt text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Acceso Liberado</h3>
                            <p class="text-slate-500 font-light text-sm leading-relaxed max-w-md mx-auto mb-8">
                                La sincronización con el servidor ha finalizado. El contenido visual ya está disponible para su descarga.
                            </p>
                            <button onclick="window.location.reload()" class="btn-saas !py-3">
                                <i class="fas fa-sync-alt mr-2"></i> Cargar Repositorio
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
        div.className = "bg-white p-5 border border-slate-200 space-y-4 relative animate-fade-in rounded-2xl shadow-sm";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <span class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Colega #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-slate-400 hover:text-red-500 text-xs font-medium transition flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md hover:bg-red-50">
                    <i class="fas fa-times"></i> Quitar
                </button>
            </div>
            <div>
                <input type="text" class="input-nombre-acompanante input-saas" placeholder="Nombre y Apellido *" required>
            </div>
            <div>
                <input type="email" class="input-email-acompanante input-saas" placeholder="Correo (Opcional)">
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
                    <div class="py-8 text-center space-y-4 animate-fade-in">
                        <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto text-amber-500 mb-4 border border-amber-100">
                            <i class="fas fa-info-circle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Registro Existente</h3>
                        <p class="text-sm text-slate-500 font-light px-2 leading-relaxed">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-saas w-full mt-6">
                            Entendido
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
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/30 transform hover:scale-105 transition mb-2">
                            <i class="fas fa-check text-2xl text-white"></i>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Acreditación Exitosa</h3>
                            <p class="text-xs text-slate-500 font-medium bg-slate-100 px-3 py-1 rounded-full inline-block">Credenciales generadas</p>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-left space-y-4 shadow-inner mt-4">
                            <p class="text-[9px] uppercase font-bold tracking-widest text-slate-400 border-b border-slate-200 pb-2">
                                <i class="fas fa-key mr-1 text-slate-400"></i> Tokens de Acceso
                            </p>
                            <div class="text-xs space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t border-slate-200' : ''}">
                                        <span class="font-sans font-medium text-slate-600 uppercase text-[10px]">${item.nombre}:</span> 
                                        <span class="bg-white border border-slate-300 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-800 tracking-widest shadow-sm">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <button onclick="cerrarModalAsistencia()" class="btn-saas w-full !py-4 mt-6">
                            Finalizar Proceso
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 py-4 border border-emerald-200 text-xs font-semibold text-emerald-700 w-full max-w-xs md:max-w-md mx-auto bg-emerald-50 rounded-2xl flex items-center justify-center gap-2 animate-fade-in shadow-sm">
                        <i class="fas fa-check-circle text-lg"></i> Asistencia Verificada
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
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
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
            elemento.classList.replace('border-white', 'border-blue-500');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-blue-500', 'border-white');
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
            alert("Atención: Seleccione al menos un elemento para descargar.");
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