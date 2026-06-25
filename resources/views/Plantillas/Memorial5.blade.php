<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>In Memoriam | {{ $evento->nombre_evento }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --noir-bg: #0f0f0f;      /* Negro casi puro */
            --noir-card: #1a1a1a;    /* Gris carbón */
            --noir-accent: #d1d5db;  /* Platino / Oro blanco */
            --noir-text: #f8fafc;    /* Blanco fantasma */
        }

        body { 
            font-family: 'Montserrat', sans-serif; 
            background-color: var(--noir-bg); 
            color: var(--noir-text); 
            scroll-behavior: smooth; 
            overflow-x: hidden;
        }

        h1, h2, h3, .font-bodoni { font-family: 'Bodoni Moda', serif; }
        
        .snap-container { 
            width: 100%; 
            height: 100svh; 
            overflow-y: scroll; 
            scroll-snap-type: y proximity; 
        }
        
        .section-noir { 
            min-height: 100svh; 
            width: 100%; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            position: relative; 
            scroll-snap-align: start; 
            padding: 4rem 1.5rem; 
        }

        /* TEXTURA DE GRANO FOTOGRÁFICO */
        .section-noir::before {
            content: "";
            position: absolute; inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/carbon-fibre.png");
            opacity: 0.05;
            pointer-events: none;
        }

        /* LÍNEAS DE DISEÑO ASIMÉTRICO */
        .design-line {
            position: absolute;
            background: var(--noir-accent);
            opacity: 0.2;
        }

        .glass-noir {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* BOTONES ESTILO GALERÍA */
        .btn-noir {
            background: transparent;
            color: white;
            border: 1px solid white;
            padding: 14px 40px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 5px;
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            border-radius: 0;
            display: inline-block;
            cursor: pointer;
        }
        .btn-noir:hover {
            background: white;
            color: black;
            padding: 14px 50px;
        }
        .btn-noir:disabled { opacity: 0.3; cursor: not-allowed; }

        .photo-reveal {
            box-shadow: 0 30px 60px rgba(0,0,0,0.8);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .animate-up { animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        .hide-scroll::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>

@php
    $fechaHoraEventoStr = $evento->fecha_principal . ' ' . ($evento->hora ?? '18:00:00');
    $fechaHoraEvento = \Carbon\Carbon::parse($fechaHoraEventoStr);
    $mostrarGaleria = \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($fechaHoraEventoStr)->addHour());
@endphp

<div class="snap-container">
    
    {{-- SECCIÓN 1: EL RETRATO (HERO ASIMÉTRICO) --}}
    <section class="section-noir">
        <div class="design-line w-px h-64 top-0 left-[10%]"></div>
        <div class="design-line h-px w-64 top-[20%] left-0"></div>

        <div class="max-w-7xl w-full mx-auto grid grid-cols-1 md:grid-cols-12 gap-8 items-center relative z-10">
            
            <div class="md:col-span-7 md:col-start-1 text-center md:text-left order-2 md:order-1 animate-up">
                <span class="text-[10px] uppercase tracking-[0.6em] text-white/40 block mb-6">Un Legado Eterno</span>
                <h1 class="text-6xl sm:text-7xl lg:text-[110px] leading-[0.85] font-bodoni italic mb-8">
                    {{ $evento->nombre_evento }}
                </h1>
                <p class="text-lg md:text-2xl font-light text-white/60 tracking-widest lowercase mb-12">
                    {{ \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('Y') }} — {{ \Carbon\Carbon::parse($evento->fecha_principal)->format('Y') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center md:justify-start items-center">
                    <a href="#seccionLibroRecuerdos" class="btn-noir">Firmar Libro</a>
                    <a href="#seccionGaleriaVis" class="text-[10px] uppercase tracking-widest border-b border-white/20 pb-1 hover:border-white transition">Explorar Galería</a>
                </div>
            </div>

            <div class="md:col-span-5 md:col-start-8 order-1 md:order-2 flex justify-center animate-up" style="animation-delay: 0.3s">
                <div class="relative w-full max-w-[350px] aspect-[4/5] photo-reveal overflow-hidden bg-zinc-900">
                    @if($evento->fotosGaleria->count() > 0)
                        <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" class="w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition duration-1000">
                    @endif
                </div>
            </div>

        </div>
    </section>

    {{-- SECCIÓN 2: LA BIOGRAFÍA (MODERN GALLERY) --}}
    <section class="section-noir bg-[#0a0a0a]">
        <div class="max-w-4xl w-full mx-auto text-center px-6">
            <h2 class="text-4xl md:text-6xl font-bodoni mb-12 text-white/90 italic animate-up">El Relato</h2>
            <div class="w-20 h-px bg-white/20 mx-auto mb-12"></div>
            
            <p class="text-xl md:text-3xl font-light leading-relaxed text-white/70 italic font-serif animate-up px-4">
                "{{ $evento->biografia_resumen }}"
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20 text-[10px] uppercase tracking-[0.4em] text-white/30 font-semibold animate-up">
                <div class="space-y-2">
                    <p class="text-white/60">Encuentro</p>
                    <p>{{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-white/60">Hora</p>
                    <p>{{ $evento->hora }} hrs</p>
                </div>
                <div class="space-y-2">
                    <p class="text-white/60">Ubicación</p>
                    <p>{{ $evento->ubicacion_texto }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: LIBRO DE CONDOLENCIAS (GRID NOIR) --}}
    <section id="seccionMuroMensajes" class="w-full bg-[#0f0f0f] py-32 px-6 flex flex-col items-center min-h-screen snap-start relative">
        <div class="max-w-6xl w-full text-center mb-20 animate-up">
            <h2 class="text-5xl md:text-7xl font-bodoni italic text-white mb-4">Pensamientos</h2>
            <p class="text-[10px] uppercase tracking-[0.5em] text-white/30">Homenajes de la comunidad</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-px bg-white/10 w-full max-w-7xl border border-white/10">
            @forelse($interaccionesAprobadas ?? [] as $item)
                <div class="bg-[#0f0f0f] p-10 flex flex-col justify-between hover:bg-[#151515] transition duration-500 min-h-[400px]">
                    <div class="space-y-6">
                        @if($item->url_onedrive)
                            <div class="aspect-square w-full grayscale opacity-60 hover:opacity-100 transition duration-700 overflow-hidden">
                                @php
                                    $directImgUrl = $item->url_onedrive;
                                    if (str_contains($directImgUrl, '1drv.ms')) {
                                        $directImgUrl = str_replace('1drv.ms/i/s!', 'api.onedrive.com/v1.0/shares/u!', $directImgUrl) . '/root/content';
                                    }
                                @endphp
                                <img src="{{ str_contains($item->url_onedrive, 'http') ? $directImgUrl : asset('storage/' . $item->url_onedrive) }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <p class="text-lg font-light leading-relaxed text-white/80 italic">"{{ $item->contenido_texto }}"</p>
                    </div>
                    <div class="mt-10 pt-6 border-t border-white/5">
                        <p class="text-[10px] uppercase tracking-[0.3em] text-white font-bold mb-1">{{ $item->nombre_autor }}</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/30">{{ $item->vinculo_autor ?? 'Allegado' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center text-white/20 italic tracking-widest text-xl bg-[#0f0f0f]">
                    Aún no se han registrado memorias.
                </div>
            @endforelse
        </div>
    </section>

    {{-- SECCIÓN 4: GALERÍA (MUSEUM STYLE) --}}
    <section id="seccionGaleriaVis" class="section-noir bg-black !h-auto py-32">
        <div class="max-w-7xl w-full mx-auto px-4 text-center">
            <h2 class="text-5xl md:text-8xl font-bodoni text-white mb-20 italic">Memoria Visual</h2>

            @if($mostrarGaleria)
                <div class="w-full flex flex-col md:flex-row justify-between items-center mb-16 border-b border-white/10 pb-8 gap-6">
                    <div class="text-left">
                        <span id="contador-seleccionadas" class="font-bodoni italic text-2xl text-white">0 seleccionadas</span>
                    </div>
                    <div class="flex gap-4">
                        <button onclick="descargarSeleccionadas()" class="text-[10px] uppercase tracking-widest border border-white/40 px-6 py-3 hover:bg-white hover:text-black transition">Descargar</button>
                        <button onclick="descargarTodas()" class="text-[10px] uppercase tracking-widest bg-white text-black px-6 py-3 hover:bg-zinc-200 transition">Todo el Archivo</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-h-[70vh] overflow-y-auto hide-scroll animate-up">
                    @foreach($galeriaUnificada ?? [] as $foto)
                        <div class="foto-item relative cursor-pointer grayscale hover:grayscale-0 transition-all duration-700 bg-zinc-900 group aspect-[3/4]" data-url="{{ $foto['url'] }}" onclick="toggleSeleccion(this)" onmouseenter="playPreview(this)" onmouseleave="pausePreview(this)">
                            @if($foto['esVideo'])
                                <video src="{{ $foto['url'] }}" class="vid-preview w-full h-full object-cover opacity-50 group-hover:opacity-100" muted loop playsinline></video>
                                <div class="absolute inset-0 flex items-center justify-center"><i class="fas fa-play text-white/50 text-xl"></i></div>
                            @else
                                <img src="{{ $foto['url'] }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-100">
                            @endif
                            <div class="check-icon absolute top-4 right-4 opacity-0 scale-0 transition-all"><i class="fas fa-check text-xs bg-white text-black p-2"></i></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-20 glass-noir p-10 inline-block mx-auto border border-white/10">
                    <i class="fas fa-lock text-3xl mb-6 text-white/20"></i>
                    <h3 class="text-xl tracking-widest uppercase mb-4">Archivo Bajo Custodia</h3>
                    <p class="text-white/40 text-sm max-w-sm mx-auto italic">Disponible 1 hora después del inicio oficial del servicio.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 5: EL LIBRO (FORMULARIO) --}}
    <section id="seccionLibroRecuerdos" class="section-noir">
        <div class="max-w-2xl w-full mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-7xl font-bodoni italic mb-4">Firma el Libro</h2>
                <div class="w-12 h-px bg-white/20 mx-auto"></div>
            </div>

            <div id="bloqueFormularioMensaje" class="glass-noir p-8 md:p-12 shadow-2xl">
                <form id="formRegistrarLamento" onsubmit="enviarMensajeLamento(event, '{{ $evento->evento_id }}')" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <input type="text" id="inputCodigoValidar" required placeholder="CLAVE DE ACCESO" class="input-celestial border-b border-white/20 bg-transparent py-3 uppercase tracking-[0.3em] font-mono text-xs outline-none focus:border-white">
                        <select id="inputVinculoAutor" required class="input-celestial border-b border-white/20 bg-transparent py-3 text-xs outline-none focus:border-white cursor-pointer uppercase tracking-widest">
                            <option value="" disabled selected>VÍNCULO</option>
                            <option value="Familiar">Familiar</option>
                            <option value="Amigo/a">Amigo</option>
                            <option value="Compañero">Compañero</option>
                        </select>
                    </div>
                    <input type="text" id="inputAutorMensaje" required placeholder="NOMBRE Y APELLIDO (FIRMA)" class="input-celestial border-b border-white/20 bg-transparent py-3 w-full outline-none focus:border-white uppercase tracking-widest text-xs">
                    <textarea id="inputContenidoMensaje" required rows="4" placeholder="SUS PALABRAS..." class="w-full border-b border-white/20 bg-transparent py-3 outline-none focus:border-white italic text-lg leading-relaxed"></textarea>
                    
                    <div class="flex items-center gap-4 cursor-pointer group" onclick="document.getElementById('inputArchivoFoto').click()">
                        <i class="fas fa-camera text-white/20 group-hover:text-white transition"></i>
                        <span class="text-[10px] uppercase tracking-widest text-white/40 group-hover:text-white transition" id="txtNombreArchivo">Adjuntar imagen (opcional)</span>
                        <input id="inputArchivoFoto" name="archivo" type="file" accept="image/*" class="hidden">
                    </div>

                    <button type="submit" id="btnPublicarMuro" class="btn-noir w-full !text-xs !font-bold">Publicar Homenaje</button>
                </form>
            </div>

            <div class="text-center mt-12">
                <button onclick="abrirModalAsistencia()" class="text-[9px] uppercase tracking-[0.4em] text-white/20 hover:text-white transition underline italic">Solicitar clave de acceso personal</button>
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

{{-- MODAL SOLICITUD CLAVE --}}
<div id="modalAsistencia" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/95 backdrop-blur-xl p-4">
    <div class="bg-[#111] border border-white/10 max-w-md w-full p-10 text-center shadow-2xl rounded-none">
        <div id="cuerpoInternoModalAsistencia">
            <h3 class="text-3xl font-bodoni italic text-white mb-8">Obtener Pase</h3>
            <form onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-8">
                <input type="text" id="inputNombrePrincipal" required placeholder="NOMBRE COMPLETO" class="w-full bg-transparent border-b border-white/20 py-3 outline-none focus:border-white uppercase text-xs tracking-widest">
                <input type="email" id="inputEmailPrincipal" required placeholder="CORREO ELECTRÓNICO" class="w-full bg-transparent border-b border-white/20 py-3 outline-none focus:border-white uppercase text-xs tracking-widest">
                <button type="submit" class="btn-noir w-full mt-6">Solicitar</button>
                <button type="button" onclick="cerrarModalAsistencia()" class="text-[10px] uppercase tracking-widest text-white/20 hover:text-white mt-4 block mx-auto">Cancelar</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REPRODUCTOR --}}
<div id="modalReproductor" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/98 p-4" onclick="cerrarReproductor()">
    <button onclick="cerrarReproductor()" class="absolute top-8 right-8 text-white/30 hover:text-white transition z-50 text-3xl"><i class="fas fa-times font-light"></i></button>
    <div class="w-full max-w-5xl shadow-2xl border border-white/10 p-2" onclick="event.stopPropagation()">
        <video id="videoPlayerS" controls class="w-full max-h-[85vh] bg-black"></video>
    </div>
</div>

<script>
    // TODA TU LÓGICA DE JAVASCRIPT SE MANTIENE IGUAL
    function abrirModalAsistencia() { document.getElementById('modalAsistencia').classList.remove('hidden'); }
    function cerrarModalAsistencia() { document.getElementById('modalAsistencia').classList.add('hidden'); }

    function enviarDatosAsistencia(event, eventoId) {
        event.preventDefault();
        const payload = {
            nombre_invitado: document.getElementById('inputNombrePrincipal').value,
            email: document.getElementById('inputEmailPrincipal').value
        };
        fetch(`/invitacion/memorial/${eventoId}/firmar`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(payload)
        }).then(res => res.json()).then(data => {
            if (data.success) {
                document.getElementById('cuerpoInternoModalAsistencia').innerHTML = `
                    <div class="animate-up text-center">
                        <i class="fas fa-check-circle text-4xl mb-6 text-white/20"></i>
                        <h3 class="text-2xl font-bodoni italic mb-4 uppercase tracking-widest">Localizado</h3>
                        <p class="text-xs text-white/40 mb-8 tracking-widest">Su clave personal de acceso es:</p>
                        <div class="bg-white/5 border border-white/10 p-8 mb-8">
                            <span class="text-3xl font-mono tracking-[0.4em] text-white font-bold">${data.codigos[0].codigo}</span>
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="btn-noir w-full">Entendido</button>
                    </div>`;
            }
        });
    }

    function enviarMensajeLamento(event, eventoId) {
        event.preventDefault();
        const btn = document.getElementById('btnPublicarMuro');
        btn.disabled = true; btn.innerHTML = "PROCESANDO ARCHIVOS...";
        
        const formData = new FormData();
        formData.append('nombre_autor', document.getElementById('inputAutorMensaje').value);
        formData.append('vinculo_autor', document.getElementById('inputVinculoAutor').value);
        formData.append('contenido', document.getElementById('inputContenidoMensaje').value);
        formData.append('codigo_verificacion', document.getElementById('inputCodigoValidar').value.toUpperCase());
        if(document.getElementById('inputArchivoFoto').files[0]) formData.append('archivo', document.getElementById('inputArchivoFoto').files[0]);

        fetch(`/invitacion/memorial/${eventoId}/registrar`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        }).then(async res => {
            const data = await res.json();
            if(!res.ok) { alert(data.message); btn.disabled = false; btn.innerHTML = "Publicar Homenaje"; return; }
            document.getElementById('bloqueFormularioMensaje').innerHTML = `
                <div class="py-20 text-center animate-up">
                    <h3 class="text-4xl font-bodoni italic mb-4">Gracias</h3>
                    <p class="text-white/40 tracking-widest uppercase text-[10px]">Su mensaje ha sido enviado a revisión familiar.</p>
                </div>`;
            setTimeout(() => window.location.reload(), 3000);
        });
    }

    document.getElementById('inputArchivoFoto')?.addEventListener('change', e => {
        if(e.target.files[0]) document.getElementById('txtNombreArchivo').innerText = "ARCHIVO SELECCIONADO: " + e.target.files[0].name;
    });

    // SISTEMA MULTIMEDIA
    function toggleSeleccion(el) {
        el.classList.toggle('seleccionada');
        const icon = el.querySelector('.check-icon');
        const overlay = el.querySelector('.overlay');
        if(el.classList.contains('seleccionada')) {
            icon.classList.replace('opacity-0', 'opacity-100'); icon.classList.replace('scale-0', 'scale-100');
            overlay.classList.replace('opacity-0', 'opacity-100');
            el.classList.add('border-white');
        } else {
            icon.classList.replace('opacity-100', 'opacity-0'); icon.classList.replace('scale-100', 'scale-0');
            overlay.classList.replace('opacity-100', 'opacity-0');
            el.classList.remove('border-white');
        }
        document.getElementById('contador-seleccionadas').innerText = document.querySelectorAll('.foto-item.seleccionada').length + " seleccionadas";
    }

    function playPreview(el) { el.querySelector('.vid-preview')?.play().catch(()=>{}); }
    function pausePreview(el) { el.querySelector('.vid-preview')?.pause(); }
    
    function abrirReproductor(ev, url) {
        ev.stopPropagation(); 
        const modal = document.getElementById('modalReproductor');
        const player = document.getElementById('videoPlayerS');
        player.src = url; modal.classList.remove('hidden'); player.play();
    }
    function cerrarReproductor() { 
        const player = document.getElementById('videoPlayerS');
        player.pause(); player.src = ""; document.getElementById('modalReproductor').classList.add('hidden'); 
    }

    function descargarSeleccionadas() {
        const items = document.querySelectorAll('.foto-item.seleccionada');
        if(items.length === 0) return alert("Seleccione al menos una foto");
        items.forEach((it, i) => setTimeout(() => {
            const a = document.createElement('a'); a.href = it.dataset.url; a.download = "";
            if(it.dataset.url.includes('sharepoint')) a.href += (a.href.includes('?') ? '&' : '?') + 'download=1';
            document.body.appendChild(a); a.click(); a.remove();
        }, i * 1000));
    }

    function descargarTodas() {
        document.querySelectorAll('.foto-item').forEach((it, i) => setTimeout(() => {
            const a = document.createElement('a'); a.href = it.dataset.url; a.download = "";
            document.body.appendChild(a); a.click(); a.remove();
        }, i * 800));
    }
</script>
</body>
</html>