@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    
    {{-- Encabezado --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('eventos.index') }}" class="text-slate-500 hover:text-indigo-600 transition text-sm flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i> Volver al panel
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Lista de Invitados Confirmados</h1>
            <p class="text-slate-500 text-sm">Monitorea los asistentes para el evento: <strong class="text-slate-700">{{ $evento->nombre_evento }}</strong></p>
        </div>

        {{-- Panel derecho: Botón Masivo y Contador --}}
        <div class="flex items-center gap-4">
            {{-- BOTÓN: ENVIAR A TODOS --}}
            @if($evento->invitados->whereNotNull('email')->count() > 0)
                <button onclick="enviarClaveATodos(this, '{{ $evento->evento_id }}')" class="group bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-indigo-200 flex items-center">
                    <span class="icono-btn-todos"><i class="fas fa-paper-plane mr-2 group-hover:animate-bounce"></i></span>
                    <span class="texto-btn-todos">Enviar a Todos</span>
                </button>
            @endif

            {{-- Contador rápido --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-5 py-3 text-right">
                <span class="block text-xs font-semibold text-indigo-600 uppercase tracking-wider">Total Confirmados</span>
                <span class="text-2xl font-black text-indigo-900">{{ $evento->invitados->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Contenedor de la Tabla --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="font-bold text-slate-700 flex items-center">
                <i class="fa-solid fa-users text-indigo-500 mr-2"></i> Control de Asistencia (Rsvp)
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6">Clave / Código</th>
                        <th class="py-4 px-6">Nombre Completo</th>
                        <th class="py-4 px-6">Correo Electrónico</th>
                        <th class="py-4 px-6">Mesa Asignada</th>
                        <th class="py-4 px-6">Fecha de Confirmación</th>
                        <th class="py-4 px-6 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($evento->invitados as $invitado)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono text-xs font-bold text-indigo-600">{{ $invitado->numero_invitado ?? '-' }}</td>
                            <td class="py-4 px-6 font-semibold text-slate-800">{{ $invitado->nombre_invitado }}</td>
                            <td class="py-4 px-6 font-mono text-xs text-slate-500">{{ $invitado->email ? $invitado->email : 'No registrado' }}</td>
                            <td class="py-4 px-6">
                                <span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium">{{ $invitado->mesa_asignada ?? 'Por asignar' }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-xs">
                                {{ $invitado->fecha_confirmacion ? \Carbon\Carbon::parse($invitado->fecha_confirmacion)->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                            
                            {{-- 🔥 COLUMNA DE ACCIONES ACTUALIZADA CON WHATSAPP 🔥 --}}
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    
                                    {{-- Lógica del mensaje de WhatsApp --}}
                                    @php
                                        $esMemorial = strtolower($evento->tipo->nombre) === 'memorial';
                                        
                                        // Armamos la URL base (Si no es memorial, le pegamos el token general del evento para que puedan ver la info)
                                        $urlInvitacion = route('eventos.show', $evento->slug) . ($esMemorial ? '' : '?token=' . $evento->token_invitacion_general);
                                        
                                        $mensajeWssp = "¡Hola *" . trim($invitado->nombre_invitado) . "*! 👋\n\n";
                                        
                                        if ($esMemorial) {
                                            $mensajeWssp .= "Te comparto el acceso al homenaje de *" . trim($evento->nombre_evento) . "*.\n\n";
                                            $mensajeWssp .= "📍 *Enlace:* " . $urlInvitacion . "\n\n";
                                            $mensajeWssp .= "Tu clave personal para firmar el libro es: *" . ($invitado->numero_invitado ?? '') . "*";
                                        } else {
                                            $mensajeWssp .= "Aquí tienes tus accesos para *" . trim($evento->nombre_evento) . "*.\n\n";
                                            $mensajeWssp .= "📍 *Enlace:* " . $urlInvitacion . "\n\n";
                                            $mensajeWssp .= "🎫 *Tu Código Personal:* " . ($invitado->numero_invitado ?? '') . "\n";
                                            $mensajeWssp .= "🪑 *Asiento/Mesa:* " . ($invitado->mesa_asignada ?? 'General') . "\n\n";
                                            $mensajeWssp .= "Guarda este código para participar en las dinámicas del evento.";
                                        }
                                        
                                        $urlWhatsapp = "https://wa.me/?text=" . urlencode($mensajeWssp);
                                    @endphp

                                    {{-- Botón de WhatsApp --}}
                                    <a href="{{ $urlWhatsapp }}" target="_blank" title="Enviar Accesos por WhatsApp" class="group bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white transition-all duration-300 px-3 py-1.5 rounded-lg text-[10px] font-bold tracking-wide uppercase flex items-center shadow-sm">
                                        <i class="fab fa-whatsapp text-sm mr-1.5 group-hover:scale-110 transition-transform"></i>
                                        <span>WhatsApp</span>
                                    </a>

                                    {{-- Botón de Correo Original --}}
                                    @if($invitado->email)
                                        <button onclick="enviarClave(this, '{{ $invitado->invitado_id }}')" title="Enviar Recordatorio por Correo" class="group bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white transition-all duration-300 px-3 py-1.5 rounded-lg text-[10px] font-bold tracking-wide uppercase flex items-center shadow-sm">
                                            <span class="icono-btn"><i class="fa-regular fa-envelope mr-1.5 group-hover:animate-bounce"></i></span>
                                            <span class="texto-btn">Correo</span>
                                        </button>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 flex items-center">
                                            <i class="fa-solid fa-envelope-circle-xmark mr-1"></i> Sin email
                                        </span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 font-light space-y-2">
                                <i class="fa-regular fa-address-book text-4xl block text-slate-200"></i>
                                <p class="text-sm font-semibold text-slate-500">No hay invitados confirmados aún</p>
                                <p class="text-xs">Cuando las personas escaneen el QR del matrimonio y confirmen su asistencia, aparecerán en esta lista.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // --- FUNCIÓN ORIGINAL: ENVIAR A UN SOLO INVITADO ---
    function enviarClave(boton, invitadoId) {
        const icono = boton.querySelector('.icono-btn');
        const texto = boton.querySelector('.texto-btn');
        const contenidoOriginal = boton.innerHTML;

        boton.disabled = true;
        boton.classList.replace('hover:bg-indigo-600', 'cursor-wait');
        icono.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1.5"></i>';
        texto.innerText = 'Enviando...';

        fetch(`/invitados/${invitadoId}/recordar-clave`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                boton.classList.replace('bg-indigo-50', 'bg-emerald-50');
                boton.classList.replace('text-indigo-600', 'text-emerald-600');
                icono.innerHTML = '<i class="fas fa-check-circle mr-1.5"></i>';
                texto.innerText = 'Enviado';
                
                setTimeout(() => {
                    boton.disabled = false;
                    boton.classList.replace('bg-emerald-50', 'bg-indigo-50');
                    boton.classList.replace('text-emerald-600', 'text-indigo-600');
                    boton.classList.replace('cursor-wait', 'hover:bg-indigo-600');
                    boton.innerHTML = contenidoOriginal;
                }, 3000);
            } else {
                throw new Error('Error en el envío');
            }
        })
        .catch(error => {
            boton.classList.replace('bg-indigo-50', 'bg-rose-50');
            boton.classList.replace('text-indigo-600', 'text-rose-600');
            icono.innerHTML = '<i class="fas fa-exclamation-circle mr-1.5"></i>';
            texto.innerText = 'Error';
            
            setTimeout(() => {
                boton.disabled = false;
                boton.classList.replace('bg-rose-50', 'bg-indigo-50');
                boton.classList.replace('text-rose-600', 'text-indigo-600');
                boton.innerHTML = contenidoOriginal;
            }, 3000);
        });
    }

    // --- FUNCIÓN ORIGINAL: ENVIAR A TODOS ---
    function enviarClaveATodos(boton, eventoId) {
        if(!confirm('¿Estás seguro de enviar el recordatorio de clave a TODOS los invitados que tienen correo registrado?')) {
            return;
        }

        const icono = boton.querySelector('.icono-btn-todos');
        const texto = boton.querySelector('.texto-btn-todos');
        const contenidoOriginal = boton.innerHTML;

        boton.disabled = true;
        boton.classList.replace('hover:bg-indigo-700', 'cursor-wait');
        icono.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>';
        texto.innerText = 'Enviando a todos...';

        fetch(`/eventos/${eventoId}/recordar-claves-masivo`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                boton.classList.replace('bg-indigo-600', 'bg-emerald-500');
                icono.innerHTML = '<i class="fas fa-check-double mr-2"></i>';
                texto.innerText = data.message || '¡Correos Enviados!';
                
                setTimeout(() => {
                    boton.disabled = false;
                    boton.classList.replace('bg-emerald-500', 'bg-indigo-600');
                    boton.classList.replace('cursor-wait', 'hover:bg-indigo-700');
                    boton.innerHTML = contenidoOriginal;
                }, 4000);
            } else {
                throw new Error(data.message || 'Error en el envío');
            }
        })
        .catch(error => {
            boton.classList.replace('bg-indigo-600', 'bg-rose-500');
            icono.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>';
            texto.innerText = 'Fallo en envío masivo';
            
            setTimeout(() => {
                boton.disabled = false;
                boton.classList.replace('bg-rose-500', 'bg-indigo-600');
                boton.innerHTML = contenidoOriginal;
            }, 4000);
        });
    }
</script>
@endsection