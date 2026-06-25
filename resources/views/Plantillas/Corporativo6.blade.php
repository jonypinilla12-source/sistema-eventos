<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Encuentro de Equipo</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --fun-bg: #FFF9F5;       /* Crema suave */
            --fun-coral: #FF6B6B;    /* Rojo Coral (Botones) */
            --fun-mint: #4ECDC4;     /* Menta (Acentos) */
            --fun-yellow: #FFE66D;   /* Amarillo Sol (Detalles) */
            --fun-dark: #2D3436;     /* Texto oscuro */
            --fun-gray: #636E72;     /* Texto secundario */
        }

        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: var(--fun-bg); 
            color: var(--fun-dark); 
            scroll-behavior: smooth; 
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-poppins { font-family: 'Poppins', sans-serif; }

        .snap-container {
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y proximity;
            scroll-behavior: smooth;
        }

        .section-fun {
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

        /* Formas divertidas de fondo */
        .blob-shape {
            position: absolute;
            z-index: 0;
            opacity: 0.5;
            pointer-events: none;
        }

        /* Tarjetas estilo "Burbuja" */
        .fun-card {
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
            border: 2px solid rgba(0,0,0,0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .fun-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 50px -10px rgba(0,0,0,0.08);
        }

        /* Botones Amigables (Pill, Bouncy) */
        .btn-fun {
            background-color: var(--fun-coral);
            color: white;
            padding: 14px 32px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            border-radius: 999px;
            transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            border: none;
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
            width: 100%;
        }
        @media (min-width: 768px) { .btn-fun { width: auto; font-size: 1.1rem; padding: 16px 40px; } }

        .btn-fun:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(255, 107, 107, 0.4);
            color: white;
        }
        .btn-fun:active { transform: scale(0.95); }
        .btn-fun:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

        .btn-fun-secondary {
            background-color: var(--fun-mint);
            box-shadow: 0 8px 20px rgba(78, 205, 196, 0.3);
        }
        .btn-fun-secondary:hover {
            box-shadow: 0 12px 25px rgba(78, 205, 196, 0.4);
        }

        /* Inputs muy redondeados */
        .input-fun {
            width: 100%; border: 2px solid #edf2f7; border-radius: 20px;
            background: #f8fafc; padding: 14px 20px; font-size: 1rem; outline: none;
            color: var(--fun-dark); transition: all 0.2s; font-family: 'Nunito', sans-serif;
            font-weight: 600;
        }
        .input-fun:focus { border-color: var(--fun-mint); background: white; box-shadow: 0 0 0 4px rgba(78, 205, 196, 0.15); }
        .input-fun::placeholder { color: #a0aec0; font-weight: 400; }

        .animate-bounce-soft { animation: bounceSoft 2s infinite ease-in-out alternate; }
        @keyframes bounceSoft { from { transform: translateY(0); } to { transform: translateY(-10px); } }

        .animate-pop { animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        @keyframes popIn { 0% { opacity: 0; transform: scale(0.8); } 100% { opacity: 1; transform: scale(1); } }
        
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

    {{-- SECCIÓN 1: HERO / BIENVENIDA --}}
    <section class="section-fun overflow-hidden">
        <div class="blob-shape bg-[var(--fun-yellow)] rounded-full w-96 h-96 -top-20 -left-20 mix-blend-multiply blur-3xl animate-bounce-soft"></div>
        <div class="blob-shape bg-[var(--fun-mint)] rounded-full w-[500px] h-[500px] bottom-0 right-[-100px] mix-blend-multiply blur-3xl animate-bounce-soft" style="animation-delay: 1s;"></div>
        
        <div class="z-10 w-full max-w-6xl px-4 flex flex-col md:flex-row items-center gap-12">
            
            <div class="w-full md:w-1/2 text-center md:text-left animate-pop">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border-2 border-[var(--fun-yellow)] shadow-sm text-sm font-bold text-[var(--fun-dark)] mb-6">
                    <i class="fas fa-rocket text-[var(--fun-coral)]"></i> Encuentro Corporativo
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-poppins font-extrabold leading-[1.1] mb-6 text-[var(--fun-dark)]">
                    {{ $evento->nombre_evento }}
                </h1>
                
                <p class="text-lg text-[var(--fun-gray)] font-medium mb-10 leading-relaxed max-w-lg mx-auto md:mx-0">
                    Únete a nosotros en una jornada llena de creatividad, trabajo en equipo y mucha buena energía. ¡No te lo pierdas!
                </p>

                {{-- CONTADOR DIVERTIDO --}}
                <div id="countdown" class="flex justify-center md:justify-start gap-3 sm:gap-4 w-full">
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-3 w-16 sm:w-20 text-center flex flex-col items-center justify-center">
                        <span id="days" class="text-2xl sm:text-3xl font-extrabold text-[var(--fun-coral)]">00</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-[var(--fun-gray)] uppercase mt-1">Días</span>
                    </div>
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-3 w-16 sm:w-20 text-center flex flex-col items-center justify-center">
                        <span id="hours" class="text-2xl sm:text-3xl font-extrabold text-[var(--fun-mint)]">00</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-[var(--fun-gray)] uppercase mt-1">Hrs</span>
                    </div>
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-3 w-16 sm:w-20 text-center flex flex-col items-center justify-center">
                        <span id="minutes" class="text-2xl sm:text-3xl font-extrabold text-[var(--fun-yellow)]">00</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-[var(--fun-gray)] uppercase mt-1">Min</span>
                    </div>
                    <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-3 w-16 sm:w-20 text-center flex flex-col items-center justify-center">
                        <span id="seconds" class="text-2xl sm:text-3xl font-extrabold text-[var(--fun-dark)]">00</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-[var(--fun-gray)] uppercase mt-1">Seg</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 relative flex justify-center animate-pop" style="animation-delay: 0.2s">
                <div class="relative w-full max-w-[400px] aspect-square">
                    <div class="absolute inset-0 bg-[var(--fun-coral)] rounded-[3rem] rotate-6 opacity-20"></div>
                    <div class="absolute inset-0 bg-[var(--fun-mint)] rounded-[3rem] -rotate-3 opacity-30"></div>
                    <div class="relative w-full h-full bg-white rounded-[3rem] shadow-xl border-4 border-white overflow-hidden flex items-center justify-center z-10 p-2">
                        @if($evento->fotosGaleria->count() > 0)
                            <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                                 class="w-full h-full object-cover rounded-[2.5rem]">
                        @else
                            <div class="text-center p-8">
                                <i class="fa-solid fa-face-laugh-beam text-6xl text-[var(--fun-yellow)] mb-4"></i>
                                <p class="text-sm font-bold text-[var(--fun-gray)]">¡Ponte Ready!</p>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-16 h-16 bg-[var(--fun-yellow)] rounded-full flex items-center justify-center text-2xl shadow-lg z-20 animate-bounce-soft">
                        🎉
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- SECCIÓN 2: DE QUÉ TRATA Y AGENDA --}}
    <section class="section-fun bg-white rounded-t-[3rem]">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start px-4">
            
            {{-- Propósito --}}
            <div class="space-y-6 md:space-y-8 flex flex-col justify-center h-full">
                <div>
                    <span class="text-[var(--fun-coral)] font-bold text-sm uppercase tracking-widest block mb-2">Lo que nos espera</span>
                    <h2 class="text-4xl md:text-5xl font-poppins font-bold text-[var(--fun-dark)]">El Propósito</h2>
                </div>
                <div class="w-16 h-2 bg-[var(--fun-yellow)] rounded-full"></div>
                <p class="text-base md:text-lg text-[var(--fun-gray)] font-medium leading-relaxed">
                    {{ $evento->biografia_resumen }}
                </p>
                
                <div class="fun-card p-6 bg-[#f8fafc] border-none flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-full bg-[var(--fun-mint)]/20 flex items-center justify-center text-[var(--fun-mint)] text-xl shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <p class="font-bold text-[var(--fun-dark)]">{{ $evento->ubicacion_texto }}</p>
                        <p class="text-sm text-[var(--fun-gray)]">{{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d M, Y') }} a las {{ $evento->hora }}</p>
                    </div>
                </div>
                
                @if($evento->google_maps_url)
                    <div>
                        <a href="{{ $evento->google_maps_url }}" target="_blank" class="text-[var(--fun-coral)] font-bold hover:underline flex items-center gap-2">
                            Ver mapa detallado <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                    </div>
                @endif
            </div>

            {{-- Agenda Fun --}}
            <div class="fun-card p-8 md:p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-full bg-[var(--fun-yellow)]/30 flex items-center justify-center text-amber-600 text-xl">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3 class="text-2xl font-poppins font-bold">Cronograma</h3>
                </div>

                <div class="space-y-6 max-h-[50vh] overflow-y-auto hide-scroll relative pl-4">
                    <div class="absolute left-[23px] top-6 bottom-6 w-[3px] bg-slate-100 rounded-full"></div>
                    
                    @forelse($evento->itinerarios as $item)
                        <div class="flex gap-6 items-start relative z-10 group">
                            <div class="w-12 h-12 rounded-full bg-white border-[3px] border-[var(--fun-mint)] flex items-center justify-center flex-shrink-0 z-10 group-hover:scale-110 transition-transform shadow-sm">
                                <i class="fas fa-clock text-[var(--fun-mint)] text-sm"></i>
                            </div>
                            <div class="flex-1 bg-slate-50 p-4 rounded-2xl group-hover:bg-[var(--fun-mint)]/5 transition-colors border border-slate-100">
                                <span class="text-xs font-bold text-[var(--fun-mint)] block mb-1">
                                    {{ \Carbon\Carbon::parse($item->hora)->format('H:i') }}
                                </span>
                                <h4 class="text-base font-bold text-[var(--fun-dark)]">
                                    {{ $item->actividad }}
                                </h4>
                                @if($item->descripcion)
                                    <p class="text-sm text-[var(--fun-gray)] font-medium mt-2">
                                        {{ $item->descripcion }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-tools text-3xl text-slate-300 mb-3"></i>
                            <p class="text-[var(--fun-gray)] font-bold">¡Estamos preparando sorpresas!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: ARCHIVO VISUAL (CLOUD) --}}
    <section class="section-fun !h-auto min-h-screen py-20 !block relative overflow-hidden bg-[#f8fafc]">
        <div class="absolute top-10 right-10 w-24 h-24 bg-[var(--fun-coral)] rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-10 left-10 w-32 h-32 bg-[var(--fun-mint)] rounded-full blur-3xl opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 w-full flex flex-col items-center relative z-10">
            
            <div class="text-center space-y-3 mb-10 w-full">
                <h2 class="text-4xl md:text-5xl font-poppins font-extrabold text-[var(--fun-dark)]">Nuestros Momentos</h2>
                <p class="text-[var(--fun-gray)] font-medium text-lg">La galería compartida del equipo 📸</p>
            </div>

            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 fun-card p-5 md:p-6 gap-4">
                    <div class="text-center md:text-left flex items-center gap-4">
                        <div class="hidden sm:flex w-12 h-12 rounded-full bg-[var(--fun-yellow)]/30 items-center justify-center text-amber-600 text-xl">
                            <i class="fas fa-images"></i>
                        </div>
                        <div>
                            <span id="contador-seleccionadas" class="font-poppins font-bold text-lg md:text-xl text-[var(--fun-dark)] block">
                                0 Fotos seleccionadas
                            </span>
                            <p class="text-xs text-[var(--fun-gray)] font-medium mt-1">Haz clic en las fotos para elegirlas</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="btn-fun btn-fun-secondary !py-3 !text-sm">
                            <i class="fas fa-download"></i> Bajar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-fun !py-3 !text-sm">
                            <i class="fas fa-cloud-download-alt"></i> Descargar Todo
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
                                'etiqueta' => 'DEL EQUIPO'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll pb-6 px-2">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer fun-card overflow-hidden border-4 border-white hover:border-[var(--fun-mint)] transition-all duration-300 aspect-square flex items-center justify-center p-0" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            <div class="w-full h-full relative bg-slate-100">
                                @if($foto['esVideo'])
                                    <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/10 hover:bg-black/20 transition">
                                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition text-[var(--fun-coral)]">
                                            <i class="fas fa-play ml-1 text-xl"></i>
                                        </div>
                                    </button>
                                    <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover transition duration-700" muted loop playsinline preload="metadata"></video>
                                @else
                                    <img src="{{ $foto['url'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @endif
                            </div>
                            
                            <div class="overlay absolute inset-0 bg-[var(--fun-mint)]/20 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-[var(--fun-mint)] text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-lg z-30 pointer-events-none border-2 border-white">
                                <i class="fas fa-check"></i>
                            </div>

                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl py-1.5 px-3 text-[10px] font-bold text-[var(--fun-dark)] z-30 pointer-events-none shadow-sm flex items-center gap-1.5">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video text-[var(--fun-coral)]"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} text-[var(--fun-mint)]"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 fun-card border-dashed border-2 border-slate-200">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                <i class="fa-regular fa-face-smile-wink text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[var(--fun-dark)] mb-2">¡Prepara tu mejor sonrisa!</h3>
                            <p class="text-slate-500 font-medium">Aún no hemos subido fotos a la nube. ¡Atento a las actualizaciones!</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl fun-card p-10 md:p-16 text-center mx-auto" id="locked-gallery-msg">
                    <div class="w-20 h-20 bg-[var(--fun-yellow)]/20 rounded-full flex items-center justify-center mx-auto mb-6 text-amber-500">
                        <i class="fas fa-gift text-4xl animate-bounce-soft"></i>
                    </div>
                    <h3 class="text-2xl font-poppins font-bold text-[var(--fun-dark)] mb-3">¡Es una sorpresa!</h3>
                    <p class="text-slate-500 font-medium text-sm md:text-base leading-relaxed max-w-md mx-auto mb-8">
                        Las fotos y videos del encuentro se habilitarán automáticamente <strong class="text-[var(--fun-coral)]">1 hora después</strong> del inicio oficial. ¡Disfruta el momento!
                    </p>
                    <button onclick="window.location.reload()" class="btn-fun btn-fun-secondary !py-3">
                        <i class="fas fa-sync-alt mr-2"></i> Revisar Estado
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: RSVP (FORMULARIO AMIGABLE) --}}
    <section class="section-fun bg-[var(--fun-dark)] text-white rounded-t-[3rem]">
        <div class="text-center space-y-6 md:space-y-8 max-w-3xl w-full px-4 relative z-10">
            
            <div class="w-24 h-24 bg-[var(--fun-coral)] rounded-3xl rotate-12 flex items-center justify-center mx-auto shadow-xl hover:rotate-0 transition-transform duration-300">
                <i class="fa-solid fa-ticket-alt text-4xl text-white"></i>
            </div>
            
            <h2 class="text-4xl md:text-6xl font-poppins font-extrabold tracking-tight">¡Confirma tu <br class="md:hidden">Lugar!</h2>
            
            <p class="text-slate-300 max-w-md mx-auto font-medium text-sm md:text-base leading-relaxed">
                Necesitamos que te registres para crear tus credenciales mágicas de acceso. ¡No te quedes fuera del equipo!
            </p>
            
            <div id="contenedorBotonPrincipalRSVP" class="pt-6 w-full flex justify-center">
                @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                    <button onclick="abrirModalAsistencia()" class="btn-fun !w-full max-w-xs md:max-w-sm !py-4 shadow-xl">
                        Anotarme Ahora <i class="fa-solid fa-hand-sparkles ml-2"></i>
                    </button>
                @else
                    <div class="px-6 py-4 border-2 border-dashed border-slate-600 text-sm font-bold text-slate-300 w-full max-w-xs md:max-w-md mx-auto bg-slate-800/50 rounded-2xl flex items-center justify-center gap-3">
                        <i class="fas fa-mobile-alt text-[var(--fun-yellow)] text-xl"></i> Escanea el QR para entrar
                    </div>
                @endif
            </div>
            
            <div class="pt-10 flex flex-col items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-800/50 inline-block px-8 py-4 rounded-3xl mx-auto border border-slate-700">
                <p class="flex items-center gap-2"><i class="fas fa-users text-[var(--fun-mint)]"></i> Grupo: <span class="text-white">{{ $invitado->mesa_asignada ?? 'Por asignar' }}</span></p>
                <p class="flex items-center gap-2"><i class="fas fa-tshirt text-[var(--fun-coral)]"></i> Dress Code: Casual & Cómodo</p>
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
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-white hover:text-[var(--fun-coral)] transition z-50 bg-white/10 w-12 h-12 rounded-full flex items-center justify-center backdrop-blur-md">
        <i class="fas fa-times text-xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-white rounded-3xl overflow-hidden shadow-2xl p-2" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black rounded-2xl"></video>
    </div>
</div>

{{-- MODAL PÚBLICO DE ASISTENCIA - EDICIÓN AMIGABLE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4">
    <div class="fun-card w-full max-w-md p-6 md:p-8 text-center animate-pop relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-[var(--fun-coral)] via-[var(--fun-yellow)] to-[var(--fun-mint)]"></div>
        
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4 text-left pt-2">
                <h3 class="text-xl font-poppins font-bold text-[var(--fun-dark)]">¡Súmate a la lista!</h3>
                <button onclick="cerrarModalAsistencia()" class="text-slate-400 hover:text-[var(--fun-coral)] transition w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center"><i class="fas fa-times"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-blue-50/50 p-5 border border-blue-100 rounded-2xl space-y-4">
                    <span class="text-xs font-extrabold text-blue-600 block flex items-center gap-2 uppercase tracking-wide">
                        <i class="fas fa-user-astronaut text-lg"></i> Tu Información
                    </span>
                    <div>
                        <input type="text" id="inputNombrePrincipal" placeholder="Tu Nombre y Apellido *" required class="input-fun bg-white shadow-sm">
                    </div>
                    <div>
                        <input type="email" id="inputEmailPrincipal" class="input-fun bg-white shadow-sm" placeholder="Tu correo electrónico (Opcional)">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-4 border-2 border-dashed border-slate-300 text-slate-500 rounded-2xl text-sm font-bold hover:bg-slate-50 hover:text-[var(--fun-mint)] hover:border-[var(--fun-mint)] transition flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i> Añadir un colega más
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="btn-fun w-full !py-4 mt-6 !text-lg">
                    ¡Confirmar Ahora!
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
                    <div class="flex items-center justify-center gap-3 bg-[var(--fun-yellow)] text-amber-800 px-8 py-4 rounded-full font-extrabold text-lg shadow-md animate-bounce-soft">
                        <i class="fas fa-fire text-2xl"></i> ¡EL EVENTO ESTÁ EN LLAMAS!
                    </div>
                `;
                
                // Lógica de desbloqueo dinámico de galería si el usuario tiene la web abierta
                if (gap <= -3600000) {
                    const lockedGallery = document.getElementById('locked-gallery-msg');
                    if(lockedGallery) {
                        lockedGallery.innerHTML = `
                            <div class="w-20 h-20 bg-[var(--fun-mint)]/20 text-[var(--fun-mint)] rounded-full flex items-center justify-center mx-auto mb-6 transition hover:scale-110">
                                <i class="fas fa-camera-retro text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-poppins font-bold text-[var(--fun-dark)] mb-2">¡Álbum Desbloqueado!</h3>
                            <p class="text-slate-500 font-medium text-sm leading-relaxed max-w-md mx-auto mb-8">
                                La espera terminó. Ya puedes ver todas las fotos y videos que el equipo ha estado compartiendo.
                            </p>
                            <button onclick="window.location.reload()" class="btn-fun btn-fun-secondary !py-3">
                                <i class="fas fa-sync-alt mr-2"></i> Cargar Galería
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
        div.className = "bg-orange-50/50 p-5 border border-orange-100 space-y-4 relative animate-pop rounded-2xl";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-orange-200/50 pb-3">
                <span class="text-xs font-bold text-orange-600 uppercase flex items-center gap-2"><i class="fas fa-user-friends"></i> Colega #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-slate-400 hover:text-red-500 text-xs font-bold transition flex items-center gap-1 bg-white px-3 py-1.5 rounded-full shadow-sm">
                    <i class="fas fa-times"></i> Quitar
                </button>
            </div>
            <div>
                <input type="text" class="input-nombre-acompanante input-fun bg-white" placeholder="Nombre de tu colega *" required>
            </div>
            <div>
                <input type="email" class="input-email-acompanante input-fun bg-white" placeholder="Correo electrónico (Opcional)">
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
                    <div class="py-8 text-center space-y-4 animate-pop">
                        <div class="w-20 h-20 bg-[var(--fun-yellow)]/20 rounded-full flex items-center justify-center mx-auto text-amber-500 mb-2">
                            <i class="fas fa-smile-wink text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-poppins font-bold text-[var(--fun-dark)]">¡Ya te tenemos anotado!</h3>
                        <p class="text-slate-500 font-medium text-sm leading-relaxed px-2">${data.message}</p>
                        <button onclick="cerrarModalAsistencia()" class="btn-fun w-full mt-6">
                            ¡Genial, gracias!
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
                    <div class="py-6 text-center space-y-6 animate-pop">
                        <div class="w-20 h-20 bg-[var(--fun-mint)] text-white rounded-[2rem] flex items-center justify-center mx-auto shadow-lg shadow-[var(--fun-mint)]/30 transform rotate-12 mb-2">
                            <i class="fas fa-check text-4xl"></i>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-3xl font-poppins font-extrabold text-[var(--fun-dark)] tracking-tight">¡Todo Listo!</h3>
                            <p class="text-sm text-slate-500 font-medium">Tus credenciales están creadas.</p>
                        </div>

                        <div class="bg-slate-50 border-2 border-slate-100 rounded-3xl p-6 text-left space-y-4">
                            <p class="text-xs font-bold text-[var(--fun-coral)] uppercase tracking-wider mb-2 flex items-center gap-2">
                                <i class="fas fa-ticket-alt"></i> Pases de Acceso
                            </p>
                            <div class="space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t-2 border-dashed border-slate-200' : ''}">
                                        <span class="font-sans font-bold text-slate-600 uppercase text-xs">${item.nombre}</span> 
                                        <span class="bg-white border-2 border-slate-200 px-4 py-2 rounded-xl text-xs font-extrabold text-[var(--fun-dark)] tracking-widest shadow-sm">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-xs text-slate-400 font-medium italic">Guarda estos códigos, podrían servirte para las dinámicas del evento 😉</p>

                        <button onclick="cerrarModalAsistencia()" class="btn-fun w-full !py-4 mt-2">
                            ¡Nos vemos allá!
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-8 py-4 border-2 border-[var(--fun-mint)] text-sm font-bold text-[var(--fun-dark)] w-full max-w-xs md:max-w-md mx-auto bg-white rounded-full flex items-center justify-center gap-3 animate-pop shadow-lg shadow-[var(--fun-mint)]/20">
                        <i class="fas fa-check-circle text-[var(--fun-mint)] text-xl"></i> ¡ESTÁS EN LA LISTA!
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("Ups, ocurrió un error. Intenta nuevamente.");
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
            elemento.classList.replace('border-white', 'border-[var(--fun-mint)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--fun-mint)]', 'border-white');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} Fotos seleccionadas`;
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
            alert("¡Hey! Selecciona al menos una foto haciendo clic sobre ella.");
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
            alert("Todavía no hay fotos en la galería.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>
</body>
</html>