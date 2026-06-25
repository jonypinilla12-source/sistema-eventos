<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trivia | {{ $evento->nombre_evento }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f7f3f0; color: #333; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .animate-pop { animation: popIn 0.3s ease-out forwards; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.97); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white max-w-xl w-full rounded-2xl shadow-xl border border-stone-100 p-6 md:p-10 relative overflow-hidden">
        
        {{-- PANTALLA 1: BIENVENIDA / INTRODUCCIÓN --}}
        <div id="pantalla-inicio" class="text-center space-y-6 animate-pop">
            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto shadow-xs border border-amber-100">
                <i class="fas fa-gamepad text-2xl text-amber-500"></i>
            </div>
            <span class="text-xs uppercase tracking-widest text-amber-600 font-bold block">Trivia del Evento</span>
            <h1 class="text-3xl font-serif text-slate-800">¡Hola, {{ $invitado->nombre_invitado }}!</h1>
            <p class="text-slate-500 text-sm leading-relaxed">Demuestra qué tanto conoces a los anfitriones. Responderás un total de <strong class="text-slate-700">{{ $evento->juegoPreguntas->count() }} preguntas</strong> de trivia. ¡Cada segundo cuenta para el ranking!</p>
            
            <button onclick="comenzarJuego()" class="w-full bg-slate-800 text-white py-4 rounded-xl font-bold uppercase tracking-wider text-xs hover:bg-slate-900 transition shadow-md">
                Comenzar a Jugar
            </button>
        </div>

        {{-- PANTALLA 2: JUEGO EN PROGRESO --}}
        <div id="pantalla-juego" class="hidden space-y-6 animate-pop">
            {{-- Barra superior de estado --}}
            <div class="flex justify-between items-center text-xs font-semibold uppercase tracking-wider text-slate-400 border-b pb-4">
                <span id="info-progreso">Pregunta 1 de X</span>
                <span class="text-amber-600"><i class="fas fa-clock mr-1"></i> Tiempo: <span id="info-cronometro" class="font-mono text-sm font-bold">0s</span></span>
            </div>

            {{-- Enunciado de la Pregunta --}}
            <h2 id="texto-pregunta" class="text-xl font-serif text-slate-800 leading-snug">Cargando pregunta...</h2>

            {{-- Listado Dinámico de Alternativas --}}
            <div class="space-y-3 pt-2">
                <button onclick="seleccionarOpcion('a')" id="btn-opcion-a" class="w-full text-left p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm flex items-center space-x-3">
                    <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-bold text-slate-500">A</span>
                    <span id="texto-opcion-a">Opción A</span>
                </button>
                <button onclick="seleccionarOpcion('b')" id="btn-opcion-b" class="w-full text-left p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm flex items-center space-x-3">
                    <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-bold text-slate-500">B</span>
                    <span id="texto-opcion-b">Opción B</span>
                </button>
                <button onclick="seleccionarOpcion('c')" id="btn-opcion-c" class="w-full text-left p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm flex items-center space-x-3">
                    <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-bold text-slate-500">C</span>
                    <span id="texto-opcion-c">Opción C</span>
                </button>
                <button onclick="seleccionarOpcion('d')" id="btn-opcion-d" class="w-full text-left p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm flex items-center space-x-3">
                    <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-bold text-slate-500">D</span>
                    <span id="texto-opcion-d">Opción D</span>
                </button>
            </div>
        </div>

        {{-- PANTALLA 3: FIN DEL JUEGO / ENVIANDO RESULTADOS --}}
        <div id="pantalla-final" class="hidden text-center space-y-6 animate-pop py-4">
            <div id="wrapper-status-final">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto border mb-4">
                    <i class="fas fa-spinner fa-spin text-xl text-slate-400"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Sincronizando puntuación...</h3>
                <p class="text-xs text-slate-400 font-light">Guardando tu récord en el servidor del evento.</p>
            </div>
        </div>

    </div>

    <script>
        const bancoPreguntas = @json($evento->juegoPreguntas);
        
        let preguntaActualIndex = 0;
        let puntajeAcumulado = 0;
        let tiempoInicio;
        let intervaloCronometro;
        let segundosTranscurridos = 0;

        function comenzarJuego() {
            document.getElementById('pantalla-inicio').classList.add('hidden');
            document.getElementById('pantalla-juego').classList.remove('hidden');
            
            tiempoInicio = Date.now();
            intervaloCronometro = setInterval(() => {
                segundosTranscurridos = Math.floor((Date.now() - tiempoInicio) / 1000);
                document.getElementById('info-cronometro').innerText = segundosTranscurridos + 's';
            }, 1000);

            renderizarPregunta();
        }

        function renderizarPregunta() {
            if (bancoPreguntas.length === 0) return;
            
            const q = bancoPreguntas[preguntaActualIndex];
            
            document.getElementById('info-progreso').innerText = `Pregunta ${preguntaActualIndex + 1} de ${bancoPreguntas.length}`;
            document.getElementById('texto-pregunta').innerText = q.pregunta;
            document.getElementById('texto-opcion-a').innerText = q.opcion_a;
            document.getElementById('texto-opcion-b').innerText = q.opcion_b;
            document.getElementById('texto-opcion-c').innerText = q.opcion_c;
            document.getElementById('texto-opcion-d').innerText = q.opcion_d;
        }

        function seleccionarOpcion(opcionElegida) {
            const q = bancoPreguntas[preguntaActualIndex];
            
            if (opcionElegida === q.respuesta_correcta) {
                puntajeAcumulado += parseInt(q.puntos);
            }

            preguntaActualIndex++;
            if (preguntaActualIndex < bancoPreguntas.length) {
                renderizarPregunta();
            } else {
                finalizarTrivia();
            }
        }

        function finalizarTrivia() {
            clearInterval(intervaloCronometro);

            document.getElementById('pantalla-juego').classList.add('hidden');
            document.getElementById('pantalla-final').classList.remove('hidden');

            const tokenCsrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            // Enviamos el nombre del jugador para cumplir con las restricciones NOT NULL de la tabla
            const payload = {
                evento_id: "{{ $evento->evento_id }}",
                invitado_id: "{{ $invitado->invitado_id }}",
                nombre_jugador: "{{ $invitado->nombre_invitado }}", // Añadido para la base de datos
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
                const contenedor = document.getElementById('wrapper-status-final');
                if (data && data.success) {
                    contenedor.innerHTML = `
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto border border-emerald-100 mb-4 shadow-sm animate-bounce">
                            <i class="fas fa-trophy text-2xl text-emerald-500"></i>
                        </div>
                        <h3 class="text-2xl font-serif text-slate-800">¡Trivia Completada!</h3>
                        <p class="text-sm text-slate-500 max-w-xs mx-auto leading-relaxed">Tus respuestas han sido procesadas de forma exitosa.</p>
                        
                        <div class="grid grid-cols-2 gap-3 bg-slate-50 p-4 border border-slate-100 rounded-xl max-w-xs mx-auto font-sans">
                            <div class="text-left border-r pr-2">
                                <span class="block text-[10px] uppercase font-bold text-slate-400">Puntaje Total</span>
                                <span class="text-xl font-black text-slate-800">${puntajeAcumulado} pts</span>
                            </div>
                            <div class="text-left pl-2">
                                <span class="block text-[10px] uppercase font-bold text-slate-400">Tiempo Récord</span>
                                <span class="text-xl font-black text-slate-800">${segundosTranscurridos} seg</span>
                            </div>
                        </div>

                        <div class="pt-6">
                            <a href="/invitacion/{{ $evento->slug }}" class="inline-block px-8 py-3 bg-slate-800 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-slate-900 transition shadow-md">Volver al Inicio</a>
                        </div>
                    `;
                } else {
                    contenedor.innerHTML = `<p class="text-rose-500 font-bold"><i class="fas fa-times-circle mr-1"></i> Error al guardar la puntuación.</p>`;
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('wrapper-status-final').innerHTML = `<p class="text-rose-500 font-bold"><i class="fas fa-exclamation-triangle mr-1"></i> Error de conexión con el servidor.</p>`;
            });
        }
    </script>
</body>
</html>