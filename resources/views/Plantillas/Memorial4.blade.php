<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>En Memoria de {{ $evento->nombre_evento }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --celestial-bg: #0b1121; /* Azul medianoche profundo */
            --celestial-card: rgba(30, 41, 59, 0.4); /* Tarjetas de cristal oscuro */
            --celestial-gold: #ceb379; /* Oro suave */
            --celestial-text: #e2e8f0; /* Texto claro */
            --celestial-muted: #94a3b8; /* Texto secundario */
        }

        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: var(--celestial-bg); 
            color: var(--celestial-text); 
            scroll-behavior: smooth; 
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-serif { font-family: 'Cormorant Garamond', serif; }
        
        .snap-container { width: 100%; overflow-x: hidden; height: 100svh; overflow-y: scroll; scroll-snap-type: y proximity; }
        
        .full-screen { min-height: 100svh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 60px 20px; scroll-snap-align: start; position: relative; }

        /* EFECTO CIELO ESTRELLADO */
        .stars-bg {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            background-image: 
                radial-gradient(1px 1px at 20px 30px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 40px 70px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 50px 160px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 90px 40px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 130px 80px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1.5px 1.5px at 160px 120px, #ffffff, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 200px 200px;
            opacity: 0.3;
            animation: twinkle 6s infinite linear;
        }
        @keyframes twinkle { 0% { opacity: 0.2; } 50% { opacity: 0.5; } 100% { opacity: 0.2; } }

        /* PANELES DE CRISTAL OSCURO */
        .glass-panel {
            background: var(--celestial-card);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(206, 179, 121, 0.15);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        /* DIVISOR ESTELAR */
        .star-divider {
            width: 150px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--celestial-gold), transparent);
            margin: 2rem auto; position: relative;
        }
        .star-divider::after {
            content: '✦'; position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            color: var(--celestial-gold); font-size: 1.2rem; background: var(--celestial-bg); padding: 0 10px;
        }

        .animate-fade-in { animation: fadeInDoc 0.6s ease-out forwards; }
        @keyframes fadeInDoc { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Ocultar scrollbar */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* Inputs y Botones Celestiales */
        .input-celestial {
            width: 100%; border: none; border-bottom: 1px solid rgba(206, 179, 121, 0.3);
            background: transparent; padding: 12px 0; font-size: 0.9rem; outline: none;
            color: var(--celestial-text); transition: border-color 0.3s;
        }
        .input-celestial:focus { border-bottom-color: var(--celestial-gold); }
        .input-celestial::placeholder { color: var(--celestial-muted); font-weight: 300; }
        select.input-celestial option { background: var(--celestial-bg); color: var(--celestial-text); }

        .btn-celestial {
            background: transparent; color: var(--celestial-gold);
            border: 1px solid var(--celestial-gold); padding: 12px 30px;
            text-transform: uppercase; letter-spacing: 2px; font-size: 0.75rem;
            transition: all 0.4s ease; border-radius: 4px;
        }
        .btn-celestial:hover {
            background: var(--celestial-gold); color: var(--celestial-bg);
            box-shadow: 0 0 15px rgba(206, 179, 121, 0.3);
        }
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
    
    {{-- SECCIÓN 1: HERO (CIELO ESTRELLADO) --}}
    <section class="full-screen bg-[radial-gradient(ellipse_at_top,_var(--celestial-bg),_#000000)] overflow-hidden">
        <div class="stars-bg"></div>
        <div class="z-10 w-full max-w-4xl mx-auto flex flex-col items-center">
            
            <div class="mb-8 opacity-70 italic text-sm tracking-[0.3em] uppercase text-[var(--celestial-gold)] font-serif">En memoria y celebración de la vida de</div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl text-white mb-4 font-light drop-shadow-md px-4">
                {{ $evento->nombre_evento }}
            </h1>
            
            <div class="star-divider"></div>
            
            <p class="text-[var(--celestial-muted)] mb-10 tracking-[0.4em] font-light">
                {{ \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('Y') }} — {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('Y') }}
            </p>
            
            <div class="w-64 h-80 md:w-72 md:h-96 rounded-full overflow-hidden border border-[var(--celestial-gold)]/40 p-2 glass-panel mb-10 relative">
                <div class="w-full h-full rounded-full overflow-hidden">
                    @if($evento->fotosGaleria->count() > 0)
                        <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition duration-1000 filter sepia-[0.3]">
                    @else
                        <div class="w-full h-full bg-black/40 flex flex-col justify-center items-center">
                            <i class="fa-solid fa-star text-4xl text-[var(--celestial-gold)] opacity-50"></i>
                        </div>
                    @endif
                </div>
            </div>
            
            <p class="max-w-xl text-[var(--celestial-text)] font-light leading-relaxed italic text-lg md:text-xl px-4">
                "Como una estrella en el firmamento, tu luz continuará guiándonos en la oscuridad."
            </p>
            
            <div class="absolute bottom-10 animate-bounce text-[var(--celestial-gold)]/50">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: BIOGRAFÍA & ANCLAJES RÁPIDOS --}}
    <section class="full-screen bg-black/20 border-t border-[var(--celestial-gold)]/10">
        <div class="stars-bg opacity-10"></div>
        <div class="z-10 w-full max-w-3xl mx-auto flex flex-col items-center">
            
            <i class="fa-solid fa-feather-pointed text-3xl text-[var(--celestial-gold)] mb-6 opacity-80"></i>
            <h2 class="text-4xl mb-8 text-[var(--celestial-gold)]">Servicio Conmemorativo</h2>
            
            <div class="glass-panel p-8 md:p-12 space-y-6 text-center w-full mb-10 rounded-2xl">
                <p class="text-lg md:text-xl text-[var(--celestial-text)] font-light leading-loose font-serif italic">
                    {{ $evento->biografia_resumen }}
                </p>
                <div class="pt-8 mt-4 border-t border-[var(--celestial-gold)]/20 flex flex-col items-center justify-center space-y-2 text-[var(--celestial-muted)] text-sm tracking-wider">
                    <p><i class="far fa-calendar-alt text-[var(--celestial-gold)] mr-2"></i> {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('l d \d\e F, Y') }}</p>
                    <p><i class="far fa-clock text-[var(--celestial-gold)] mr-2"></i> {{ $evento->hora }} HRS</p>
                    <p><i class="fas fa-map-marker-alt text-[var(--celestial-gold)] mr-2"></i> {{ $evento->ubicacion_texto }}</p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-4 md:gap-8 text-xs text-[var(--celestial-gold)]/70 uppercase tracking-widest mt-4 font-semibold">
                <a href="#seccionMuroMensajes" class="hover:text-[var(--celestial-gold)] transition pb-1 border-b border-transparent hover:border-[var(--celestial-gold)]">Libro de Estrellas</a>
                <span class="hidden md:inline text-white/20">•</span>
                <a href="#seccionGaleriaVis" class="hover:text-[var(--celestial-gold)] transition pb-1 border-b border-transparent hover:border-[var(--celestial-gold)]">Memoria Visual</a>
                <span class="hidden md:inline text-white/20">•</span>
                <a href="#seccionLibroRecuerdos" class="hover:text-[var(--celestial-gold)] transition pb-1 border-b border-transparent hover:border-[var(--celestial-gold)]">Dejar Ofrenda</a>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: EL MURO DE RECUERDOS PUBLICADOS --}}
    <section id="seccionMuroMensajes" class="w-full bg-[#070b15] py-24 px-6 flex flex-col items-center min-h-screen snap-start relative">
        <div class="stars-bg opacity-20"></div>
        <div class="max-w-5xl w-full text-center space-y-6 z-10">
            <span class="text-xs uppercase tracking-[0.4em] text-[var(--celestial-muted)] block"><i class="fa-solid fa-book-journal-whills mr-2"></i>Ecos del Alma</span>
            <h2 class="text-4xl md:text-5xl font-light text-[var(--celestial-text)] font-serif">Libro de Condolencias Abierto</h2>
            <div class="star-divider"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left w-full mt-12">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="glass-panel p-8 space-y-6 flex flex-col justify-between hover:-translate-y-1 transition-all duration-500 rounded-xl border-t border-t-[var(--celestial-gold)]/30">
                        <div class="space-y-4">
                            @if($item->url_onedrive)
                                <div class="w-full h-52 overflow-hidden bg-black/40 border border-[var(--celestial-gold)]/20 shadow-inner mb-4 rounded-lg p-1">
                                    @if(str_starts_with($item->url_onedrive, 'http'))
                                        @php
                                            $directImgUrl = $item->url_onedrive;
                                            if (str_contains($directImgUrl, '1drv.ms')) {
                                                $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                            } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                                $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                            }
                                        @endphp
                                        <img src="{{ $directImgUrl }}" class="w-full h-full object-cover filter sepia-[0.2] hover:sepia-0 hover:scale-[1.02] transition-all duration-500 rounded" onerror="this.style.display='none';">
                                    @else
                                        <img src="{{ asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover filter sepia-[0.2] hover:sepia-0 hover:scale-[1.02] transition-all duration-500 rounded">
                                    @endif
                                </div>
                            @endif
                            <i class="fas fa-quote-left text-2xl text-[var(--celestial-gold)]/40 mb-2 block"></i>
                            <p class="text-[var(--celestial-text)] font-serif font-light leading-relaxed italic text-lg md:text-xl">
                                {{ $item->contenido_texto }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-[var(--celestial-gold)]/10 flex justify-between items-center text-xs">
                            <div>
                                <span class="font-medium text-[var(--celestial-gold)] block text-sm tracking-wider uppercase">{{ $item->nombre_autor }}</span>
                                <span class="text-[var(--celestial-muted)] font-light">{{ $item->vinculo_autor ?? 'Allegado' }}</span>
                            </div>
                            <div class="text-[10px] text-[var(--celestial-muted)] font-mono opacity-60">
                                <i class="fa-regular fa-star mr-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 py-16 border border-dashed border-[var(--celestial-gold)]/20 text-center text-[var(--celestial-muted)] font-light space-y-4 w-full glass-panel rounded-2xl">
                        <i class="fa-regular fa-comment-dots text-4xl block text-[var(--celestial-gold)]/40"></i>
                        <p class="tracking-wider uppercase text-xs font-semibold text-[var(--celestial-text)]">El santuario digital está abierto</p>
                        <p class="text-sm italic font-serif">Aún no se han publicado mensajes. Sea el primero en encender una luz con sus palabras.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3.5: REGISTRO VISUAL UNIFICADO (CLOUD ONEDRIVE) --}}
    <section id="seccionGaleriaVis" class="w-full py-24 px-6 flex flex-col items-center min-h-screen relative snap-start bg-gradient-to-b from-[#070b15] to-[var(--celestial-bg)]">
        <div class="stars-bg opacity-30"></div>
        <div class="max-w-6xl w-full text-center space-y-6 z-10">
            <span class="text-xs uppercase tracking-[0.4em] text-[var(--celestial-muted)] block"><i class="fa-regular fa-images mr-1"></i> Destellos en el tiempo</span>
            <h2 class="text-4xl md:text-5xl font-light text-[var(--celestial-text)] font-serif">Memoria Visual</h2>
            <div class="star-divider"></div>

            {{-- LÓGICA DE BLOQUEO DE GALERÍA --}}
            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-10 glass-panel border-t border-[var(--celestial-gold)]/40 p-4 md:p-6 shadow-lg gap-4 animate-fade-in rounded-xl">
                    <div class="text-center md:text-left">
                        <span id="contador-seleccionadas" class="font-serif italic text-xl text-[var(--celestial-gold)]">
                            0 Seleccionadas
                        </span>
                        <p class="text-[9px] text-[var(--celestial-muted)] uppercase tracking-widest mt-1">Haga clic en los retratos para guardar</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="btn-celestial w-full md:w-auto">
                            <i class="fas fa-download mr-1.5"></i> Bajar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-celestial !bg-[var(--celestial-gold)] !text-[var(--celestial-bg)] w-full md:w-auto font-bold">
                            <i class="fas fa-cloud-download-alt mr-1.5"></i> Obtener Archivo Completo
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
                                    'etiqueta' => 'RETRATO OFICIAL'
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
                                'etiqueta' => 'APORTE DE LUZ'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full max-h-[65vh] overflow-y-auto hide-scroll p-2 animate-fade-in pb-10">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer overflow-hidden glass-panel border border-transparent hover:border-[var(--celestial-gold)] transition-all duration-500 p-1 aspect-[4/5] rounded-lg" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            <div class="w-full h-full rounded bg-black overflow-hidden relative">
                                @if($foto['esVideo'])
                                    <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/30 hover:bg-black/10 transition">
                                        <div class="w-12 h-12 bg-[var(--celestial-bg)]/80 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-105 transition border border-[var(--celestial-gold)]/50 shadow-[0_0_15px_rgba(206,179,121,0.3)]">
                                            <i class="fas fa-play text-[var(--celestial-gold)] text-sm ml-1"></i>
                                        </div>
                                    </button>
                                    <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover filter sepia-[0.3] opacity-80 transition duration-1000 group-hover:sepia-0 group-hover:opacity-100" muted loop playsinline preload="metadata"></video>
                                @else
                                    <img src="{{ $foto['url'] }}" class="w-full h-full object-cover filter sepia-[0.3] opacity-80 transition-all duration-1000 group-hover:sepia-0 group-hover:scale-105 group-hover:opacity-100">
                                @endif
                            </div>
                            
                            <div class="overlay absolute inset-0 bg-[var(--celestial-gold)]/10 opacity-0 transition duration-300 z-20 pointer-events-none mix-blend-screen"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-[var(--celestial-gold)] text-[var(--celestial-bg)] rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-2 left-2 right-2 bg-black/70 backdrop-blur-sm border border-[var(--celestial-gold)]/30 text-[var(--celestial-gold)] text-[8px] uppercase tracking-widest font-semibold py-2 px-2 text-center z-30 pointer-events-none rounded">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video opacity-70 mr-1"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} opacity-70 mr-1"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center p-16 glass-panel border border-dashed border-[var(--celestial-gold)]/30 rounded-2xl mx-2">
                            <i class="fa-regular fa-image text-4xl text-[var(--celestial-gold)]/40 mb-4"></i>
                            <p class="text-[var(--celestial-text)] font-serif text-lg tracking-wide italic">El repositorio visual se encuentra vacío en este momento.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl glass-panel border border-[var(--celestial-gold)]/20 p-12 md:p-20 text-center shadow-lg mx-auto rounded-3xl" id="locked-gallery-msg">
                    <div class="w-20 h-20 bg-[var(--celestial-bg)] border border-[var(--celestial-gold)]/40 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_15px_rgba(206,179,121,0.2)]">
                        <i class="fas fa-lock text-2xl text-[var(--celestial-gold)]"></i>
                    </div>
                    <h3 class="text-2xl font-light text-white mb-3 font-serif uppercase tracking-widest">Contenido en Custodia</h3>
                    <p class="text-[var(--celestial-muted)] font-light text-sm leading-relaxed max-w-md mx-auto mb-8 italic">
                        Por respeto al transcurso de la ceremonia, el archivo fotográfico se habilitará automáticamente <strong class="text-[var(--celestial-gold)]">1 hora después</strong> del inicio oficial.
                    </p>
                    <button onclick="window.location.reload()" class="btn-celestial">
                        <i class="fas fa-sync-alt mr-2"></i> Observar el Firmamento
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: FORMULARIO DE RECUERDOS --}}
    <section id="seccionLibroRecuerdos" class="full-screen bg-[var(--celestial-bg)] relative py-16">
        <div class="stars-bg opacity-30 absolute inset-0 pointer-events-none"></div>
        
        <div class="max-w-xl w-full px-6 text-center space-y-4 z-10 my-auto">
            <span class="text-xs uppercase tracking-[0.4em] text-[var(--celestial-muted)] block"><i class="fa-regular fa-envelope-open mr-1"></i> Su Espacio</span>
            <h2 class="text-3xl md:text-5xl text-white font-light font-serif">Dejar una Ofrenda de Luz</h2>
            <div class="star-divider"></div>
            
            <div id="bloqueFormularioMensaje" class="glass-panel p-8 md:p-10 border border-[var(--celestial-gold)]/30 text-left space-y-6 shadow-2xl w-full mt-10 rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[var(--celestial-gold)] to-transparent opacity-50"></div>

                <form id="formRegistrarLamento" onsubmit="enviarMensajeLamento(event, '{{ $evento->evento_id }}')" class="space-y-6" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-semibold">Clave de Acceso Asignada *</label>
                            <input type="text" id="inputCodigoValidar" required placeholder="Ej: JON-2897" class="input-celestial text-center tracking-widest font-mono uppercase bg-black/20 rounded px-2 w-full">
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-semibold">Su Vínculo / Relación *</label>
                            <select id="inputVinculoAutor" required class="input-celestial bg-black/20 rounded px-2 cursor-pointer font-serif italic text-base w-full">
                                <option value="" disabled selected>Seleccione una opción...</option>
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
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-semibold">Su Nombre Completo (Firma) *</label>
                        <input type="text" id="inputAutorMensaje" required placeholder="¿Cómo desea figurar en el libro?" class="input-celestial bg-black/20 rounded px-3 font-serif text-lg w-full">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-semibold">Palabras de Aliento *</label>
                        <textarea id="inputContenidoMensaje" required rows="4" placeholder="Escriba aquí su mensaje de condolencias o memorias..." class="w-full border border-[var(--celestial-gold)]/30 bg-black/30 p-4 rounded-lg text-base outline-none focus:border-[var(--celestial-gold)] transition text-[var(--celestial-text)] font-serif italic leading-relaxed resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-semibold">Adjuntar Fotografía / Video (Opcional)</label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border border-[var(--celestial-gold)]/30 border-dashed bg-black/20 transition hover:bg-black/40 cursor-pointer rounded-lg relative" onclick="document.getElementById('inputArchivoFoto').click()">
                            <div class="space-y-1 text-center">
                                <i class="fa-regular fa-image text-3xl text-[var(--celestial-gold)]/50 mb-2 block"></i>
                                <div class="flex flex-col items-center text-xs text-[var(--celestial-muted)]">
                                    <span class="relative font-medium text-[var(--celestial-gold)] hover:text-white underline tracking-wider">
                                        Seleccionar archivo multimedia
                                    </span>
                                    <input id="inputArchivoFoto" name="archivo" type="file" accept="image/*,video/*" class="hidden">
                                </div>
                                <p class="text-[9px] text-stone-500 font-mono mt-2 uppercase tracking-widest" id="txtNombreArchivo">Hasta 50MB permitidos.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="btnPublicarMuro" class="btn-celestial !bg-[var(--celestial-gold)] !text-[var(--celestial-bg)] font-bold w-full !py-4 shadow-[0_0_15px_rgba(206,179,121,0.2)] hover:shadow-[0_0_25px_rgba(206,179,121,0.5)]">
                        Publicar en el Santuario Digital
                    </button>
                </form>
            </div>

            <div id="contenedorBotonAuxiliar" class="pt-6 text-center">
                <p class="text-xs text-[var(--celestial-muted)] mb-3 font-light italic">¿Aún no dispone de sus credenciales personales?</p>
                <button onclick="abrirModalAsistencia()" class="text-[10px] font-bold uppercase tracking-widest text-[var(--celestial-gold)] hover:text-white transition cursor-pointer border-b border-[var(--celestial-gold)]/50 pb-1">
                    [ Solicitar pase de acceso al libro ]
                </button>
            </div>
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
    </section>

</div>

{{-- MODAL ESTILO CELESTIAL PARA SOLICITAR CLAVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
    <div class="glass-panel border-t-2 border-t-[var(--celestial-gold)] max-w-md w-full p-8 text-center shadow-2xl max-h-[90vh] overflow-y-auto animate-fade-in rounded-2xl">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b border-[var(--celestial-gold)]/20 pb-4">
                <h3 class="text-2xl font-serif text-[var(--starlight)] tracking-widest uppercase">Libro de Recuerdos</h3>
                <button onclick="cerrarModalAsistencia()" class="text-[var(--celestial-muted)] hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="formObtenerClave" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <div class="bg-black/40 p-6 rounded-xl border border-[var(--celestial-gold)]/20 space-y-5">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-bold">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="input-celestial font-serif text-lg">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--celestial-muted)] mb-2 font-bold">Correo Electrónico *</label>
                        <input type="email" id="inputEmailPrincipal" required class="input-celestial font-serif text-lg" placeholder="correo@ejemplo.com">
                    </div>
                </div>
                <button type="submit" class="btn-celestial w-full !py-3.5 bg-[var(--celestial-gold)]/10">
                    Obtener Identificador
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO OSCURO --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 md:top-8 md:right-8 text-white/50 hover:text-[var(--celestial-gold)] transition z-50">
        <i class="fas fa-times text-3xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-lg overflow-hidden shadow-[0_0_30px_rgba(206,179,121,0.2)] border border-[var(--celestial-gold)]/30" onclick="event.stopPropagation()">
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
                        <div class="w-16 h-16 bg-[var(--celestial-bg)] border border-[var(--celestial-gold)]/50 rounded-full flex items-center justify-center mx-auto mb-6 transition duration-700 hover:scale-105 shadow-[0_0_15px_rgba(206,179,121,0.3)]">
                            <i class="fas fa-unlock-alt text-2xl text-[var(--celestial-gold)]"></i>
                        </div>
                        <h3 class="text-2xl font-serif text-white mb-3 tracking-widest uppercase">Archivo Desbloqueado</h3>
                        <p class="text-[var(--celestial-muted)] font-light text-sm leading-relaxed max-w-md mx-auto mb-8 italic">
                            El tiempo de respeto ha concluido. El material visual y memorias del evento ya se encuentran disponibles en el firmamento.
                        </p>
                        <button onclick="window.location.reload()" class="btn-celestial">
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
                    <div class="py-6 text-center space-y-8 animate-fade-in">
                        <div class="w-16 h-16 bg-[var(--celestial-bg)] rounded-full flex items-center justify-center mx-auto border border-[var(--celestial-gold)]/50 shadow-[0_0_15px_rgba(206,179,121,0.3)]">
                            <i class="fas fa-feather-alt text-2xl text-[var(--celestial-gold)]"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl uppercase tracking-[0.2em] text-white font-serif">Registro Completado</h3>
                            <p class="text-xs text-[var(--celestial-muted)] font-light px-2 italic">Su pase único ha sido materializado.</p>
                        </div>
                        <div class="bg-black/40 border border-[var(--celestial-gold)]/20 p-6 text-left space-y-4 rounded-xl">
                            <p class="text-[9px] uppercase font-bold tracking-widest text-[var(--celestial-gold)] border-b border-[var(--celestial-gold)]/20 pb-2">
                                <i class="fas fa-key mr-1"></i> Copie esta clave
                            </p>
                            <div class="text-xs flex justify-between items-center pt-2">
                                <span class="text-stone-300 font-medium font-serif text-base">${data.codigos[0].nombre}:</span>
                                <span class="bg-[var(--celestial-gold)] px-3 py-1.5 rounded text-xs font-bold text-[var(--celestial-bg)] font-mono tracking-widest shadow-md">${data.codigos[0].codigo}</span>
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia(); window.location.hash = 'seccionLibroRecuerdos';" class="btn-celestial !bg-[var(--celestial-gold)] !text-[var(--celestial-bg)] font-bold w-full mt-4">
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
            document.getElementById('txtNombreArchivo').innerText = `Archivo listo: ${file.name}`;
            document.getElementById('txtNombreArchivo').classList.add('text-[var(--celestial-gold)]');
        }
    });

    function enviarMensajeLamento(event, eventoId) {
        event.preventDefault();

        const botonPublicar = document.getElementById('btnPublicarMuro');
        
        botonPublicar.disabled = true;
        botonPublicar.classList.remove('hover:shadow-[0_0_25px_rgba(206,179,121,0.5)]');
        botonPublicar.style.opacity = '0.7';
        botonPublicar.style.cursor = 'not-allowed';
        botonPublicar.innerHTML = `<i class="fas fa-star fa-spin mr-2"></i> Elevando recuerdo a las estrellas...`;

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
                botonPublicar.style.opacity = '1';
                botonPublicar.style.cursor = 'pointer';
                botonPublicar.innerHTML = "Publicar en el Santuario Digital";
                throw new Error("Fallo controlado en el backend.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const cajaFormulario = document.getElementById('bloqueFormularioMensaje');
                
                cajaFormulario.innerHTML = `
                    <div class="py-12 text-center space-y-6 animate-fade-in font-light relative">
                        <div class="absolute inset-0 stars-bg opacity-50"></div>
                        <div class="w-16 h-16 border border-[var(--celestial-gold)]/50 rounded-full flex items-center justify-center mx-auto text-[var(--celestial-gold)] bg-[var(--celestial-bg)] shadow-[0_0_20px_rgba(206,179,121,0.2)] relative z-10">
                            <i class="fa-regular fa-star text-2xl"></i>
                        </div>
                        <div class="space-y-3 relative z-10">
                            <h3 class="text-3xl font-serif text-white tracking-widest uppercase">Ofrenda Registrada</h3>
                            <p class="text-base text-[var(--celestial-muted)] max-w-md mx-auto leading-relaxed italic">"${data.message}"</p>
                        </div>
                        <div class="star-divider !w-24 relative z-10"></div>
                        <p class="text-[10px] text-[var(--celestial-gold)] pt-2 tracking-[0.3em] uppercase font-bold relative z-10">La luz de sus palabras ha sido recibida.</p>
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
            elemento.classList.replace('border-transparent', 'border-[var(--celestial-gold)]');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.replace('border-[var(--celestial-gold)]', 'border-transparent');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} Memorias`;
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
            alert("El archivo estelar se encuentra vacío.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>

</body>
</html>