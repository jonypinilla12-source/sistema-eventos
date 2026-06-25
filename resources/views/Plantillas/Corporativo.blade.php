<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Evento Corporativo</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&family=Lexend:wght@400;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        h1, h2, h3, .font-brand { font-family: 'Lexend', sans-serif; }

        .snap-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }

        .section-corp {
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            padding: 40px 20px;
        }
        @media (min-width: 768px) {
            .section-corp { padding: 40px; }
        }

        .btn-corp {
            background-color: #0f172a;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-corp:hover {
            background-color: #334155;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 12px;
            min-width: 80px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Animación de entrada suave */
        .animate-fade-in { animation: modalIn 0.3s ease-out forwards; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    // Variables de tiempo
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '09:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
    
    // 🔥 LÓGICA DE TIEMPO: Se activa 1 hora después del inicio
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: HERO / KEYNOTE --}}
    <section class="section-corp bg-slate-900 text-white overflow-hidden !flex-row">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#38bdf8 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="z-10 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 max-w-7xl items-center w-full">
            <div class="space-y-6 md:space-y-8 text-center md:text-left">
                <div class="inline-block px-4 py-1 bg-sky-500/20 border border-sky-500/50 rounded-full text-sky-400 text-xs font-bold uppercase tracking-widest">
                    Evento Oficial 2026
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight">
                    {{ $evento->nombre_evento }}
                </h1>
                
                {{-- CONTADOR CON SEGUNDOS --}}
                <div id="countdown" class="flex justify-center md:justify-start gap-2 md:gap-3">
                    <div class="stat-card bg-slate-800 border-slate-700 text-center">
                        <span id="days" class="text-xl md:text-3xl font-bold text-white block">00</span>
                        <span class="text-[8px] md:text-[9px] text-slate-400 uppercase font-bold">Días</span>
                    </div>
                    <div class="stat-card bg-slate-800 border-slate-700 text-center">
                        <span id="hours" class="text-xl md:text-3xl font-bold text-white block">00</span>
                        <span class="text-[8px] md:text-[9px] text-slate-400 uppercase font-bold">Hrs</span>
                    </div>
                    <div class="stat-card bg-slate-800 border-slate-700 text-center border-sky-500/50">
                        <span id="minutes" class="text-xl md:text-3xl font-bold text-sky-400 block">00</span>
                        <span class="text-[8px] md:text-[9px] text-slate-400 uppercase font-bold">Min</span>
                    </div>
                    <div class="stat-card bg-slate-800 border-slate-700 text-center">
                        <span id="seconds" class="text-xl md:text-3xl font-bold text-white block opacity-80">00</span>
                        <span class="text-[8px] md:text-[9px] text-slate-400 uppercase font-bold">Seg</span>
                    </div>
                </div>
            </div>

            <div class="relative w-full max-w-[300px] md:max-w-none mx-auto">
                <div class="rounded-3xl shadow-2xl overflow-hidden bg-slate-800 border border-slate-700 h-[300px] md:h-[450px] flex items-center justify-center">
                    @if($evento->fotosGaleria->count() > 0)
                        <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                             class="max-w-full max-h-full object-contain p-4 transition-all duration-700 hover:scale-105">
                    @else
                        <div class="text-center p-8 text-slate-600">
                            <i class="fa-solid fa-chart-line text-6xl mb-4"></i>
                            <p class="text-xs tracking-wider uppercase font-bold">Business Summit</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: PROPÓSITO E ITINERARIO --}}
    <section class="section-corp bg-white">
        <div class="max-w-4xl w-full flex flex-col items-center">
            <div class="text-center space-y-4 md:space-y-6">
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900">Sobre el Encuentro</h2>
                <div class="h-1.5 w-16 md:w-20 bg-sky-500 mx-auto rounded-full"></div>
                <p class="text-base md:text-xl text-slate-500 leading-relaxed font-light max-w-2xl px-2">
                    {{ $evento->biografia_resumen }}
                </p>
            </div>

            {{-- ITINERARIO --}}
            <div class="mt-8 md:mt-12 w-full max-w-2xl bg-slate-50 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm max-h-[50vh] overflow-y-auto hide-scroll">
                <h3 class="text-center text-xs md:text-sm font-bold text-slate-400 mb-6 md:mb-8 uppercase tracking-[0.2em] md:tracking-[0.3em] flex items-center justify-center gap-2 md:gap-3">
                    <span class="h-px w-6 md:w-8 bg-slate-200"></span>
                    Agenda Ejecutiva
                    <span class="h-px w-6 md:w-8 bg-slate-200"></span>
                </h3>

                <div class="space-y-6">
                    @forelse($evento->itinerarios as $item)
                        <div class="flex gap-4 md:gap-6 items-start group">
                            <div class="min-w-[45px] md:min-w-[55px] text-sky-600 font-bold text-sm md:text-base pt-0.5">
                                {{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}
                            </div>
                            <div class="flex-1 border-l-2 border-sky-500/20 pl-4 md:pl-6 relative">
                                <div class="absolute -left-[7px] top-1.5 w-3 h-3 bg-sky-500 rounded-full shadow-[0_0_8px_rgba(14,165,233,0.4)] transition-transform group-hover:scale-125"></div>
                                <h4 class="text-sm md:text-base font-bold text-slate-800 leading-tight">
                                    {{ $item->actividad }}
                                </h4>
                                @if($item->descripcion)
                                    <p class="text-xs md:text-sm text-slate-500 mt-1 font-light italic leading-snug">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 italic text-center py-4 text-sm">Programación por confirmar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="section-corp bg-slate-50">
        <div class="bg-white p-8 md:p-16 rounded-3xl shadow-sm border border-slate-200 max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center mx-4 md:mx-0">
            <div class="text-center md:text-left order-2 md:order-1">
                <span class="text-sky-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 block">Logística</span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6 text-slate-900 leading-tight">Ubicación Estratégica</h2>
                <p class="text-base md:text-lg text-slate-600 mb-6 md:mb-8 leading-relaxed">
                    {{ $evento->ubicacion_texto }} <br>
                    <span class="text-xs md:text-sm font-semibold text-slate-400 mt-2 block">Fecha: {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d F, Y') }}</span>
                </p>
                @if($evento->google_maps_url)
                <div class="flex justify-center md:justify-start">
                    <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-corp w-full md:w-auto text-sm md:text-base">
                        Abrir Mapa <i class="fa-solid fa-location-dot ml-2"></i>
                    </a>
                </div>
                @endif
            </div>
            <div class="h-48 md:h-64 bg-slate-100 rounded-2xl flex items-center justify-center border border-slate-200 overflow-hidden relative order-1 md:order-2">
                <i class="fa-solid fa-map-location-dot text-5xl md:text-7xl text-slate-200"></i>
                <div class="absolute inset-0 bg-sky-500/5"></div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4: REGISTRO VISUAL (CLOUD) --}}
    <section class="section-corp bg-white !h-auto min-h-screen py-20 !block">
        <div class="max-w-7xl mx-auto px-4 md:px-6 w-full flex flex-col items-center">
            
            <div class="text-center space-y-3 md:space-y-4 mb-10 md:mb-12">
                <span class="text-sky-500 text-[10px] md:text-xs font-bold uppercase tracking-widest">Multimedia</span>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900">Registro Visual del Evento</h2>
                <div class="h-1.5 w-16 bg-sky-500 mx-auto rounded-full"></div>
            </div>

            {{-- 🔥 LÓGICA DE BLOQUEO DE GALERÍA --}}
            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 bg-slate-50 border border-slate-200 p-4 md:p-6 rounded-2xl shadow-sm gap-4 animate-fade-in">
                    <div class="text-center md:text-left">
                        <span id="contador-seleccionadas" class="font-brand text-lg md:text-xl font-bold text-slate-700">
                            0 Archivos Seleccionados
                        </span>
                        <p class="text-[9px] md:text-[10px] text-slate-400 uppercase tracking-wider mt-1 font-medium">Haga clic en los elementos para su descarga</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border-2 border-slate-300 text-slate-600 px-6 py-2.5 md:py-3 hover:border-slate-800 hover:text-slate-800 transition uppercase tracking-wider rounded-lg w-full md:w-auto bg-white">
                            <i class="fas fa-download mr-2"></i> Bajar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-corp !w-full md:!w-auto !py-2.5 md:!py-3 !text-[10px] md:!text-xs">
                            <i class="fas fa-cloud-download-alt mr-2"></i> Descargar Todo
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
                                    'etiqueta' => 'Registro Oficial'
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
                                'etiqueta' => 'Archivo Cloud'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll p-2 animate-fade-in">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 bg-slate-100" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            @if($foto['esVideo'])
                                <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-slate-900/10 hover:bg-slate-900/20 transition">
                                    <div class="w-10 h-10 md:w-14 md:h-14 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition shadow-md">
                                        <i class="fas fa-play text-sky-600 ml-1 md:text-lg"></i>
                                    </div>
                                </button>
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover" muted loop playsinline preload="metadata"></video>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover group-hover:scale-105 transition-transform duration-700">
                            @endif
                            
                            <div class="overlay absolute inset-0 bg-sky-600/10 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-sky-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-slate-900/80 to-transparent pt-8 pb-3 px-3 text-white text-[8px] md:text-[10px] uppercase tracking-wider truncate text-left z-30 pointer-events-none">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video text-sky-400 mr-1.5"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} text-sky-400 mr-1.5"></i>
                                @endif
                                <span class="font-medium opacity-90">{{ $foto['etiqueta'] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center border border-dashed border-slate-300 p-12 bg-slate-50 rounded-2xl">
                            <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-3"></i>
                            <p class="text-slate-500 font-medium text-sm md:text-base">El repositorio multimedia se encuentra vacío actualmente.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl bg-slate-50 border border-dashed border-slate-200 rounded-3xl p-10 md:p-16 text-center" id="locked-gallery-msg">
                    <div class="w-20 h-20 bg-white shadow-sm border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 mb-3">Material Clasificado</h3>
                    <p class="text-slate-500 font-light text-sm md:text-base leading-relaxed max-w-md mx-auto mb-4">
                        El repositorio visual se habilitará automáticamente <strong class="text-sky-600 font-semibold">1 hora después</strong> del inicio oficial del evento.
                    </p>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-widest"><i class="fas fa-clock mr-1"></i> Paciencia, falta poco</p>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP --}}
    <section class="section-corp bg-slate-900 text-white !flex-col">
        <div class="text-center space-y-8 md:space-y-12 max-w-3xl w-full px-4">
            <div class="space-y-4">
                <h2 class="text-4xl md:text-6xl font-black uppercase tracking-tight">Confirmar <br class="md:hidden"> Acceso</h2>
                <div class="h-1.5 w-16 bg-sky-500 mx-auto rounded-full"></div>
            </div>
            
            <p class="text-slate-400 max-w-lg mx-auto font-light text-sm md:text-base leading-relaxed">
                Asegure su participación en este encuentro de alto nivel. El registro es de carácter obligatorio para generar las credenciales de ingreso al recinto.
            </p>
            
            <div id="contenedorBotonPrincipalRSVP">
                @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                    <button onclick="abrirModalAsistencia()" class="btn-corp !bg-sky-500 hover:!bg-sky-600 !text-white shadow-xl shadow-sky-900/50 w-full max-w-xs md:max-w-md">
                        Finalizar Registro <i class="fa-solid fa-arrow-right ml-2"></i>
                    </button>
                @else
                    <div class="px-6 py-4 border border-dashed border-slate-600 text-[10px] md:text-xs font-bold uppercase tracking-widest text-slate-400 w-full max-w-xs md:max-w-md mx-auto bg-slate-800/50 rounded-xl">
                        Acreditación vía Código QR Requerida
                    </div>
                @endif
            </div>
            
            <div class="pt-8 flex justify-center gap-6 md:gap-8 text-[9px] md:text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-chair text-sky-500"></i> Localidad: <span class="text-slate-300">{{ $invitado->mesa_asignada ?? 'Preferencial' }}</span>
                </div>
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
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-slate-900/95 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-slate-400 hover:text-white transition z-50 bg-slate-800 w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center border border-slate-600">
        <i class="fas fa-times md:text-xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-xl md:rounded-2xl overflow-hidden shadow-2xl border border-slate-700" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

{{-- MODAL PÚBLICO DE ASISTENCIA - EDICIÓN CORPORATIVA / CORPORATE EXECUTIVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
    <div class="bg-white text-slate-900 rounded-2xl max-w-md w-full p-6 text-center shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto animate-fade-in">
        
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b pb-4 text-left">
                <h3 class="text-lg font-bold text-slate-800 tracking-tight"><i class="fa-solid fa-id-card text-sky-600 mr-2"></i> Formulario de Acreditación</h3>
                <button onclick="cerrarModalAsistencia()" class="text-slate-400 hover:text-slate-600 transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-slate-50 p-4 border border-slate-200 rounded-xl space-y-4">
                    <span class="text-[10px] uppercase tracking-wider font-bold text-sky-600 block"><i class="fas fa-user mr-1"></i> Asistente Titular</span>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre y Apellido *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-slate-200 bg-white p-3 rounded-lg text-sm outline-none focus:border-sky-500 transition text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Correo Corporativo / Personal</label>
                        <input type="email" id="inputEmailPrincipal" class="w-full border border-slate-200 bg-white p-3 rounded-lg text-sm outline-none focus:border-sky-500 transition text-slate-800" placeholder="nombre@empresa.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 border-2 border-dashed border-slate-200 text-slate-600 rounded-lg text-xs font-semibold uppercase tracking-wider hover:bg-slate-50 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Registrar Colaborador Adicional
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full bg-slate-900 text-white py-4 rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-slate-800 shadow-md transition-all duration-300 mt-6 block text-center">
                    Confirmar Inscripción
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
                document.getElementById('countdown').innerHTML = "<p class='text-lg md:text-xl font-bold text-sky-500 uppercase tracking-[0.2em] md:tracking-[0.3em]'>SISTEMA INICIADO</p>";
                
                // 🔥 LÓGICA DE JAVASCRIPT: Si el evento ya inició, verificamos si ya pasó 1 hora
                // 1 hora = -3600000 ms
                if (gap <= -3600000) {
                    const lockedGallery = document.getElementById('locked-gallery-msg');
                    if(lockedGallery) {
                        lockedGallery.innerHTML = `
                            <div class="w-20 h-20 bg-emerald-50 border border-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-unlock-alt text-3xl text-emerald-500"></i>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-slate-800 mb-3">¡Repositorio Disponible!</h3>
                            <p class="text-slate-500 font-light text-sm md:text-base leading-relaxed mb-6">
                                El material visual ya se encuentra desbloqueado para los asistentes.
                            </p>
                            <button onclick="window.location.reload()" class="btn-corp !text-xs !py-3 !px-6 shadow-md">
                                <i class="fas fa-sync-alt"></i> Sincronizar Galería
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
        div.className = "bg-slate-50 p-4 border border-slate-200 rounded-xl space-y-4 relative animate-fade-in";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400"><i class="fas fa-users mr-1"></i> Colaborador #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-rose-500 hover:text-rose-700 text-xs font-bold uppercase tracking-wide transition">
                    <i class="fas fa-trash-alt mr-1"></i> Remover
                </button>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Completo *</label>
                <input type="text" class="input-nombre-acompanante w-full border border-slate-200 bg-white p-3 rounded-lg text-sm outline-none focus:border-sky-500 transition text-slate-800" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Correo Electrónico (Opcional)</label>
                <input type="email" class="input-email-acompanante w-full border border-slate-200 bg-white p-3 rounded-lg text-sm outline-none focus:border-sky-500 transition text-slate-800" placeholder="colaborador@empresa.com">
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
                    <div class="py-6 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto border border-amber-200">
                            <i class="fas fa-exclamation-triangle text-xl md:text-2xl text-amber-500"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl font-bold text-slate-800 tracking-tight">Registro Preexistente</h3>
                            <p class="text-xs md:text-sm text-slate-500 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="p-3 md:p-4 bg-amber-50/50 border border-amber-100 rounded-xl text-[10px] md:text-xs text-amber-800 text-left leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i> Esta credencial ya fue emitida. Si requiere modificar el número de asistentes vinculados, contacte al comité organizador.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-slate-900 text-white py-2.5 md:py-3 rounded-lg text-[10px] md:text-xs uppercase font-bold tracking-wider hover:bg-slate-800 transition shadow-md mt-2 md:mt-4">
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
                    <div class="py-4 md:py-6 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto border border-emerald-200 shadow-sm">
                            <i class="fas fa-id-badge text-xl md:text-2xl text-emerald-500"></i>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Acreditación Exitosa</h3>
                            <p class="text-[10px] md:text-sm text-slate-500 font-light px-2">Sus identificadores corporativos han sido procesados en el sistema.</p>
                        </div>

                        <div class="bg-slate-900 border border-slate-800 rounded-xl md:rounded-2xl p-4 md:p-5 text-left space-y-3 md:space-y-4 shadow-xl text-white">
                            <p class="text-[8px] md:text-[9px] uppercase font-bold tracking-[0.2em] text-sky-400 border-b border-slate-800 pb-2 flex justify-between">
                                <span><i class="fas fa-bolt mr-1"></i> PASE DIGITAL</span> <span class="hidden md:inline">EVENTIFY O.S.</span>
                            </p>
                            <div class="text-[10px] md:text-xs space-y-2 md:space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t border-slate-800' : ''}">
                                        <span class="font-sans font-light tracking-wide text-slate-300">${item.nombre}:</span> 
                                        <span class="bg-slate-800 border border-slate-700 px-3 py-1 rounded-md text-[11px] font-bold text-sky-400 font-mono tracking-widest shadow-sm">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[9px] md:text-[10px] text-slate-400 italic max-w-xs mx-auto leading-relaxed px-2">Guarde estos códigos. Serán requeridos para dinámicas interactivas si el organizador lo dispone.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-slate-100 text-slate-800 border border-slate-200 py-2.5 md:py-3 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition shadow-sm mt-2">
                            Finalizar Proceso
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-8 py-3 md:py-4 border border-emerald-500/20 text-[10px] md:text-xs font-bold uppercase tracking-widest text-emerald-600 max-w-xs md:max-w-md mx-auto bg-emerald-500/5 rounded-xl animate-fade-in">
                        <i class="fas fa-check-circle mr-1 md:mr-2"></i> Registro Completado
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

    // --- SISTEMA MULTIMEDIA CORPORATIVO ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-slate-200', 'border-sky-500');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-sky-500', 'border-slate-200');
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
