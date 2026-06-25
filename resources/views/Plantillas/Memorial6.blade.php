<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>En Memoria de {{ $evento->nombre_evento }} | Luz Eterna</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --warm-bg: #FCF8F5;       /* Crema muy suave */
            --warm-card: #FFFFFF;     /* Blanco puro para tarjetas */
            --amber-glow: #E5A95A;    /* Ámbar suave (luz de vela) */
            --terracotta: #C06B52;    /* Terracota para acentos profundos */
            --text-dark: #4A423D;     /* Gris cálido oscuro para textos principales */
            --text-muted: #8C8077;    /* Gris cálido claro para textos secundarios */
        }

        body { 
            font-family: 'Montserrat', sans-serif; 
            background-color: var(--warm-bg); 
            color: var(--text-dark); 
            scroll-behavior: smooth; 
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-serif { font-family: 'Lora', serif; }
        
        /* Contenedor de scroll tipo "snap" */
        .snap-container { width: 100%; overflow-x: hidden; height: 100svh; overflow-y: scroll; scroll-snap-type: y proximity; }
        
        .full-screen { min-height: 100svh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 60px 20px; scroll-snap-align: start; position: relative; }

        /* EFECTO LUZ FLOTANTE (Partículas cálidas) */
        .light-particles {
            position: absolute; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
        }
        .particle {
            position: absolute;
            background: radial-gradient(circle, var(--amber-glow) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0.4;
            animation: floatUp 8s infinite ease-in-out alternate;
        }
        .p1 { width: 100px; height: 100px; bottom: -50px; left: 10%; animation-duration: 12s; }
        .p2 { width: 150px; height: 150px; bottom: -70px; left: 80%; animation-duration: 15s; animation-delay: 2s; }
        .p3 { width: 80px; height: 80px; top: 20%; left: 50%; animation-duration: 10s; animation-delay: 1s; opacity: 0.2; }

        @keyframes floatUp {
            0% { transform: translateY(0) scale(1); opacity: 0.2; }
            100% { transform: translateY(-100px) scale(1.2); opacity: 0.5; }
        }

        /* TARJETAS Y PANELES */
        .warm-panel {
            background: var(--warm-card);
            border: 1px solid rgba(229, 169, 90, 0.15);
            box-shadow: 0 15px 35px rgba(74, 66, 61, 0.04);
            border-radius: 12px;
        }

        /* DIVISOR CÁLIDO */
        .warm-divider {
            width: 100px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--amber-glow), transparent);
            margin: 2rem auto; position: relative;
        }
        .warm-divider::after {
            content: '\f46a'; /* Icono de hojita/fuego en fontawesome */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute; top: -10px; left: 50%; transform: translateX(-50%);
            color: var(--amber-glow); font-size: 0.9rem; background: var(--warm-bg); padding: 0 10px;
        }

        /* ANIMACIONES */
        .animate-fade-in { animation: fadeInDoc 0.6s ease-out forwards; }
        @keyframes fadeInDoc { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        /* Ocultar scrollbar */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* BOTONES CÁLIDOS */
        .btn-warm {
            background: transparent; color: var(--terracotta);
            border: 1px solid var(--terracotta); padding: 12px 32px;
            text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem; font-weight: 500;
            transition: all 0.4s ease; border-radius: 50px; display: inline-block; cursor: pointer;
        }
        .btn-warm:hover {
            background: var(--terracotta); color: white;
            box-shadow: 0 8px 20px rgba(192, 107, 82, 0.2);
            transform: translateY(-2px);
        }
        .btn-warm-solid {
            background: var(--amber-glow); color: white; border: none;
            box-shadow: 0 4px 15px rgba(229, 169, 90, 0.3);
        }
        .btn-warm-solid:hover {
            background: #d69848; box-shadow: 0 8px 25px rgba(229, 169, 90, 0.4);
        }

        /* INPUTS */
        .input-warm {
            width: 100%; border: 1px solid rgba(74, 66, 61, 0.1); border-radius: 8px;
            background: #faf7f5; padding: 14px 16px; font-size: 0.9rem; outline: none;
            color: var(--text-dark); transition: all 0.3s;
        }
        .input-warm:focus { border-color: var(--amber-glow); background: white; box-shadow: 0 0 0 3px rgba(229, 169, 90, 0.1); }
        .input-warm::placeholder { color: var(--text-muted); font-weight: 300; }
    </style>
</head>
<body>

@php
    // 🔥 LÓGICA DE TIEMPO
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    
    // La galería se habilita 1 hora después del inicio oficial
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="snap-container">
    
    {{-- SECCIÓN 1: HERO (LUZ ETERNA) --}}
    <section class="full-screen bg-gradient-to-b from-[#FFFaf5] to-[#F5EAE1] overflow-hidden">
        <div class="light-particles">
            <div class="particle p1"></div>
            <div class="particle p2"></div>
            <div class="particle p3"></div>
        </div>
        
        <div class="z-10 w-full max-w-4xl mx-auto flex flex-col items-center">
            
            <div class="mb-6 opacity-60 italic text-xs tracking-[0.3em] uppercase text-[var(--terracotta)] font-medium">Celebrando la vida de</div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl text-[var(--text-dark)] mb-4 font-serif font-light drop-shadow-sm px-4">
                {{ $evento->nombre_evento }}
            </h1>
            
            <div class="warm-divider"></div>
            
            <p class="text-[var(--text-muted)] mb-10 tracking-[0.3em] font-light text-sm">
                {{ \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('Y') }} — {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('Y') }}
            </p>
            
            <div class="w-64 h-80 md:w-[320px] md:h-[400px] rounded-t-full rounded-b-xl overflow-hidden border-[6px] border-white shadow-[0_20px_40px_rgba(229,169,90,0.15)] mb-10 relative bg-white">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover transition duration-1000 filter sepia-[0.1] hover:sepia-0">
                @else
                    <div class="w-full h-full bg-[#faf7f5] flex flex-col justify-center items-center">
                        <i class="fa-solid fa-dove text-5xl text-[var(--amber-glow)] opacity-40"></i>
                    </div>
                @endif
            </div>
            
            <p class="max-w-xl text-[var(--text-muted)] font-serif italic text-lg md:text-xl px-4 leading-relaxed">
                "Su recuerdo será un faro de luz cálida que nos acompañará en cada atardecer."
            </p>
            
            <div class="absolute bottom-6 animate-bounce text-[var(--amber-glow)] opacity-70">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: BIOGRAFÍA & ANCLAJES RÁPIDOS --}}
    <section class="full-screen bg-white">
        <div class="z-10 w-full max-w-4xl mx-auto flex flex-col items-center">
            
            <div class="w-16 h-16 rounded-full bg-[#FCF8F5] flex items-center justify-center mb-6 shadow-sm border border-[var(--amber-glow)]/20">
                <i class="fa-solid fa-seedling text-2xl text-[var(--terracotta)] opacity-80"></i>
            </div>
            
            <h2 class="text-3xl md:text-4xl mb-8 text-[var(--text-dark)] font-serif">Encuentro en su Memoria</h2>
            
            <div class="warm-panel p-8 md:p-12 space-y-6 text-center w-full mb-10 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[var(--amber-glow)] to-transparent opacity-30"></div>
                
                <p class="text-base md:text-lg text-[var(--text-dark)] font-light leading-relaxed">
                    {{ $evento->biografia_resumen }}
                </p>
                
                <div class="pt-8 mt-4 border-t border-stone-100 flex flex-col md:flex-row items-center justify-center md:space-x-8 space-y-4 md:space-y-0 text-[var(--text-muted)] text-sm">
                    <p class="flex items-center"><i class="far fa-calendar-alt text-[var(--amber-glow)] mr-2 text-lg"></i> {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('l d \d\e F, Y') }}</p>
                    <p class="flex items-center"><i class="far fa-clock text-[var(--amber-glow)] mr-2 text-lg"></i> {{ $evento->hora }} HRS</p>
                    <p class="flex items-center"><i class="fas fa-map-marker-alt text-[var(--amber-glow)] mr-2 text-lg"></i> {{ $evento->ubicacion_texto }}</p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-4 md:gap-8 text-xs text-[var(--text-muted)] uppercase tracking-widest mt-4 font-semibold">
                <a href="#seccionMuroMensajes" class="hover:text-[var(--terracotta)] transition pb-1 border-b border-transparent hover:border-[var(--terracotta)]">Ofrendas de Paz</a>
                <span class="hidden md:inline text-stone-300">•</span>
                <a href="#seccionGaleriaVis" class="hover:text-[var(--terracotta)] transition pb-1 border-b border-transparent hover:border-[var(--terracotta)]">Luz en Imágenes</a>
                <span class="hidden md:inline text-stone-300">•</span>
                <a href="#seccionLibroRecuerdos" class="hover:text-[var(--terracotta)] transition pb-1 border-b border-transparent hover:border-[var(--terracotta)]">Dejar Mensaje</a>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: EL MURO DE RECUERDOS PUBLICADOS --}}
    <section id="seccionMuroMensajes" class="w-full bg-[#FCF8F5] py-24 px-6 flex flex-col items-center min-h-screen snap-start relative">
        <div class="light-particles opacity-30">
            <div class="particle p2"></div>
        </div>
        
        <div class="max-w-5xl w-full text-center space-y-6 z-10">
            <span class="text-xs uppercase tracking-[0.4em] text-[var(--terracotta)] block font-medium"><i class="fa-solid fa-book-open-reader mr-2"></i>Palabras que abrazan</span>
            <h2 class="text-4xl md:text-5xl font-light text-[var(--text-dark)] font-serif">Libro de Condolencias</h2>
            <div class="warm-divider !bg-transparent"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left w-full mt-12">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="warm-panel p-8 flex flex-col justify-between hover:-translate-y-1 transition-all duration-500">
                        <div class="space-y-4">
                            @if($item->url_onedrive)
                                <div class="w-full h-52 overflow-hidden bg-stone-50 border border-stone-100 rounded-lg mb-4">
                                    @if(str_starts_with($item->url_onedrive, 'http'))
                                        @php
                                            $directImgUrl = $item->url_onedrive;
                                            if (str_contains($directImgUrl, '1drv.ms')) {
                                                $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                            } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                                $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                            }
                                        @endphp
                                        <img src="{{ $directImgUrl }}" class="w-full h-full object-cover hover:scale-[1.03] transition-all duration-700" onerror="this.style.display='none';">
                                    @else
                                        <img src="{{ asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover hover:scale-[1.03] transition-all duration-700">
                                    @endif
                                </div>
                            @endif
                            <i class="fas fa-quote-left text-3xl text-[var(--amber-glow)]/30 mb-2 block"></i>
                            <p class="text-[var(--text-dark)] font-light leading-relaxed text-base md:text-lg">
                                "{{ $item->contenido_texto }}"
                            </p>
                        </div>

                        <div class="pt-5 mt-5 border-t border-stone-100 flex justify-between items-center">
                            <div>
                                <span class="font-semibold text-[var(--terracotta)] block text-sm tracking-wide">{{ $item->nombre_autor }}</span>
                                <span class="text-[var(--text-muted)] font-light text-xs">{{ $item->vinculo_autor ?? 'Allegado' }}</span>
                            </div>
                            <div class="text-[10px] text-[var(--text-muted)] font-mono opacity-80 bg-stone-50 px-2 py-1 rounded">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 py-20 border border-dashed border-[var(--amber-glow)]/30 text-center text-[var(--text-muted)] space-y-4 w-full warm-panel">
                        <i class="fa-regular fa-envelope-open text-4xl block text-[var(--amber-glow)]/40"></i>
                        <p class="tracking-widest uppercase text-xs font-semibold text-[var(--text-dark)]">El libro digital aguarda sus palabras</p>
                        <p class="text-sm font-light">Aún no se han publicado mensajes. Comparta su apoyo y amor con la familia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3.5: REGISTRO VISUAL UNIFICADO (CLOUD ONEDRIVE) --}}
    <section id="seccionGaleriaVis" class="w-full py-24 px-6 flex flex-col items-center min-h-screen relative snap-start bg-white">
        <div class="max-w-6xl w-full text-center space-y-6 z-10">
            <span class="text-xs uppercase tracking-[0.4em] text-[var(--terracotta)] block font-medium"><i class="fa-regular fa-image mr-2"></i>Instantes de Luz</span>
            <h2 class="text-4xl md:text-5xl font-light text-[var(--text-dark)] font-serif">Memoria Visual</h2>
            <div class="warm-divider !bg-transparent"></div>

            {{-- LÓGICA DE BLOQUEO DE GALERÍA --}}
            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-10 warm-panel p-5 md:p-6 gap-4 animate-fade-in">
                    <div class="text-center md:text-left">
                        <span id="contador-seleccionadas" class="font-serif italic text-xl text-[var(--terracotta)]">
                            0 Seleccionadas
                        </span>
                        <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-widest mt-1">Haga clic en los recuerdos para descargar</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="btn-warm w-full md:w-auto !py-2.5">
                            <i class="fas fa-download mr-1.5"></i> Bajar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-warm btn-warm-solid w-full md:w-auto !py-2.5">
                            <i class="fas fa-images mr-1.5"></i> Obtener Todas
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
                                    'etiqueta' => 'ARCHIVO FAMILIAR'
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
                                'etiqueta' => 'APORTE DE CERCANOS'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full max-h-[65vh] overflow-y-auto hide-scroll p-2 animate-fade-in pb-10">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer overflow-hidden warm-panel border-2 border-transparent hover:border-[var(--amber-glow)] transition-all duration-300 p-1 aspect-square rounded-xl" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            <div class="w-full h-full rounded-lg overflow-hidden relative bg-[#faf7f5]">
                                @if($foto['esVideo'])
                                    <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/10 hover:bg-black/20 transition">
                                        <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-105 transition border border-[var(--amber-glow)]/30 shadow-md">
                                            <i class="fas fa-play text-[var(--terracotta)] text-sm ml-1"></i>
                                        </div>
                                    </button>
                                    <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover transition duration-1000 opacity-90 group-hover:opacity-100" muted loop playsinline preload="metadata"></video>
                                @else
                                    <img src="{{ $foto['url'] }}" class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-[1.03]">
                                @endif
                            </div>
                            
                            <div class="overlay absolute inset-0 bg-[var(--amber-glow)]/10 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-multiply rounded-xl"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-[var(--terracotta)] text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-2 left-2 right-2 bg-white/95 backdrop-blur-md border border-[var(--amber-glow)]/20 text-[var(--text-dark)] text-[7px] md:text-[8px] uppercase tracking-widest font-semibold py-2 px-2 text-center z-30 pointer-events-none rounded shadow-sm">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video opacity-50 mr-1 text-[var(--terracotta)]"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} opacity-50 mr-1 text-[var(--terracotta)]"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center p-16 warm-panel border border-dashed border-[var(--amber-glow)]/30 mx-2">
                            <i class="fa-regular fa-image text-4xl text-[var(--amber-glow)]/40 mb-4"></i>
                            <p class="text-[var(--text-muted)] font-light text-lg tracking-wide">El archivo visual se encuentra vacío en este momento.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl warm-panel border border-[var(--amber-glow)]/20 p-12 md:p-20 text-center shadow-lg mx-auto" id="locked-gallery-msg">
                    <div class="w-20 h-20 bg-[#FCF8F5] border border-[var(--amber-glow)]/30 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-lock text-2xl text-[var(--amber-glow)]"></i>
                    </div>
                    <h3 class="text-2xl font-serif text-[var(--text-dark)] mb-3">Galería en Custodia</h3>
                    <p class="text-[var(--text-muted)] font-light text-sm leading-relaxed max-w-md mx-auto mb-8">
                        Por respeto a los tiempos de la ceremonia, el archivo fotográfico se habilitará automáticamente <strong class="text-[var(--terracotta)] font-medium">1 hora después</strong> del inicio oficial.
                    </p>
                    <button onclick="window.location.reload()" class="btn-warm">
                        <i class="fas fa-sync-alt mr-2"></i> Refrescar Pantalla
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: FORMULARIO DE RECUERDOS --}}
    <section id="seccionLibroRecuerdos" class="full-screen bg-gradient-to-t from-[#FCF8F5] to-white border-t border-stone-100">
        <div class="light-particles opacity-20">
            <div class="particle p3"></div>
        </div>
        <div class="max-w-xl w-full px-6 text-center space-y-4 z-10">
            <span class="text-xs uppercase tracking-[0.4em] text-[var(--terracotta)] block font-medium"><i class="fa-regular fa-envelope-open mr-2"></i>Palabras para siempre</span>
            <h2 class="text-3xl md:text-5xl text-[var(--text-dark)] font-serif">Dejar una Ofrenda de Amor</h2>
            <div class="warm-divider !bg-transparent"></div>
            
            <div id="bloqueFormularioMensaje" class="warm-panel p-8 md:p-10 text-left space-y-6 shadow-xl w-full mt-10 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[var(--amber-glow)] to-transparent opacity-50"></div>

                <form id="formRegistrarLamento" onsubmit="enviarMensajeLamento(event, '{{ $evento->evento_id }}')" class="space-y-6" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-semibold">Clave de Acceso *</label>
                            <input type="text" id="inputCodigoValidar" required placeholder="Ej: JON-2897" class="input-warm text-center tracking-widest font-mono uppercase">
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-semibold">Su Vínculo *</label>
                            <select id="inputVinculoAutor" required class="input-warm cursor-pointer">
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="Familiar">Familiar directo</option>
                                <option value="Hermano/a">Hermano / Hermana</option>
                                <option value="Amigo/a">Amigo / Amiga</option>
                                <option value="Compañero de Trabajo">Compañero de trabajo</option>
                                <option value="Vecino/a">Vecino / Vecina</option>
                                <option value="Conocido/a">Conocido / Allegado</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-semibold">Su Nombre (Firma) *</label>
                        <input type="text" id="inputAutorMensaje" required placeholder="¿Cómo desea figurar en el libro?" class="input-warm">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-semibold">Mensaje de Condolencia o Anécdota *</label>
                        <textarea id="inputContenidoMensaje" required rows="4" placeholder="Escriba aquí sus palabras de consuelo..." class="input-warm resize-none leading-relaxed italic"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-semibold">Adjuntar Fotografía / Video (Opcional)</label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border border-stone-200 border-dashed bg-[#faf7f5] transition hover:bg-white cursor-pointer rounded-lg relative" onclick="document.getElementById('inputArchivoFoto').click()">
                            <div class="space-y-1 text-center">
                                <i class="fa-regular fa-images text-3xl text-[var(--amber-glow)]/60 mb-2 block"></i>
                                <div class="flex flex-col items-center text-xs text-[var(--text-muted)]">
                                    <span class="relative font-medium text-[var(--terracotta)] hover:text-[var(--text-dark)] underline tracking-wide">
                                        Seleccionar archivo del dispositivo
                                    </span>
                                    <input id="inputArchivoFoto" name="archivo" type="file" accept="image/*,video/*" class="hidden">
                                </div>
                                <p class="text-[9px] text-stone-400 font-mono mt-2 uppercase tracking-widest" id="txtNombreArchivo">Imágenes/Videos hasta 50MB.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="btnPublicarMuro" class="btn-warm btn-warm-solid w-full !py-4 shadow-md font-bold tracking-widest text-xs">
                        Publicar en el Libro Digital
                    </button>
                </form>
            </div>

            <div id="contenedorBotonAuxiliar" class="pt-6 text-center">
                <p class="text-xs text-[var(--text-muted)] mb-3 font-light">¿Aún no dispone de su clave personal?</p>
                <button onclick="abrirModalAsistencia()" class="text-[10px] font-bold uppercase tracking-widest text-[var(--terracotta)] hover:text-[var(--text-dark)] transition cursor-pointer border-b border-[var(--terracotta)]/50 pb-1">
                    Solicitar pase de acceso
                </button>
            </div>

                    {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ESTILO CELESTIAL 🔥 --}}
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

{{-- MODAL CÁLIDO PARA SOLICITAR CLAVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-stone-900/60 backdrop-blur-sm p-4">
    <div class="warm-panel max-w-md w-full p-8 text-center shadow-2xl max-h-[90vh] overflow-y-auto animate-fade-in relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-[var(--amber-glow)] opacity-80"></div>
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b border-stone-100 pb-4">
                <h3 class="text-xl font-serif text-[var(--text-dark)]">Libro de Dedicatorias</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-[var(--terracotta)] transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="formObtenerClave" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <div class="bg-[#faf7f5] p-6 rounded-xl border border-stone-100 space-y-5">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-bold">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="input-warm bg-white">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-muted)] mb-2 font-bold">Correo Electrónico *</label>
                        <input type="email" id="inputEmailPrincipal" required class="input-warm bg-white" placeholder="ejemplo@correo.com">
                    </div>
                </div>
                <button type="submit" class="btn-warm btn-warm-solid w-full !py-3.5">
                    Obtener Identificador
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO OSCURO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-stone-900/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/50 hover:text-[var(--amber-glow)] transition z-50">
        <i class="fas fa-times text-3xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-xl overflow-hidden shadow-[0_0_40px_rgba(229,169,90,0.15)] border border-stone-800" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

<script>
    // LÓGICA DE TIEMPO DEL RELOJ PARA LA GALERÍA
    document.addEventListener('DOMContentLoaded', function() {
        const fechaEventoStr = "{{ $evento->fecha_principal }}T{{ $evento->hora ?? '18:00:00' }}";
        const countDate = new Date(fechaEventoStr).getTime();

        const checkGalleryUnlock = () => {
            const now = new Date().getTime();
            const gap = countDate - now;

            if (gap <= -3600000) {
                const lockedGallery = document.getElementById('locked-gallery-msg');
                if(lockedGallery) {
                    lockedGallery.innerHTML = `
                        <div class="w-16 h-16 bg-[#FFFaf5] border border-[var(--amber-glow)]/40 rounded-full flex items-center justify-center mx-auto mb-6 transition duration-700 hover:scale-105 shadow-sm">
                            <i class="fas fa-unlock-alt text-2xl text-[var(--amber-glow)]"></i>
                        </div>
                        <h3 class="text-2xl font-serif text-[var(--text-dark)] mb-3">Archivo Desbloqueado</h3>
                        <p class="text-[var(--text-muted)] font-light text-sm leading-relaxed max-w-md mx-auto mb-8 italic">
                            El tiempo de respeto ha concluido. El material visual y memorias del evento ya se encuentran disponibles en este espacio.
                        </p>
                        <button onclick="window.location.reload()" class="btn-warm btn-warm-solid !py-3">
                            Visualizar Memorias
                        </button>
                    `;
                }
            }
        };

        setInterval(checkGalleryUnlock, 60000); 
        checkGalleryUnlock();
    });

    function abrirModalAsistencia() { document.getElementById('modalAsistencia').classList.remove('hidden'); }
    function cerrarModalAsistencia() { document.getElementById('modalAsistencia').classList.add('hidden'); }

    function enviarDatosAsistencia(event, eventoId) {
        event.preventDefault();
        const dataPayload = {
            nombre_invitado: document.getElementById('inputNombrePrincipal').value.trim(),
            email: document.getElementById('inputEmailPrincipal').value.trim()
        };
        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/invitacion/memorial/${eventoId}/firmar`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': tokenCsrf },
            body: JSON.stringify(dataPayload)
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                contenedorModal.innerHTML = `
                    <div class="py-6 text-center space-y-6 animate-fade-in">
                        <div class="w-16 h-16 bg-[#faf7f5] rounded-full flex items-center justify-center mx-auto border border-[var(--amber-glow)]/40 shadow-sm">
                            <i class="fas fa-feather-alt text-2xl text-[var(--terracotta)]"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-serif text-[var(--text-dark)]">Pase Generado</h3>
                            <p class="text-xs text-[var(--text-muted)] font-light px-2 italic">Su identificador único está listo para ser utilizado.</p>
                        </div>
                        <div class="bg-white border border-[var(--amber-glow)]/20 p-6 text-left space-y-4 rounded-xl shadow-sm">
                            <p class="text-[9px] uppercase font-bold tracking-widest text-[var(--terracotta)] border-b border-stone-100 pb-2">
                                <i class="fas fa-key mr-1"></i> Su clave de acceso
                            </p>
                            <div class="text-xs flex justify-between items-center pt-2">
                                <span class="text-stone-600 font-medium font-serif text-base">${data.codigos[0].nombre}:</span>
                                <span class="bg-[var(--warm-bg)] border border-[var(--amber-glow)]/40 px-3 py-1.5 rounded text-xs font-bold text-[var(--text-dark)] font-mono tracking-widest shadow-sm">${data.codigos[0].codigo}</span>
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia(); window.location.hash = 'seccionLibroRecuerdos';" class="btn-warm btn-warm-solid w-full mt-4 !py-3.5">
                            Copiar e Ir al Libro
                        </button>
                    </div>
                `;
            }
        });
    }

    document.getElementById('inputArchivoFoto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('txtNombreArchivo').innerText = `Archivo seleccionado: ${file.name}`;
            document.getElementById('txtNombreArchivo').classList.add('text-[var(--terracotta)]', 'font-medium');
        }
    });

    function enviarMensajeLamento(event, eventoId) {
        event.preventDefault();

        const botonPublicar = document.getElementById('btnPublicarMuro');
        
        botonPublicar.disabled = true;
        botonPublicar.classList.remove('btn-warm-solid');
        botonPublicar.style.backgroundColor = '#ccc';
        botonPublicar.style.cursor = 'not-allowed';
        botonPublicar.innerHTML = `<i class="fas fa-circle-notch fa-spin mr-2"></i> Subiendo ofrenda...`;

        const formData = new FormData();
        formData.append('nombre_autor', document.getElementById('inputAutorMensaje').value.trim());
        formData.append('vinculo_autor', document.getElementById('inputVinculoAutor').value);
        formData.append('contenido', document.getElementById('inputContenidoMensaje').value.trim());
        formData.append('codigo_verificacion', document.getElementById('inputCodigoValidar').value.trim().toUpperCase());

        const inputFoto = document.getElementById('inputArchivoFoto');
        if (inputFoto && inputFoto.files.length > 0) {
            formData.append('archivo', inputFoto.files[0]);
        }

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/invitacion/memorial/${eventoId}/registrar`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': tokenCsrf, 'Accept': 'application/json' },
            body: formData
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert(data.message || "Error al verificar las credenciales.");
                botonPublicar.disabled = false;
                botonPublicar.style.backgroundColor = '';
                botonPublicar.classList.add('btn-warm-solid');
                botonPublicar.style.cursor = 'pointer';
                botonPublicar.innerHTML = "Publicar en el Libro Digital";
                throw new Error("Fallo controlado en el backend.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const cajaFormulario = document.getElementById('bloqueFormularioMensaje');
                
                cajaFormulario.innerHTML = `
                    <div class="py-12 text-center space-y-6 animate-fade-in font-light relative">
                        <div class="w-16 h-16 border border-[var(--amber-glow)]/40 rounded-full flex items-center justify-center mx-auto text-[var(--amber-glow)] bg-[#faf7f5] shadow-sm">
                            <i class="fa-solid fa-heart text-2xl"></i>
                        </div>
                        <div class="space-y-3 relative z-10">
                            <h3 class="text-3xl font-serif text-[var(--text-dark)]">Ofrenda Registrada</h3>
                            <p class="text-base text-[var(--text-muted)] max-w-sm mx-auto leading-relaxed italic">"${data.message}"</p>
                        </div>
                        <div class="warm-divider !w-16"></div>
                        <p class="text-[10px] text-[var(--terracotta)] pt-2 tracking-[0.2em] uppercase font-semibold">Agradecemos profundamente su compañía en este momento.</p>
                    </div>
                `;
                
                setTimeout(() => { window.location.reload(); }, 3500);
            }
        })
        .catch(error => {
            console.error("Detalle del flujo:", error);
        });
    }

    // --- SISTEMA MULTIMEDIA ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('ring-2', 'ring-[var(--amber-glow)]', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-2', 'ring-[var(--amber-glow)]', 'ring-offset-2');
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

    function playPreview(elemento) { const vid = elemento.querySelector('.vid-preview'); if(vid) { vid.play().catch(e => console.log('Autoplay block')); } }
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
        if (seleccionadas.length === 0) {
            alert("Por favor, seleccione al menos una imagen para descargar.");
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
            alert("El archivo se encuentra vacío.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>

</body>
</html>