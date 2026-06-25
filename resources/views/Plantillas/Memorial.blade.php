<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>En Memoria de {{ $evento->nombre_evento }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fcfcfc; color: #4a4a4a; scroll-behavior: smooth; overflow-x: hidden; }
        h1, h2, h3, h4, .font-zen { font-family: 'Libre Baskerville', serif; }
        .full-screen { min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 60px 20px; scroll-snap-align: start; }
        
        /* 🔥 CAMBIO AQUÍ: Cambiamos 'mandatory' a 'proximity' para que el scroll sea más amable y no te salte las secciones largas */
        .snap-container { width: 100%; overflow-x: hidden; height: 100vh; overflow-y: scroll; scroll-snap-type: y proximity; }
        
        .soft-shadow { box-shadow: 0 10px 30px rgba(0,0,0,0.02); }

        .animate-fade-in { animation: fadeInDoc 0.4s ease-out forwards; }
        @keyframes fadeInDoc { from { opacity: 0; transform: scale(0.98); } to { opacity: 1; transform: scale(1); } }
        
        /* Ocultar scrollbar en elementos internos */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
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
    
    {{-- SECCIÓN 1: HERO --}}
    <section class="full-screen">
        <div class="mb-8 opacity-60 italic text-sm tracking-widest uppercase">En memoria de</div>
        <h1 class="text-4xl md:text-6xl text-gray-800 mb-4">{{ $evento->nombre_evento }}</h1>
        <p class="text-gray-400 mb-10 tracking-widest italic">
            {{ \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('Y') }} — {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('Y') }}
        </p>
        <div class="w-64 h-80 rounded-t-full overflow-hidden border-8 border-white soft-shadow mb-10 relative">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover grayscale transition duration-1000 hover:grayscale-0">
            @else
                <div class="w-full h-full bg-stone-100 flex flex-col justify-center items-center">
                    <i class="fa-solid fa-dove text-4xl text-stone-300"></i>
                </div>
            @endif
        </div>
        <p class="max-w-md text-gray-500 font-light leading-relaxed italic">"Su luz seguirá brillando en nuestros corazones."</p>
    </section>

    {{-- SECCIÓN 2: BIOGRAFÍA & ANCLAJES RÁPIDOS --}}
    <section class="full-screen bg-white border-t border-stone-50">
        <h2 class="text-3xl mb-8 font-zen">Servicio Memorial</h2>
        <div class="p-8 border-l border-gray-100 space-y-6 text-left max-w-lg mb-10">
            <p class="text-xl text-gray-600 font-light leading-relaxed">{{ $evento->biografia_resumen }}</p>
            <div class="pt-6 border-t border-gray-50 italic text-gray-400">
                Lugar: {{ $evento->ubicacion_texto }}
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-4 md:gap-6 text-xs text-stone-400 underline tracking-widest uppercase mt-4">
            <a href="#seccionMuroMensajes" class="hover:text-stone-800 transition">Libro de recuerdos</a>
            <span class="hidden md:inline">•</span>
            <a href="#seccionGaleriaVis" class="hover:text-stone-800 transition">Memoria Visual</a>
            <span class="hidden md:inline">•</span>
            <a href="#seccionLibroRecuerdos" class="hover:text-stone-800 transition">Escribir condolencia</a>
        </div>
    </section>

    {{-- SECCIÓN 3: EL MURO DE RECUERDOS PUBLICADOS --}}
    {{-- 🔥 CAMBIO AQUÍ: Agregamos "snap-start" a las clases --}}
    <section id="seccionMuroMensajes" class="w-full bg-stone-50/40 border-t border-stone-100 py-24 px-6 flex flex-col items-center min-h-screen snap-start">
        <div class="max-w-5xl w-full text-center space-y-6">
            <span class="text-xs uppercase tracking-[0.4em] text-stone-400 block"><i class="fa-solid fa-scroll mr-1"></i> Memorias Compartidas</span>
            <h2 class="text-3xl md:text-5xl font-light text-stone-800 font-zen">Libro de Condolencias Abierto</h2>
            <div class="w-16 h-px bg-stone-300 mx-auto mt-6 mb-16"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left w-full">
                @forelse($interaccionesAprobadas ?? [] as $item)
                    <div class="bg-white border border-stone-200/80 p-8 space-y-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 shadow-xs">
                        <div class="space-y-4">
                            @if($item->url_onedrive)
                                <div class="w-full h-52 overflow-hidden bg-stone-100 border border-stone-200 shadow-xs mb-4">
                                    @if(str_starts_with($item->url_onedrive, 'http'))
                                        @php
                                            $directImgUrl = $item->url_onedrive;
                                            if (str_contains($directImgUrl, '1drv.ms')) {
                                                $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                            } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                                $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                            }
                                        @endphp
                                        <img src="{{ $directImgUrl }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500" onerror="this.style.display='none';">
                                    @else
                                        <img src="{{ asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                                    @endif
                                </div>
                            @endif
                            <p class="text-stone-600 font-light leading-relaxed italic text-base">
                                "{{ $item->contenido_texto }}"
                            </p>
                        </div>

                        <div class="pt-4 border-t border-stone-100 flex justify-between items-center text-xs">
                            <div>
                                <span class="font-medium text-stone-800 block text-sm font-zen">{{ $item->nombre_autor }}</span>
                                <span class="text-stone-400 font-light">{{ $item->vinculo_autor ?? 'Allegado' }}</span>
                            </div>
                            <div class="text-[10px] text-stone-300 font-mono">
                                <i class="fa-regular fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 py-16 border-2 border-dashed border-stone-200 text-center text-stone-400 font-light space-y-3 w-full bg-white">
                        <i class="fa-regular fa-comment-dots text-3xl block text-stone-300"></i>
                        <p class="tracking-wider uppercase text-[11px] font-semibold">El libro digital está abierto</p>
                        <p class="text-xs italic">Aún no se han publicado mensajes. Sea el primero en plasmar sus palabras de consuelo.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3.5: REGISTRO VISUAL UNIFICADO (CLOUD ONEDRIVE) --}}
    {{-- 🔥 CAMBIO AQUÍ: Agregamos "snap-start" a las clases --}}
    <section id="seccionGaleriaVis" class="w-full bg-white py-24 px-6 flex flex-col items-center min-h-screen relative snap-start">
        <div class="max-w-6xl w-full text-center space-y-6 z-10">
            <span class="text-xs uppercase tracking-[0.4em] text-stone-400 block"><i class="fa-regular fa-images mr-1"></i> Memoria Visual</span>
            <h2 class="text-3xl md:text-5xl font-light text-stone-800 font-zen">Archivo Fotográfico</h2>
            <div class="w-16 h-px bg-stone-300 mx-auto mt-6 mb-12"></div>

            {{-- LÓGICA DE BLOQUEO DE GALERÍA DE 1 HORA --}}
            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-10 bg-stone-50/50 border border-stone-200 p-4 md:p-6 shadow-sm gap-4 animate-fade-in rounded-sm">
                    <div class="text-center md:text-left">
                        <span id="contador-seleccionadas" class="font-zen text-lg md:text-xl text-stone-800 tracking-widest">
                            0 Seleccionadas
                        </span>
                        <p class="text-[8px] md:text-[9px] text-stone-400 uppercase tracking-widest mt-1">Haga clic en las imágenes para extraer</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button onclick="descargarSeleccionadas()" class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] md:tracking-[0.3em] font-bold border border-stone-800 text-stone-800 px-6 py-3 hover:bg-stone-800 hover:text-white transition w-full md:w-auto">
                            Descargar Selección
                        </button>
                        <button onclick="descargarTodas()" class="text-[9px] md:text-[10px] uppercase tracking-[0.2em] md:tracking-[0.3em] font-bold bg-stone-800 text-white px-6 py-3 hover:bg-stone-900 transition shadow-sm w-full md:w-auto">
                            Descargar Todo
                        </button>
                    </div>
                </div>

                @php
                    $galeriaUnificada = collect();

                    // 1. Fotos Locales Físicas
                    if(isset($evento->fotosGaleria)) {
                        foreach($evento->fotosGaleria as $foto) {
                            if(!str_starts_with($foto->url_recurso, 'http')) {
                                $ext = strtolower(pathinfo($foto->url_recurso, PATHINFO_EXTENSION));
                                $esVideoLocal = in_array($ext, ['mp4', 'mov', 'avi', 'webm']);

                                $galeriaUnificada->push([
                                    'url' => asset('storage/' . $foto->url_recurso),
                                    'esNube' => false,
                                    'esVideo' => $esVideoLocal,
                                    'etiqueta' => 'Archivo Interno'
                                ]);
                            }
                        }
                    }

                    // 2. Fotos de OneDrive en tiempo real
                    if(isset($fotosNubeRealtime)) {
                        foreach($fotosNubeRealtime as $fotoCloud) {
                            $galeriaUnificada->push([
                                'url' => $fotoCloud['url'],
                                'esNube' => true,
                                'esVideo' => $fotoCloud['esVideo'] ?? false,
                                'etiqueta' => 'Nube Compartida'
                            ]);
                        }
                    }
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6 w-full max-h-[65vh] overflow-y-auto hide-scroll p-1 md:p-2 animate-fade-in">
                    @forelse($galeriaUnificada as $foto)
                        <div class="foto-item relative group cursor-pointer overflow-hidden bg-[#fcfcfc] shadow-sm border border-stone-200 transition-all duration-500 hover:shadow-md" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            
                            @if($foto['esVideo'])
                                <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-stone-900/10 hover:bg-stone-900/20 transition">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-105 transition shadow-sm border border-stone-100">
                                        <i class="fas fa-play text-stone-800 text-xs md:text-sm ml-0.5"></i>
                                    </div>
                                </button>
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-40 md:h-56 object-cover grayscale transition duration-1000 group-hover:grayscale-0 opacity-90 group-hover:opacity-100" muted loop playsinline preload="metadata"></video>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-40 md:h-56 object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                            @endif
                            
                            <div class="overlay absolute inset-0 bg-stone-900/5 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                            
                            <div class="check-icon absolute top-3 right-3 bg-stone-800 text-white rounded-full w-5 h-5 md:w-6 md:h-6 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-sm z-30 pointer-events-none">
                                <i class="fas fa-check text-[8px] md:text-[10px]"></i>
                            </div>

                            <div class="absolute bottom-3 left-3 right-3 bg-white/95 backdrop-blur-sm text-stone-800 text-[7px] md:text-[8px] uppercase tracking-[0.2em] font-bold py-1.5 md:py-2 px-2 text-center z-30 pointer-events-none border border-stone-200/50">
                                @if($foto['esVideo'])
                                    <i class="fas fa-video text-stone-400 mr-1"></i>
                                @else
                                    <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} text-stone-400 mr-1"></i>
                                @endif
                                {{ $foto['etiqueta'] }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center p-12 bg-stone-50 border border-stone-200 rounded-sm">
                            <i class="fa-regular fa-image text-2xl md:text-3xl text-stone-300 mb-3 md:mb-4"></i>
                            <p class="text-stone-500 font-light text-xs md:text-sm tracking-widest uppercase">Repositorio visual vacío.</p>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
                <div class="w-full max-w-2xl bg-white border border-stone-200 p-8 md:p-16 text-center shadow-sm mx-auto" id="locked-gallery-msg">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-stone-50 border border-stone-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-xl md:text-2xl text-stone-300"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-light text-stone-800 mb-3 uppercase tracking-widest font-zen">Contenido en Custodia</h3>
                    <p class="text-stone-500 font-light text-xs md:text-sm leading-relaxed max-w-md mx-auto mb-6 italic">
                        Por respeto al transcurso de la ceremonia, el archivo fotográfico se habilitará automáticamente <strong class="font-semibold text-stone-700">1 hora después</strong> del inicio oficial.
                    </p>
                    <button onclick="window.location.reload()" class="px-6 py-3 border border-stone-300 text-[9px] md:text-[10px] uppercase tracking-widest text-stone-500 hover:bg-stone-50 transition shadow-sm">
                        <i class="fas fa-sync-alt mr-2"></i> Refrescar Estado
                    </button>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: FORMULARIO DE RECUERDOS --}}
    <section id="seccionLibroRecuerdos" class="full-screen bg-stone-50 border-t border-stone-100 relative">
        
        {{-- CONTENIDO PRINCIPAL CENTRADO --}}
        <div class="max-w-xl w-full px-6 text-center space-y-4 my-auto pb-16">
            <span class="text-xs uppercase tracking-[0.4em] text-stone-400 block"><i class="fa-regular fa-envelope-open mr-1"></i> Espacio del Recuerdo</span>
            <h2 class="text-3xl md:text-4xl text-gray-800 font-light font-zen">Dejar un Mensaje de Aliento</h2>
            <div class="w-12 h-px bg-stone-300 mx-auto my-6"></div>
            
            <div id="bloqueFormularioMensaje" class="bg-white p-8 border border-stone-200 text-left space-y-6 shadow-sm w-full mb-8">
                <form id="formRegistrarLamento" onsubmit="enviarMensajeLamento(event, '{{ $evento->evento_id }}')" class="space-y-6" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Clave de Acceso Asignada *</label>
                            <input type="text" id="inputCodigoValidar" required placeholder="Ej: JON-2897" class="w-full border border-stone-200 bg-stone-50 p-3 text-sm outline-none focus:border-stone-500 transition text-gray-800 font-mono tracking-widest uppercase">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Su Vínculo / Relación *</label>
                            <select id="inputVinculoAutor" required class="w-full border border-stone-200 bg-stone-50 p-3 text-sm outline-none focus:border-stone-500 transition text-gray-700 font-light cursor-pointer">
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
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Su Nombre Completo (Firma) *</label>
                        <input type="text" id="inputAutorMensaje" required placeholder="¿Cómo desea aparecer en el libro?" class="w-full border border-stone-200 bg-stone-50 p-3 text-sm outline-none focus:border-stone-500 transition text-gray-800 font-light">
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Mensaje de Condolencia o Anécdota *</label>
                        <textarea id="inputContenidoMensaje" required rows="4" placeholder="Escriba aquí sus palabras de consuelo o memorias..." class="w-full border border-stone-200 bg-stone-50 p-3 rounded-none text-sm outline-none focus:border-gray-500 transition text-gray-700 font-light leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Adjuntar una Fotografía de Recuerdo (Opcional)</label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-stone-200 border-dashed bg-white transition hover:bg-stone-50/30">
                            <div class="space-y-1 text-center">
                                <i class="fa-regular fa-image text-2xl text-stone-400 mb-2 block"></i>
                                <div class="flex flex-col items-center text-xs text-stone-600">
                                    <label for="inputArchivoFoto" class="relative font-medium text-stone-700 hover:text-stone-900 cursor-pointer underline">
                                        <span>Seleccionar archivo</span>
                                        <input id="inputArchivoFoto" name="archivo" type="file" accept="image/*" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-[10px] text-stone-400 font-mono mt-2" id="txtNombreArchivo">JPG, PNG hasta 10MB</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="btnPublicarMuro" class="w-full bg-stone-800 text-white py-4 font-semibold text-xs uppercase tracking-widest hover:bg-stone-900 shadow-sm transition-all duration-300 block text-center rounded-none cursor-pointer">
                        Publicar en el Libro Digital
                    </button>
                </form>
            </div>

            <div id="contenedorBotonAuxiliar" class="pt-4 text-center">
                <p class="text-xs text-stone-400 mb-3 font-light">¿Aún no dispone de sus credenciales personales?</p>
                <button onclick="abrirModalAsistencia()" class="text-xs font-bold uppercase tracking-widest text-stone-600 hover:text-stone-900 transition underline cursor-pointer">
                    [ Solicitar clave de acceso al libro ]
                </button>
            </div>
        </div>

        {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ESTILO MEMORIAL 🔥 --}}
        <div class="absolute bottom-6 md:bottom-8 w-full text-center z-20 pointer-events-none">
            <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-500 group cursor-pointer hover:-translate-y-1 pointer-events-auto">
                <span class="text-[7px] md:text-[8px] uppercase tracking-[0.4em] text-stone-400 mb-1 font-light">Tecnología y Diseño por</span>
                <div class="flex items-center gap-1.5 transition-colors mt-1">
                    <i class="fas fa-dove text-[10px] md:text-xs text-stone-400 group-hover:text-stone-600 transition-colors"></i>
                    <span class="font-zen italic text-sm md:text-base tracking-widest text-stone-500 group-hover:text-stone-800 transition-colors drop-shadow-sm">Eventify</span>
                </div>
            </a>
        </div>
    </section>

</div>

{{-- MODAL REPRODUCTOR DE VIDEO ZEN --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-stone-900/90 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-stone-400 hover:text-white transition z-50 bg-stone-800 w-10 h-10 flex items-center justify-center rounded-full">
        <i class="fas fa-times"></i>
    </button>
    <div class="w-full max-w-4xl bg-black rounded-sm overflow-hidden shadow-2xl border border-stone-700" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
    </div>
</div>

{{-- MODAL PÚBLICO PARA SOLICITAR CLAVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-stone-900/40 backdrop-blur-xs p-4">
    <div class="bg-[#fdfdfd] text-gray-700 rounded-none max-w-md w-full p-8 text-center shadow-2xl border border-gray-200 max-h-[90vh] overflow-y-auto animate-fade-in">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h3 class="text-lg uppercase tracking-widest font-light text-gray-800">Libro de Dedicatorias</h3>
                <button onclick="cerrarModalAsistencia()" class="text-gray-400 hover:text-gray-800 transition"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form id="formObtenerClave" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <div class="bg-stone-50/60 p-5 border border-stone-200/60 space-y-4">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Nombre Completo *</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-stone-200 bg-white p-3 text-sm outline-none focus:border-gray-500 text-gray-800">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Correo Electrónico *</label>
                        <input type="email" id="inputEmailPrincipal" required class="w-full border border-stone-200 bg-white p-3 text-sm outline-none focus:border-gray-500 text-gray-800" placeholder="ejemplo@correo.com">
                    </div>
                </div>
                <button type="submit" class="w-full bg-stone-800 text-white py-4 font-semibold text-xs uppercase tracking-widest hover:bg-stone-900 shadow-sm transition-all mt-4 block text-center rounded-none cursor-pointer">
                    Obtener Pase de Acceso
                </button>
            </form>
        </div>
    </div>
</div>

<script>
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
                        <div class="w-12 h-12 bg-stone-100 rounded-full flex items-center justify-center mx-auto border border-stone-200"><i class="fas fa-feather-alt text-sm text-stone-600"></i></div>
                        <div class="space-y-2">
                            <h3 class="text-xl uppercase tracking-[0.15em] text-stone-800 font-light">Registro Completado</h3>
                            <p class="text-xs text-stone-500 font-light px-2">Su pase único ha sido localizado o generado.</p>
                        </div>
                        <div class="bg-[#fbfbf9] border border-stone-200 p-6 text-left space-y-4 shadow-inner">
                            <p class="text-[9px] uppercase font-bold tracking-[0.2em] text-stone-400 border-b border-stone-200 pb-2"><i class="fas fa-key mr-1"></i> Copie esta clave</p>
                            <div class="text-xs flex justify-between items-center">
                                <span class="text-stone-600">${data.codigos[0].nombre}:</span>
                                <span class="bg-stone-800 px-3 py-1 text-[11px] font-bold text-white font-mono tracking-widest">${data.codigos[0].codigo}</span>
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia(); window.location.hash = 'seccionLibroRecuerdos';" class="w-full bg-stone-800 text-white py-3 text-xs font-semibold uppercase tracking-widest hover:bg-stone-900 transition shadow-sm rounded-none">Copiar e Ir al Libro</button>
                    </div>
                `;
            }
        });
    }

    document.getElementById('inputArchivoFoto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('txtNombreArchivo').innerText = `Seleccionado: ${file.name}`;
        }
    });

    function enviarMensajeLamento(event, eventoId) {
        event.preventDefault();

        // --- CONTROL DE CARGA Y PREVENCIÓN DE DOBLE CLIC ---
        const botonPublicar = document.getElementById('btnPublicarMuro');
        
        // Bloqueamos el botón y cambiamos estilos visuales para que se note deshabilitado
        botonPublicar.disabled = true;
        botonPublicar.classList.remove('bg-stone-800', 'hover:bg-stone-900');
        botonPublicar.classList.add('bg-stone-400', 'cursor-not-allowed');
        
        // Colocamos el texto de carga junto con un icono animado de FontAwesome
        botonPublicar.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Guardando memorias en OneDrive...`;

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
            headers: {
                'X-CSRF-TOKEN': tokenCsrf,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                alert(data.message || "Error al verificar los datos.");
                
                // Si la validación del Backend falla (ej: clave incorrecta), reactivamos el botón
                botonPublicar.disabled = false;
                botonPublicar.classList.remove('bg-stone-400', 'cursor-not-allowed');
                botonPublicar.classList.add('bg-stone-800', 'hover:bg-stone-900');
                botonPublicar.innerHTML = "Publicar en el Libro Digital";

                throw new Error("Fallo controlado en el backend.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const cajaFormulario = document.getElementById('bloqueFormularioMensaje');
                
                // Transición limpia hacia el estado final de éxito y agradecimientos
                cajaFormulario.innerHTML = `
                    <div class="py-8 text-center space-y-6 animate-fade-in font-light">
                        <div class="w-12 h-12 border border-stone-300 rounded-full flex items-center justify-center mx-auto text-stone-400">
                            <i class="fa-regular fa-heart"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-serif text-stone-800">Pensamiento Registrado</h3>
                            <p class="text-sm text-stone-500 max-w-sm mx-auto leading-relaxed italic">${data.message}</p>
                        </div>
                        <p class="text-[11px] text-stone-400 pt-4 tracking-wider uppercase">Gracias por acompañar a la familia en este momento.</p>
                    </div>
                `;
                
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        })
        .catch(error => {
            console.error("Detalle del flujo:", error);
        });
    }

    // --- SISTEMA MULTIMEDIA ZEN ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('ring-1', 'ring-stone-800', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-1', 'ring-stone-800', 'ring-offset-2');
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