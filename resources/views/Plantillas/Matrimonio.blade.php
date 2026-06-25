<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Invitación</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        body { font-family: 'Montserrat', sans-serif; background-color: #f3f3f3; overflow-x: hidden; }

        .snap-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        .full-screen-section {
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            overflow: hidden;
            padding: 1rem;
            background-image: url("https://www.transparenttextures.com/patterns/cream-paper.png");
        }
        @media (min-width: 768px) {
            .full-screen-section { padding: 20px; height: 100vh; flex-direction: row; }
        }

        .full-screen-section::before, .full-screen-section::after {
            content: '\f510'; 
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            font-size: 8rem;
            color: rgba(212, 165, 165, 0.12);
            z-index: 1;
            pointer-events: none;
        }
        @media (min-width: 768px) {
            .full-screen-section::before, .full-screen-section::after { font-size: 15rem; }
        }
        .full-screen-section::before { top: -20px; left: -20px; transform: rotate(15deg); }
        .full-screen-section::after { bottom: -20px; right: -20px; transform: rotate(-165deg); }
        @media (min-width: 768px) {
            .full-screen-section::before { top: -50px; left: -50px; }
            .full-screen-section::after { bottom: -50px; right: -50px; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .bg-image-container {
            position: absolute;
            inset: 0;
            z-index: 0;
            filter: sepia(15%) brightness(95%);
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }
        .scroll-indicator { animation: bounce 2s infinite; }
        
        .animate-pop { animation: popIn 0.3s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.97); } to { opacity: 1; transform: scale(1); } }
        
        /* Ocultar Scrollbar */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: PORTADA --}}
    <section class="full-screen-section !p-4">
        <div class="relative w-full max-w-6xl h-[85vh] md:h-[90vh] flex items-center justify-center overflow-hidden rounded-2xl shadow-2xl bg-white z-10">
            <div class="bg-image-container">
                @if($evento->fotosGaleria && $evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-stone-200"></div>
                @endif
            </div>
            
            <div class="absolute inset-0 bg-black/5 z-10"></div> 

            <div class="z-20 glass-card p-6 md:p-14 w-[90%] max-w-xl text-center rounded-xl border border-white/50 mx-4">
                <p class="uppercase tracking-[0.3em] md:tracking-[0.6em] text-gray-400 mb-3 md:mb-4 text-[8px] md:text-[10px] font-bold">
                    {{ strtolower($evento->tipo->nombre) === 'memorial' ? 'In Memoriam' : 'Nuestra Boda' }}
                </p>
                <h1 class="text-3xl sm:text-4xl md:text-6xl text-gray-800 mb-4 md:mb-6 leading-tight tracking-tight break-words">{{ $evento->nombre_evento }}</h1>
                
                <div class="flex items-center justify-center gap-2 md:gap-4 mb-4 md:mb-6 text-rose-300">
                    <div class="h-[1px] w-8 md:w-10 bg-rose-200"></div>
                    <i class="fa-solid {{ strtolower($evento->tipo->nombre) === 'memorial' ? 'fa-dove' : 'fa-heart' }} text-[10px] md:text-xs"></i>
                    <div class="h-[1px] w-8 md:w-10 bg-rose-200"></div>
                </div>

                <p class="text-base md:text-xl text-gray-600 italic mb-6 md:mb-8">
                    {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d F Y') }}
                </p>

                <div id="countdown" class="grid grid-cols-4 gap-1 md:gap-4 border-t border-gray-100 pt-6 md:pt-8 font-light w-full max-w-[280px] md:max-w-none mx-auto">
                    <div class="flex flex-col">
                        <span id="days" class="text-2xl md:text-4xl text-gray-800 font-bold">00</span>
                        <span class="text-[7px] md:text-[9px] uppercase tracking-widest text-gray-400">Días</span>
                    </div>
                    <div class="flex flex-col">
                        <span id="hours" class="text-2xl md:text-4xl text-gray-800 font-bold">00</span>
                        <span class="text-[7px] md:text-[9px] uppercase tracking-widest text-gray-400">Hrs</span>
                    </div>
                    <div class="flex flex-col">
                        <span id="minutes" class="text-2xl md:text-4xl text-gray-800 font-bold">00</span>
                        <span class="text-[7px] md:text-[9px] uppercase tracking-widest text-gray-400">Min</span>
                    </div>
                    <div class="flex flex-col border-l border-rose-100 ml-1 md:ml-2">
                        <span id="seconds" class="text-2xl md:text-4xl text-rose-400 font-bold">00</span>
                        <span class="text-[7px] md:text-[9px] uppercase tracking-widest text-gray-400">Seg</span>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-4 md:bottom-8 z-30 scroll-indicator text-gray-500 text-[8px] md:text-[10px] tracking-widest uppercase">
                <span class="block mb-1 md:mb-2">Desliza</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: HISTORIA --}}
    <section class="full-screen-section !p-4">
        <div class="relative w-full max-w-6xl h-auto md:h-[90vh] min-h-[85vh] bg-white rounded-2xl shadow-2xl z-10 flex items-center p-6 md:p-20 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center w-full">
                <div class="order-2 md:order-1 px-2 md:px-4 z-10 text-center md:text-left">
                    <h2 class="text-3xl sm:text-4xl md:text-6xl text-gray-800 mb-4 md:mb-8">
                        {{ strtolower($evento->tipo->nombre) === 'memorial' ? 'Memoria de Vida' : 'Nuestra Historia' }}
                    </h2>
                    <p class="text-gray-500 leading-relaxed text-sm md:text-lg font-light italic">
                        "{!! nl2br(e($evento->biografia_resumen)) !!}"
                    </p>
                    <div class="mt-6 md:mt-8 flex items-center justify-center md:justify-start gap-4 text-rose-300">
                        <div class="h-[1px] w-8 md:w-12 bg-rose-200"></div>
                        <span class="text-[8px] md:text-[10px] uppercase tracking-widest font-bold font-sans">
                            {{ strtolower($evento->tipo->nombre) === 'memorial' ? 'Recuerdo' : 'Love Story' }}
                        </span>
                    </div>
                </div>
                <div class="order-1 md:order-2 h-[250px] sm:h-[300px] md:h-[500px] relative z-10 w-full max-w-[300px] md:max-w-none mx-auto">
                    @if($evento->fotosGaleria->count() > 1)
                        <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" class="w-full h-full object-cover rounded-t-full shadow-xl">
                    @else
                        <div class="w-full h-full bg-stone-50 rounded-t-full border border-stone-100 flex items-center justify-center">
                            <i class="fa-solid fa-heart text-stone-200 text-5xl md:text-6xl"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="full-screen-section !p-4">
        <div class="relative w-full max-w-6xl h-[85vh] md:h-[90vh] bg-white rounded-2xl shadow-2xl z-10 flex flex-col justify-center items-center text-center p-6">
            <i class="fa-solid fa-map-pin text-rose-300 text-4xl md:text-5xl mb-4 md:mb-6"></i>
            <h2 class="text-4xl md:text-5xl text-gray-800 mb-4 md:mb-6 font-serif">Dónde & Cuándo</h2>
            <p class="text-base md:text-xl text-gray-600 font-light max-w-2xl mb-8 md:mb-12 leading-relaxed italic px-2">
                {{ $evento->ubicacion_texto }}
            </p>
            @if($evento->google_maps_url)
            <a href="{{ $evento->google_maps_url }}" target="_blank" 
               class="px-8 md:px-12 py-3 md:py-4 border border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white transition-all tracking-[0.2em] md:tracking-[0.3em] text-[8px] md:text-[10px] uppercase rounded-sm w-full max-w-[250px] md:max-w-max">
                Ver en Google Maps
            </a>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES / TRIVIA --}}
    <section class="full-screen-section !p-4">
        <div class="relative w-full max-w-6xl h-[85vh] md:h-[90vh] bg-white rounded-2xl shadow-2xl z-10 flex flex-col justify-center items-center p-4 sm:p-8 overflow-y-auto">
            
            @if(strtolower($evento->tipo->nombre) === 'memorial')
                <div class="w-full max-w-xl text-center space-y-4">
                    <h2 class="text-2xl md:text-3xl text-gray-800 font-serif">Libro de Recuerdos Digital</h2>
                    <p class="text-xs md:text-sm text-gray-400 font-light px-2">Escribe un pensamiento o comparte una foto para honrar su legado.</p>
                    
                    <form id="formMemorial" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" enctype="multipart/form-data" class="space-y-3 md:space-y-4 text-left bg-stone-50 p-4 md:p-6 rounded-xl border">
                        <div>
                            <label class="block text-[10px] md:text-xs font-bold uppercase text-gray-500 mb-1">Tu Nombre Completo *</label>
                            <input type="text" name="nombre_autor" required class="w-full border bg-white p-2.5 md:p-3 rounded-lg outline-none text-xs md:text-sm focus:border-stone-400">
                        </div>

                        <div>
                            <label class="block text-[10px] md:text-xs font-bold uppercase text-gray-500 mb-1">¿Qué deseas subir? *</label>
                            <select name="tipo" id="tipoAporte" onchange="alternarCamposMemorial()" class="w-full border bg-white p-2.5 md:p-3 rounded-lg outline-none text-xs md:text-sm">
                                <option value="texto">Escribir un mensaje o dedicatoria</option>
                                <option value="imagen">Subir una fotografía histórica</option>
                            </select>
                        </div>

                        <div id="grupoTexto">
                            <label class="block text-[10px] md:text-xs font-bold uppercase text-gray-500 mb-1">Tu Mensaje *</label>
                            <textarea name="contenido" id="contenidoTexto" rows="3" class="w-full border bg-white p-2.5 md:p-3 rounded-lg outline-none text-xs md:text-sm focus:border-stone-400" placeholder="Escriba tus palabras..."></textarea>
                        </div>

                        <div id="grupoArchivo" class="hidden">
                            <label class="block text-[10px] md:text-xs font-bold uppercase text-gray-500 mb-1">Seleccionar Foto *</label>
                            <input type="file" name="archivo" id="archivoImagen" accept="image/*" class="w-full border bg-white p-1.5 md:p-2 rounded-lg text-[10px] md:text-sm">
                        </div>

                        <button type="submit" id="btnPublicarMemorial" class="w-full bg-stone-800 text-white py-2.5 md:py-3 rounded-lg font-bold hover:bg-stone-700 transition text-[10px] md:text-xs uppercase tracking-widest mt-2">
                            Enviar Recuerdo
                        </button>
                    </form>
                </div>
            @else
                <h2 class="text-3xl md:text-4xl text-gray-800 mb-8 md:mb-16 font-serif tracking-wide">Momentos Especiales</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 w-full max-w-4xl px-2">
                    
                    {{-- BLOQUE TRIVIA --}}
                    <div class="p-6 md:p-10 border border-stone-100 bg-stone-50 hover:shadow-lg transition-all rounded-lg text-center flex flex-col justify-between items-center h-auto md:h-72">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg md:text-xl mb-1 md:mb-2 font-serif">¿Cuánto nos conoces?</h3>
                            <p class="text-[9px] md:text-[10px] text-gray-400 uppercase tracking-widest">Trivia de Pareja</p>
                        </div>
                        <div id="wrapper-btn-trivia" class="w-full flex flex-col items-center gap-2 md:gap-3">
                            @if($yaComenzo)
                                <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full px-6 md:px-8 py-2.5 md:py-3 bg-gray-800 text-white text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-600 transition font-bold rounded">Jugar Ahora</button>
                                
                                <button onclick="verRanking()" class="w-full px-6 md:px-8 py-2.5 md:py-3 border border-gray-800 text-gray-800 text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-gray-100 transition font-bold rounded">Ver Ranking</button>
                            @else
                                <button id="btn-time-trivia" disabled class="w-full px-6 md:px-8 py-2.5 md:py-3 bg-stone-300 text-stone-500 text-[9px] md:text-[10px] uppercase tracking-[0.2em] cursor-not-allowed font-medium rounded">
                                    <i class="fas fa-lock mr-1"></i> Disponible en el Evento
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- BLOQUE MURO --}}
                    <div class="p-6 md:p-10 border border-stone-100 bg-stone-50 hover:shadow-lg transition-all rounded-lg text-center flex flex-col justify-between items-center h-auto md:h-72">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg md:text-xl mb-1 md:mb-2 font-serif">Muro de Deseos</h3>
                            <p class="text-[9px] md:text-[10px] text-gray-400 uppercase tracking-widest">Libro de visitas</p>
                        </div>
                        <div id="wrapper-btn-muro" class="w-full flex flex-col items-center gap-2 md:gap-3">
                            @if($yaComenzo)
                                <button onclick="solicitarAccesoVerificacion('muro')" class="w-full px-6 md:px-8 py-2.5 md:py-3 border border-gray-800 text-gray-800 text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 hover:text-white transition font-bold rounded">Escribir Mensaje</button>
                                <button onclick="mostrarMuroVisual()" class="w-full px-6 md:px-8 py-2.5 md:py-3 border border-gray-800 text-gray-800 text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 hover:text-white transition font-bold rounded">Ver Muro <i class="fa-solid fa-arrow-right ml-1 md:ml-2 text-[8px] md:text-[10px]"></i></button>
                            @else
                                <button id="btn-time-muro" disabled class="w-full px-6 md:px-8 py-2.5 md:py-3 bg-stone-300 text-stone-500 text-[9px] md:text-[10px] uppercase tracking-[0.2em] cursor-not-allowed font-medium rounded">
                                    <i class="fas fa-lock mr-1"></i> Disponible en el Evento
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </section>

    {{-- MOSTRAR MURO VISUAL DESEOS DE BODA --}}
    <section id="seccionMuroMensajes" class="hidden fixed inset-0 z-[90] bg-[#f3f3f3] overflow-y-auto w-full h-full" style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');">
        <div class="max-w-6xl w-full mx-auto px-4 md:px-6 py-12 md:py-16 text-center min-h-screen flex flex-col relative z-10">
            
            {{-- Encabezado del Muro --}}
            <div class="mb-10 md:mb-12 animate-pop">
                <i class="fas fa-comment-dots text-rose-300 text-3xl md:text-4xl mb-4 md:mb-6"></i>
                <h2 class="text-3xl sm:text-4xl md:text-6xl text-gray-800 font-serif mb-4 md:mb-6 tracking-tight">Muro de Deseos</h2>
                
                <div class="flex items-center justify-center gap-3 md:gap-4 mb-4 md:mb-6 text-rose-300">
                    <div class="h-[1px] w-8 md:w-12 bg-rose-200"></div>
                    <i class="fa-solid fa-heart text-[10px] md:text-xs"></i>
                    <div class="h-[1px] w-8 md:w-12 bg-rose-200"></div>
                </div>
                
                <p class="text-sm md:text-xl text-gray-500 italic font-light px-4">
                    Los mensajes de nuestros invitados
                </p>
            </div>

            {{-- Grid de Mensajes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 flex-grow items-start w-full">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="p-6 md:p-8 bg-white rounded-xl md:rounded-2xl shadow-xl border border-stone-100 flex flex-col text-left transition-all hover:-translate-y-2 hover:shadow-2xl h-full w-full">
                        
                        @if($item->url_onedrive)
                            @php
                                $directImgUrl = $item->url_onedrive;
                                if (str_contains($directImgUrl, '1drv.ms')) {
                                    $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                    $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                }
                            @endphp
                            <div class="mb-4 md:mb-6 overflow-hidden rounded-lg md:rounded-xl shadow-sm border border-stone-50 shrink-0">
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" 
                                    class="w-full h-40 md:h-56 object-cover hover:scale-105 transition-transform duration-700">
                            </div>
                        @endif
                        
                        <div class="flex flex-col flex-grow justify-between space-y-4">
                            <p class="text-sm md:text-base text-gray-600 font-light italic leading-relaxed flex-grow mb-4 md:mb-6 break-words">
                                "{{ $item->contenido_texto }}"
                            </p>
                            
                            <div class="pt-3 md:pt-4 border-t border-stone-100 flex items-center justify-between mt-auto">
                                <span class="text-[9px] md:text-[10px] uppercase tracking-wider md:tracking-widest font-bold text-gray-800 truncate pr-2">
                                    {{ $item->nombre_autor }}
                                </span>
                                <i class="fas fa-star text-amber-400 text-[9px] md:text-[10px] shrink-0"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 md:py-16 bg-white rounded-xl md:rounded-2xl shadow-md border border-stone-100 mx-2">
                        <i class="fa-regular fa-folder-open text-stone-300 text-3xl md:text-4xl mb-3 md:mb-4"></i>
                        <p class="text-stone-500 italic font-light text-sm md:text-base">Aún no hay mensajes en la galería.</p>
                    </div>
                @endforelse
            </div>

            {{-- Botón de Cierre / Volver --}}
            <div class="mt-12 md:mt-16 pb-8 flex justify-center w-full">
                <button onclick="ocultarMuroVisual()" class="px-6 md:px-10 py-3 md:py-4 bg-slate-800 text-white rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition hover:bg-slate-900 shadow-lg w-full max-w-xs md:max-w-max">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </button>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4.5: GALERÍA DE RECUERDOS (TIEMPO REAL CLOUD) --}}
    <section class="full-screen-section !p-4">
        <div class="relative w-full max-w-6xl h-auto min-h-[85vh] md:min-h-[90vh] bg-white rounded-2xl shadow-2xl z-10 flex flex-col items-center p-6 md:p-12 overflow-hidden">
            
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-3xl sm:text-4xl md:text-5xl text-gray-800 font-serif mb-2 md:mb-4">Capturando Momentos</h2>
                <div class="flex items-center justify-center gap-3 md:gap-4 text-rose-300">
                    <div class="h-[1px] w-8 md:w-12 bg-rose-200"></div>
                    <i class="fa-solid fa-camera-retro text-[10px] md:text-xs"></i>
                    <div class="h-[1px] w-8 md:w-12 bg-rose-200"></div>
                </div>
            </div>

            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 bg-stone-50 border border-stone-100 p-4 md:p-6 rounded-xl gap-4">
                <div class="text-center md:text-left">
                    <span id="contador-seleccionadas" class="font-serif italic text-xl md:text-2xl text-gray-800">
                        0 seleccionadas
                    </span>
                    <p class="text-[9px] md:text-[10px] text-gray-400 uppercase tracking-widest mt-1">Haz clic en las fotos para descargar</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button onclick="descargarSeleccionadas()" class="text-[10px] md:text-xs font-bold border border-gray-800 text-gray-800 px-6 py-2.5 md:py-3 hover:bg-gray-800 hover:text-white transition uppercase tracking-widest rounded w-full md:w-auto">
                        <i class="fas fa-download mr-2"></i> Selección
                    </button>
                    <button onclick="descargarTodas()" class="text-[10px] md:text-xs font-bold bg-[#bc8567] text-white px-6 py-2.5 md:py-3 hover:bg-[#4a3728] transition uppercase tracking-widest rounded w-full md:w-auto shadow-md">
                        <i class="fas fa-cloud-download-alt mr-2"></i> Descargar Todo
                    </button>
                </div>
            </div>

            @php
                $galeriaUnificada = collect();

                // 1. Fotos Locales de la BD
                if(isset($evento->fotosGaleria)) {
                    foreach($evento->fotosGaleria as $foto) {
                        if(!str_starts_with($foto->url_recurso, 'http')) {
                            $ext = strtolower(pathinfo($foto->url_recurso, PATHINFO_EXTENSION));
                            $esVideoLocal = in_array($ext, ['mp4', 'mov', 'avi', 'webm']);

                            $galeriaUnificada->push([
                                'url' => asset('storage/' . $foto->url_recurso),
                                'esNube' => false,
                                'esVideo' => $esVideoLocal,
                                'etiqueta' => 'Álbum Oficial'
                            ]);
                        }
                    }
                }

                // 2. Fotos de OneDrive
                if(isset($fotosNubeRealtime)) {
                    foreach($fotosNubeRealtime as $fotoCloud) {
                        $galeriaUnificada->push([
                            'url' => $fotoCloud['url'],
                            'esNube' => true,
                            'esVideo' => $fotoCloud['esVideo'] ?? false,
                            'etiqueta' => 'Recuerdo de Invitado'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 w-full max-h-[60vh] overflow-y-auto hide-scroll p-2">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer border border-stone-100 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 bg-stone-50" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-black/10 hover:bg-black/20 transition">
                                <div class="w-12 h-12 bg-white/80 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition shadow-lg">
                                    <i class="fas fa-play text-gray-800 ml-1"></i>
                                </div>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover group-hover:scale-105 transition-transform duration-700">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-[#4a3728]/30 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-3 right-3 bg-white text-[#4a3728] rounded-full w-6 h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-md z-30 pointer-events-none">
                            <i class="fas fa-check text-xs"></i>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent pt-6 pb-2 px-3 text-white text-[8px] md:text-[9px] uppercase tracking-widest truncate z-30 pointer-events-none">
                            <i class="fas {{ $foto['esVideo'] ? 'fa-video' : ($foto['esNube'] ? 'fa-cloud' : 'fa-camera') }} mr-1"></i>
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 border border-dashed border-stone-200 text-center rounded-xl bg-stone-50">
                        <i class="fa-regular fa-images text-3xl text-stone-300 mb-3"></i>
                        <p class="text-stone-500 font-serif italic text-lg">Aún no hay memorias guardadas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP --}}
    <section class="full-screen-section !p-4 relative">
        <div class="relative w-full max-w-6xl h-[85vh] md:h-[90vh] bg-[#1a1a1a] text-white rounded-2xl shadow-2xl z-10 flex flex-col p-6 md:p-8">
            
            {{-- CONTENIDO PRINCIPAL CENTRADO --}}
            <div class="my-auto flex flex-col items-center text-center w-full">
                @if(strtolower($evento->tipo->nombre) === 'memorial')
                    <i class="fa-solid fa-dove text-stone-500 text-4xl md:text-5xl mb-4 md:mb-6"></i>
                    <h2 class="text-3xl sm:text-4xl md:text-6xl mb-6 md:mb-8 leading-tight font-serif italic">Agradecemos tu Presencia</h2>
                    <div class="w-10 md:w-12 h-[1px] bg-stone-600 mb-6 md:mb-8"></div>
                    <p class="text-stone-400 text-xs md:text-sm font-light leading-relaxed md:leading-loose max-w-md italic px-4 mb-8">
                        Gracias por acompañarnos y formar parte de este tributo de amor y respeto. Su recuerdo seguirá vivo en cada uno de nosotros.
                    </p>
                @else
                    <h2 class="text-4xl sm:text-5xl md:text-7xl mb-6 md:mb-8 leading-tight font-serif italic">¿Nos acompañas?</h2>
                    <div class="w-10 md:w-12 h-[1px] bg-stone-600 mb-6 md:mb-8"></div>
                    <p class="text-stone-400 text-xs md:text-sm font-light mb-8 md:mb-12 leading-relaxed md:leading-loose max-w-md italic px-4">
                        Sería un honor para nosotros contar con tu presencia en este inicio de nuestra vida juntos.
                    </p>
                @endif

                <div class="w-full flex justify-center mb-6">
                    @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                        <button onclick="abrirModalAsistencia()" class="px-8 md:px-12 py-3 md:py-4 bg-white text-black font-bold uppercase text-[10px] md:text-xs tracking-widest rounded shadow-lg hover:bg-stone-200 transition-colors duration-300 w-full max-w-xs md:max-w-max">
                            Confirmar Asistencia
                        </button>
                    @else
                        <div class="px-6 md:px-8 py-3 bg-white/10 border border-white/20 text-[9px] md:text-xs tracking-wider uppercase text-stone-300 w-full max-w-xs md:max-w-max">
                            Código QR Obligatorio
                        </div>
                    @endif
                </div>
            </div>

            {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) PERFECTAMENTE ANCLADA 🔥 --}}
            <div class="mt-auto w-full text-center pt-8 pb-2">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-80 hover:opacity-100 transition-all duration-300 group cursor-pointer">
                    <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-stone-500 mb-1.5 font-medium">Tecnología y Diseño por</span>
                    <div class="flex items-center gap-1.5 transition-colors">
                        <i class="fas fa-glass-cheers text-[11px] md:text-xs text-rose-400 group-hover:text-rose-300"></i>
                        <span class="font-serif italic text-sm md:text-base font-bold tracking-widest text-white group-hover:text-rose-100 transition-colors">Eventify</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO DE TRIVIA/MURO --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/80 backdrop-blur-xs p-4">
    <div id="wrapper-dinamico-modal" class="bg-white rounded-2xl max-w-xl w-[95%] md:w-full p-5 md:p-10 text-center shadow-2xl border border-stone-100 max-h-[95vh] overflow-y-auto">
        
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-4 border-b pb-2 text-left">
                <h3 class="text-sm md:text-base font-bold uppercase tracking-wide text-gray-800"><i class="fas fa-key text-amber-500 mr-1"></i> Código Requerido</h3>
                <button onclick="cerrarModalFiltro()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-3 md:space-y-4 text-left">
                <p class="text-[10px] md:text-xs text-stone-500 font-light leading-relaxed">Para ingresar, introduce el **Código de Pase Personal** que el sistema te entregó en la pantalla al confirmar tu asistencia.</p>
                <div>
                    <label class="block text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mb-1">Introduce tu Clave</label>
                    <input type="text" id="inputCodigoIngreso" placeholder="Ej: MAT-4819" class="w-full border p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm font-mono tracking-widest outline-none uppercase focus:border-indigo-500">
                </div>
                <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="w-full bg-slate-800 text-white py-2.5 md:py-3 rounded-lg md:rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition hover:bg-slate-900 shadow-md mt-2">
                    Verificar e Ingresar
                </button>
            </div>
        </div>

    </div>
</div>

{{-- MODAL RANKING DE TRIVIA (ESTILO EDITORIAL/CLÁSICO) --}}
<div id="modalRanking" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl border border-stone-100 w-[95%] md:w-full max-w-2xl p-6 md:p-8 text-center shadow-2xl relative max-h-[95vh] flex flex-col font-sans">
        
        <div class="flex justify-between items-center mb-4 md:mb-6 border-b border-stone-200 pb-3 md:pb-4 shrink-0 text-left">
            <h3 class="text-xl md:text-2xl font-serif italic text-gray-800">
                <i class="fas fa-crown mr-2 text-amber-500"></i> Cuadro de Honor
            </h3>
            <button onclick="cerrarModalRanking()" class="text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-xl"></i></button>
        </div>

        <div class="overflow-y-auto pr-1 md:pr-2 space-y-2 md:space-y-3 flex-grow hide-scroll text-left" id="cuerpo-ranking">
            <div class="text-center py-10">
                <i class="fas fa-circle-notch fa-spin text-3xl md:text-4xl text-stone-300"></i>
            </div>
        </div>

        <div class="mt-4 md:mt-6 pt-3 md:pt-4 shrink-0 border-t border-stone-100">
            <button onclick="cerrarModalRanking()" class="w-full py-2.5 md:py-3 bg-stone-800 text-white rounded-lg md:rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-stone-900 transition shadow-md">
                Cerrar Ranking
            </button>
        </div>
    </div>
</div>

{{-- MODAL PÚBLICO PARA DEJAR MENSAJES EN EL MURO DE DESEOS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/30 backdrop-blur-sm p-4">
    <div class="bg-white text-gray-800 w-[95%] md:w-full max-w-md p-5 md:p-6 rounded-2xl shadow-xl max-h-[95vh] overflow-y-auto">
        
        <div class="flex justify-between items-center mb-4 border-b pb-2 text-left">
            <h3 class="text-sm md:text-base font-bold uppercase tracking-wide text-gray-800">
                <i class="fas fa-comment-dots text-amber-500 mr-1"></i> Dejar un mensaje
            </h3>
            <button onclick="cerrarModalMuroBoda()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-lg md:text-xl"></i>
            </button>
        </div>

        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" class="space-y-3 md:space-y-4 text-left">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">

            <div>
                <label class="block text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mb-1">Nombre</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly 
                    class="w-full border p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-indigo-500 text-gray-800">
            </div>
            
            <div>
                <label class="block text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mb-1">Rol en el elenco *</label>
                <select name="vinculo_autor" required 
                    class="w-full border p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-indigo-500 text-gray-800 cursor-pointer">
                    <option value="" disabled selected>Seleccione opción...</option>
                    <option value="Familiar">Familiar directo</option>
                    <option value="Amigo/a">Amigo / Amiga</option>
                    <option value="Compañero">Compañero de trabajo</option>
                    <option value="Conocido">Conocido</option>
                </select>
            </div>

            <div>
                <label class="block text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mb-1">Tu Mensaje *</label>
                <textarea name="contenido" required rows="3" 
                    class="w-full border p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm outline-none focus:border-indigo-500 text-gray-800 leading-relaxed" 
                    placeholder="Escribe tus deseos..."></textarea>
            </div>

            <div>
                <label class="block text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mb-1">Recuerdo Visual (Opcional)</label>
                <input type="file" name="archivo" accept="image/*" 
                    class="w-full text-[10px] md:text-sm text-gray-500 border p-1.5 md:p-2 rounded-lg md:rounded-xl outline-none focus:border-indigo-500 file:mr-2 md:file:mr-4 file:py-1 md:file:py-2 file:px-2 md:file:px-4 file:border-0 file:text-[9px] md:file:text-xs file:font-bold file:uppercase file:tracking-widest file:rounded-md md:file:rounded-lg file:text-slate-700 file:bg-slate-100 file:cursor-pointer hover:file:bg-slate-200 transition-all">
            </div>

            <button type="submit" id="btnPublicarMuro" 
                class="w-full bg-slate-800 text-white py-2.5 md:py-3 rounded-lg md:rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition hover:bg-slate-900 shadow-md mt-2">
                Publicar Mensaje
            </button>
        </form>
    </div>
</div>

{{-- MODAL PÚBLICO PARA REGISTRO DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="bg-white text-black rounded-2xl max-w-md w-[95%] md:w-full p-5 md:p-6 text-center shadow-2xl animate-fade-in max-h-[95vh] overflow-y-auto">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-4 border-b pb-2 text-left">
                <h3 class="text-lg md:text-xl font-bold font-serif text-gray-800">Confirmar mi Asistencia</h3>
                <button onclick="cerrarModalAsistencia()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-3 md:space-y-4 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-stone-50 p-3 md:p-4 rounded-xl border border-stone-100 space-y-2 md:space-y-3">
                    <span class="text-[9px] md:text-[10px] uppercase tracking-wider font-bold text-rose-400">Invitado Principal</span>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold uppercase text-gray-500 mb-1">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border bg-white p-2 md:p-2.5 rounded-lg text-xs md:text-sm outline-none focus:border-gray-400" placeholder="Ej: Jonathan Pinilla">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-bold uppercase text-gray-500 mb-1">Correo Electrónico (Opcional)</label>
                        <input type="email" id="inputEmailPrincipal" class="w-full border bg-white p-2 md:p-2.5 rounded-lg text-xs md:text-sm outline-none focus:border-gray-400" placeholder="juan@correo.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-2 md:space-y-3"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-2 border-2 border-dashed border-stone-300 text-stone-600 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wider hover:bg-stone-50 transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> ¿Asistes con alguien más?
                </button>

                <button type="submit" id="btnConfirmarAsistencia" class="w-full bg-stone-800 text-white py-2.5 md:py-3 rounded-lg font-bold text-[10px] md:text-xs uppercase tracking-widest shadow-md hover:bg-stone-700 transition mt-3 md:mt-4">
                    Confirmar Asistencia
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR DE VIDEO ELEGANTE --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-white/50 hover:text-white transition z-50">
        <i class="fas fa-times text-3xl md:text-4xl drop-shadow-md"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-xl overflow-hidden shadow-2xl border border-white/10" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
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
        const horaEvento = "{{ $evento->hora ?? '18:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='col-span-4 py-4 text-rose-400 font-bold tracking-widest uppercase text-center w-full text-xs md:text-base'>¡Llegó el gran día!</p>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('trivia')" class="w-full px-6 md:px-8 py-2.5 md:py-3 bg-gray-800 text-white text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-600 transition font-bold rounded">Jugar Ahora</button>
                        
                        <button onclick="verRanking()" class="w-full px-6 md:px-8 py-2.5 md:py-3 border border-gray-800 text-gray-800 text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-gray-100 transition font-bold rounded">Ver Ranking</button>
                    `;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `
                        <button onclick="solicitarAccesoVerificacion('muro')" class="w-full px-6 md:px-8 py-2.5 md:py-3 border border-gray-800 text-gray-800 text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 hover:text-white transition font-bold rounded">Escribir Mensaje</button>
                        <button onclick="mostrarMuroVisual()" class="w-full px-6 md:px-8 py-2.5 md:py-3 border border-gray-800 text-gray-800 text-[9px] md:text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 hover:text-white transition font-bold rounded">Ver Muro <i class="fa-solid fa-arrow-right ml-1 md:ml-2 text-[8px] md:text-[10px]"></i></button>
                    `;
                }
                return;
            }

            document.getElementById('days').innerText = Math.floor(gap / day).toString().padStart(2, '0');
            document.getElementById('hours').innerText = Math.floor((gap % d) / hour).toString().padStart(2, '0');
            document.getElementById('minutes').innerText = Math.floor((gap % hour) / minute).toString().padStart(2, '0');
            document.getElementById('seconds').innerText = Math.floor((gap % minute) / second).toString().padStart(2, '0');
        };

        setInterval(updateCountdown, 1000);
        updateCountdown();

        if(document.getElementById('tipoAporte')) {
            alternarCamposMemorial();
        }
    });

    function solicitarAccesoVerificacion(modulo) {
        moduloObjetivo = modulo;
        document.getElementById('wrapper-dinamico-modal').className = "bg-white rounded-2xl max-w-xl w-[95%] md:w-full p-5 md:p-10 text-center shadow-2xl border border-stone-100 max-h-[95vh] overflow-y-auto";
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-4 border-b pb-2 text-left">
                    <h3 class="text-sm md:text-base font-bold uppercase tracking-wide text-gray-800"><i class="fas fa-key text-amber-500 mr-1"></i> Código Requerido</h3>
                    <button onclick="cerrarModalFiltro()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-3 md:space-y-4 text-left">
                    <p class="text-[10px] md:text-xs text-stone-500 font-light leading-relaxed">Para ingresar, introduce el **Código de Pase Personal** que el sistema te entregó en la pantalla al confirmar tu asistencia.</p>
                    <div>
                        <label class="block text-[9px] md:text-[10px] font-bold uppercase text-gray-400 mb-1">Introduce tu Clave</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="Ej: MAT-4819" class="w-full border p-2.5 md:p-3 rounded-lg md:rounded-xl text-xs md:text-sm font-mono tracking-widest outline-none uppercase focus:border-indigo-500">
                    </div>
                    <button id="btnVerificarCodigo" onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="w-full bg-slate-800 text-white py-2.5 md:py-3 rounded-lg md:rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition hover:bg-slate-900 shadow-md mt-2">
                        Verificar e Ingresar
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() { document.getElementById('modalFiltroAcceso').classList.add('hidden'); }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("Por favor, introduce un código válido."); return; }

        const btnVerificar = document.getElementById('btnVerificarCodigo');
        const txtOriginalVerificar = btnVerificar.innerHTML;
        
        // Animación de carga para Validar Credencial
        btnVerificar.disabled = true;
        btnVerificar.classList.add('opacity-70', 'cursor-not-allowed');
        btnVerificar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> VERIFICANDO...';

        fetch(`/invitacion/validar-pase-trivia`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
        })
        .then(async response => {
            const data = await response.status === 422 || response.status === 404 || response.status === 200 ? await response.json() : {};
            
            if (response.status === 422 && data.already_played) {
                if (moduloObjetivo === 'trivia') {
                    const wrapper = document.getElementById('wrapper-dinamico-modal');
                    wrapper.innerHTML = `
                        <div class="py-4 md:py-6 text-center space-y-4 md:space-y-6 animate-pop">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto shadow-sm">
                                <i class="fas fa-exclamation-circle text-xl md:text-2xl text-amber-500"></i>
                            </div>
                            <div class="space-y-1 md:space-y-2">
                                <h3 class="text-lg md:text-xl font-serif italic text-[#4a3728]">Trivia Ya Completada</h3>
                                <p class="text-[10px] md:text-sm text-stone-600 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                            </div>
                            <div class="pt-2 md:pt-4 space-y-2 md:space-y-3">
                                <button onclick="verRanking()" class="w-full px-6 md:px-8 py-2.5 md:py-3 bg-stone-800 text-white text-[10px] md:text-xs font-bold uppercase tracking-widest rounded-lg md:rounded-xl hover:bg-stone-700 transition shadow-md">Ver el Cuadro de Honor</button>
                                <button onclick="cerrarModalFiltro()" class="w-full px-6 md:px-8 py-2.5 md:py-3 bg-stone-100 text-stone-600 text-[10px] md:text-xs font-bold uppercase tracking-widest rounded-lg md:rounded-xl hover:bg-stone-200 transition">Regresar</button>
                            </div>
                        </div>
                    `;
                    throw new Error("already_handled");
                } else {
                    return { success: true, invitado_id: null, nombre_invitado: "Invitado" };
                }
            }

            if (!response.ok) { alert(data.message || "Entrada Inválida."); throw new Error("invalid_code"); }
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
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado !== "Invitado" ? data.nombre_invitado : "Tu Familia/Amigos";
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => { 
            if (err.message !== "already_handled") {
                console.error("Fallo:", err); 
            }
            if (btnVerificar) {
                btnVerificar.disabled = false;
                btnVerificar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnVerificar.innerHTML = txtOriginalVerificar;
            }
        });
    }

    function mostrarMuroVisual() {
        const muro = document.getElementById('seccionMuroMensajes');
        muro.classList.remove('hidden');
        setTimeout(() => { muro.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 50);
    }

    function ocultarMuroVisual() {
        const muro = document.getElementById('seccionMuroMensajes');
        muro.previousElementSibling.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(() => { muro.classList.add('hidden'); }, 600);
    }

    function abrirModalMuroBoda() { document.getElementById('modalMuroBoda').classList.remove('hidden'); }
    function cerrarModalMuroBoda() { document.getElementById('modalMuroBoda').classList.add('hidden'); }

    function enviarRecuerdoMemorial(event, eventoId) {
        event.preventDefault();
        const botonPublicar = document.getElementById('btnPublicarMuro');
        const textoOriginal = botonPublicar.innerHTML;
        
        // Animación elegante de carga
        botonPublicar.disabled = true;
        botonPublicar.classList.add('opacity-70', 'cursor-not-allowed');
        botonPublicar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> ENVIANDO...';

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
                alert(data.message || "Error al verificar la clave.");
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
                throw new Error("Validation fail");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const modalInterior = document.getElementById('modalMuroBoda').firstElementChild;
                modalInterior.innerHTML = `
                    <div class="py-6 md:py-8 text-center space-y-4 md:space-y-6 animate-pop font-mono">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50/10 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30">
                            <i class="fas fa-check text-xl md:text-2xl text-emerald-400"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl font-bold uppercase italic text-stone-600">¡Mensaje Publicado!</h3>
                            <p class="text-[10px] md:text-xs text-stone-400 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <button onclick="cerrarModalMuroBoda(); window.location.reload();" class="w-full bg-slate-800 text-white py-2.5 md:py-3.5 rounded-lg md:rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest hover:bg-slate-900 transition mt-3 md:mt-4">
                            Cerrar
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            if (botonPublicar) {
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('opacity-70', 'cursor-not-allowed');
                botonPublicar.innerHTML = textoOriginal;
            }
        });
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-4 md:space-y-6 animate-pop font-mono">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto shadow-xs border border-amber-100">
                    <i class="fas fa-gamepad text-lg md:text-xl text-amber-500"></i>
                </div>
                <span class="text-[10px] md:text-xs uppercase tracking-widest text-amber-600 font-bold block">Trivia del Evento</span>
                <h1 class="text-xl md:text-3xl font-serif text-slate-800">¡Hola, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-slate-500 text-[10px] md:text-sm leading-relaxed px-1 md:px-2">Demuestra qué tanto conoces a los anfitriones. Responderás un total de <strong class="text-slate-700">${bancoPreguntas.length} preguntas</strong> de trivia. ¡Cada segundo cuenta para el ranking!</p>
                
                <button onclick="comenzarJuegoModal()" class="w-full bg-slate-800 text-white py-3 md:py-4 rounded-lg md:rounded-xl font-bold uppercase tracking-wider text-[10px] md:text-xs hover:bg-slate-900 transition shadow-md mt-2">
                    Comenzar a Jugar
                </button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-4 md:space-y-6 text-left animate-pop font-mono">
                <div class="flex justify-between items-center text-[10px] md:text-xs font-semibold uppercase tracking-wider text-slate-400 border-b pb-2 md:pb-4">
                    <span id="info-progreso">Pregunta 1 de X</span>
                    <span class="text-amber-600"><i class="fas fa-clock mr-1"></i> Tiempo: <span id="info-cronometro" class="font-mono text-xs md:text-sm font-bold">0s</span></span>
                </div>

                <h2 id="texto-pregunta" class="text-base md:text-xl font-serif text-slate-800 leading-snug">Cargando pregunta...</h2>

                <div class="space-y-2 md:space-y-3 pt-1 md:pt-2">
                    <button onclick="seleccionarOpcionModal('a')" id="btn-opcion-a" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">A</span>
                        <span id="texto-opcion-a" class="break-words">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" id="btn-opcion-b" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">B</span>
                        <span id="texto-opcion-b" class="break-words">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" id="btn-opcion-c" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">C</span>
                        <span id="texto-opcion-c" class="break-words">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" id="btn-opcion-d" class="w-full text-left p-3 md:p-4 rounded-lg md:rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-[10px] md:text-sm flex items-center space-x-2 md:space-x-3 text-slate-700">
                        <span class="w-5 h-5 md:w-6 md:h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] md:text-xs font-bold text-slate-500 border border-slate-200 shrink-0">D</span>
                        <span id="texto-opcion-d" class="break-words">Opción D</span>
                    </button>
                </div>
            </div>
        `;
        tiempoInicio = Date.now();
        intervaloCronometro = setInterval(() => {
            segundosTranscurridos = Math.floor((Date.now() - tiempoInicio) / 1000);
            const crono = document.getElementById('info-cronometro');
            if(crono) crono.innerText = segundosTranscurridos + 's';
        }, 1000);
        renderizarPreguntaModal();
    }

    function renderizarPreguntaModal() {
        if(bancoPreguntas.length === 0) {
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-slate-400 text-[10px] md:text-xs font-mono">Este evento no cuenta con preguntas de trivia configuradas.</p>`;
            clearInterval(intervaloCronometro);
            return;
        }
        const q = bancoPreguntas[preguntaActualIndex];
        document.getElementById('info-progreso').innerText = `Pregunta ${preguntaActualIndex + 1} de ${bancoPreguntas.length}`;
        document.getElementById('texto-pregunta').innerText = q.pregunta;
        document.getElementById('texto-opcion-a').innerText = q.opcion_a;
        document.getElementById('texto-opcion-b').innerText = q.opcion_b;
        document.getElementById('texto-opcion-c').innerText = q.opcion_c;
        document.getElementById('texto-opcion-d').innerText = q.opcion_d;
    }

    function seleccionarOpcionModal(opcionElegida) {
        const q = bancoPreguntas[preguntaActualIndex];
        if (opcionElegida === q.respuesta_correcta) {
            puntajeAcumulado += parseInt(q.puntos);
        }

        preguntaActualIndex++;
        if (preguntaActualIndex < bancoPreguntas.length) {
            renderizarPreguntaModal();
        } else {
            finalizarTriviaModal();
        }
    }

    function finalizarTriviaModal() {
        clearInterval(intervaloCronometro);
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        
        wrapper.innerHTML = `
            <div class="text-center space-y-4 md:space-y-6 py-6 md:py-8 animate-pop">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto border">
                    <i class="fas fa-spinner fa-spin text-lg md:text-xl text-slate-400"></i>
                </div>
                <h3 class="text-lg md:text-xl font-bold text-slate-800">Sincronizando puntuación...</h3>
                <p class="text-[10px] md:text-xs text-slate-400 font-light">Guardando tu récord en el servidor del evento.</p>
            </div>
        `;

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        const payload = {
            evento_id: "{{ $evento->evento_id }}",
            invitado_id: datosInvitadoValidado.id, 
            nombre_jugador: datosInvitadoValidado.nombre, 
            puntaje: puntajeAcumulado,
            tiempo_segundos: segundosTranscurridos
        };

        fetch('/invitacion/registrar-participacion-trivia', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': tokenCsrf },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                wrapper.innerHTML = `
                    <div class="text-center space-y-4 md:space-y-6 py-2 md:py-4 animate-pop">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto border border-emerald-100 mb-2 md:mb-4 shadow-sm">
                            <i class="fas fa-trophy text-xl md:text-2xl text-emerald-500"></i>
                        </div>
                        <h3 class="text-xl md:text-2xl font-serif text-slate-800">¡Trivia Completada!</h3>
                        <p class="text-[10px] md:text-sm text-slate-500 max-w-xs mx-auto leading-relaxed px-2">Tus respuestas han sido procesadas de forma exitosa.</p>
                        
                        <div class="grid grid-cols-2 gap-3 md:gap-4 bg-slate-50 p-3 md:p-4 border border-slate-100 rounded-lg md:rounded-xl max-w-xs mx-auto text-left">
                            <div class="border-r pr-2">
                                <span class="block text-[8px] md:text-[10px] uppercase font-bold text-slate-400 mb-1">Puntaje Total</span>
                                <span class="text-lg md:text-xl font-black text-slate-800">${puntajeAcumulado} pts</span>
                            </div>
                            <div class="text-left pl-2">
                                <span class="block text-[8px] md:text-[10px] uppercase font-bold text-slate-400 mb-1">Tiempo Récord</span>
                                <span class="text-lg md:text-xl font-black text-slate-800">${segundosTranscurridos} seg</span>
                            </div>
                        </div>

                        <div class="pt-2 md:pt-4 space-y-2 md:space-y-3">
                            <button onclick="verRanking()" class="w-full bg-slate-800 text-white py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-slate-900 transition shadow-md">Ver el Cuadro de Honor</button>
                            <button onclick="cerrarModalFiltro()" class="w-full bg-stone-100 text-stone-600 py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-stone-200 transition">Terminar</button>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            wrapper.innerHTML = `<p class="text-red-500 font-bold text-xs md:text-sm"><i class="fas fa-exclamation-triangle mr-1"></i> Error al guardar la puntuación.</p>`;
        });
    }

    // --- LÓGICA DEL RANKING (DISEÑO EDITORIAL/CLÁSICO) ---
    function verRanking() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
        document.getElementById('modalRanking').classList.remove('hidden');
        document.getElementById('cuerpo-ranking').innerHTML = '<div class="text-center py-10"><i class="fas fa-circle-notch fa-spin text-3xl md:text-4xl text-stone-300"></i></div>';

        fetch(`/invitacion/evento/{{ $evento->evento_id }}/ranking`)
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let html = '';
                if(data.ranking.length === 0) {
                    html = '<p class="text-stone-500 text-center font-light italic mt-10 text-xs md:text-sm">La lista de honor aún no tiene registros.</p>';
                } else {
                    data.ranking.forEach((jugador, index) => {
                        let medalla = `<span class="text-base md:text-lg text-stone-400 font-serif mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0">#${index + 1}</span>`;
                        let resplandor = 'border-stone-100 bg-white text-gray-800';
                        
                        if(index === 0) {
                            medalla = '<i class="fas fa-crown text-amber-500 text-lg md:text-2xl mr-2 md:mr-4 w-4 md:w-6 text-center drop-shadow-sm shrink-0"></i>';
                            resplandor = 'border-amber-200 shadow-[0_3px_10px_rgba(245,158,11,0.1)] md:shadow-[0_5px_15px_rgba(245,158,11,0.1)] bg-amber-50 scale-[1.02] z-10 relative';
                        } else if(index === 1) {
                            medalla = '<i class="fas fa-medal text-gray-400 text-base md:text-xl mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                            resplandor = 'border-stone-200 bg-stone-50 text-gray-700';
                        } else if(index === 2) {
                            medalla = '<i class="fas fa-medal text-amber-700 text-base md:text-xl mr-2 md:mr-4 w-4 md:w-6 text-center shrink-0"></i>';
                        }

                        html += `
                            <div class="flex justify-between items-center border ${resplandor} p-3 md:p-4 animate-pop mb-2 md:mb-3 rounded-lg md:rounded-xl">
                                <div class="flex items-center truncate pr-2">
                                    ${medalla}
                                    <span class="font-semibold tracking-wide text-xs md:text-sm truncate">${jugador.nombre_jugador}</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="block font-black text-lg md:text-xl leading-none">${jugador.puntaje_total} <span class="text-[8px] md:text-[9px] text-stone-400 font-normal">pts</span></span>
                                    <span class="block text-[8px] md:text-[9px] text-stone-400 tracking-widest uppercase mt-1 border-t border-stone-200 pt-1">${jugador.tiempo_empleado} seg</span>
                                </div>
                            </div>
                        `;
                    });
                }
                document.getElementById('cuerpo-ranking').innerHTML = html;
            } else {
                document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 font-bold text-center mt-10 text-[10px] md:text-xs uppercase tracking-widest">Error al cargar la lista.</p>';
            }
        })
        .catch(err => {
            document.getElementById('cuerpo-ranking').innerHTML = '<p class="text-rose-500 font-bold text-center mt-10 text-[10px] md:text-xs uppercase tracking-widest">Fallo de conexión.</p>';
        });
    }

    function cerrarModalRanking() {
        document.getElementById('modalRanking').classList.add('hidden');
    }

    let contadorAcompanantes = 0;
    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-rose-50/40 p-3 md:p-4 rounded-lg md:rounded-xl border border-rose-100/60 space-y-2 md:space-y-3 relative animate-fade-in";
        div.innerHTML = `
            <div class="flex justify-between items-center">
                <span class="text-[9px] md:text-[10px] uppercase tracking-wider font-bold text-stone-500">Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-rose-400 hover:text-rose-600 text-[10px] md:text-xs font-bold">
                    <i class="fas fa-trash-alt"></i> Quitar
                </button>
            </div>
            <div>
                <input type="text" class="input-nombre-acompanante w-full border bg-white p-2 md:p-2.5 rounded-lg text-xs md:text-sm outline-none focus:border-gray-400" placeholder="Nombre Completo *" required>
            </div>
            <div>
                <input type="email" class="input-email-acompanante w-full border bg-white p-2 md:p-2.5 rounded-lg text-xs md:text-sm outline-none focus:border-gray-400" placeholder="Correo (Opcional)">
            </div>
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
        
        // Animación de carga para Confirmar Asistencia
        btnConfirmar.disabled = true;
        btnConfirmar.classList.add('opacity-70', 'cursor-not-allowed');
        btnConfirmar.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> CONFIRMANDO...';

        const nodosNombres = document.querySelectorAll('.input-nombre-acompanante');
        const nodosEmails = document.querySelectorAll('.input-email-acompanante');
        const listaAcompanantes = Array.from(nodosNombres).map((input, index) => {
            return {
                nombre: input.value.trim(),
                email: nodosEmails[index]?.value.trim() || ''
            };
        }).filter(a => a.nombre !== "");
        
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
                    <div class="py-6 px-2 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto border border-amber-200">
                            <i class="fas fa-exclamation-triangle text-xl md:text-2xl text-amber-500"></i>
                        </div>
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-lg md:text-xl font-serif italic text-[#4a3728]">Asistencia Ya Confirmada</h3>
                            <p class="text-[10px] md:text-sm text-stone-500 font-light px-2 md:px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="p-3 md:p-4 bg-amber-50/50 border border-amber-100 rounded-xl text-[10px] md:text-xs text-amber-800 text-left leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i> Si necesitas modificar los cupos reservados o realizar algún cambio, por favor contacta directamente a los novios.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-stone-800 text-white py-2 md:py-2.5 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-stone-700 transition shadow-md mt-2">
                            Entendido
                        </button>
                    </div>
                `;
                throw new Error("already_handled");
            }

            if (!response.ok) {
                throw new Error("Error en el Servidor Laravel.");
            }
            return data;
        })
        .then(data => {
            if (data && data.success) {
                const contenedorModal = document.getElementById('cuerpoInternoModalAsistencia');
                
                contenedorModal.innerHTML = `
                    <div class="py-4 md:py-6 px-2 text-center space-y-4 md:space-y-6 animate-fade-in">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto border border-emerald-200">
                            <i class="fas fa-check text-xl md:text-2xl text-emerald-500"></i>
                        </div>
                        
                        <div class="space-y-1 md:space-y-2">
                            <h3 class="text-xl md:text-2xl font-serif italic text-[#4a3728]">¡Todo Listo!</h3>
                            <p class="text-[10px] md:text-sm text-stone-500 font-light px-1 md:px-2">Guarda tus códigos de acceso individuales para participar en las dinámicas.</p>
                        </div>

                        <div class="bg-white border border-stone-200 rounded-[20px] md:rounded-[25px] p-4 md:p-5 text-left space-y-3 md:space-y-4 shadow-sm">
                            <p class="text-[8px] md:text-[10px] uppercase font-bold tracking-widest text-[#bc8567] border-b border-stone-100 pb-1.5 md:pb-2">
                                <i class="fas fa-ticket-alt mr-1"></i> Pases Personales
                            </p>
                            <div class="text-[10px] md:text-xs space-y-2 md:space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-2 md:pt-3 border-t border-dashed border-stone-100' : ''}">
                                        <span class="font-sans font-medium text-stone-700 truncate pr-2">${item.nombre}:</span> 
                                        <span class="bg-[#4a3728] px-2 md:px-3 py-0.5 md:py-1 rounded-md md:rounded-lg text-[9px] md:text-[11px] font-bold text-[#f4eee8] font-mono tracking-widest shadow-sm shrink-0">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[9px] md:text-[10px] text-stone-400 italic leading-relaxed px-2 md:px-4">Utiliza estos códigos en el Muro de Deseos o en la Trivia de Pareja durante el evento.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-[#bc8567] text-white py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-bold uppercase tracking-widest hover:bg-[#4a3728] transition shadow-md mt-2">
                            Entendido
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-6 md:px-8 py-3 md:py-4 border border-emerald-500/30 text-[10px] md:text-xs tracking-widest uppercase text-emerald-600 w-full max-w-xs md:max-w-md mx-auto bg-emerald-500/5 rounded-[15px] md:rounded-[20px] animate-fade-in font-bold">
                        <i class="fas fa-check-circle mr-1 md:mr-2"></i> ¡Asistencia Confirmada!
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("Ocurrió un inconveniente al procesar tu RSVP.");
            }
            if (btnConfirmar) {
                btnConfirmar.disabled = false;
                btnConfirmar.classList.remove('opacity-70', 'cursor-not-allowed');
                btnConfirmar.innerHTML = txtOriginalConfirmar;
            }
        });
    }

    function alternarCamposMemorial() {
        const tipo = document.getElementById('tipoAporte').value;
        const grupoTexto = document.getElementById('grupoTexto');
        const grupoArchivo = document.getElementById('grupoArchivo');
        const contenidoTexto = document.getElementById('contenidoTexto');
        const archivoImagen = document.getElementById('archivoImagen');

        if (tipo === 'texto') {
            grupoTexto.classList.remove('hidden');
            grupoArchivo.classList.add('hidden');
            contenidoTexto.required = true;
            archivoImagen.required = false;
        } else {
            grupoTexto.classList.add('hidden');
            grupoArchivo.classList.remove('hidden');
            contenidoTexto.required = false;
            archivoImagen.required = true;
        }
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

    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('ring-2', 'ring-[#bc8567]', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-2', 'ring-[#bc8567]', 'ring-offset-2');
            overlay.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('opacity-100', 'opacity-0');
            check.classList.replace('scale-100', 'scale-0');
        }
        actualizarContador();
    }

    function actualizarContador() {
        const total = document.querySelectorAll('.foto-item.seleccionada').length;
        document.getElementById('contador-seleccionadas').innerText = `${total} seleccionadas`;
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
            alert("Por favor, selecciona al menos una memoria para descargar.");
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
            alert("La galería aún está vacía.");
            return;
        }
        todas.forEach((item, index) => {
            setTimeout(() => { forzarDescarga(item.dataset.url); }, index * 1000);
        });
    }
</script>

</body>
</html>