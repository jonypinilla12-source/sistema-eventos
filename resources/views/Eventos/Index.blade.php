@extends('layouts.app')

@section('content')
@php
    $esAdmin = auth()->user()->rol_id == 1;
@endphp

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            @if($esAdmin)
                <h1 class="text-2xl font-bold text-slate-800">Eventos Activos</h1>
                <p class="text-slate-500 text-sm">Gestiona y supervisa todas las celebraciones actuales.</p>
            @else
                <h1 class="text-2xl font-bold text-slate-800">Tus Eventos</h1>
                <p class="text-slate-500 text-sm">Gestiona y supervisa tus celebraciones y eventos asignados.</p>
            @endif
        </div>
        
        @if($esAdmin)
        <a href="{{ route('eventos.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center space-x-2">
            <i class="fas fa-plus text-sm"></i>
            <span>Nuevo Evento</span>
        </a>
        @endif
    </div>

    @if(session('exito'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
            {{ session('exito') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($eventos as $evento)
        @php
            $esMemorial = strtolower($evento->tipo->nombre) === 'memorial';
            $urlEvento = route('eventos.show', $evento->slug) . ($esMemorial ? '' : '?token=' . $evento->token_invitacion_general);
            $fotoEvento = $evento->fotosGaleria->first() ? asset('storage/' . $evento->fotosGaleria->first()->url_recurso) : '';
            $fechaFormateada = \Carbon\Carbon::parse($evento->fecha_principal)->format('d \d\e F, Y');
            $fechaNacimiento = $evento->fecha_nacimiento ? \Carbon\Carbon::parse($evento->fecha_nacimiento)->format('d/m/Y') : '';
            $fechasCombinadas = $fechaNacimiento ? ($fechaNacimiento . ' - ' . $fechaFormateada) : $fechaFormateada;
            $tipoNormalizado = strtolower($evento->tipo->nombre);
        @endphp
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-all group relative flex flex-col justify-between">
            
            @if(auth()->user()->rol_id == 1 || auth()->user()->usuario_id == $evento->anfitrion_id)
            <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="{{ route('eventos.edit', $evento->evento_id) }}" class="bg-white/90 backdrop-blur shadow-sm border border-slate-200 text-slate-600 p-2 rounded-lg hover:text-indigo-600 hover:border-indigo-200 transition">
                    <i class="fas fa-edit text-xs"></i>
                </a>
            </div>
            @endif

            <div class="p-6 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-indigo-50 text-indigo-600 text-[10px] uppercase font-bold px-2.5 py-1 rounded-lg tracking-wider">
                        {{ $evento->tipo->nombre }}
                    </span>
                    <span class="{{ $evento->activo ? 'text-emerald-500' : 'text-slate-400' }}">
                        <i class="fas fa-circle text-[8px]"></i>
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-indigo-600 transition">
                    {{ $evento->nombre_evento }}
                </h3>
                <p class="text-xs text-slate-400 mb-4 italic">/{{ $evento->slug }}</p>

                <div class="space-y-2 mb-6 flex-grow">
                    <div class="flex items-center text-sm text-slate-600">
                        <i class="far fa-calendar-alt w-5 text-indigo-400"></i>
                        <span>{{ \Carbon\Carbon::parse($evento->fecha_principal)->format('d M, Y') }}</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600">
                        <i class="far fa-user w-5 text-indigo-400"></i>
                        <span>Anfitrión: <strong>{{ $evento->usuario->nombre ?? 'Sin Anfitrión' }}</strong></span>
                    </div>
                </div>

                <div class="bg-slate-50/80 p-3 rounded-xl border border-slate-100 mb-6 grid {{ $esMemorial ? 'grid-cols-1' : 'grid-cols-3' }} gap-2">
                    @if(!$esMemorial)
                        <a href="{{ route('eventos.invitados', $evento->evento_id) }}" class="flex flex-col items-center justify-center text-center bg-white border border-slate-200 text-slate-700 py-2 px-1 rounded-lg text-[10px] font-bold hover:text-indigo-600 hover:border-indigo-200 transition shadow-2xs">
                            <i class="fas fa-users text-indigo-500 mb-1 text-xs"></i>
                            <span>Invitados ({{ $evento->invitados->count() }})</span>
                        </a>

                        <a href="{{ route('eventos.trivia', $evento->evento_id) }}" class="flex flex-col items-center justify-center text-center bg-white border border-slate-200 text-slate-700 py-2 px-1 rounded-lg text-[10px] font-bold hover:text-amber-600 hover:border-amber-200 transition shadow-2xs">
                            <i class="fas fa-gamepad text-amber-500 mb-1 text-xs"></i>
                            <span>Trivia ({{ $evento->juegoPreguntas->count() }})</span>
                        </a>
                    @endif

                    <a href="{{ route('eventos.interacciones', $evento->evento_id) }}" class="flex {{ $esMemorial ? 'flex-row space-x-2 py-3' : 'flex-col' }} items-center justify-center text-center bg-white border border-slate-200 text-slate-700 py-2 px-1 rounded-lg text-[10px] font-bold hover:text-emerald-600 hover:border-emerald-200 transition shadow-2xs">
                        <i class="fas fa-comment-medical text-xs {{ $esMemorial ? 'text-emerald-500 animate-pulse' : 'text-slate-500 mb-1' }}"></i>
                        <span>{{ $esMemorial ? 'Moderar Dedicatorias' : 'Muro Mensajes' }}</span>
                    </a>
                </div>

                <div class="pt-4 border-t flex flex-col gap-2 mt-auto">
                    <div class="grid grid-cols-3 gap-2">
                        <a href="{{ route('eventos.galeria', $evento->evento_id) }}" class="flex items-center justify-center text-center bg-slate-100 text-slate-700 py-2 rounded-lg text-[10px] font-bold hover:bg-indigo-50 hover:text-indigo-600 transition">
                            <i class="fas fa-images mr-1"></i> Galería
                        </a>
                        <a href="{{ route('eventos.itinerario', $evento->evento_id) }}" class="flex items-center justify-center text-center bg-slate-100 text-slate-700 py-2 rounded-lg text-[10px] font-bold hover:bg-amber-50 hover:text-amber-600 transition">
                            <i class="fas fa-list-ul mr-1"></i> Itinerario
                        </a>
                        <form id="formSubidaNube-{{ $evento->evento_id }}" action="{{ route('eventos.onedrive.store', $evento->evento_id) }}" method="POST" enctype="multipart/form-data" class="m-0 h-full">
                            @csrf
                            <label class="cursor-pointer flex items-center justify-center h-full text-center bg-blue-50 text-blue-600 py-2 rounded-lg text-[10px] font-bold hover:bg-blue-100 transition border border-blue-100 shadow-sm relative overflow-hidden">
                                <i class="fas fa-cloud-upload-alt mr-1"></i> Nube
                                <input type="file" name="fotos[]" class="hidden" onchange="mostrarLoaderSubida('formSubidaNube-{{ $evento->evento_id }}')" accept="image/*,video/*" multiple>
                            </label>
                        </form>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="prepararModalQR(this)"
                                data-nombre="{{ e($evento->nombre_evento) }}"
                                data-url="{{ $urlEvento }}"
                                data-plantilla="{{ e($evento->id_plantilla) }}"
                                data-foto="{{ $fotoEvento }}"
                                data-tipo="{{ $tipoNormalizado }}"
                                data-fecha="{{ $fechasCombinadas }}"
                                data-bio="{{ e($evento->biografia_resumen ?? '') }}"
                                class="text-center bg-slate-800 text-white py-2 rounded-lg text-[10px] font-bold hover:bg-slate-900 transition flex items-center justify-center">
                            <i class="fas fa-qrcode mr-1"></i> Generar QR
                        </button>
                                        
                        <a href="{{ route('eventos.show', $evento->slug) }}" target="_blank" class="text-center bg-indigo-600 text-white py-2 rounded-lg text-[10px] font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100 flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-1"></i> Ver Invitación
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- PANTALLA DE CARGA --}}
<div id="loaderSubidaNube" class="fixed inset-0 z-[150] hidden flex flex-col items-center justify-center bg-slate-900/95 backdrop-blur-md p-4 transition-all duration-300">
    <i class="fas fa-circle-notch fa-spin text-6xl md:text-7xl text-blue-500 mb-6 drop-shadow-[0_0_15px_rgba(59,130,246,0.8)]"></i>
    <h2 class="text-2xl md:text-4xl font-bold text-white mb-3 tracking-widest uppercase text-center" style="font-family: 'Anton', sans-serif;">
        ENVIANDO DATOS AL MULTIVERSO...
    </h2>
</div>

{{-- MODAL QR --}}
<div id="modalQR" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full p-8 text-center animate-fade-in relative overflow-y-auto max-h-[95vh]">
        <div class="flex justify-between items-center mb-6">
            <h3 id="modalTitulo" class="text-2xl font-bold text-slate-800 uppercase tracking-tight"></h3>
            <button onclick="cerrarModalQR()" class="text-slate-400 hover:text-slate-600 transition"><i class="fas fa-times text-2xl"></i></button>
        </div>
        
        <div id="wrapper-canvas" class="mb-8 rounded-2xl overflow-hidden border-2 border-slate-100 shadow-2xl bg-white mx-auto flex items-center justify-center" style="max-width: 100%; width: 500px; min-height: 400px;">
            <canvas id="canvasTarjeta" class="w-full h-auto shadow-md"></canvas>
        </div>
        <div id="contenedorQR" class="hidden"></div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <button onclick="descargarImagen()" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 text-sm flex items-center justify-center">
                <i class="fas fa-file-image mr-2 text-lg"></i> Bajar Tarjeta
            </button>
            <button onclick="descargarSoloQR()" class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold hover:bg-slate-900 transition shadow-lg shadow-slate-200 text-sm flex items-center justify-center">
                <i class="fas fa-qrcode mr-2 text-lg"></i> Bajar Solo QR
            </button>
            <button onclick="compartirPorWhatsApp()" class="w-full bg-[#25D366] text-white py-3.5 rounded-xl font-bold hover:bg-[#128C7E] transition shadow-lg shadow-green-200 text-sm flex items-center justify-center">
                <i class="fab fa-whatsapp mr-2 text-lg"></i> Enviar por WhatsApp
            </button>
            <button onclick="cerrarModalQR()" class="w-full bg-slate-100 text-slate-600 py-3.5 rounded-xl font-bold hover:bg-slate-200 transition text-sm">
                Cerrar
            </button>
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;600;800&family=Libre+Baskerville:ital@0;1&family=Playfair+Display:ital,wght@0,600;1,600&family=Montserrat:wght@400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

<script>
    let currentData = { nombre: '', url: '', plantilla: '', foto: '', tipo: '', fecha: '', bio: '' };

    function prepararModalQR(boton) {
        const nombre = boton.getAttribute('data-nombre');
        const url = boton.getAttribute('data-url');
        const plantilla = boton.getAttribute('data-plantilla');
        const foto = boton.getAttribute('data-foto');
        const tipo = boton.getAttribute('data-tipo');
        const fecha = boton.getAttribute('data-fecha');
        const bio = boton.getAttribute('data-bio');

        abrirModalQR(nombre, url, plantilla, foto, tipo, fecha, bio);
    }

    function abrirModalQR(nombre, url, plantilla, foto, tipo, fecha, bio) {
        currentData = { nombre, url, plantilla, foto, tipo, fecha, bio };
        document.getElementById('modalTitulo').innerText = nombre;
        const contenedor = document.getElementById('contenedorQR');
        contenedor.innerHTML = "";
        
        new QRCode(contenedor, {
            text: url, width: 800, height: 800, colorDark : "#000000", colorLight : "#ffffff", correctLevel : QRCode.CorrectLevel.H
        });
        
        setTimeout(() => {
            generarTarjetaCanvas();
            document.getElementById('modalQR').classList.remove('hidden');
        }, 500);
    }

    async function generarTarjetaCanvas() {
        const canvas = document.getElementById('canvasTarjeta');
        const ctx = canvas.getContext('2d');
        
        let tipoNormalizado = currentData.tipo.toLowerCase().trim();
        let theme = 'matrimonio'; 
        
        if (tipoNormalizado.includes('memorial')) theme = 'memorial';
        else if (tipoNormalizado.includes('corp') || tipoNormalizado.includes('empresa')) theme = 'corporativo';

        // ==============================================
        // TAMAÑOS DINÁMICOS DEL LIENZO
        // ==============================================
        if (theme === 'matrimonio') {
            canvas.width = 2000;  // Horizontal y elegante
            canvas.height = 1700;
        } else if (theme === 'corporativo') {
            canvas.width = 1920;  // Vertical
            canvas.height = 1300;
        } else {
            canvas.width = 1080;  // Memorial original vertical (Este es el default)
            canvas.height = 2100;
        }
        const estilos = {
            'matrimonio': { 
                bg: '#FCFAF8', text: '#2C3E50', accent: '#C5A880', 
                titleFont: 'Great Vibes', font: 'Montserrat', 
                topText: 'N U E S T R A   B O D A',
                actionText: 'ESCANEA PARA ACOMPAÑARNOS'
            },
            'memorial': { 
                bg: '#FDFCF8', text: '#111827', accent: '#475569', 
                titleFont: 'Great Vibes', font: 'Inter',
                topText: 'EN MEMORIA DE', actionText: 'ESCANEA PARA VER EL HOMENAJE'
            },
            'corporativo': { 
                bg: '#0F172A', text: '#FFFFFF', accent: '#38BDF8', 
                titleFont: 'Lexend', font: 'Inter', 
                topText: 'BUSINESS SUMMIT', actionText: 'ESCANEA PARA REGISTRO'
            }
        };

        const style = estilos[theme];

        // 1. Fondo base
        ctx.fillStyle = style.bg;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // ==============================================
        // TEMA 1: MATRIMONIO (HORIZONTAL CREATIVO)
        // ==============================================
        if (theme === 'matrimonio') {
            
            // FOTO EN LA MITAD IZQUIERDA CON CORTE DIAGONAL
            if (currentData.foto) {
                try {
                    const foto = await cargarImagen(currentData.foto);
                    let imgW = 900; 
                    let imgH = canvas.height;
                    
                    const ratio = Math.max(imgW / foto.width, imgH / foto.height);
                    const drawW = foto.width * ratio; const drawH = foto.height * ratio;
                    const drawX = (imgW - drawW) / 2; const drawY = (imgH - drawH) / 2;

                    ctx.save();
                    // Clip diagonal elegante
                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.lineTo(850, 0);
                    ctx.lineTo(650, canvas.height);
                    ctx.lineTo(0, canvas.height);
                    ctx.closePath();
                    ctx.clip(); 
                    
                    ctx.drawImage(foto, drawX, drawY, drawW, drawH);
                    ctx.restore();

                    // Línea dorada separadora en la diagonal
                    ctx.beginPath();
                    ctx.moveTo(850, 0);
                    ctx.lineTo(650, canvas.height);
                    ctx.strokeStyle = style.accent;
                    ctx.lineWidth = 8;
                    ctx.stroke();

                } catch (e) { console.error("Error foto matrimonio", e); }
            }

            // CONTENIDO A LA DERECHA (Centrado en el espacio restante)
            let centerX = 1335; // Centro del lado derecho
            let currentY = 180;

            // Anillos
            ctx.strokeStyle = style.accent; 
            ctx.lineWidth = 3;
            ctx.beginPath(); ctx.arc(centerX - 20, currentY, 22, 0, Math.PI * 2); ctx.stroke();
            ctx.beginPath(); ctx.arc(centerX + 20, currentY, 22, 0, Math.PI * 2); ctx.stroke();
            
            // Texto superior
            currentY += 70;
            ctx.textAlign = "center"; 
            ctx.fillStyle = style.accent;
            ctx.font = `bold 24px ${style.font}`; 
            ctx.fillText(style.topText, centerX, currentY);

            // Nombres de los novios
            currentY += 130;
            ctx.fillStyle = style.text;
            let fontSize = currentData.nombre.length > 20 ? 110 : 150;
            ctx.font = `${fontSize}px ${style.titleFont}`;
            const numLines = wrapText(ctx, currentData.nombre, centerX, currentY, 900, 140, true);
            currentY += (numLines * 140);

            // Línea separadora
            ctx.beginPath(); ctx.moveTo(centerX - 100, currentY - 50); ctx.lineTo(centerX + 100, currentY - 50); 
            ctx.strokeStyle = style.accent; ctx.lineWidth = 2; ctx.stroke();

            // Fecha
            ctx.fillStyle = hexToRgba(style.text, 0.7);
            ctx.font = `500 32px ${style.font}`;
            ctx.fillText(currentData.fecha.toUpperCase(), centerX, currentY + 10);
            
            // Bio
            if (currentData.bio) {
                currentY += 70;
                ctx.fillStyle = hexToRgba(style.text, 0.6);
                ctx.font = `italic 28px ${style.font}`;
                const bioLines = wrapText(ctx, `"${currentData.bio}"`, centerX, currentY, 700, 40, true);
                currentY += (bioLines * 40);
            }

            // CÓDIGO QR Y CTA (Centrado abajo a la derecha)
            const qrCanvas = document.querySelector('#contenedorQR canvas');
            if (qrCanvas) {
                const qrSize = 250;
                const x = centerX - (qrSize / 2);
                const y = Math.max(currentY + 40, 720); 

                ctx.fillStyle = "#FFFFFF";
                ctx.shadowColor = "rgba(0,0,0,0.05)"; ctx.shadowBlur = 15;
                roundRect(ctx, x - 15, y - 15, qrSize + 30, qrSize + 30, 15, true);
                ctx.shadowBlur = 0;

                ctx.strokeStyle = style.accent; ctx.lineWidth = 1; ctx.stroke();
                ctx.drawImage(qrCanvas, x, y, qrSize, qrSize);

                ctx.fillStyle = style.text; 
                ctx.font = `bold 22px ${style.font}`;
                ctx.fillText(style.actionText, centerX, y + qrSize + 55);
            }
        }

        // ==============================================
        // TEMA 2: CORPORATIVO (HORIZONTAL MODERNO)
        // ==============================================
        else if (theme === 'corporativo') {
            
            // Fondo Base oscuro
            ctx.fillStyle = style.bg;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let rightCenterX = 1410; // Centro exacto de la mitad derecha (textos y logo)
            let leftCenterX = 450;   // Centro exacto de la mitad izquierda (código QR)
            let currentY = 120;      // Margen superior para centrar verticalmente a la derecha

            // Línea neón separadora en la diagonal
            ctx.beginPath();
            ctx.moveTo(850, 0);
            ctx.lineTo(950, canvas.height);
            ctx.strokeStyle = style.accent;
            ctx.lineWidth = 10;
            ctx.stroke();

            // 1. DERECHA: LOGO COMPLETO CENTRADO (Arriba de BUSINESS SUMMIT)
            if (currentData.foto) {
                try {
                    const foto = await cargarImagen(currentData.foto);
                    let logoMaxW = 450; 
                    let logoMaxH = 200;
                    
                    // Usamos Math.min para que el logo encaje perfecto sin cortarse
                    const logoRatio = Math.min(logoMaxW / foto.width, logoMaxH / foto.height);
                    const logoW = foto.width * logoRatio; 
                    const logoH = foto.height * logoRatio;
                    const logoX = rightCenterX - (logoW / 2); 
                    const logoY = currentY;

                    ctx.drawImage(foto, logoX, logoY, logoW, logoH);
                    
                    currentY += logoH + 50; // Espacio debajo del logo
                } catch (e) { console.error("Error foto corporativo", e); }
            }

            // 2. DERECHA: Texto superior (BUSINESS SUMMIT)
            ctx.textAlign = "center"; 
            ctx.fillStyle = style.accent;
            ctx.font = `bold 28px ${style.font}`; 
            ctx.fillText(style.topText, rightCenterX, currentY);

            // 3. DERECHA: Titulo Principal
            currentY += 80;
            ctx.fillStyle = style.text;
            let fontSize = currentData.nombre.length > 20 ? 70 : 90;
            ctx.font = `bold ${fontSize}px ${style.titleFont}`;
            const numLines = wrapText(ctx, currentData.nombre.toUpperCase(), rightCenterX, currentY, 800, fontSize + 15, true);
            currentY += (numLines * (fontSize + 15));

            // 4. DERECHA: Fecha (Azul Neón)
            ctx.fillStyle = style.accent;
            ctx.font = `600 32px ${style.font}`;
            ctx.fillText(currentData.fecha.toUpperCase(), rightCenterX, currentY + 10);
            
            // 5. DERECHA: Bio
            if (currentData.bio) {
                currentY += 70;
                ctx.fillStyle = '#94A3B8';
                ctx.font = `400 28px ${style.font}`;
                const bioLines = wrapText(ctx, currentData.bio, rightCenterX, currentY, 700, 42, true);
                currentY += (bioLines * 42);
            }

            // 6. IZQUIERDA: CÓDIGO QR Y CTA (Centrado en el espacio azul oscuro)
            const qrCanvas = document.querySelector('#contenedorQR canvas');
            if (qrCanvas) {
                const qrSize = 360; // QR bien grande para escanear fácil
                const x = leftCenterX - (qrSize / 2);
                const y = (canvas.height / 2) - (qrSize / 2) - 40; // Centrado verticalmente a la izquierda

                ctx.fillStyle = "#FFFFFF";
                ctx.shadowColor = hexToRgba(style.accent, 0.5); 
                ctx.shadowBlur = 30;
                roundRect(ctx, x - 20, y - 20, qrSize + 40, qrSize + 40, 15, true);
                ctx.shadowBlur = 0;

                ctx.strokeStyle = style.accent; 
                ctx.lineWidth = 4; 
                ctx.stroke();
                
                ctx.drawImage(qrCanvas, x, y, qrSize, qrSize);

                ctx.fillStyle = "#FFFFFF"; 
                ctx.font = `bold 24px ${style.font}`;
                ctx.fillText(style.actionText, leftCenterX, y + qrSize + 70);
            }
        }

        // ==============================================
        // TEMA 3: MEMORIAL (TU DISEÑO APROBADO - INTACTO)
        // ==============================================
        else if (theme === 'memorial') {
            
            // 1. Fondo suave crema claro
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, '#FDFCF8');
            gradient.addColorStop(1, '#F0EBE1');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let currentY = 160;

            // 2. FOTO CIRCULAR (Centro Arriba)
            if (currentData.foto) {
                try {
                    const foto = await cargarImagen(currentData.foto);
                    let imgW = 480; 
                    let imgH = 480;
                    let imgX = (canvas.width - imgW) / 2;
                    let imgY = currentY;

                    const ratio = Math.max(imgW / foto.width, imgH / foto.height);
                    const drawW = foto.width * ratio; 
                    const drawH = foto.height * ratio;
                    const drawX = imgX + (imgW - drawW) / 2; 
                    const drawY = imgY + (imgH - drawH) / 2;

                    ctx.save();
                    ctx.beginPath();
                    ctx.arc(imgX + imgW/2, imgY + imgH/2, imgW/2, 0, Math.PI * 2, false);
                    ctx.closePath();
                    ctx.clip();
                    ctx.drawImage(foto, drawX, drawY, drawW, drawH);
                    ctx.restore();

                    // Borde circular sutil
                    ctx.strokeStyle = '#94A3B8'; 
                    ctx.lineWidth = 4;
                    ctx.beginPath();
                    ctx.arc(imgX + imgW/2, imgY + imgH/2, imgW/2, 0, Math.PI * 2, false);
                    ctx.stroke();

                    // Lazo de Luto sobre la foto (Abajo a la derecha)
                    ctx.save();
                    ctx.translate(imgX + imgW - 60, imgY + imgH - 50);
                    ctx.lineWidth = 26;
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';
                    ctx.strokeStyle = '#1a1a1a';
                    ctx.beginPath();
                    ctx.moveTo(-35, 60);
                    ctx.bezierCurveTo(-15, -60, 45, -90, 0, -90);
                    ctx.bezierCurveTo(-45, -90, 15, -60, 35, 60);
                    ctx.stroke();
                    // Reflejo interior del lazo
                    ctx.lineWidth = 4;
                    ctx.strokeStyle = 'rgba(255,255,255,0.4)';
                    ctx.stroke();
                    ctx.restore();

                    currentY += imgH + 80;
                } catch (e) { console.error("Error foto memorial", e); }
            } else {
                currentY += 100;
            }

            // 3. TEXTO "HONRANDO LA VIDA DE:"
            ctx.textAlign = "center";
            ctx.fillStyle = '#1E293B'; 
            ctx.font = `bold 30px 'Inter'`;
            ctx.fillText("HONRANDO LA VIDA DE:", canvas.width / 2, currentY);

            currentY += 100;

            // 4. NOMBRE EN CURSIVA GRANDE
            ctx.fillStyle = '#111827';
            let fontSize = currentData.nombre.length > 20 ? 90 : 120;
            ctx.font = `${fontSize}px 'Great Vibes'`;
            const lineasNombre = wrapText(ctx, currentData.nombre, canvas.width / 2, currentY, 900, 120, true);
            currentY += (lineasNombre * 120) + 30;

            // 5. FECHAS
            ctx.fillStyle = '#374151';
            ctx.font = `bold 30px 'Inter'`;
            ctx.fillText("📅 " + currentData.fecha.toUpperCase(), canvas.width / 2, currentY);

            currentY += 90;

            // 6. BIOGRAFÍA
            if (currentData.bio) {
                ctx.fillStyle = '#4B5563';
                ctx.font = `400 28px 'Inter'`;
                // Añadimos comillas si no las tiene para que parezca una cita
                const bioTexto = `"${currentData.bio.replace(/^"|"$/g, '')}"`;
                const bioLines = wrapText(ctx, bioTexto, canvas.width / 2, currentY, 840, 42, true);
                currentY += (bioLines * 42) + 60;
            }

            // 7. TEXTO ANTES DEL QR
            ctx.fillStyle = '#111827';
            ctx.font = `500 26px 'Inter'`;
            ctx.fillText(style.actionText, canvas.width / 2, currentY);

            currentY += 40;

            // 8. CÓDIGO QR
            const qrCanvas = document.querySelector('#contenedorQR canvas');
            if (qrCanvas) {
                const qrSize = 340;
                const x = (canvas.width - qrSize) / 2;
                const y = currentY; 

                ctx.fillStyle = "#FFFFFF";
                ctx.shadowColor = "rgba(0,0,0,0.08)";
                ctx.shadowBlur = 15;
                roundRect(ctx, x - 20, y - 20, qrSize + 40, qrSize + 40, 15, true);
                ctx.shadowBlur = 0;

                ctx.strokeStyle = '#E2E8F0'; 
                ctx.lineWidth = 2; 
                ctx.stroke();

                ctx.drawImage(qrCanvas, x, y, qrSize, qrSize);

                currentY += qrSize + 110;

                // 9. TEXTO INFERIOR
                ctx.fillStyle = '#1F2937';
                ctx.font = `bold 28px 'Inter'`;
                ctx.fillText("ACOMPÁÑANOS A CELEBRAR SU LEGADO", canvas.width / 2, currentY);
            }

        } 
    }

    function hexToRgba(hex, alpha) {
        let c = hex.substring(1);
        if(c.length === 3) c = c[0]+c[0]+c[1]+c[1]+c[2]+c[2];
        let r = parseInt(c.substring(0, 2), 16), g = parseInt(c.substring(2, 4), 16), b = parseInt(c.substring(4, 6), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    function cargarImagen(url) {
        return new Promise((resolve, reject) => {
            const img = new Image(); img.crossOrigin = "Anonymous"; img.src = url;
            img.onload = () => resolve(img); img.onerror = reject;
        });
    }

    function descargarImagen() {
        const canvas = document.getElementById('canvasTarjeta');
        const link = document.createElement('a');
        link.download = `Invitacion-${currentData.nombre}.png`;
        link.href = canvas.toDataURL("image/png", 1.0);
        link.click();
    }

    function descargarSoloQR() {
        const qrCanvas = document.querySelector('#contenedorQR canvas');
        if (qrCanvas) {
            const link = document.createElement('a');
            link.download = `QR-${currentData.nombre}.png`;
            link.href = qrCanvas.toDataURL("image/png", 1.0);
            link.click();
        } else {
            alert("No se pudo obtener el código QR en este momento.");
        }
    }

    function cerrarModalQR() { document.getElementById('modalQR').classList.add('hidden'); }
    
    function roundRect(ctx, x, y, width, height, radius, fill) {
        ctx.beginPath(); ctx.moveTo(x + radius, y); ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius); ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height); ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - radius); ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y); ctx.closePath(); if (fill) ctx.fill();
    }
    
    function wrapText(ctx, text, x, y, maxWidth, lineHeight, render) {
        if(!text) return 0;
        const words = text.split(' '); let line = ''; let lines = [];
        for (let n = 0; n < words.length; n++) {
            const testLine = line + words[n] + ' ';
            if (ctx.measureText(testLine).width > maxWidth && n > 0) { lines.push(line); line = words[n] + ' '; }
            else { line = testLine; }
        }
        lines.push(line);
        if (render) { for (let i = 0; i < lines.length; i++) { ctx.fillText(lines[i], x, y + (i * lineHeight)); } }
        return lines.length;
    }

    function mostrarLoaderSubida(formId) {
        document.getElementById('loaderSubidaNube').classList.remove('hidden');
        document.getElementById(formId).submit();
    }

   function compartirPorWhatsApp() {
        let nombreEvento = currentData.nombre;
        let urlInvitacion = currentData.url;
        let fechaEvento = currentData.fecha; 
        let tipoEvento = currentData.tipo ? currentData.tipo.toLowerCase().trim() : '';
        let mensajeWssp = '';

        if (tipoEvento.includes('matrimonio')) {
            mensajeWssp = `💍 *¡Nos casamos y queremos que seas parte de nuestra historia!* 💍\n\nTe invitamos a celebrar nuestra unión:\n🤍 *${nombreEvento}*\n`;
            if (fechaEvento) mensajeWssp += `📅 *Fecha:* ${fechaEvento}\n\n`;
            mensajeWssp += `Ingresa a nuestra invitación digital para conocer todos los detalles de la boda, ver nuestro itinerario y confirmar tu asistencia:\n👉 ${urlInvitacion}\n\n🎟️ *Importante:* Recuerda que al confirmar en el enlace, recibirás tu código de acceso para entrar a la fiesta. ¡No faltes!`;
        } 
        else if (tipoEvento.includes('corporativo') || tipoEvento.includes('empresa')) {
            mensajeWssp = `🏢 *Invitación a Evento Exclusivo* 🏢\n\nTenemos el honor de invitarle a nuestro próximo encuentro corporativo:\n✨ *${nombreEvento}*\n`;
            if (fechaEvento) mensajeWssp += `📅 *Fecha:* ${fechaEvento}\n\n`;
            mensajeWssp += `Le solicitamos ingresar al siguiente portal para revisar la agenda ejecutiva, los detalles de la ubicación y confirmar su asistencia:\n🔗 ${urlInvitacion}\n\n📌 *Nota:* El registro es obligatorio. Al confirmar su presencia, el sistema le emitirá sus credenciales de acceso.`;
        } 
        else if (tipoEvento.includes('memorial')) {
            mensajeWssp = `🕊️ *En Homenaje y Recuerdo* 🕊️\n\nTe invitamos a acompañarnos en la ceremonia en memoria de:\n🤍 *${nombreEvento}*\n`;
            if (fechaEvento) mensajeWssp += `📅 *Fecha:* ${fechaEvento}\n\n`;
            mensajeWssp += `Ingresa al siguiente enlace para ver los detalles de la ceremonia, la ubicación y plasmar tus palabras en nuestro libro de condolencias digital:\n👉 ${urlInvitacion}\n\nAgradecemos profundamente tu compañía y apoyo en estos momentos.`;
        } 
        else {
            mensajeWssp = `✨ *¡Tienes una invitación muy especial!* ✨\n\nTe esperamos en:\n🎉 *${nombreEvento}*\n`;
            if (fechaEvento) mensajeWssp += `📅 *Fecha:* ${fechaEvento}\n\n`;
            mensajeWssp += `Confirma tu asistencia y revisa los detalles ingresando aquí:\n👉 ${urlInvitacion}`;
        }

        const canvas = document.getElementById('canvasTarjeta');
        
        canvas.toBlob(async (blob) => {
            const file = new File([blob], `Invitacion-${nombreEvento}.png`, { type: 'image/png' });
            
            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                try {
                    await navigator.share({ title: nombreEvento, text: mensajeWssp, files: [file] });
                    return; 
                } catch (err) { console.log('Acción nativa cancelada.', err); }
            }

            let urlFinal = `https://wa.me/?text=${encodeURIComponent(mensajeWssp)}`;
            
            try {
                await navigator.clipboard.write([ new ClipboardItem({ [blob.type]: blob }) ]);
                alert("¡Imagen copiada al portapapeles! 📋\n\nSe abrirá WhatsApp Web. Solo haz clic en el chat y presiona 'Pegar' (Ctrl+V) para enviar la tarjeta gráfica junto con el texto.");
            } catch (err) {
                console.log("No se pudo copiar al portapapeles", err);
                descargarImagen();
                alert("Hemos descargado la tarjeta a tus archivos. Se abrirá WhatsApp para que pegues el texto y adjuntes la imagen manualmente.");
            }

            window.open(urlFinal, '_blank');
        }, 'image/png');
    }
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
</style>
@endsection