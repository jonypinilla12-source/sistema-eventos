<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>En Memoria de {{ $evento->nombre_evento }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;1,400;1,700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { font-family: 'Crimson Text', serif; background-color: #efefed; color: #3e4a3d; scroll-behavior: smooth; }
        .font-sans-body { font-family: 'Inter', sans-serif; }
        .bg-nature { background-color: #fdfdfb; border: 20px solid #e2e2da; }
        
        .animate-fade-in { animation: popIn 0.4s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.98); } to { opacity: 1; transform: scale(1); } }

        /* Ocultar scrollbar en elementos internos */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="p-4 md:p-12 flex flex-col items-center justify-center min-h-screen">

@php
    // 🔥 LÓGICA DE TIEMPO PARA BLOQUEO DE GALERÍA
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    
    // La galería se habilita 1 hora después del inicio oficial
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

    {{-- BLOQUE PRINCIPAL: HERO, BIOGRAFÍA Y DETALLES --}}
    <div class="bg-nature max-w-4xl w-full p-8 md:p-16 relative overflow-hidden shadow-xs mb-12">
        <div class="absolute top-0 right-0 p-10 opacity-[0.03] pointer-events-none">
            <i class="fa-solid fa-leaf text-[250px]"></i>
        </div>
        
        <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="text-xs uppercase tracking-[0.3em] opacity-60 block font-sans-body">En Memoria Del Alma</span>
                <h1 class="text-4xl md:text-5xl text-stone-800 leading-tight">{{ $evento->nombre_evento }}</h1>
                <p class="text-xs text-stone-400 font-mono tracking-widest -mt-4">
                    {{ \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('Y') }} — {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('Y') }}
                </p>
                <div class="w-12 h-px bg-stone-300"></div>
                <p class="text-lg italic leading-relaxed opacity-90 text-stone-600">
                    "Que los árboles canten tu nombre y el viento lleve tu historia."
                </p>
                <div class="text-sm space-y-3 border-t border-stone-200/80 pt-6 font-sans-body text-stone-600">
                    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('l d \d\e F, Y') }}</p>
                    <p><strong>Lugar:</strong> {{ $evento->ubicacion_texto }}</p>
                    <p><strong>Hora:</strong> {{ $evento->hora }}</p>
                </div>
            </div>
            
            {{-- ARREGLO FOTO HERO PRINCIPAL --}}
            <div class="shadow-xl border-4 border-white flex items-center justify-center bg-[#fdfdfb]">
                @if($evento->fotosGaleria->count() > 0)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="max-w-full md:max-w-sm h-auto max-h-[380px] object-contain grayscale transition duration-1000 hover:grayscale-0">
                @else
                    <div class="py-20 text-stone-300"><i class="fa-solid fa-dove text-6xl"></i></div>
                @endif
            </div>
        </div>
        
        <div class="mt-12 text-center italic opacity-80 border-t border-stone-100 pt-8 max-w-2xl mx-auto leading-relaxed text-base md:text-lg">
            "{{ $evento->biografia_resumen }}"
        </div>

        <div class="mt-8 pt-4 border-t border-stone-100 flex flex-wrap justify-center gap-4 md:gap-6 text-xs uppercase tracking-widest font-sans-body text-stone-400">
            <a href="#seccionMuroMensajes" class="hover:text-stone-800 underline transition">Ver libro de recuerdos</a>
            <span class="hidden md:inline">•</span>
            <a href="#seccionGaleriaVis" class="hover:text-stone-800 underline transition">Memoria Visual</a>
            <span class="hidden md:inline">•</span>
            <a href="#seccionLibroRecuerdos" class="hover:text-stone-800 underline transition">Escribir condolencia</a>
        </div>
    </div>

    {{-- SECCIÓN 2: EL MURO DE RECUERDOS PUBLICADOS (DEDICATORIAS APROBADAS) --}}
    <section id="seccionMuroMensajes" class="bg-nature max-w-4xl w-full p-8 md:p-16 relative overflow-hidden shadow-xs mb-12">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs uppercase tracking-[0.3em] text-stone-400 block font-sans-body"><i class="fa-solid fa-scroll mr-1"></i> Libro de Ofrendas</span>
            <h2 class="text-3xl text-stone-800">Pensamientos Compartidos</h2>
            <div class="w-12 h-px bg-stone-300 mx-auto my-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left w-full mt-12">
            @forelse($interaccionesAprobadas ?? [] as $item)
                <div class="bg-[#fcfbf9]/60 border border-stone-200/60 p-6 space-y-4 flex flex-col justify-between shadow-2xs">
                    <div class="space-y-4">
                        @if($item->url_onedrive)
                            <div class="w-full h-64 overflow-hidden bg-[#fdfdfb] border border-stone-200/60 flex items-center justify-center shadow-3xs">
                                @if(str_starts_with($item->url_onedrive, 'http'))
                                    {{-- CONVERSIÓN DE LINK DE VISUALIZACIÓN A IMAGEN DIRECTA --}}
                                    @php
                                        $directImgUrl = $item->url_onedrive;
                                        if (str_contains($directImgUrl, '1drv.ms')) {
                                            $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                        } elseif (str_contains($directImgUrl, 'sharepoint.com') && !str_contains($directImgUrl, 'download=1')) {
                                            $directImgUrl = $directImgUrl . (str_contains($directImgUrl, '?') ? '&' : '?') . 'download=1';
                                        }
                                    @endphp
                                    <img src="{{ $directImgUrl }}" class="max-w-full max-h-full object-contain grayscale hover:grayscale-0 hover:scale-[1.02] transition-all duration-500" onerror="this.style.display='none';">
                                @else
                                    <img src="{{ asset('storage/' . $item->url_onedrive) }}" class="max-w-full max-h-full object-contain grayscale hover:grayscale-0 hover:scale-[1.02] transition-all duration-500">
                                @endif
                            </div>
                        @endif
                        <p class="text-stone-600 italic leading-relaxed text-base">
                            "{{ $item->contenido_texto }}"
                        </p>
                    </div>

                    <div class="pt-3 border-t border-stone-200/40 flex justify-between items-center text-xs font-sans-body">
                        <div>
                            <span class="font-medium text-stone-800 block text-sm font-serif">{{ $item->nombre_autor }}</span>
                            <span class="text-stone-400 font-light text-[11px]">{{ $item->vinculo_autor ?? 'Allegado' }}</span>
                        </div>
                        <div class="text-[10px] text-stone-300 font-mono">
                            <i class="fa-regular fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 py-16 border-2 border-dashed border-stone-200 text-center text-stone-400 font-light space-y-3 w-full bg-[#fcfbf9]/30">
                    <i class="fa-regular fa-comment-dots text-2xl block text-stone-300"></i>
                    <p class="tracking-widest uppercase text-[11px] font-bold font-sans-body">El altar digital está abierto</p>
                    <p class="text-xs italic">Aún no hay mensajes aprobados. Deje sus palabras de apoyo abajo.</p>
                </div>
            @endforelse
        </div>

        <div class="pt-12 text-center">
            <a href="#seccionLibroRecuerdos" class="inline-block px-10 py-3 bg-[#3e4a3d] text-white text-xs font-semibold uppercase tracking-widest font-sans-body hover:bg-stone-800 transition shadow-xs">
                Dejar un mensaje
            </a>
        </div>
    </section>

    {{-- SECCIÓN 3: MEMORIA VISUAL UNIFICADA (CLOUD ONEDRIVE) --}}
    <section id="seccionGaleriaVis" class="bg-nature max-w-4xl w-full p-8 md:p-16 relative overflow-hidden shadow-xs mb-12">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs uppercase tracking-[0.3em] text-stone-400 block font-sans-body"><i class="fa-regular fa-images mr-1"></i> Evidencia Visual</span>
            <h2 class="text-3xl text-stone-800">Archivo Fotográfico</h2>
            <div class="w-12 h-px bg-stone-300 mx-auto my-4"></div>
        </div>

        {{-- LÓGICA DE BLOQUEO DE GALERÍA --}}
        @if($mostrarGaleria)
            <div class="w-full flex flex-col md:flex-row justify-between items-center mb-8 mt-10 bg-[#fcfbf9]/80 border border-stone-200/60 p-4 shadow-sm gap-4">
                <div class="text-center md:text-left">
                    <span id="contador-seleccionadas" class="font-serif italic text-lg text-stone-800">
                        0 Seleccionadas
                    </span>
                    <p class="text-[9px] text-stone-400 uppercase tracking-widest mt-1 font-sans-body">Haga clic en las imágenes para extraer</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto font-sans-body">
                    <button onclick="descargarSeleccionadas()" class="text-[9px] uppercase tracking-[0.2em] font-semibold border border-stone-300 text-stone-600 px-5 py-2 hover:bg-white transition w-full md:w-auto">
                        Bajar Selección
                    </button>
                    <button onclick="descargarTodas()" class="text-[9px] uppercase tracking-[0.2em] font-semibold bg-[#3e4a3d] text-white px-5 py-2 hover:bg-stone-800 transition shadow-sm w-full md:w-auto">
                        Bajar Todo
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
                            'etiqueta' => 'Aporte Familiar'
                        ]);
                    }
                }
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-h-[60vh] overflow-y-auto hide-scroll p-1 mt-6 animate-fade-in">
                @forelse($galeriaUnificada as $foto)
                    <div class="foto-item relative group cursor-pointer overflow-hidden bg-[#fdfdfb] shadow-sm border border-stone-200/60 p-1 transition-all duration-300 hover:shadow-md" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                        
                        @if($foto['esVideo'])
                            <button type="button" onclick="abrirReproductor(event, '{{ $foto['url'] }}')" class="absolute inset-0 flex items-center justify-center z-40 bg-stone-900/10 hover:bg-stone-900/20 transition">
                                <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center backdrop-blur-sm group-hover:scale-105 transition shadow-sm border border-stone-100">
                                    <i class="fas fa-play text-stone-800 text-xs ml-0.5"></i>
                                </div>
                            </button>
                            <video src="{{ $foto['url'] }}" class="vid-preview w-full h-32 md:h-48 object-cover grayscale transition duration-1000 group-hover:grayscale-0 opacity-90 group-hover:opacity-100" muted loop playsinline preload="metadata"></video>
                        @else
                            <img src="{{ $foto['url'] }}" class="w-full h-32 md:h-48 object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 opacity-90 group-hover:opacity-100">
                        @endif
                        
                        <div class="overlay absolute inset-0 bg-stone-900/5 opacity-0 transition duration-300 z-20 pointer-events-none"></div>
                        
                        <div class="check-icon absolute top-3 right-3 bg-[#3e4a3d] text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 scale-0 transition-all duration-300 shadow-sm z-30 pointer-events-none">
                            <i class="fas fa-check text-[8px]"></i>
                        </div>

                        <div class="absolute bottom-2 left-2 right-2 bg-white/95 backdrop-blur-sm border border-stone-200 text-stone-600 text-[7px] uppercase tracking-widest font-semibold py-1.5 px-2 text-center z-30 pointer-events-none font-sans-body">
                            @if($foto['esVideo'])
                                <i class="fas fa-video text-stone-400 mr-1"></i>
                            @else
                                <i class="fas {{ $foto['esNube'] ? 'fa-cloud' : 'fa-camera' }} text-stone-400 mr-1"></i>
                            @endif
                            {{ $foto['etiqueta'] }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center p-12 bg-[#fcfbf9]/40 border border-stone-200 border-dashed rounded-sm">
                        <i class="fa-regular fa-image text-2xl text-stone-300 mb-3"></i>
                        <p class="text-stone-400 font-sans-body text-xs tracking-widest uppercase">El repositorio visual se encuentra vacío.</p>
                    </div>
                @endforelse
            </div>
        @else
            {{-- ESTADO BLOQUEADO DE LA GALERÍA --}}
            <div class="w-full mt-10 bg-[#fcfbf9]/60 border border-stone-200/60 p-8 md:p-12 text-center shadow-2xs" id="locked-gallery-msg">
                <div class="w-14 h-14 bg-white border border-stone-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-lg text-stone-300"></i>
                </div>
                <h3 class="text-xl font-serif text-stone-700 mb-2">Contenido en Custodia</h3>
                <p class="text-stone-500 font-light text-sm leading-relaxed max-w-md mx-auto mb-6 italic">
                    Por respeto al transcurso de la ceremonia, el archivo fotográfico se habilitará <strong class="font-medium text-stone-700">1 hora después</strong> del inicio oficial.
                </p>
                <button onclick="window.location.reload()" class="px-6 py-2.5 border border-stone-300 text-[10px] uppercase tracking-widest text-stone-500 hover:bg-white transition shadow-3xs font-sans-body">
                    <i class="fas fa-sync-alt mr-1"></i> Refrescar Estado
                </button>
            </div>
        @endif
    </section>

    {{-- SECCIÓN 4: FORMULARIO DE RECUERDOS --}}
    <section id="seccionLibroRecuerdos" class="bg-nature max-w-4xl w-full p-8 md:p-16 relative overflow-hidden shadow-xs mb-12 mx-auto flex flex-col">
        
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs uppercase tracking-[0.3em] text-stone-400 block font-sans-body"><i class="fa-regular fa-envelope-open mr-1"></i> Su Espacio</span>
            <h2 class="text-3xl font-serif text-gray-700">Dejar una Ofrenda de Palabras</h2>
            <div class="w-10 h-[1px] bg-gray-300 mx-auto my-6"></div>
        </div>

        <div id="bloqueFormularioMensaje" class="text-left space-y-6 mt-10 max-w-2xl mx-auto bg-[#fcfbf9]/60 p-6 md:p-8 border border-stone-200">
            <form id="formRegistrarLamento" onsubmit="enviarMensajeLamento(event, '{{ $evento->evento_id }}')" class="space-y-6" enctype="multipart/form-data">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 font-sans-body">
                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-gray-500 mb-1 font-semibold">Clave de Acceso Asignada *</label>
                        <input type="text" id="inputCodigoValidar" required placeholder="Ej: JON-2897" class="w-full border border-gray-200 bg-white p-3 text-sm outline-none focus:border-gray-400 transition text-gray-800 font-mono tracking-widest uppercase rounded-xs">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-wider text-gray-500 mb-1 font-semibold">Su Vínculo / Relación *</label>
                        <select id="inputVinculoAutor" required class="w-full border border-gray-200 bg-white p-3 text-sm outline-none focus:border-gray-400 transition text-gray-600 font-light cursor-pointer rounded-xs">
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

                <div class="font-sans-body">
                    <label class="block text-[10px] uppercase tracking-wider text-gray-500 mb-1 font-semibold">Su Nombre Completo (Firma) *</label>
                    <input type="text" id="inputAutorMensaje" required placeholder="¿Cómo desea figurar en el libro?" class="w-full border border-gray-200 bg-white p-3 text-sm outline-none focus:border-gray-400 transition text-gray-800 font-light rounded-xs">
                </div>

                <div class="font-sans-body">
                    <label class="block text-[10px] uppercase tracking-wider text-gray-500 mb-1 font-semibold">Dedicatoria o Palabras de Aliento *</label>
                    <textarea id="inputContenidoMensaje" required rows="4" placeholder="Escriba aquí su mensaje de condolencias..." class="w-full border border-gray-200 bg-white p-3 text-sm outline-none focus:border-gray-400 transition text-gray-700 font-light leading-relaxed rounded-xs"></textarea>
                </div>

                <div class="font-sans-body">
                    <label class="block text-[10px] uppercase tracking-wider text-gray-500 mb-1 font-semibold">Adjuntar una Imagen / Video (Opcional)</label>
                    <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-stone-200 border-dashed bg-white transition hover:bg-stone-50/50 cursor-pointer relative" onclick="document.getElementById('inputArchivoFoto').click()">
                        <div class="space-y-1 text-center">
                            <i class="fa-regular fa-image text-2xl text-stone-300 mb-2 block"></i>
                            <div class="flex flex-col items-center text-xs text-stone-600">
                                <span class="relative font-medium text-stone-700 hover:text-stone-900 underline">
                                    Seleccionar archivo multimedia
                                </span>
                                <input id="inputArchivoFoto" name="archivo" type="file" accept="image/*,video/*" class="hidden">
                            </div>
                            <p class="text-[10px] text-stone-400 font-mono mt-1" id="txtNombreArchivo">Hasta 50MB permitidos.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" id="btnPublicarMuro" class="w-full bg-[#3e4a3d] text-white py-4 font-semibold text-xs uppercase tracking-widest font-sans-body hover:bg-stone-800 transition shadow-xs cursor-pointer">
                    Publicar en el Libro Digital
                </button>
            </form>
        </div>

        <div id="contenedorBotonAuxiliar" class="pt-8 pb-10 text-center font-sans-body">
            <p class="text-xs text-stone-400 mb-2 italic">¿No dispone de su clave de validación personal?</p>
            <button onclick="abrirModalAsistencia()" class="text-xs font-bold uppercase tracking-widest text-stone-500 hover:text-stone-800 transition underline cursor-pointer">
                [ Solicitar pase de acceso al libro ]
            </button>
        </div>

        {{-- 🔥 PUBLICIDAD SUTIL (WATERMARK) ESTILO NATURALEZA 🔥 --}}
        <div class="mt-auto w-full text-center pt-8 border-t border-stone-200/50 z-20">
            <a href="{{ url('/') }}" target="_blank" class="inline-flex flex-col items-center opacity-60 hover:opacity-100 transition-all duration-500 group cursor-pointer hover:-translate-y-1">
                <span class="text-[7.5px] md:text-[9px] uppercase tracking-[0.4em] text-stone-400 mb-1.5 font-sans-body font-semibold">Tecnología y Diseño por</span>
                <div class="flex items-center gap-1.5 transition-colors mt-1">
                    <i class="fas fa-leaf text-[10px] md:text-xs text-stone-400 group-hover:text-[#3e4a3d] transition-colors"></i>
                    <span class="font-serif italic text-sm md:text-base tracking-widest text-stone-500 group-hover:text-[#3e4a3d] transition-colors drop-shadow-sm">Eventify</span>
                </div>
            </a>
        </div>

    </section>
    
    {{-- MODAL ESTILO NATURALEZA PARA SOLICITAR CLAVE --}}
    <div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-stone-900/40 backdrop-blur-xs p-4">
        <div class="bg-[#fdfdfb] border-[10px] border-[#e2e2da] max-w-md w-full p-8 text-center shadow-2xl max-h-[90vh] overflow-y-auto animate-fade-in text-stone-700">
            <div id="cuerpoInternoModalAsistencia">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-xl font-serif text-stone-800">Libro de Recuerdos</h3>
                    <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-stone-800 transition"><i class="fas fa-times text-lg"></i></button>
                </div>
                <form id="formObtenerClave" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left font-sans-body">
                    <div class="bg-stone-50 p-5 border border-stone-200 space-y-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-wider text-stone-500 mb-1 font-medium">Nombre Completo *</label>
                            <input type="text" id="inputNombrePrincipal" required class="w-full border border-stone-200 bg-white p-3 text-sm outline-none focus:border-stone-400 text-gray-800">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-wider text-stone-500 mb-1 font-medium">Correo Electrónico *</label>
                            <input type="email" id="inputEmailPrincipal" required class="w-full border border-stone-200 bg-white p-3 text-sm outline-none focus:border-stone-400 text-gray-800" placeholder="ejemplo@correo.com">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#3e4a3d] text-white py-4 font-semibold text-xs uppercase tracking-widest hover:bg-stone-800 transition shadow-xs cursor-pointer">
                        Obtener Identificador
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL REPRODUCTOR DE VIDEO ZEN --}}
    <div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-stone-900/90 backdrop-blur-sm p-4" onclick="cerrarReproductor()">
        <button onclick="cerrarReproductor()" class="absolute top-4 right-4 md:top-8 md:right-8 text-stone-400 hover:text-white transition z-50 bg-stone-800 w-10 h-10 flex items-center justify-center rounded-full shadow-md">
            <i class="fas fa-times"></i>
        </button>
        <div class="w-full max-w-4xl bg-black rounded-sm overflow-hidden shadow-2xl border border-stone-600" onclick="event.stopPropagation()">
            <video id="videoPlayerS" controls class="w-full max-h-[80vh] bg-black"></video>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaEventoStr = "{{ $evento->fecha_principal }}T{{ $evento->hora ?? '18:00:00' }}";
        const countDate = new Date(fechaEventoStr).getTime();

        const checkGalleryUnlock = () => {
            const now = new Date().getTime();
            const gap = countDate - now;

            // Si ha pasado 1 hora (-3600000 ms)
            if (gap <= -3600000) {
                const lockedGallery = document.getElementById('locked-gallery-msg');
                if(lockedGallery) {
                    lockedGallery.innerHTML = `
                        <div class="w-14 h-14 bg-white border border-stone-200 rounded-full flex items-center justify-center mx-auto mb-4 transition duration-700 hover:scale-105">
                            <i class="fas fa-unlock-alt text-lg text-stone-600"></i>
                        </div>
                        <h3 class="text-xl font-serif text-stone-700 mb-2">Archivo Desbloqueado</h3>
                        <p class="text-stone-500 font-light text-sm leading-relaxed max-w-md mx-auto mb-6 italic">
                            El tiempo de respeto ha concluido. El material visual y memorias del evento ya se encuentran disponibles.
                        </p>
                        <button onclick="window.location.reload()" class="px-6 py-2.5 bg-[#3e4a3d] text-white text-[10px] uppercase tracking-widest hover:bg-stone-800 transition shadow-3xs font-sans-body">
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
                    <div class="py-4 text-center space-y-6 animate-fade-in font-sans-body">
                        <div class="w-12 h-12 bg-stone-50 rounded-full flex items-center justify-center mx-auto border border-stone-200"><i class="fas fa-feather-alt text-sm text-stone-500"></i></div>
                        <div class="space-y-1">
                            <h3 class="text-xl font-serif text-stone-800">Firma Registrada</h3>
                            <p class="text-xs text-stone-400 px-2">Su clave de acceso ha sido asignada con éxito.</p>
                        </div>
                        <div class="bg-stone-50 border border-stone-200 p-6 text-left space-y-3">
                            <p class="text-[10px] uppercase font-bold tracking-wider text-stone-400 border-b pb-2"><i class="fas fa-key mr-1"></i> Clave de validación</p>
                            <div class="text-xs flex justify-between items-center">
                                <span class="text-stone-600 font-medium font-serif">${data.codigos[0].nombre}:</span>
                                <span class="bg-stone-800 px-3 py-1 text-[11px] font-bold text-white font-mono tracking-widest">${data.codigos[0].codigo}</span>
                            </div>
                        </div>
                        <button onclick="cerrarModalAsistencia(); window.location.hash = 'seccionLibroRecuerdos';" class="w-full bg-[#3e4a3d] text-white py-3 text-xs font-semibold uppercase tracking-widest hover:bg-stone-800 transition rounded-xs">Copiar Clave y Redactar</button>
                    </div>
                `;
            }
        });
    }

    document.getElementById('inputArchivoFoto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('txtNombreArchivo').innerText = `Archivo listo: ${file.name}`;
            document.getElementById('txtNombreArchivo').classList.add('text-stone-800', 'font-medium');
        }
    });

    function enviarMensajeLamento(event, eventoId) {
        event.preventDefault();

        const botonPublicar = document.getElementById('btnPublicarMuro');
        botonPublicar.disabled = true;
        botonPublicar.classList.remove('bg-[#3e4a3d]', 'hover:bg-stone-800');
        botonPublicar.classList.add('bg-stone-400', 'cursor-not-allowed');
        botonPublicar.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Elevando recuerdo a la nube...`;

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
                botonPublicar.classList.remove('bg-stone-400', 'cursor-not-allowed');
                botonPublicar.classList.add('bg-[#3e4a3d]', 'hover:bg-stone-800');
                botonPublicar.innerHTML = "Publicar en el Libro Digital";
                throw new Error("Fallo de validación.");
            }
            return data;
        })
        .then(data => {
            if (data.success) {
                const cajaFormulario = document.getElementById('bloqueFormularioMensaje');
                cajaFormulario.innerHTML = `
                    <div class="py-8 text-center space-y-4 animate-fade-in font-light font-sans-body">
                        <div class="w-12 h-12 border border-stone-300 rounded-full flex items-center justify-center mx-auto text-stone-400">
                            <i class="fa-regular fa-heart"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-xl font-serif text-stone-800">Homenaje Guardado</h3>
                            <p class="text-sm text-stone-500 max-w-sm mx-auto leading-relaxed italic">${data.message}</p>
                        </div>
                        <p class="text-[10px] text-stone-400 pt-4 tracking-widest uppercase font-semibold">Agradecemos profundamente su compañía espiritual.</p>
                    </div>
                `;
                
                setTimeout(() => { window.location.reload(); }, 2000);
            }
        })
        .catch(error => console.error("Error:", error));
    }

    // --- SISTEMA MULTIMEDIA ZEN ---
    function toggleSeleccion(elemento) {
        elemento.classList.toggle('seleccionada');
        const overlay = elemento.querySelector('.overlay');
        const check = elemento.querySelector('.check-icon');

        if (elemento.classList.contains('seleccionada')) {
            elemento.classList.add('ring-1', 'ring-[#3e4a3d]', 'ring-offset-2');
            overlay.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('opacity-0', 'opacity-100');
            check.classList.replace('scale-0', 'scale-100');
        } else {
            elemento.classList.remove('ring-1', 'ring-[#3e4a3d]', 'ring-offset-2');
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
            alert("Por favor, seleccione al menos un archivo para descargar.");
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