<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $evento->nombre_evento }} | Invitación de Gala</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Great+Vibes&family=Montserrat:wght@200;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --oro-champagne: #e3c5a8;
            --negro-etiqueta: #050505;
        }

        h1, h2, h3, .font-titular { font-family: 'Cinzel', serif; }
        .font-firma { font-family: 'Great Vibes', cursive; }
        body { font-family: 'Montserrat', sans-serif; background-color: var(--negro-etiqueta); color: white; scroll-behavior: smooth; }

        .snap-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
        }

        .seccion-gala {
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            scroll-snap-align: start;
            overflow: hidden;
            background: radial-gradient(circle at center, #111 0%, #050505 100%);
        }

        .texto-oro {
            background: linear-gradient(to bottom, #f3e5d8 0%, #e3c5a8 50%, #b59372 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gala {
            position: relative;
            padding: 1.25rem 4rem;
            border: 1px solid var(--oro-champagne);
            text-transform: uppercase;
            letter-spacing: 6px;
            font-size: 0.75rem;
            background: transparent;
            color: var(--oro-champagne);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-gala:hover {
            color: var(--negro-etiqueta);
            background: var(--oro-champagne);
            box-shadow: 0 0 30px rgba(227, 197, 168, 0.3);
            letter-spacing: 8px;
        }

        .divisor-oro {
            width: 80px;
            height: 1px;
            background: var(--oro-champagne);
            margin: 2rem auto;
            position: relative;
        }

        .divisor-oro::after {
            content: '✦';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--oro-champagne);
            background: #050505;
            padding: 0 10px;
            font-size: 0.8rem;
        }

        @keyframes fundidoLento {
            from { opacity: 0.2; transform: scale(1.1); }
            to { opacity: 0.4; transform: scale(1); }
        }
        .img-fondo-suave { animation: fundidoLento 15s infinite alternate ease-in-out; }
        
        .animate-pop { animation: popIn 0.4s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.97); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body>

@php
    // Seteamos la variable al inicio de la ejecución para evitar el error de variable indefinida
    $fechaHoraEvento = \Carbon\Carbon::parse($evento->fecha_principal . ' ' . ($evento->hora ?? '21:00:00'));
    $yaComenzo = \Carbon\Carbon::now()->greaterThanOrEqualTo($fechaHoraEvento);
@endphp

<div class="snap-container">

    {{-- SECCIÓN 1: BIENVENIDA --}}
    <section class="seccion-gala">
        <div class="absolute inset-0 z-0">
            @if($evento->fotosGaleria->count() > 0)
                <img src="{{ asset('storage/' . $evento->fotosGaleria->first()->url_recurso) }}" 
                     class="w-full h-full object-cover img-fondo-suave">
            @endif
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="z-10 text-center px-4">
            <span class="font-firma text-4xl tracking-widest texto-oro mb-6 block">Bienvenidos a la celebración de</span>
            <h1 class="text-6xl md:text-9xl texto-oro font-bold mb-6 tracking-tighter">
                {{ $evento->nombre_evento }}
            </h1>
            
            <div class="divisor-oro"></div>

            <p class="text-2xl md:text-3xl font-extralight tracking-[0.4em] mb-12">
                {{ \Carbon\Carbon::parse($evento->fecha_principal)->translatedFormat('d.m.Y') }}
            </p>

            {{-- CONTADOR ELEGANTE --}}
            <div id="countdown" class="flex justify-center gap-10 md:gap-20">
                <div class="flex flex-col">
                    <span id="days" class="text-5xl md:text-7xl font-light texto-oro">00</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] opacity-50">Días</span>
                </div>
                <div class="flex flex-col">
                    <span id="hours" class="text-5xl md:text-7xl font-light">00</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] opacity-50">Horas</span>
                </div>
                <div class="flex flex-col">
                    <span id="minutes" class="text-5xl md:text-7xl font-light">00</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] opacity-50">Minutos</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-10">
                    <span id="seconds" class="text-5xl md:text-7xl font-light text-rose-300">00</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] opacity-50">Segundos</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: HISTORIA --}}
    <section class="seccion-gala">
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-20 items-center px-10">
            <div class="space-y-10">
                <p class="font-firma text-5xl texto-oro">Nuestra Historia</p>
                <h2 class="text-5xl md:text-7xl leading-none">Un camino hacia el siempre</h2>
                <p class="text-stone-400 leading-loose text-xl font-light tracking-wide italic">
                    "{{ $evento->biografia_resumen }}"
                </p>
            </div>
            <div class="relative group">
                @if($evento->fotosGaleria->count() > 1)
                    <img src="{{ asset('storage/' . $evento->fotosGaleria[1]->url_recurso) }}" 
                         class="w-full h-[600px] object-cover rounded-sm grayscale group-hover:grayscale-0 transition-all duration-1000 shadow-2xl">
                @endif
                <div class="absolute -bottom-10 -left-10 bg-black/80 border border-white/10 p-10 backdrop-blur-md hidden md:block">
                    <p class="font-firma text-4xl texto-oro">S & M</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: UBICACIÓN --}}
    <section class="seccion-gala">
        <div class="text-center px-6">
            <p class="font-firma text-5xl texto-oro mb-4 text-center">El Escenario</p>
            <h2 class="text-5xl md:text-8xl mb-10 tracking-widest uppercase">Lugar del Evento</h2>
            
            <p class="text-2xl text-stone-300 font-extralight max-w-3xl mx-auto mb-16 leading-relaxed italic">
                {{ $evento->ubicacion_texto }}
            </p>
            
            @if($evento->google_maps_url)
            <a href="{{ $evento->google_maps_url }}" target="_blank" class="btn-gala inline-block">
                Ver Ubicación <i class="fa-solid fa-diamond-turn-right ml-2 text-[10px]"></i>
            </a>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 4: INTERACCIONES --}}
    <section class="seccion-gala bg-[#080808]">
        <div class="max-w-5xl w-full px-6 text-center">
            <h2 class="text-5xl mb-20 tracking-[0.3em] font-light">Dinámicas de la Noche</h2>
            
            <div class="grid md:grid-cols-2 gap-12">
                <div class="p-16 border border-white/5 shadow-inner hover:bg-white/[0.02] transition-colors flex flex-col justify-between items-center h-80">
                    <div>
                        <h3 class="font-firma text-4xl texto-oro mb-6">Trivia Real</h3>
                        <p class="text-stone-500 font-light text-sm mb-10 tracking-widest uppercase italic">¿Cuánto nos conoces?</p>
                    </div>
                    <div id="wrapper-btn-trivia" class="w-full">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('trivia')" class="text-[10px] uppercase tracking-[0.5em] border-b border-rose-200 pb-2 hover:text-rose-200 transition font-bold">Comenzar Juego</button>
                        @else
                            <button id="btn-time-trivia" disabled class="text-[10px] uppercase tracking-[0.4em] text-stone-600 cursor-not-allowed font-medium">
                                <i class="fas fa-lock mr-1"></i> Disponible en el Evento
                            </button>
                        @endif
                    </div>
                </div>

                <div class="p-16 border border-white/5 shadow-inner hover:bg-white/[0.02] transition-colors flex flex-col justify-between items-center h-80">
                    <div>
                        <h3 class="font-firma text-4xl texto-oro mb-6">Muro de Deseos</h3>
                        <p class="text-stone-500 font-light text-sm mb-10 tracking-widest uppercase italic">Deja un mensaje</p>
                    </div>
                    <div id="wrapper-btn-muro" class="w-full">
                        @if($yaComenzo)
                            <button onclick="solicitarAccesoVerificacion('muro')" class="text-[10px] uppercase tracking-[0.5em] border-b border-rose-200 pb-2 hover:text-rose-200 transition font-bold">Escribir Saludo</button>
                        @else
                            <button id="btn-time-muro" disabled class="text-[10px] uppercase tracking-[0.4em] text-stone-600 cursor-not-allowed font-medium">
                                <i class="fas fa-lock mr-1"></i> Disponible en el Evento
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: RSVP --}}
    <section class="seccion-gala">
        <div class="text-center px-4 relative">
            <p class="font-firma text-6xl texto-oro mb-12">Por favor, confirma tu asistencia</p>
            <h2 class="text-6xl md:text-9xl mb-16 tracking-tighter font-bold">R.S.V.P</h2>
            
            <div id="contenedorBotonPrincipalRSVP">
                @if(isset($invitado) && $invitado && $invitado->token_acceso !== 'INVITADO-GENERAL')
                    <button onclick="abrirModalAsistencia()" class="btn-gala">
                        Confirmar Asistencia
                    </button>
                @else
                    <div class="px-8 py-4 border border-white/10 text-xs tracking-[0.4em] uppercase text-stone-400 max-w-md mx-auto bg-black/20">
                        Código QR Obligatorio para Acceso
                    </div>
                @endif
            </div>
            
            <div class="mt-20 opacity-30 uppercase text-[9px] tracking-[0.6em] space-y-4">
                <p>Mesa Reservada: {{ $invitado->mesa_asignada ?? 'Pronto disponible' }}</p>
                <p>Código de Vestimenta: Etiqueta Rigurosa / Gala</p>
            </div>
        </div>
    </section>

</div>

{{-- MODAL GLOBAL DE FILTRO Y JUEGO DE TRIVIA INTEGRADO - ESTILO GALA --}}
<div id="modalFiltroAcceso" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div id="wrapper-dinamico-modal" class="bg-[#111] rounded-sm max-w-xl w-full p-8 text-center shadow-2xl border border-white/10 max-h-[90vh] overflow-y-auto">
        
        <div id="cuerpo-filtro-llave">
            <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                <h3 class="text-lg tracking-widest uppercase font-light font-titular text-stone-200"><i class="fas fa-key text-amber-400 mr-2"></i> Código de Gala Requerido</h3>
                <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="space-y-6 text-left">
                <p class="text-xs text-stone-400 font-light leading-relaxed">Para interactuar en las dinámicas, ingresa el **Código de Pase Personal** individual que se te asignó al confirmar asistencia.</p>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-2">Introduce tu Clave</label>
                    <input type="text" id="inputCodigoCheck" placeholder="Ej: GALA-2841" class="w-full border border-white/20 bg-black/60 p-3 rounded-sm text-sm font-mono tracking-widest outline-none uppercase focus:border-stone-400 text-stone-200">
                </div>
                <button onclick="procesarVerificacionCodigo('{{ $evento->evento_id }}')" class="w-full bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black py-3.5 rounded-sm font-bold text-xs uppercase tracking-[0.3em] transition-all duration-500 shadow-md">
                    Verificar Credencial
                </button>
            </div>
        </div>

    </div>
</div>

{{-- MODAL INTEGRADO PARA EL MURO DE DESEOS DE BODAS --}}
<div id="modalMuroBoda" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="bg-[#111] text-white rounded-sm max-w-md w-full p-8 text-center shadow-2xl border border-white/10">
        <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
            <h3 class="text-lg uppercase tracking-widest font-light font-titular text-stone-200">Dejar Mensaje de Buenos Deseos</h3>
            <button onclick="cerrarModalMuroBoda()" class="text-gray-400 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        <form id="formMuroBoda" onsubmit="enviarRecuerdoMemorial(event, '{{ $evento->evento_id }}')" class="space-y-5 text-left">
            <input type="hidden" name="tipo" value="texto">
            <input type="hidden" name="codigo_verificacion" id="hiddenCodigoMuro">
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-2">Tu Nombre</label>
                <input type="text" name="nombre_autor" id="inputNombreAutorMuro" readonly class="w-full border border-white/10 bg-black/40 p-3 rounded-sm text-sm outline-none text-stone-400 font-medium">
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-2">Tu Mensaje para los Novios *</label>
                <textarea name="contenido" required rows="3" class="w-full border border-white/20 bg-black/60 p-3 rounded-sm text-sm outline-none focus:border-stone-400 text-stone-200" placeholder="¡Felicidades en esta mágica etapa!"></textarea>
            </div>
            <button type="submit" class="w-full bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black py-3.5 rounded-sm font-bold text-xs uppercase tracking-[0.3em] shadow-md transition-all duration-500">
                Enviar Felicitación
            </button>
        </form>
    </div>
</div>

{{-- MODAL PÚBLICO PARA REGISTRO DE ASISTENCIA --}}
<div id="modalAsistencia" class="fixed inset-0 z-[70] hidden flex items-center justify-center bg-black/95 backdrop-blur-md p-4">
    <div class="bg-[#111] text-white rounded-sm max-w-md w-full p-8 text-center shadow-2xl border border-white/10 max-h-[90vh] overflow-y-auto">
        <div id="cuerpoInternoModalAsistencia">
            <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                <h3 class="text-xl tracking-widest uppercase font-light font-titular text-stone-200">Registro de Gala</h3>
                <button onclick="cerrarModalAsistencia()" class="text-stone-400 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="formConfirmarAsistencia" onsubmit="enviarDatosAsistencia(event, '{{ $evento->evento_id }}')" class="space-y-6 text-left">
                <input type="hidden" id="inputHiddenToken" value="{{ $invitado->token_acceso ?? '' }}">

                <div class="bg-black/40 p-5 rounded-sm border border-white/5 space-y-4">
                    <span class="text-[9px] uppercase tracking-[0.3em] font-bold text-stone-400 block"><i class="fas fa-user-tie mr-1"></i> Invitado Principal</span>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Nombre Completo</label>
                        <input type="text" id="inputNombrePrincipal" required class="w-full border border-white/20 bg-black/60 p-3 rounded-sm text-sm outline-none focus:border-stone-400 text-stone-200">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Correo Electrónico (Opcional)</label>
                        <input type="email" id="inputEmailPrincipal" class="w-full border border-white/20 bg-black/60 p-3 rounded-sm text-sm outline-none focus:border-stone-400 text-stone-200" placeholder="correo@ejemplo.com">
                    </div>
                </div>

                <div id="contenedorAcompanantes" class="space-y-4"></div>

                <button type="button" onclick="agregarCampoAcompanante()" class="w-full py-3 border border-dashed border-white/20 text-stone-400 rounded-sm text-[10px] uppercase tracking-[0.3em] hover:bg-white/[0.02] hover:text-white transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus text-[8px]"></i> Añadir Acompañante de Gala
                </button>

                <button type="submit" class="w-full bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black py-4 rounded-sm font-bold text-xs uppercase tracking-[0.4em] shadow-md transition-all duration-500 mt-6">
                    Confirmar mi Puesto
                </button>
            </form>
        </div>
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
        const horaEvento = "{{ $evento->hora ?? '21:00:00' }}"; 
        const countDate = new Date(`${fechaEvento}T${horaEvento}`).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const gap = countDate - now;
            const s=1000, m=s*60, h=m*60, d=h*24;

            if (gap <= 0) {
                document.getElementById('countdown').innerHTML = "<p class='texto-oro text-3xl font-firma py-10'>¡La fiesta ha comenzado!</p>";
                
                const wrapTrivia = document.getElementById('wrapper-btn-trivia');
                if(wrapTrivia && document.getElementById('btn-time-trivia')) {
                    wrapTrivia.innerHTML = `<button onclick="solicitarAccesoVerificacion('trivia')" class="text-[10px] uppercase tracking-[0.5em] border-b border-rose-200 pb-2 hover:text-rose-200 transition font-bold">Comenzar Juego</button>`;
                }
                const wrapMuro = document.getElementById('wrapper-btn-muro');
                if(wrapMuro && document.getElementById('btn-time-muro')) {
                    wrapMuro.innerHTML = `<button onclick="solicitarAccesoVerificacion('muro')" class="text-[10px] uppercase tracking-[0.5em] border-b border-rose-200 pb-2 hover:text-rose-200 transition font-bold">Escribir Saludo</button>`;
                }
                return;
            }

            document.getElementById('days').innerText = Math.floor(gap / d).toString().padStart(2, '0');
            document.getElementById('hours').innerText = Math.floor((gap % d) / h).toString().padStart(2, '0');
            document.getElementById('minutes').innerText = Math.floor((gap % h) / m).toString().padStart(2, '0');
            document.getElementById('seconds').innerText = Math.floor((gap % m) / s).toString().padStart(2, '0');
        };

        setInterval(updateCountdown, 1000);
        updateCountdown();
    });

    function solicitarAccesoVerificacion(modulo) {
        moduloObjetivo = modulo;
        document.getElementById('wrapper-dinamico-modal').innerHTML = `
            <div id="cuerpo-filtro-llave">
                <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                    <h3 class="text-lg tracking-widest uppercase font-light font-titular text-stone-200"><i class="fas fa-key text-amber-400 mr-2"></i> Código de Gala Requerido</h3>
                    <button onclick="cerrarModalFiltro()" class="text-stone-400 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="space-y-6 text-left">
                    <p class="text-xs text-stone-400 font-light leading-relaxed">Para interactuar en las dinámicas, ingresa el **Código de Pase Personal** individual que se te asignó al confirmar asistencia.</p>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-2">Introduce tu Clave</label>
                        <input type="text" id="inputCodigoIngreso" placeholder="Ej: GALA-2841" class="w-full border border-white/20 bg-black/60 p-3 rounded-sm text-sm font-mono tracking-widest outline-none uppercase focus:border-stone-400 text-stone-200">
                    </div>
                    <button onclick="procesarVerificacionCodigo('${ '{{ $evento->evento_id }}' }')" class="w-full bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black py-3.5 rounded-sm font-bold text-xs uppercase tracking-[0.3em] transition-all duration-500 shadow-md">
                        Verificar Credencial
                    </button>
                </div>
            </div>
        `;
        document.getElementById('modalFiltroAcceso').classList.remove('hidden');
    }

    function cerrarModalFiltro() {
        document.getElementById('modalFiltroAcceso').classList.add('hidden');
    }

    function procesarVerificacionCodigo(eventoId) {
        const codigo = document.getElementById('inputCodigoIngreso').value.trim().toUpperCase();
        if(!codigo) { alert("Por favor, introduce un código válido."); return; }

        const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/invitacion/validar-pase-trivia`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': tokenCsrf },
            body: JSON.stringify({ codigo: codigo, evento_id: eventoId })
        })
        .then(async response => {
            const data = await response.status === 422 || response.status === 404 || response.status === 200 
                ? await response.json() 
                : {};
                
            if (response.status === 422 && data.already_played) {
                const wrapper = document.getElementById('wrapper-dinamico-modal');
                wrapper.innerHTML = `
                    <div class="py-6 text-center space-y-6 animate-pop">
                        <div class="w-16 h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto border border-amber-500/30">
                            <i class="fas fa-exclamation-circle text-2xl text-amber-400"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-titular uppercase tracking-widest text-stone-200">Cuestionario Ya Respondido</h3>
                            <p class="text-sm text-stone-400 font-light px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="pt-4">
                            <button onclick="cerrarModalFiltro()" class="px-8 py-3 bg-transparent border border-stone-400 text-stone-400 hover:bg-stone-400 hover:text-black transition text-xs font-bold uppercase tracking-widest rounded-sm">
                                Regresar
                            </button>
                        </div>
                    </div>
                `;
                throw new Error("already_handled");
            }

            if (!response.ok) {
                alert(data.message || "Credencial inválida.");
                throw new Error("invalid_code");
            }
            return data;
        })
        .then(data => {
            if(data && data.success) {
                datosInvitadoValidado = {
                    id: data.invitado_id,
                    nombre: data.nombre_invitado,
                    codigo: codigo
                };

                if(moduloObjetivo === 'trivia') {
                    bancoPreguntas = data.preguntas;
                    preguntaActualIndex = 0;
                    puntajeAcumulado = 0;
                    segundosTranscurridos = 0;
                    
                    montarPantallaInicioJuego();
                } else if(moduloObjetivo === 'muro') {
                    cerrarModalFiltro();
                    document.getElementById('hiddenCodigoMuro').value = codigo;
                    document.getElementById('inputNombreAutorMuro').value = data.nombre_invitado;
                    abrirModalMuroBoda();
                }
            }
        })
        .catch(err => {
            if (err.message !== "already_handled") {
                console.error("Fallo filtro acceso:", err);
            }
        });
    }

    function montarPantallaInicioJuego() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-inicio" class="text-center space-y-6 animate-pop">
                <div class="w-16 h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto border border-amber-500/20">
                    <i class="fas fa-gamepad text-xl text-amber-400"></i>
                </div>
                <span class="text-xs uppercase tracking-[0.2em] text-amber-500 font-bold block">Trivia Exclusiva de Gala</span>
                <h1 class="text-3xl font-titular text-stone-200">¡Saludos, ${datosInvitadoValidado.nombre}!</h1>
                <p class="text-stone-400 text-sm leading-relaxed font-light">Pon a prueba tus conocimientos sobre la pareja. Responderás un set de <strong class="text-stone-200">${bancoPreguntas.length} preguntas</strong> cronometradas en tiempo real.</p>
                
                <button onclick="comenzarJuegoModal()" class="w-full bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black py-4 rounded-sm font-bold text-xs uppercase tracking-[0.3em] transition-all duration-500">
                    Iniciar Desafío
                </button>
            </div>
        `;
    }

    function comenzarJuegoModal() {
        const wrapper = document.getElementById('wrapper-dinamico-modal');
        wrapper.innerHTML = `
            <div id="pantalla-juego" class="space-y-6 text-left animate-pop">
                <div class="flex justify-between items-center text-xs font-semibold uppercase tracking-[0.2em] text-stone-500 border-b border-white/5 pb-4">
                    <span id="info-progreso">Pregunta 1 de X</span>
                    <span class="text-amber-400"><i class="fas fa-clock mr-1"></i> Cronómetro: <span id="info-cronometro" class="font-mono text-sm font-bold">0s</span></span>
                </div>

                <h2 id="texto-pregunta" class="text-xl font-titular text-stone-200 leading-snug">Cargando pregunta...</h2>

                <div class="space-y-3 pt-2">
                    <button onclick="seleccionarOpcionModal('a')" id="btn-opcion-a" class="w-full text-left p-4 rounded-sm border border-white/10 bg-black/40 hover:bg-white/[0.02] hover:border-white/30 transition text-sm flex items-center space-x-4 text-stone-300">
                        <span class="w-6 h-6 bg-white/5 rounded-full flex items-center justify-center text-xs font-bold text-amber-400 border border-amber-500/20">A</span>
                        <span id="texto-opcion-a">Opción A</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('b')" id="btn-opcion-b" class="w-full text-left p-4 rounded-sm border border-white/10 bg-black/40 hover:bg-white/[0.02] hover:border-white/30 transition text-sm flex items-center space-x-4 text-stone-300">
                        <span class="w-6 h-6 bg-white/5 rounded-full flex items-center justify-center text-xs font-bold text-amber-400 border border-amber-500/20">B</span>
                        <span id="texto-opcion-b">Opción B</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('c')" id="btn-opcion-c" class="w-full text-left p-4 rounded-sm border border-white/10 bg-black/40 hover:bg-white/[0.02] hover:border-white/30 transition text-sm flex items-center space-x-4 text-stone-300">
                        <span class="w-6 h-6 bg-white/5 rounded-full flex items-center justify-center text-xs font-bold text-amber-400 border border-amber-500/20">C</span>
                        <span id="texto-opcion-c">Opción C</span>
                    </button>
                    <button onclick="seleccionarOpcionModal('d')" id="btn-opcion-d" class="w-full text-left p-4 rounded-sm border border-white/10 bg-black/40 hover:bg-white/[0.02] hover:border-white/30 transition text-sm flex items-center space-x-4 text-stone-300">
                        <span class="w-6 h-6 bg-white/5 rounded-full flex items-center justify-center text-xs font-bold text-amber-400 border border-amber-500/20">D</span>
                        <span id="texto-opcion-d">Opción D</span>
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
            document.getElementById('wrapper-dinamico-modal').innerHTML = `<p class="p-4 text-stone-500">Este evento no cuenta con preguntas configuradas.</p>`;
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
            <div class="text-center space-y-6 py-4 animate-pop">
                <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto border border-white/10">
                    <i class="fas fa-spinner fa-spin text-xl text-stone-400"></i>
                </div>
                <h3 class="text-xl font-titular uppercase tracking-widest text-stone-200">Sincronizando Puntuación</h3>
                <p class="text-xs text-stone-500 font-light">Asentando tus registros en la base de datos del altar.</p>
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
                    <div class="text-center space-y-8 py-4 animate-pop">
                        <div class="w-16 h-16 bg-emerald-50/10 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30 mb-4 shadow-xl">
                            <i class="fas fa-trophy text-2xl text-emerald-400"></i>
                        </div>
                        <h3 class="text-2xl font-titular uppercase tracking-[0.2em] texto-oro">Desafío Completado</h3>
                        <p class="text-sm text-stone-400 font-light max-w-xs mx-auto leading-relaxed">Tus respuestas de gala han sido guardadas de manera exitosa en el ranking oficial.</p>
                        
                        <div class="grid grid-cols-2 gap-4 bg-black/50 p-5 border border-white/5 rounded-sm max-w-xs mx-auto text-left font-mono text-xs">
                            <div class="border-r border-white/10 pr-2">
                                <span class="block text-[9px] uppercase font-bold text-stone-500 tracking-wider mb-1">Puntaje Gala</span>
                                <span class="text-xl font-black text-stone-200">${puntajeAcumulado} pts</span>
                            </div>
                            <div class="text-left pl-2">
                                <span class="block text-[9px] uppercase font-bold text-stone-500 tracking-wider mb-1">Tiempo Empleado</span>
                                <span class="text-xl font-black text-stone-200">${segundosTranscurridos} seg</span>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button onclick="cerrarModalFiltro()" class="px-10 py-3 bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black text-xs font-bold uppercase tracking-[0.3em] rounded-sm transition-all duration-500 shadow-md">Cerrar Ventana</button>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error(err);
            wrapper.innerHTML = `<p class="text-rose-400 font-bold font-mono text-xs"><i class="fas fa-exclamation-triangle mr-1"></i> Error al sincronizar los datos.</p>`;
        });
    }

    let contadorAcompanantes = 0;

    function agregarCampoAcompanante() {
        contadorAcompanantes++;
        const contenedor = document.getElementById('contenedorAcompanantes');
        
        const div = document.createElement('div');
        div.id = `acompanante_row_${contadorAcompanantes}`;
        div.className = "bg-black/60 p-5 rounded-sm border border-white/5 space-y-4 relative animate-fade-in";
        
        div.innerHTML = `
            <div class="flex justify-between items-center border-b border-white/5 pb-2">
                <span class="text-[9px] uppercase tracking-[0.3em] font-bold text-stone-400"><i class="fas fa-users mr-1"></i> Acompañante #${contadorAcompanantes}</span>
                <button type="button" onclick="removerCampoAcompanante(${contadorAcompanantes})" class="text-rose-400 hover:text-rose-300 text-[10px] uppercase tracking-wider transition">
                    <i class="fas fa-trash-alt mr-1"></i> Quitar
                </button>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Nombre del Acompañante</label>
                <input type="text" class="input-nombre-acompanante w-full border border-white/20 bg-black/40 p-3 rounded-sm text-sm outline-none focus:border-stone-400 text-stone-200" required>
            </div>
            <div>
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Correo Electrónico (Opcional)</label>
                <input type="email" class="input-email-acompanante w-full border border-white/20 bg-black/40 p-3 rounded-sm text-sm outline-none focus:border-stone-400 text-stone-200" placeholder="correo@ejemplo.com">
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
                    <div class="py-8 px-2 text-center space-y-6 animate-fade-in">
                        <div class="w-16 h-16 bg-amber-50/10 rounded-full flex items-center justify-center mx-auto border border-amber-500/30">
                            <i class="fas fa-exclamation-triangle text-2xl text-amber-400"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-titular uppercase tracking-widest text-stone-200">Asistencia Registrada</h3>
                            <p class="text-sm text-stone-400 font-light px-4 leading-relaxed">${data.message}</p>
                        </div>
                        <div class="p-4 bg-black/40 border border-amber-500/20 rounded-sm text-xs text-amber-300 text-left leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i> Si necesitas reasignar cupos familiares o modificar los datos de tu correo, comunícate con la administración del evento.
                        </div>
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-transparent border border-stone-500 text-stone-400 py-3 rounded-sm text-xs uppercase tracking-[0.3em] hover:text-white hover:border-white transition-all duration-300">
                            Cerrar Ventana
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
                    <div class="py-8 px-2 text-center space-y-8 animate-fade-in">
                        <div class="w-16 h-16 bg-emerald-50/10 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30">
                            <i class="fas fa-check text-2xl text-emerald-400"></i>
                        </div>
                        
                        <div class="space-y-2">
                            <h3 class="text-2xl font-titular uppercase tracking-[0.2em] texto-oro">Acceso Confirmado</h3>
                            <p class="text-xs text-stone-400 font-light px-2">Conserva tus pases individuales para las interacciones interactivas de la noche.</p>
                        </div>

                        <div class="bg-black/60 border border-white/10 rounded-sm p-5 text-left space-y-4 shadow-2xl">
                            <p class="text-[9px] uppercase font-bold tracking-[0.3em] text-stone-400 border-b border-white/5 pb-2">
                                <i class="fas fa-ticket-alt mr-1"></i> Códigos de Acceso Generados
                            </p>
                            <div class="text-xs space-y-3 font-mono">
                                ${data.codigos.map((item, index) => `
                                    <div class="flex justify-between items-center ${index > 0 ? 'pt-3 border-t border-dashed border-white/5' : ''}">
                                        <span class="font-sans font-light tracking-wide text-stone-300">${item.nombre}:</span> 
                                        <span class="bg-gradient-to-r from-stone-200 to-stone-400 px-3 py-1 rounded-sm text-[11px] font-bold text-black font-mono tracking-widest shadow-lg">
                                            ${item.codigo}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <p class="text-[10px] text-stone-500 italic max-w-xs mx-auto leading-relaxed">Presenta estos códigos al ingresar al muro de deseos digital o al responder las trivias.</p>
                        
                        <button onclick="cerrarModalAsistencia()" class="w-full bg-transparent border border-stone-300 text-stone-300 hover:bg-stone-300 hover:text-black py-3 rounded-sm text-xs font-bold uppercase tracking-[0.3em] transition-all duration-500">
                            Finalizar
                        </button>
                    </div>
                `;

                document.getElementById('contenedorBotonPrincipalRSVP').innerHTML = `
                    <div class="px-8 py-4 border border-emerald-500/20 text-xs tracking-[0.4em] uppercase text-emerald-400 max-w-md mx-auto bg-emerald-500/5 rounded-sm animate-fade-in">
                        <i class="fas fa-check-circle mr-2"></i> ¡Asistencia Confirmada!
                    </div>
                `;
            }
        })
        .catch(error => {
            if (error.message !== "already_handled") {
                console.error("Detalle:", error);
                alert("No se pudo conectar con el servidor. Revisa los datos de gala.");
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

    function enviarRecuerdoMemorial(event, eventoId) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch(`/invitacion/memorial/${eventoId}/recuerdo`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
                cerrarModalMuroBoda();
                if(document.getElementById('tipoAporte')) alternarCamposMemorial();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error al registrar interacción:", error));
    }

    function abrirModalMuroBoda() { document.getElementById('modalMuroBoda').classList.remove('hidden'); }
    function cerrarModalMuroBoda() { document.getElementById('modalMuroBoda').classList.add('hidden'); }
</script>

</body>
</html>