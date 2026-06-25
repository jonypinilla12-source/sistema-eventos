<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Terminal de Acceso</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root { --neon: #00f2ff; --dark: #020617; }
        body { font-family: 'Share Tech Mono', monospace; background-color: var(--dark); color: #fff; overflow-x: hidden; }
        h1, h2, h3, .font-tech { font-family: 'Orbitron', sans-serif; }

        /* Efecto de Scanline */
        body::before {
            content: " ";
            display: block;
            position: fixed;
            top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), 
                        linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            z-index: 50;
            background-size: 100% 4px, 3px 100%;
            pointer-events: none;
        }

        .neon-border-glitch {
            border: 1px solid var(--neon);
            box-shadow: 0 0 10px rgba(0, 242, 255, 0.2), inset 0 0 10px rgba(0, 242, 255, 0.1);
        }

        .neon-text { color: var(--neon); text-shadow: 0 0 8px rgba(0, 242, 255, 0.6); }

        .status-pulse {
            width: 8px; height: 8px;
            background: var(--neon);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--neon);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.2); }
            100% { opacity: 1; transform: scale(1); }
        }

        .bg-grid {
            background-size: 40px 40px;
            background-image: radial-gradient(circle, rgba(0, 242, 255, 0.1) 1px, transparent 1px);
        }

        .animate-fade-in { animation: glitchIn 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards; }
        @keyframes glitchIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-grid">

@php
    // 🔥 LÓGICA DE TIEMPO CYBERPUNK
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
    
    // Desbloqueo del Data Stream a 1 Hora de inicio
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="max-w-6xl mx-auto px-4 py-12 space-y-24 relative z-10">

    {{-- HERO SECTION --}}
    <header class="text-center space-y-6 pt-10">
        <div class="inline-block border border-cyan-500/30 px-4 py-1 rounded-sm text-[10px] tracking-[0.4em] text-cyan-400 uppercase animate-pulse">
            SISTEMA ONLINE // TRANSMISIÓN AUTORIZADA
        </div>
        
        <h1 class="text-5xl md:text-8xl font-black neon-text uppercase tracking-tighter italic">
            {{ $evento->nombre_evento }}
        </h1>

        {{-- COUNTDOWN CON SEGUNDOS --}}
        <div id="countdown" class="flex justify-center gap-6 md:gap-12 py-8">
            <div class="text-center min-w-[70px]">
                <span id="days" class="text-4xl md:text-6xl font-bold block">00</span>
                <span class="text-[9px] uppercase tracking-widest opacity-50">Días</span>
            </div>
            <div class="text-center min-w-[70px]">
                <span id="hours" class="text-4xl md:text-6xl font-bold block text-cyan-400">00</span>
                <span class="text-[9px] uppercase tracking-widest opacity-50">Horas</span>
            </div>
            <div class="text-center min-w-[70px]">
                <span id="minutes" class="text-4xl md:text-6xl font-bold block">00</span>
                <span class="text-[9px] uppercase tracking-widest opacity-50">Min</span>
            </div>
            <div class="text-center min-w-[70px]">
                <span id="seconds" class="text-4xl md:text-6xl font-bold block neon-text">00</span>
                <span class="text-[9px] uppercase tracking-widest opacity-50">Seg</span>
            </div>
        </div>
    </header>

    {{-- INFO & IMAGEN ADAPTADA --}}
    <section class="grid md:grid-cols-2 gap-12 items-center">
        <div class="neon-border-glitch p-8 bg-black/60 backdrop-blur-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-2 opacity-10 font-bold text-xs">MODULE_v.2.0.26</div>
            <h2 class="text-2xl font-bold neon-text mb-6 uppercase tracking-widest border-b border-cyan-500/20 pb-2 text-left">Sinopsis del Módulo</h2>
            <p class="text-lg leading-relaxed text-cyan-50/80 italic text-left">
                {{ $evento->biografia_resumen }}
            </p>
            <div class="mt-8 flex gap-4 text-[10px] text-cyan-500/50 uppercase">
                <span>ENC_TYPE: AES-256</span>
                <span>STATUS: VERIFIED</span>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute -inset-1 bg-cyan-500 rounded-sm blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
            <div class="relative rounded-sm border border-cyan-500/50 w-full h-[400px] bg-black flex items-center justify-center overflow-hidden">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                         class="max-w-full max-h-full object-contain p-6 transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 pointer-events-none opacity-10" 
                         style="background-image: linear-gradient(rgba(0,242,255,0.1) 1px, transparent 1px); background-size: 100% 20px;"></div>
                @else
                    <div class="flex flex-col items-center gap-4 text-cyan-500/20">
                        <i class="fa-solid fa-microchip text-6xl"></i>
                        <span class="text-[10px] tracking-widest uppercase">Null Data Stream</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ITINERARIO ESTILO TERMINAL --}}
    <section class="space-y-10">
        <h2 class="text-3xl font-bold neon-text text-center md:text-left uppercase tracking-[0.2em]">
            <i class="fa-solid fa-terminal mr-4"></i>Secuencia de Eventos
        </h2>

        <div class="grid gap-1 border-l border-cyan-500/30 ml-4">
            @forelse($evento->itinerarios as $item)
                <div class="relative pl-8 pb-10 group">
                    <div class="absolute -left-[5px] top-1 status-pulse"></div>
                    <div class="flex flex-col md:flex-row md:items-baseline gap-2 md:gap-6">
                        <span class="text-xl font-bold text-cyan-400">
                            [{{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}]
                        </span>
                        <h3 class="text-xl font-bold uppercase tracking-wider group-hover:text-cyan-300 transition-colors">
                            {{ $item->actividad }}
                        </h3>
                    </div>
                    @if($item->descripcion)
                        <p class="mt-2 text-sm text-slate-400 font-light max-w-2xl border-l border-slate-800 pl-4">
                            > {{ $item->descripcion }}
                        </p>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center border border-dashed border-slate-800">
                    <p class="text-slate-500 italic">CARGANDO BASE DE DATOS... SIN REGISTROS.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- SECCIÓN EVIDENCIA VISUAL (CLOUD) --}}
    <section class="space-y-10">
        <h2 class="text-3xl font-bold neon-text text-center md:text-left uppercase tracking-[0.2em] mb-10">
            <i class="fas fa-server mr-4"></i>Data Stream // Visuales
        </h2>

        @if($mostrarGaleria)
            <div class="neon-border-glitch p-4 md:p-6 flex flex-col md:flex-row justify-between items-center mb-8 bg-black/40 gap-4 animate-fade-in">
                <div class="text-center md:text-left">
                    <span id="contador-seleccionadas" class="font-tech text-lg md:text-xl text-cyan-400 tracking-widest uppercase">
                        0 NODOS SELECCIONADOS
                    </span>
                    <p class="text-[9px] md:text-[10px] text-slate-500 uppercase tracking-widest mt-1">> CLICK TO EXTRACT DATA</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border border-cyan-500 text-cyan-400 px-6 py-2.5 md:py-3 hover:bg-cyan-500 hover:text-black transition uppercase tracking-widest w-full md:w-auto shadow-[0_0_10px_rgba(0,242,255,0.2)]">
                        > EXTRACT_SELECTION
                    </button>
                    <button onclick="descargarTodas()" class="text-[10px] md:text-xs font-bold bg-cyan-500 text-black px-6 py-2.5 md:py-3 hover:bg-white transition uppercase tracking-widest w-full md:w-auto shadow-[0_0_15px_rgba(0,242,255,0.4)]">
                        > DOWNLOAD_ALL
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
                                'etiqueta' => 'LOCAL_STORAGE'
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
                            'etiqueta' => 'CLOUD_SYNC'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4 w-full max-h-[60vh] overflow-y-auto hide-scroll p-1 animate-fade-in">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer overflow-hidden border border-cyan-500/20 bg-black hover:border-cyan-400 transition-all duration-300" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/40 hover:bg-black/10 transition">
                                <div class="w-10 h-10 border border-cyan-500 text-cyan-400 rounded-sm flex items-center justify-center backdrop-blur-sm group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-black transition shadow-[0_0_10px_rgba(0,242,255,0.4)]">
                                    <i class="fas fa-play text-xs ml-0.5"></i>
                                </div>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-48 object-cover filter contrast-125 saturate-50 group-hover:saturate-100 transition duration-500" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-48 object-cover filter contrast-125 saturate-50 group-hover:saturate-100 group-hover:scale-105 transition-all duration-700">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-cyan-500/20 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-screen"></div>
                        
                        <div class="check-icon absolute top-2 right-2 bg-cyan-500 text-black border border-white rounded-none w-5 h-5 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-[0_0_8px_var(--neon)] z-30 pointer-events-none">
                            <i class="fas fa-check text-[10px]"></i>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-black/90 border-t border-cyan-500/50 text-cyan-400 text-[8px] md:text-[9px] uppercase tracking-widest py-1.5 px-2 text-center z-30 pointer-events-none">
                            @if($foto['esVideo'])
                                <i class="fas fa-video mr-1"></i>
                            @else
                                <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-database' }} mr-1"></i>
                            @endif
                            > {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center p-12 border border-dashed border-cyan-500/30 bg-black/40">
                        <i class="fa-solid fa-server text-3xl text-cyan-500/40 mb-3"></i>
                        <p class="text-cyan-500/60 font-light text-xs md:text-sm tracking-widest uppercase">> NO DATA FRAGMENTS FOUND.</p>
                    </div>
                @endforelse
            </div>
        @else
            {{-- BLOQUEO DE CIBERSEGURIDAD HASTA 1 HORA DESPUÉS --}}
            <div class="w-full neon-border-glitch bg-black/60 p-8 md:p-16 text-center relative overflow-hidden" id="locked-gallery-msg">
                <div class="absolute inset-0 pointer-events-none opacity-5" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 2px, #00f2ff 2px, #00f2ff 4px);"></div>
                <div class="w-16 h-16 md:w-20 md:h-20 border border-red-500/50 bg-red-900/20 text-red-500 rounded-none flex items-center justify-center mx-auto mb-6 shadow-[0_0_15px_rgba(255,0,0,0.3)] animate-pulse">
                    <i class="fas fa-lock text-2xl md:text-3xl"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-red-500 mb-3 uppercase tracking-widest font-tech">ERROR: Acceso Restringido</h3>
                <p class="text-slate-400 font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-6">
                    > El nivel de seguridad para la extracción del Data Stream se liberará <strong class="text-cyan-400">1 HORA</strong> después del inicio del sistema central.
                </p>
                <button onclick="window.location.reload()" class="px-6 py-3 border border-cyan-500/50 text-[10px] uppercase tracking-widest text-cyan-400 hover:bg-cyan-500/10 transition">
                    > RE-CHECK_STATUS
                </button>
            </div>
        @endif
    </section>

    {{-- UBICACIÓN & RSVP --}}
    <footer class="grid md:grid-cols-2 gap-8 items-stretch pb-10">
        <div class="neon-border-glitch p-8 flex flex-col justify-center bg-black/40">
            <span class="text-[10px] text-cyan-500 mb-2 uppercase tracking-widest">Geo-Localización:</span>
            <p class="text-2xl font-bold mb-6 italic">{{ $evento->ubicacion_texto }}</p>
            @if($evento->google_maps_url)
            <a href="{{ $evento->google_maps_url }}" target="_blank" class="text-xs uppercase tracking-widest text-cyan-400 hover:text-white transition">
                [ INICIAR PROTOCOLO DE NAVEGACIÓN ]
            </a>
            @endif
        </div>

        <div id="contenedorBotonPrincipalRSVP" class="flex w-full">
            @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                <button onclick="abrirModalAsistencia()" class="w-full bg-cyan-500 text-black font-black text-xl uppercase tracking-[0.2em] py-8 hover:bg-white hover:shadow-[0_0_30px_#fff] transition-all duration-500 rounded-sm cursor-pointer">
                    Confirmar Acceso
                </button>
            @else
                <div class="w-full flex items-center justify-center p-6 bg-red-950/20 border border-red-500/30 text-red-400 text-xs font-bold tracking-[0.2em] uppercase rounded-sm text-center">
                    [ ERROR: ESCANEO DE CREDENCIAL QR REQUERIDO ]
                </div>
            @endif
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
    </footer>

    <div class="text-center text-[10px] opacity-20 py-10 uppercase tracking-[1em]">
        End of Transmission // {{ $invitado->token_acceso ?? 'GUEST-ID-001' }}
    </div>

</div>

{{-- MODAL REPRODUCTOR DE VIDEO TERMINAL --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-cyan-500/50 hover:text-cyan-400 transition z-50 border border-cyan-500/50 bg-black w-10 h-10 flex items-center justify-center">
        <i class="fas fa-times"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-none overflow-hidden neon-border-glitch" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

{{-- MODAL TERMINAL DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/90 backdrop-blur-xs p-4">
    <div class="bg-[#020617] text-white rounded-none max-w-md w-full p-6 text-center border border-cyan-500/40 shadow-[0_0_20px_rgba(0,242,255,0.15)] max-h-[90vh] overflow-y-auto animate-fade-in">
        
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b border-cyan-500/20 pb-3">
                <h3 class="text-lg font-bold neon-text uppercase tracking-widest"><i class="fa-solid fa-terminal mr-2"></i> rsvp_handshake.exe</h3>
                <button onclick="cerrarModalAsistencia()" class="text-cyan-500/40 hover:text-cyan-400 transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/80 p-4 border border-cyan-500/20 rounded-none space-y-4">
                    <span class="text-[10px] uppercase tracking-wider font-bold text-cyan-400 block">> ROOT_USER_DATA</span>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-slate-400 mb-1">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-cyan-500/30 bg-[#020617] p-2.5 rounded-none text-sm outline-none focus:border-cyan-400 text-cyan-100 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-slate-400 mb-1">Dirección de Email *</label>
                        <input type="email" id="inputEmailPrincipal" required class="w-full border border-cyan-500/30 bg-[#020617] p-2.5 rounded-none text-sm outline-none focus:border-cyan-400 text-cyan-100 font-mono" placeholder="operario@net.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2.5 border border-dashed border-cyan-500/20 text-cyan-400/60 rounded-none text-xs font-bold uppercase tracking-widest hover:bg-cyan-500/5 hover:text-cyan-400 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus text-[9px]"></i> [ INYECTAR NODO ADICIONAL ]
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full bg-cyan-500 text-black py-3.5 rounded-none font-bold text-sm uppercase tracking-widest hover:bg-white transition-all duration-300 shadow-[0_0_15px_rgba(0,242,255,0.2)] block text-center">
                    EJECUTAR REGISTRO
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
                document.getElementById('countdown').innerHTML = "<p class='text-2xl neon-text animate-pulse'>SISTEMA INICIADO // BIENVENIDO</p>";
                
                // Lógica de desbloqueo dinámico si el usuario mantiene la página abierta
                if (gap <= -3600000) {
                    const lockedGallery = document.getElementById('locked-gallery-msg');
                    if(lockedGallery) {
                        lockedGallery.innerHTML = `
                            <div class="absolute inset-0 pointer-events-none opacity-5" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 2px, #00f2ff 2px, #00f2ff 4px);"></div>
                            <div class="w-16 h-16 md:w-20 md:h-20 border border-cyan-500/50 bg-cyan-900/20 text-cyan-400 rounded-none flex items-center justify-center mx-auto mb-6 shadow-[0_0_15px_rgba(0,242,255,0.3)]">
                                <i class="fas fa-unlock-alt text-2xl md:text-3xl"></i>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-cyan-400 mb-3 uppercase tracking-widest font-tech">ACCESO CONCEDIDO</h3>
                            <p class="text-slate-400 font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-6">
                                > El nivel de seguridad ha sido degradado a público. La extracción de datos ahora está permitida.
                            </p>
                            <button onclick="window.location.reload()" class="px-8 py-3 bg-cyan-500 text-black font-bold text-[10px] uppercase tracking-widest hover:bg-white transition shadow-[0_0_10px_rgba(0,242,255,0.3)]">
                                > INICIAR CONEXIÓN
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
        div.className = "bg-black/60 p-4 border border-cyan-500/10 space-y-4 relative animate-fade-in";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-cyan-500/10 pb-2">
                <span class="text-[10px] uppercase tracking-widest font-bold text-slate-500">> SUB_NODE_LOG_${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-red-400 hover:text-red-300 text-xs uppercase tracking-wider transition font-bold">
                    [ REMOVE ]
                </button>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-400 mb-1">Nombre Completo *</label>
                <input type="text" class="input-nombre-acompanante w-full border border-cyan-500/30 bg-[#020617] p-2.5 rounded-none text-sm outline-none focus:border-cyan-400 text-cyan-100 font-mono" required>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-400 mb-1">Dirección de Email</label>
                <input type="email" class="input-email-acompanante w-full border border-cyan-500/30 bg-[#020617] p-2.5 rounded-none text-sm outline-none focus:border-cyan-400 text-cyan-100 font-mono" placeholder="subnexo@net.com">
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
        btnConfirmar.innerHTML = '> ENCRIPTANDO DATA...';

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
            
            // Fallback ciberpunk si la firma ya fue inyectada en el servidor
            if (response.status === 422 && data.already_registered) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                contenedorModal.innerHTML = `
                    <div class="py-6 text-center space-y-6 animate-fade-in">
                        <div class="w-16 h-16 bg-amber-500/10 rounded-none flex items-center justify-center mx-auto border border-amber-500/40">
                            <i class="fas fa-exclamation-triangle text-2xl text-amber-400"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-xl font-bold neon-text uppercase tracking-widest text-amber-400">[ REGISTRO DUPLICADO ]</h3>
                            <p class="text-sm text-slate-400 font-mono px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="p-4 bg-black border border-amber-500/20 rounded-none text-xs text-amber-300 text-left leading-relaxed font-mono">
                            > WARNING: El hash de este usuario ya fue validado en los logs centrales del main frame. Si requiere alterar sus parámetros o añadir sub-nodos, aborte e informe a soporte.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-transparent border border-stone-600 text-stone-400 py-2.5 text-xs font-bold uppercase tracking-widest hover:text-white hover:border-white transition-all">
                            ABORTAR CONEXIÓN
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
                
                // Renderizado tipo Consola de Red / Cyber Pass con códigos de acceso
                contenedorModal.innerHTML = `
                    <div class="py-6 text-center space-y-6 animate-fade-in">
                        <div class="w-16 h-16 bg-cyan-500/10 rounded-none flex items-center justify-center mx-auto border border-cyan-500/40">
                            <i class="fas fa-network-wired text-2xl neon-text"></i>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold text-white uppercase tracking-widest neon-text">HANDSHAKE_OK</h3>
                            <p class="text-xs text-slate-400 font-mono px-2">> Llaves criptográficas de entrada inyectadas con éxito.</p>
                        </div>

                        <div class="bg-black/90 border border-cyan-500/30 rounded-none p-5 text-left space-y-4 shadow-2xl">
                            <p class="text-[9px] uppercase font-bold tracking-[0.2em] text-cyan-400 border-b border-cyan-500/20 pb-2 flex justify-between">
                                <span><i class="fas fa-key mr-1"></i> ACCESS_KEYS_EMITTED</span> <span>SECURE</span>
                            </p>
                            <div class="text-xs space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t border-cyan-500/10' : ''}">
                                        <span class="font-mono tracking-wide text-slate-400">> ${item.nombre.toUpperCase()}:</span> 
                                        <span class="bg-cyan-950 border border-cyan-400 text-cyan-400 px-3 py-0.5 rounded-none text-[11px] font-bold font-mono tracking-widest shadow-[0_0_8px_rgba(0,242,255,0.2)]">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[10px] text-slate-500 font-mono tracking-tight leading-relaxed px-2">> Almacene estos tokens cifrados de forma local. Serán requeridos para interactuar con los módulos interactivos del muro y las trivias de red.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-cyan-500 text-black py-2.5 font-bold text-xs uppercase tracking-widest hover:bg-white transition-all duration-300">
                            DISCONNECT_TERMINAL
                        </button>
                    </div>
                `;

                // Bloqueamos el botón de fondo en el footer
                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="w-full py-8 border border-cyan-500 text-cyan-400 font-black text-xl uppercase tracking-[0.2em] bg-cyan-500/5 text-center">
                        SISTEMA ENLACE: OK
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("CRITICAL_ERROR: Fallo en el flujo de enlace.");
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    // --- SISTEMA MULTIMEDIA CYBERPUNK ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.replace('border-stone-800', 'border-[var(--neon)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--neon)]', 'border-stone-800');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} NODOS SELECCIONADOS`;
    }

    function playPreview(elemento) {
        const vid = elemento.querySelector('.vid-preview');
        if(vid) { vid.play().catch(e => console.log('Autoplay block')); }
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
            alert("SYS_WARNING: Ningún data fragment seleccionado para la extracción.");
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
            alert("SYS_ERROR: Servidor vacío.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>

</body>
</html>