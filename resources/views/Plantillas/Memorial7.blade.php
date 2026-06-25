<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nuestra Estrellita | {{ $evento->nombre_evento }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --baby-sky: #EBF5FA;      /* Celeste cielo muy suave */
            --baby-cloud: #FFFFFF;    /* Blanco nube */
            --baby-star: #FCE8A1;     /* Amarillo estrellita */
            --baby-blue: #9BD3E1;     /* Celeste manta */
            --baby-pink: #FFD6DE;     /* Rosadito tierno */
            --text-main: #5A7184;     /* Azul grisáceo para no usar negro */
            --text-soft: #8C9EA8;     /* Gris suave */
        }

        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: var(--baby-sky); 
            color: var(--text-main); 
            scroll-behavior: smooth; 
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-cute { font-family: 'Quicksand', sans-serif; font-weight: 700; }
        
        .snap-container { width: 100%; overflow-x: hidden; height: 100svh; overflow-y: scroll; scroll-snap-type: y proximity; }
        .full-screen { min-height: 100svh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 60px 20px; scroll-snap-align: start; position: relative; }

        /* NUBES FLOTANTES ANIMADAS */
        .sky-bg { position: absolute; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .fluffy-cloud {
            position: absolute; color: white; opacity: 0.8;
            animation: floatCloud infinite linear;
        }
        .c1 { top: 10%; font-size: 80px; animation-duration: 35s; left: -20%; }
        .c2 { top: 40%; font-size: 120px; animation-duration: 45s; right: -20%; animation-direction: reverse; opacity: 0.5; }
        .c3 { bottom: 20%; font-size: 60px; animation-duration: 25s; left: -10%; }
        .twinkle-star {
            position: absolute; color: var(--baby-star); animation: twinkle 3s infinite ease-in-out alternate;
        }

        @keyframes floatCloud { 0% { transform: translateX(0); } 100% { transform: translateX(120vw); } }
        @keyframes twinkle { 0% { opacity: 0.3; transform: scale(0.8); } 100% { opacity: 1; transform: scale(1.2); } }

        /* TARJETAS DE "JUGUETE" (Bordes muy redondos) */
        .baby-panel {
            background: var(--baby-cloud);
            border: 4px solid var(--baby-blue);
            box-shadow: 0 10px 25px rgba(155, 211, 225, 0.2);
            border-radius: 35px;
        }
        .baby-panel-pink { border-color: var(--baby-pink); }
        .baby-panel-yellow { border-color: var(--baby-star); }

        /* ANIMACIONES */
        .animate-pop { animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }

        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* BOTONES TIERNOS */
        .btn-baby {
            background: var(--baby-cloud); color: var(--baby-blue);
            border: 3px solid var(--baby-blue); padding: 14px 30px;
            text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem; font-weight: 800;
            transition: all 0.3s ease; border-radius: 50px; cursor: pointer;
            box-shadow: 0 6px 15px rgba(155, 211, 225, 0.3);
        }
        .btn-baby:hover {
            background: var(--baby-blue); color: white;
            transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 211, 225, 0.5);
        }
        .btn-baby-solid { background: var(--baby-blue); color: white; border: none; }
        .btn-baby-solid:hover { background: #86c4d4; }

        /* INPUTS REDONDITOS */
        .input-baby {
            width: 100%; border: 3px solid #E2E8F0; border-radius: 20px;
            background: #F8FAFC; padding: 14px 18px; font-size: 1rem; outline: none;
            color: var(--text-main); font-weight: 600; transition: all 0.3s;
        }
        .input-baby:focus { border-color: var(--baby-blue); background: white; }
        .input-baby::placeholder { color: var(--text-soft); font-weight: 500; }
    </style>
</head>
<body>

@php
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="snap-container">
    
    {{-- SECCIÓN 1: HERO (CIELO DE BEBÉ) --}}
    <section class="full-screen bg-[var(--baby-sky)] overflow-hidden relative">
        <div class="sky-bg">
            <i class="fa-solid fa-cloud fluffy-cloud c1"></i>
            <i class="fa-solid fa-cloud fluffy-cloud c2"></i>
            <i class="fa-solid fa-cloud fluffy-cloud c3"></i>
            <i class="fa-solid fa-star twinkle-star" style="top: 20%; left: 15%; font-size: 30px;"></i>
            <i class="fa-solid fa-star twinkle-star" style="top: 30%; right: 20%; font-size: 20px; animation-delay: 1s;"></i>
            <i class="fa-solid fa-star twinkle-star" style="bottom: 30%; left: 25%; font-size: 25px; animation-delay: 2s;"></i>
        </div>
        
        <div class="z-10 w-full max-w-4xl mx-auto flex flex-col items-center animate-pop">
            
            <div class="mb-4 bg-white/80 backdrop-blur-sm border-2 border-[var(--baby-star)] px-6 py-2 rounded-full shadow-sm inline-flex items-center gap-2">
                <i class="fa-solid fa-moon text-[var(--baby-star)] text-lg"></i>
                <span class="text-xs tracking-widest uppercase text-[var(--text-main)] font-bold">Nuestra Estrellita</span>
                <i class="fa-solid fa-star text-[var(--baby-star)] text-lg"></i>
            </div>
            
            <h1 class="text-5xl md:text-7xl text-[var(--text-main)] mb-2 font-cute drop-shadow-sm px-4 leading-tight text-[#4A5D6B]">
                {{ $evento->nombre_evento }}
            </h1>
            
            <p class="text-[var(--text-soft)] mb-8 tracking-[0.2em] font-bold text-sm bg-white/50 px-4 py-1 rounded-full">
                {{ \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('Y') }} <i class="fa-solid fa-heart text-[var(--baby-pink)] mx-2"></i> {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('Y') }}
            </p>
            
            <div class="w-56 h-56 md:w-72 md:h-72 rounded-full overflow-hidden border-[8px] border-white shadow-[0_15px_35px_rgba(155,211,225,0.4)] mb-8 relative bg-white">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover opacity-95 hover:opacity-100 hover:scale-105 transition duration-700">
                @else
                    <div class="w-full h-full bg-[var(--baby-sky)] flex flex-col justify-center items-center">
                        <i class="fa-solid fa-baby text-6xl text-[var(--baby-blue)] opacity-40"></i>
                    </div>
                @endif
            </div>
            
            <p class="max-w-md text-[var(--text-main)] font-cute text-lg md:text-xl px-4 font-semibold leading-relaxed bg-white/60 backdrop-blur-sm py-3 rounded-3xl border border-white">
                "Jugando entre las nubes, tu sonrisa iluminará nuestro cielo por siempre."
            </p>
            
            <div class="absolute bottom-6 animate-bounce text-[var(--baby-blue)] text-2xl">
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: DESPEDIDA DEL ANGELITO --}}
    <section class="full-screen bg-white relative">
        <div class="z-10 w-full max-w-4xl mx-auto flex flex-col items-center">
            
            <div class="w-20 h-20 rounded-full bg-[var(--baby-sky)] flex items-center justify-center mb-6 shadow-sm border-4 border-[var(--baby-blue)]">
                <i class="fa-solid fa-paper-plane text-3xl text-[var(--baby-blue)]"></i>
            </div>
            
            <h2 class="text-3xl md:text-5xl mb-6 text-[var(--text-main)] font-cute">Despedida de nuestro ángel</h2>
            
            <div class="baby-panel p-8 md:p-12 text-center w-full mb-8 relative overflow-hidden">
                <i class="fa-solid fa-cloud absolute -top-4 -left-4 text-6xl text-[var(--baby-sky)] opacity-50"></i>
                <i class="fa-solid fa-star absolute bottom-4 right-4 text-4xl text-[var(--baby-star)] opacity-50"></i>
                
                <p class="text-base md:text-lg text-[var(--text-main)] font-semibold leading-relaxed relative z-10">
                    {{ $evento->biografia_resumen }}
                </p>
                
                <div class="pt-8 mt-6 border-t-4 border-dotted border-[var(--baby-sky)] flex flex-col md:flex-row items-center justify-center gap-4 text-[var(--text-main)] text-sm font-bold relative z-10">
                    <p class="flex items-center bg-white px-5 py-3 rounded-2xl shadow-sm border-2 border-[var(--baby-sky)]"><i class="fa-regular fa-calendar-check text-[var(--baby-pink)] mr-2 text-xl"></i> {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d \d\e F, Y') }}</p>
                    <p class="flex items-center bg-white px-5 py-3 rounded-2xl shadow-sm border-2 border-[var(--baby-sky)]"><i class="fa-regular fa-clock text-[var(--baby-blue)] mr-2 text-xl"></i> {{ $evento->hora }} HRS</p>
                    <p class="flex items-center bg-white px-5 py-3 rounded-2xl shadow-sm border-2 border-[var(--baby-sky)]"><i class="fa-solid fa-location-dot text-[var(--baby-star)] mr-2 text-xl"></i> {{ $evento->ubicacion_texto }}</p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-3 md:gap-6 text-xs text-[var(--baby-blue)] uppercase tracking-widest mt-2 font-black">
                <a href="#seccionMuroMensajes" class="hover:text-[var(--baby-pink)] transition bg-[var(--baby-sky)] px-4 py-2 rounded-full">Cartitas al cielo</a>
                <a href="#seccionGaleriaVis" class="hover:text-[var(--baby-pink)] transition bg-[var(--baby-sky)] px-4 py-2 rounded-full">Fotitos</a>
                <a href="#seccionLibroRecuerdos" class="hover:text-[var(--baby-pink)] transition bg-[var(--baby-sky)] px-4 py-2 rounded-full">Escribir algo</a>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: MURO DE CARTITAS AL CIELO --}}
    <section id="seccionMuroMensajes" class="w-full bg-[var(--baby-sky)] py-24 px-6 flex flex-col items-center min-h-screen snap-start relative overflow-hidden">
        <i class="fa-solid fa-cloud absolute top-10 right-10 text-[100px] text-white opacity-40"></i>
        <i class="fa-solid fa-cloud absolute bottom-20 left-5 text-[80px] text-white opacity-40"></i>
        
        <div class="max-w-5xl w-full text-center space-y-4 z-10">
            <span class="text-xs uppercase tracking-[0.3em] text-[var(--baby-pink)] block font-black bg-white inline-block px-4 py-1 rounded-full shadow-sm">
                <i class="fa-solid fa-heart mr-1"></i> Mucho amor para ti
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-[var(--text-main)] font-cute">Cartitas al Cielo</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left w-full mt-10">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="baby-panel baby-panel-yellow p-6 md:p-8 flex flex-col justify-between hover:-translate-y-2 transition-all duration-300 bg-white shadow-lg">
                        <div class="space-y-4">
                            @if($item->url_onedrive)
                                <div class="w-full h-48 overflow-hidden bg-[var(--baby-sky)] rounded-2xl mb-4 border-4 border-white shadow-sm">
                                    @if(str_starts_with($item->url_onedrive, 'http'))
                                        @php
                                            $directImgUrl = $item->url_onedrive;
                                            if (str_contains($directImgUrl, '1drv.ms')) {
                                                $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                            } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                                $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                            }
                                        @endphp
                                        <img src="{{ $directImgUrl }}" class="w-full h-full object-cover hover:scale-105 transition-all duration-500" onerror="this.style.display='none';">
                                    @else
                                        <img src="{{ asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover hover:scale-105 transition-all duration-500">
                                    @endif
                                </div>
                            @endif
                            <div class="bg-[var(--baby-sky)]/50 p-4 rounded-2xl relative">
                                <i class="fa-solid fa-quote-left absolute -top-3 -left-2 text-2xl text-[var(--baby-yellow)]"></i>
                                <p class="text-[var(--text-main)] font-semibold leading-relaxed text-base relative z-10">
                                    "{{ $item->contenido_texto }}"
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t-4 border-dotted border-[var(--baby-sky)] flex justify-between items-center">
                            <div>
                                <span class="font-black text-[var(--baby-blue)] block text-sm">{{ $item->nombre_autor }}</span>
                                <span class="text-[var(--text-soft)] text-xs font-bold">{{ $item->vinculo_autor ?? 'Familia' }}</span>
                            </div>
                            <div class="text-[10px] text-[var(--text-main)] font-bold bg-[var(--baby-yellow)]/30 px-3 py-1.5 rounded-xl border border-[var(--baby-yellow)]">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 py-20 text-center space-y-4 w-full baby-panel baby-panel-pink bg-white">
                        <div class="w-20 h-20 bg-[var(--baby-pink)]/20 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-envelope-open-text text-4xl text-[var(--baby-pink)]"></i>
                        </div>
                        <p class="tracking-widest uppercase text-sm font-black text-[var(--text-main)]">El buzón de nubes está vacío</p>
                        <p class="text-base font-semibold text-[var(--text-soft)]">Sé el primero en enviarle un dibujito o una cartita llena de amor.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3.5: CAJITA DE RECUERDOS (GALERÍA) --}}
    <section id="seccionGaleriaVis" class="w-full py-24 px-6 flex flex-col items-center min-h-screen relative snap-start bg-white">
        <div class="max-w-6xl w-full text-center space-y-4 z-10">
            <span class="text-xs uppercase tracking-[0.3em] text-[var(--baby-blue)] block font-black bg-[var(--baby-sky)] inline-block px-4 py-1 rounded-full"><i class="fa-solid fa-camera-retro mr-2"></i>Tesoritos</span>
            <h2 class="text-4xl md:text-5xl font-bold text-[var(--text-main)] font-cute">Cajita de Recuerdos</h2>

            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-10 baby-panel baby-panel-pink p-5 gap-4 animate-fade-in bg-white mt-8">
                    <div class="text-center md:text-left pl-4">
                        <span id="contador-seleccionadas" class="font-cute font-black text-2xl text-[var(--baby-pink)]">
                            0 Fotitos
                        </span>
                        <p class="text-[10px] text-[var(--text-soft)] uppercase font-bold mt-1 tracking-widest">Toca las fotitos para guardarlas</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="btn-baby !border-[var(--baby-pink)] !text-[var(--baby-pink)] w-full md:w-auto">
                            Bajar Selección
                        </button>
                        <button onclick="descargarTodas()" class="btn-baby btn-baby-solid !bg-[var(--baby-pink)] w-full md:w-auto">
                            ¡Guardar Todo!
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
                                    'etiqueta' => 'ÁLBUM FAMILIAR'
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
                                'etiqueta' => 'FOTITO DE INVITADO'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[65vh] overflow-y-auto hide-scroll p-2 animate-fade-in pb-10">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer overflow-hidden baby-panel border-4 border-transparent hover:border-[var(--baby-yellow)] transition-all duration-300 p-2 aspect-square" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            <div class="w-full h-full rounded-[25px] overflow-hidden relative bg-[var(--baby-sky)]">
                                @if($foto['esVideo'])
                                    <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/10 hover:bg-black/20 transition">
                                        <div class="w-14 h-14 bg-white/95 rounded-full flex items-center justify-center group-hover:scale-110 transition shadow-lg text-[var(--baby-blue)]">
                                            <i class="fa-solid fa-play ml-1 text-xl"></i>
                                        </div>
                                    </button>
                                    <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover transition duration-700" muted loop playsinline preload="metadata"></video>
                                @else
                                    <img src="{{ $foto['url'] }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                                @endif
                            </div>
                            
                            <div class="overlay absolute inset-0 bg-[var(--baby-yellow)]/20 opacity-0 transition duration-300 z-20 pointer-events-none rounded-[30px]"></div>
                            
                            <div class="check-icon absolute top-4 right-4 bg-[var(--baby-pink)] text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-lg z-30 pointer-events-none border-2 border-white">
                                <i class="fa-solid fa-check text-sm"></i>
                            </div>

                            <div class="absolute bottom-3 left-3 right-3 bg-white/95 backdrop-blur-md text-[var(--text-main)] text-[8px] uppercase tracking-widest font-black py-2.5 rounded-2xl text-center z-30 pointer-events-none border-2 border-[var(--baby-sky)] shadow-sm">
                                <i class="fa-solid {{ $foto['esVideo'] ? 'fa-video' : ($foto['esNube'] ? 'fa-cloud' : 'fa-camera') }} mr-1 text-[var(--baby-yellow)] text-sm"></i>
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center p-16 baby-panel border-4 border-dashed border-[var(--baby-blue)]/30 mx-2 bg-[var(--baby-sky)]/30">
                            <i class="fa-solid fa-box-open text-6xl text-[var(--baby-blue)] opacity-50 mb-4"></i>
                            <p class="text-[var(--text-dark)] font-bold text-lg">La cajita de recuerdos está esperando sus fotitos.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="w-full max-w-2xl baby-panel p-10 md:p-16 text-center mx-auto mt-12 bg-white" id="locked-gallery-msg">
                    <div class="w-24 h-24 bg-[var(--baby-sky)] rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-white shadow-md">
                        <i class="fa-solid fa-lock text-4xl text-[var(--baby-blue)]"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-cute font-bold text-[var(--text-main)] mb-4">Cajita Cerrada</h3>
                    <p class="text-[var(--text-soft)] font-semibold text-sm md:text-base leading-relaxed max-w-md mx-auto mb-8">
                        Para vivir este momento con respeto, las fotitos se desbloquearán <strong class="text-[var(--baby-pink)] font-black">1 hora después</strong> del inicio.
                    </p>
                    <button onclick="window.location.reload()" class="btn-baby btn-baby-solid">
                        <i class="fa-solid fa-rotate-right mr-2"></i> Ver si ya abrió
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: FORMULARIO (ESCRIBIR CARTITA) --}}
    <section id="seccionLibroRecuerdos" class="full-screen bg-[var(--baby-sky)] relative py-16 md:py-24 border-t-4 border-dashed border-white">
        
        <div class="max-w-xl w-full px-4 md:px-6 text-center space-y-4 mb-16 z-10 my-auto">
            <div class="inline-block bg-white px-5 py-2 rounded-full shadow-sm mb-2">
                <span class="text-xs uppercase tracking-[0.3em] text-[var(--baby-blue)] font-black"><i class="fa-solid fa-pencil mr-2"></i>Tu turno</span>
            </div>
            <h2 class="text-3xl md:text-4xl text-[var(--text-dark)] font-cute font-bold">Enviar una Cartita</h2>
            
            <div id="bloqueFormularioMensaje" class="baby-panel p-6 md:p-10 text-left space-y-6 w-full mt-10 relative bg-white shadow-xl">
                
                <form id="formRegistrarLamento" onsubmit="enviarMensajeLamento(event, '{{ $evento->evento_id }}')" class="space-y-6" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-black ml-2">Tu Clave *</label>
                            <input type="text" id="inputCodigoValidar" required placeholder="Ej: JON-2897" class="input-baby font-mono tracking-widest uppercase">
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-black ml-2">¿Qué eres del bebé? *</label>
                            <select id="inputVinculoAutor" required class="input-baby cursor-pointer font-semibold">
                                <option value="" disabled selected>Elige una opción...</option>
                                <option value="Papi/Mami">Papi / Mami</option>
                                <option value="Abuelo/a">Abuelo / Abuela</option>
                                <option value="Tío/a">Tío / Tía</option>
                                <option value="Padrino/Madrina">Padrino / Madrina</option>
                                <option value="Primo/a">Primo / Prima</option>
                                <option value="Amigo/a de la familia">Amigo/a de la familia</option>
                                <option value="Conocido/a">Conocido / Allegado</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-black ml-2">Tu Nombre (Firma) *</label>
                        <input type="text" id="inputAutorMensaje" required placeholder="Ej: Tía María" class="input-baby font-semibold">
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-black ml-2">Mensajito de amor o Recuerdo *</label>
                        <textarea id="inputContenidoMensaje" required rows="4" placeholder="Escribe aquí tus palabras bonitas o esa anécdota especial..." class="input-baby resize-none font-semibold leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-black ml-2">Subir Fotito o Dibujo (Opcional)</label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-8 pb-8 border-4 border-dashed border-[var(--baby-blue)]/30 bg-[var(--baby-bg)] transition hover:bg-[var(--baby-blue)]/10 cursor-pointer rounded-[24px] relative" onclick="document.getElementById('inputArchivoFoto').click()">
                            <div class="space-y-3 text-center">
                                <i class="fa-solid fa-camera-retro text-4xl text-[var(--baby-blue)] mb-2 block drop-shadow-sm"></i>
                                <div class="flex text-sm text-[var(--text-dark)] justify-center">
                                    <span class="font-bold underline decoration-[var(--baby-pink)] decoration-4 underline-offset-4">
                                        Toca para buscar en tu celular
                                    </span>
                                    <input id="inputArchivoFoto" name="archivo" type="file" accept="image/*,video/*" class="hidden">
                                </div>
                                <p class="text-[10px] text-[var(--text-soft)] font-bold uppercase tracking-widest mt-2" id="txtNombreArchivo">Imágenes o Videos cortos</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="btnPublicarMuro" class="btn-baby btn-baby-solid w-full !py-4 text-sm mt-4">
                        ¡Enviar Cartita! <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            <div id="contenedorBotonAuxiliar" class="pt-2 text-center">
                <p class="text-sm text-[var(--text-main)] mb-3 font-bold">¿No tienes clave de acceso?</p>
                <button onclick="abrirModalAsistencia()" class="text-[11px] font-black uppercase tracking-widest text-white bg-[var(--baby-pink)] hover:bg-[#F8BBD0] transition shadow-md px-6 py-3 rounded-full cursor-pointer">
                    Pide tu clave aquí
                </button>
            </div>
        </div>

        {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) INFANTIL 🔥 --}}
        <div class="absolute bottom-6 w-full text-center z-20 pointer-events-none">
            <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-70 hover:opacity-100 transition-all duration-500 group cursor-pointer hover:-translate-y-1 pointer-events-auto">
                <span class="text-[7.5px] md:text-[9px] uppercase tracking-widest text-[var(--text-main)] mb-1.5 font-black">Hecho con amor por</span>
                <div class="flex items-center gap-2 transition-colors bg-white px-4 py-1.5 rounded-full shadow-sm border-2 border-[var(--baby-sky)]">
                    <i class="fa-solid fa-star text-[10px] md:text-xs text-[var(--baby-yellow)] group-hover:text-[var(--baby-pink)] transition-colors"></i>
                    <span class="font-cute font-bold text-sm md:text-base tracking-widest text-[var(--text-main)] group-hover:text-[var(--baby-blue)] transition-colors">Eventify</span>
                </div>
            </a>
        </div>
    </section>

</div>

{{-- MODAL PARA SOLICITAR CLAVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-[var(--text-main)]/60 backdrop-blur-sm p-4">
    <div class="baby-panel max-w-md w-full p-8 text-center max-h-[90vh] overflow-y-auto animate-fade-in shadow-2xl bg-white border-4 border-[var(--baby-pink)]">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b-4 border-dotted border-[var(--baby-sky)] pb-4">
                <h3 class="text-xl font-cute text-[var(--text-dark)] font-bold uppercase tracking-widest">Pase Mágico</h3>
                <button onclick="cerrarModalAsistencia()" class="text-[var(--text-soft)] hover:text-white hover:bg-[var(--baby-pink)] transition bg-[var(--baby-sky)] w-10 h-10 rounded-full flex items-center justify-center"><i class="fa-solid fa-times text-lg"></i></button>
            </div>
            <form id="formObtenerClave" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <div class="bg-[var(--baby-sky)] p-6 rounded-[24px] space-y-5">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-bold ml-2">Tu Nombre y Apellido *</label>
                        <input type="text" id="inputNombrePrincipal" required class="input-baby bg-white">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[var(--text-main)] mb-2 font-bold ml-2">Tu Correo Electrónico *</label>
                        <input type="email" id="inputEmailPrincipal" required class="input-baby bg-white" placeholder="ejemplo@correo.com">
                    </div>
                </div>
                <button type="submit" class="btn-baby btn-baby-solid w-full !py-4 text-sm mt-2 !bg-[var(--baby-pink)] !border-[var(--baby-pink)]">
                    ¡Obtener Clave! <i class="fa-solid fa-wand-magic-sparkles ml-1"></i>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-[var(--text-main)]/90 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-6 right-6 text-[var(--text-main)] hover:text-white transition z-50 bg-white hover:bg-[var(--baby-pink)] w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
        <i class="fa-solid fa-times text-2xl"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-[30px] overflow-hidden shadow-2xl border-4 border-white" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

<script>
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
                        <div class="w-24 h-24 bg-[var(--baby-bg)] rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-4 border-[var(--baby-blue)] transition duration-700 hover:scale-110">
                            <i class="fa-solid fa-face-smile-wink text-4xl text-[var(--baby-blue)]"></i>
                        </div>
                        <h3 class="text-3xl font-cute text-[var(--text-dark)] mb-3 font-bold">¡Cajita Abierta!</h3>
                        <p class="text-[var(--text-main)] font-semibold text-sm leading-relaxed max-w-md mx-auto mb-8">
                            El momento ha llegado. Ya puedes ver y guardar las hermosas fotitos y recuerdos.
                        </p>
                        <button onclick="window.location.reload()" class="btn-baby btn-baby-solid !py-4 text-sm">
                            ¡Ver las fotitos!
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
                        <div class="w-20 h-20 bg-[var(--baby-yellow)]/30 border-4 border-white shadow-md rounded-full flex items-center justify-center mx-auto">
                            <i class="fa-solid fa-key text-3xl text-[var(--baby-yellow)]"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-cute text-[var(--text-dark)] font-bold uppercase tracking-widest">¡Clave Lista!</h3>
                            <p class="text-sm text-[var(--text-main)] font-bold px-2">Usa este código para enviar tu cartita.</p>
                        </div>
                        <div class="bg-[var(--baby-bg)] border-4 border-white p-6 text-left space-y-4 rounded-[24px] shadow-sm">
                            <p class="text-[10px] uppercase font-black tracking-widest text-[var(--baby-blue)] border-b-2 border-dashed border-white pb-2">
                                Tu código secreto
                            </p>
                            <div class="text-sm flex justify-between items-center pt-2">
                                <span class="text-[var(--text-dark)] font-bold font-cute">${data.codigos[0].nombre}:</span>
                                <span class="bg-white border-2 border-[var(--baby-blue)] text-[var(--baby-blue)] px-4 py-2 rounded-xl text-sm font-black font-mono tracking-widest shadow-sm">${data.codigos[0].codigo}</span>
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia(); window.location.hash = 'seccionLibroRecuerdos';" class="btn-baby btn-baby-solid w-full mt-4 !py-4 text-sm !bg-[var(--baby-pink)] !border-[var(--baby-pink)]">
                            ¡Vamos a escribir!
                        </button>
                    </div>
                `;
            }
        });
    }

    document.getElementById('inputArchivoFoto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('txtNombreArchivo').innerText = `¡Listo! Subiendo: ${file.name}`;
            document.getElementById('txtNombreArchivo').classList.add('text-[var(--baby-blue)]', 'font-black', 'text-xs');
        }
    });

    function enviarMensajeLamento(event, eventoId) {
        event.preventDefault();

        const botonPublicar = document.getElementById('btnPublicarMuro');
        
        botonPublicar.disabled = true;
        botonPublicar.classList.remove('btn-baby-solid');
        botonPublicar.style.backgroundColor = '#EBF5FA';
        botonPublicar.style.color = '#9BD3E1';
        botonPublicar.style.cursor = 'not-allowed';
        botonPublicar.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> Enviando volando...`;

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
                alert(data.message || "Ups, revisa bien tu clave secreta.");
                botonPublicar.disabled = false;
                botonPublicar.style.backgroundColor = '';
                botonPublicar.style.color = '';
                botonPublicar.classList.add('btn-baby-solid');
                botonPublicar.style.cursor = 'pointer';
                botonPublicar.innerHTML = "¡Enviar Cartita! <i class='fa-solid fa-paper-plane ml-2'></i>";
                throw new Error("Fallo controlado en el backend.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const cajaFormulario = document.getElementById('bloqueFormularioMensaje');
                
                cajaFormulario.innerHTML = `
                    <div class="py-16 text-center space-y-6 animate-fade-in font-light relative">
                        <div class="w-24 h-24 border-4 border-white rounded-full flex items-center justify-center mx-auto text-white bg-[var(--baby-pink)] shadow-lg">
                            <i class="fa-solid fa-heart text-4xl animate-pulse"></i>
                        </div>
                        <div class="space-y-3 relative z-10">
                            <h3 class="text-3xl font-cute text-[var(--text-dark)] font-bold">¡Llegó al cielo!</h3>
                            <p class="text-base text-[var(--text-main)] max-w-sm mx-auto leading-relaxed font-semibold">"${data.message}"</p>
                        </div>
                        <div class="star-divider !w-16"></div>
                        <p class="text-[10px] text-[var(--baby-blue)] pt-2 tracking-[0.2em] uppercase font-black">Muchísimas gracias por tanto amor.</p>
                    </div>
                `;
                
                setTimeout(() => { window.location.reload(); }, 3500);
            }
        })
        .catch(error => { console.error("Error:", error); });
    }

    // --- SISTEMA MULTIMEDIA ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('ring-4', 'ring-[var(--baby-pink)]', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-4', 'ring-[var(--baby-pink)]', 'ring-offset-2');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} Fotitos`;
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
            alert("¡Uy! Toca alguna fotito primero para poder descargarla.");
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
            alert("La cajita todavía no tiene recuerdos.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>

</body>
</html>