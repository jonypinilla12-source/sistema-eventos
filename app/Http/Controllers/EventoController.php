<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\User;
use App\Models\TipoEvento;
use Illuminate\Http\Request;
use App\Models\Invitado;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioClaveMail;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\CredencialesAnfitrionMail;

class EventoController extends Controller
{
    public function index()
    {
        $usuarioActual = auth()->user();

        // Verificamos si es Admin (asumiendo que rol_id == 1 es Administrador)
        if ($usuarioActual->rol_id == 1) {
            // El Admin ve TODOS los eventos
            $eventos = Evento::with(['usuario', 'tipo', 'invitados', 'fotosGaleria'])->get();
        } else {
            // El Anfitrión solo ve SUS eventos
            $eventos = Evento::with(['usuario', 'tipo', 'invitados', 'fotosGaleria'])
                             ->where('anfitrion_id', $usuarioActual->usuario_id)
                             ->get();
        }

        return view('Eventos.Index', compact('eventos'));
    }

    public function create()
    {
        $usuarios = User::all();
        $tipos = TipoEvento::all();
        return view('Eventos.Create', compact('usuarios', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_evento' => 'required|max:255',
            'anfitrion_id'  => 'required|exists:usuarios,usuario_id',
            'tipo_evento_id' => 'required|exists:tipos_evento,tipo_evento_id',
            'fecha_principal' => 'required|date',
            'fecha_nacimiento' => 'nullable|date',
            'biografia_resumen' => 'nullable|string',
            'ubicacion_texto' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'id_plantilla' => 'nullable|string',
            'hora' => 'nullable|date_format:H:i'
        ]);

        // --- LÓGICA CLOUD: CARPETA AUTOMÁTICA EN ONEDRIVE ---
        $tokenEspecial = bin2hex(random_bytes(4)); // Ej: 'e83a21b4'
        $folderIdOneDrive = null;

        try {
            // Inicializamos el servicio de OneDrive para crear la carpeta madre
            $oneDrive = new \App\Services\OneDriveService();
            $folderIdOneDrive = $oneDrive->crearCarpetaRaizEvento($request->nombre_evento, $tokenEspecial);
            
            // Si retorna null, dejamos un rastro en los logs para saber en qué punto falló
            if (!$folderIdOneDrive) {
                \Illuminate\Support\Facades\Log::warning('OneDrive: La API no retornó un ID de carpeta válido para el evento: ' . $request->nombre_evento);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OneDrive Exception al crear evento: ' . $e->getMessage());
        }

        // Datos del formulario fusionados con el ID (venga con código o null)
        $datosEvento = $request->all();
        $datosEvento['onedrive_folder_id'] = $folderIdOneDrive; 

        // Creamos el evento en la base de datos
        Evento::create($datosEvento);

        // Si falló el almacenamiento cloud, avisamos sutilmente al administrador
        $mensajeExito = $folderIdOneDrive 
            ? 'Evento y carpeta en la nube creados con éxito.' 
            : 'Evento creado localmente, pero hubo un inconveniente al generar la carpeta en OneDrive. Revisa los logs de Laravel.';

        return redirect()->route('eventos.index')->with('exito', $mensajeExito);
    }

    public function show(Request $request, $slug)
    {
        // 1. Cargamos el evento con sus relaciones base
        $evento = Evento::with(['fotosGaleria', 'itinerarios', 'tipo'])
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. 🔥 CONSULTA EN TIEMPO REAL: Le preguntamos a OneDrive qué fotos existen físicamente en la nube
        $fotosNubeRealtime = [];
        if ($evento->onedrive_folder_id) {
            try {
                $oneDrive = new \App\Services\OneDriveService();
                $fotosNubeRealtime = $oneDrive->obtenerArchivosNubeTiempoReal($evento->onedrive_folder_id);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error cargando tiempo real OneDrive: ' . $e->getMessage());
            }
        }

        // Capturamos el token que viene en la URL (?token=...)
        $tokenUrl = $request->query('token');

        // Normalizamos el tipo de evento
        $tipoEvento = strtolower($evento->tipo->nombre);

        // Inicializamos la variable del muro para evitar errores de "undefined variable"
        $interaccionesAprobadas = collect();

        // 3. Validamos el acceso y cargamos datos dinámicos según el tipo de evento
        if ($tipoEvento === 'memorial') {
            // SOLO los memoriales entran directo sin restricciones de token
            $invitado = null;

            // Buscamos las dedicatorias autorizadas
            $interaccionesAprobadas = \App\Models\Interaccion::where('evento_id', $evento->evento_id)
                                             ->where('aprobado', 1)
                                             ->orderBy('interaccion_id', 'desc')
                                             ->get();
        } else {
            // PARA MATRIMONIOS Y CORPORATIVOS: Verificamos el Token de la URL
            if ($tokenUrl && $tokenUrl === $evento->token_invitacion_general) {
                $invitado = (object)[
                    'token_acceso' => $evento->token_invitacion_general,
                    'mesa_asignada' => 'General'
                ];
            } else {
                // Si entra sin Token o con token incorrecto
                $invitado = (object)[
                    'token_acceso' => 'INVITADO-GENERAL',
                    'mesa_asignada' => 'Por definir'
                ];
            }

            // Si es MATRIMONIO, también necesitamos cargar el muro de deseos
            if ($tipoEvento === 'matrimonio') {
                $interaccionesAprobadas = \App\Models\Interaccion::where('evento_id', $evento->evento_id)
                                             ->where('aprobado', 1)
                                             ->orderBy('interaccion_id', 'desc')
                                             ->get();
            }
        }

        // 4. Mapeo de plantillas Blade
        $mapaVistas = [
            'Matrimonio'   => 'Plantillas.Matrimonio',
            'Matrimonio2'  => 'Plantillas.Matrimonio2',
            'Matrimonio3'  => 'Plantillas.Matrimonio3',
            'Matrimonio4'  => 'Plantillas.Matrimonio4',
            'Matrimonio5'  => 'Plantillas.Matrimonio5',
            'Matrimonio6'  => 'Plantillas.Matrimonio6',
            'Matrimonio7'  => 'Plantillas.Matrimonio7', 
            'Matrimonio8'  => 'Plantillas.Matrimonio8',
            'Matrimonio9'  => 'Plantillas.Matrimonio9',
            'Matrimonio10' => 'Plantillas.Matrimonio10',
            'Memorial'     => 'Plantillas.Memorial',
            'Memorial2'    => 'Plantillas.Memorial2',
            'Memorial3'    => 'Plantillas.Memorial3',
            'Memorial4'    => 'Plantillas.Memorial4',
            'Memorial5'    => 'Plantillas.Memorial5',
            'Memorial6'    => 'Plantillas.Memorial6',
            'Memorial7'    => 'Plantillas.Memorial7',
            'Corporativo'  => 'Plantillas.Corporativo',
            'Corporativo2' => 'Plantillas.Corporativo2',
            'Corporativo3' => 'Plantillas.Corporativo3',
            'Corporativo4' => 'Plantillas.Corporativo4',
            'Corporativo5' => 'Plantillas.Corporativo5',
            'Corporativo6' => 'Plantillas.Corporativo6',
             // --- NUEVAS PLANTILLAS DEL SELECTOR DE LA PÁGINA PRINCIPAL ---
        ];

        $vistaBlade = $mapaVistas[$evento->id_plantilla] ?? 'Plantillas.Matrimonio';

        // Inyectamos todas las variables necesarias a la vista (incluyendo las fotos realtime)
        return view($vistaBlade, compact('evento', 'invitado', 'interaccionesAprobadas', 'fotosNubeRealtime'));
    }

    public function subirFoto(Request $request, $id) {
        $request->validate([
            'foto' => 'required|image|max:2048',
            'titulo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nombre = time() . '_' . $file->getClientOriginalName();
            $ruta = $file->storeAs('galerias', $nombre, 'public');

            // Esto usará el modelo EventoGaleria con la tabla evento_galeria_fija
            \App\Models\EventoGaleria::create([
                'evento_id' => $id,
                'url_recurso' => $ruta,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'orden' => 0 
            ]);
        }

        return back()->with('exito', 'Imagen agregada a la galería correctamente.');
    }

    public function galeria($id)
    {
        // Cargamos el evento con sus fotos actuales usando la relación
        $evento = Evento::with('fotosGaleria')->findOrFail($id);
        return view('Eventos.Galeria', compact('evento'));
    }

    public function gestionItinerario($id)
    {
        $evento = Evento::with('itinerarios')->findOrFail($id);
        return view('Eventos.Itinerario', compact('evento'));
    }

    public function guardarItinerario(Request $request, $id)
    {
        // Validamos los arrays que vienen de la vista
        $request->validate([
            'hora' => 'required|array',
            'actividad' => 'required|array',
            'descripcion' => 'nullable|array',
        ]);

        $evento = Evento::findOrFail($id);

        // Limpiamos el itinerario actual para insertar el nuevo
        $evento->itinerarios()->delete();

        // Recorremos usando el índice de 'actividad'
        foreach ($request->actividad as $key => $actividad) {
            if (!empty($actividad)) { // Solo guardamos si la actividad no está vacía
                $evento->itinerarios()->create([
                    'hora'        => $request->hora[$key] ?? null,
                    'actividad'   => $actividad,
                    'descripcion' => $request->descripcion[$key] ?? null,
                    'orden'       => $key // Opcional: guardamos el orden según la posición
                ]);
            }
        }

        return back()->with('exito', '¡Itinerario actualizado correctamente!');
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $usuarios = User::all();
        $tipos = TipoEvento::all();
        
        // Suponiendo que tienes una carpeta 'Eventos' y el archivo 'Edit.blade.php'
        return view('Eventos.Edit', compact('evento', 'usuarios', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        // 1. Aquí SÍ ponemos TODAS las validaciones completas
        $request->validate([
            'nombre_evento'     => 'required|max:255',
            'slug'              => 'required|max:255|unique:eventos,slug,' . $id . ',evento_id', // <-- Validación nueva y clave para no duplicar URLs
            'anfitrion_id'      => 'required|exists:usuarios,usuario_id',
            'tipo_evento_id'    => 'required|exists:tipos_evento,tipo_evento_id',
            'fecha_principal'   => 'required|date',
            'fecha_nacimiento'  => 'nullable|date',
            'biografia_resumen' => 'nullable|string',
            'ubicacion_texto'   => 'nullable|string|max:255',
            'google_maps_url'   => 'nullable|url',
            'id_plantilla'      => 'nullable|string',
            'hora'              => 'nullable|date_format:H:i'
        ]);

        // 2. Buscamos el evento
        $evento = Evento::findOrFail($id);
        
        // 3. Obtenemos todos los datos validados
        $datosParaActualizar = $request->all();

        // 4. Aseguramos que la hora se guarde correctamente aunque venga con segundos
        if ($request->filled('hora')) {
            // Asegura formato correcto para MySQL
            $datosParaActualizar['hora'] = \Carbon\Carbon::parse($request->hora)->format('H:i:s');
        }

        // 5. Actualizamos
        $evento->update($datosParaActualizar);

        return redirect()->route('eventos.index')->with('exito', 'Evento actualizado correctamente.');
    }

    // IMPORTANTE: Asegúrate de agregar "Request $request" aquí adentro de los paréntesis
    public function renderPlantilla(\Illuminate\Http\Request $request, $id)
    {
        // 1. Cargamos el evento y nos aseguramos de traer también las fotos locales
        $evento = Evento::with(['tipo', 'fotosGaleria'])->findOrFail($id);
        
        // 2. 🔥 NUEVO: Hacemos la misma consulta en tiempo real a OneDrive para la DEMO
        $fotosNubeRealtime = [];
        if ($evento->onedrive_folder_id) {
            try {
                $oneDrive = new \App\Services\OneDriveService();
                $fotosNubeRealtime = $oneDrive->obtenerArchivosNubeTiempoReal($evento->onedrive_folder_id);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error cargando tiempo real OneDrive en Demo: ' . $e->getMessage());
            }
        }

        $mapaVistas = [
            'Matrimonio'   => 'Plantillas.Matrimonio',
            'Matrimonio2'  => 'Plantillas.Matrimonio2',
            'Matrimonio3'  => 'Plantillas.Matrimonio3',
            'Matrimonio4'  => 'Plantillas.Matrimonio4',
            'Matrimonio5'  => 'Plantillas.Matrimonio5',
            'Matrimonio6'  => 'Plantillas.Matrimonio6',
            'Matrimonio7'  => 'Plantillas.Matrimonio7', 
            'Matrimonio8'  => 'Plantillas.Matrimonio8',
            'Matrimonio9'  => 'Plantillas.Matrimonio9',
            'Matrimonio10' => 'Plantillas.Matrimonio10',
            'Memorial'     => 'Plantillas.Memorial',
            'Memorial2'    => 'Plantillas.Memorial2',
            'Memorial3'    => 'Plantillas.Memorial3',
            'Memorial4'    => 'Plantillas.Memorial4',
            'Memorial5'    => 'Plantillas.Memorial5',
            'Memorial6'    => 'Plantillas.Memorial6',
            'Memorial7'    => 'Plantillas.Memorial7',
            'Corporativo'  => 'Plantillas.Corporativo',
            'Corporativo2' => 'Plantillas.Corporativo2',
            'Corporativo3' => 'Plantillas.Corporativo3',
            'Corporativo4' => 'Plantillas.Corporativo4',
            'Corporativo5' => 'Plantillas.Corporativo5',
            'Corporativo6' => 'Plantillas.Corporativo6',
            // --- NUEVAS PLANTILLAS DEL SELECTOR DE LA PÁGINA PRINCIPAL ---
            'Editorial'   => 'Plantillas.Matrimonio',
            'Gala Real'  => 'Plantillas.Matrimonio2',
            'Boho Chic'  => 'Plantillas.Matrimonio3',
            'Estreno'  => 'Plantillas.Matrimonio4',
            'Pop Art'  => 'Plantillas.Matrimonio5',
            'UCM'  => 'Plantillas.Matrimonio6',
            'DC'  => 'Plantillas.Matrimonio7',
            'Romance' => 'Plantillas.Matrimonio8', 
            'Magia' => 'Plantillas.Matrimonio9',
            'Jardin' => 'Plantillas.Matrimonio10',
            'A' => 'Plantillas.Corporativo',
            'B' => 'Plantillas.Corporativo2',
            'C' => 'Plantillas.Corporativo3',
            'D' => 'Plantillas.Corporativo4',
            'E' => 'Plantillas.Corporativo5',
            'F' => 'Plantillas.Corporativo6',
            '1' => 'Plantillas.Memorial',
            '2' => 'Plantillas.Memorial2',
            '3' => 'Plantillas.Memorial3',
            '4' => 'Plantillas.Memorial4',
            '5' => 'Plantillas.Memorial5',
            '6' => 'Plantillas.Memorial6',
            '7' => 'Plantillas.Memorial7',
        ];

        // LÓGICA DINÁMICA: Si viene "?preview=Algo" en la URL, usa eso. Si no, usa el que tiene el evento por defecto.
        $plantillaSolicitada = $request->query('preview', $evento->id_plantilla);

        // Si la plantilla no existe en el mapa, cae en 'Plantillas.Matrimonio' por seguridad
        $vistaBlade = $mapaVistas[$plantillaSolicitada] ?? 'Plantillas.Matrimonio';

        // LA SOLUCIÓN: Usamos el token real del evento cargado
        $invitado = (object)['token_acceso' => $evento->token_invitacion_general, 'mesa_asignada' => 'Mesa VIP (Demo)'];
        
        // Cargamos las interacciones de prueba aprobadas por si es un memorial
        $interaccionesAprobadas = \App\Models\Interaccion::where('evento_id', $evento->evento_id)
                                     ->where('aprobado', 1)
                                     ->orderBy('interaccion_id', 'desc')
                                     ->get();

        // 3. MANDAMOS LA VARIABLE $fotosNubeRealtime A LA VISTA
        return view($vistaBlade, compact('evento', 'invitado', 'interaccionesAprobadas', 'fotosNubeRealtime'));
    }

    // Método para mostrar el memorial con las condolencias aprobadas
    public function mostrarMemorial($evento_id)
    {
        $evento = Evento::findOrFail($evento_id);
        
        // Traemos solo las condolencias aprobadas por los moderadores, ordenadas por las más recientes
        $interaccionesAprobadas = Interaccion::where('evento_id', $evento->evento_id)
                                            ->where('aprobado', 1)
                                            ->orderBy('interaccion_id', 'desc')
                                            ->get();

        return view('memorial', compact('evento', 'interaccionesAprobadas'));
    }

    public function listarInvitados($id)
    {
        $evento = Evento::with('invitados')->findOrFail($id);
        return view('Eventos.Invitados', compact('evento'));
    }

    public function moderarInteracciones($id)
    {
        // Cargamos el evento con todas sus interacciones (aprobadas y pendientes)
        $evento = Evento::with(['interacciones' => function($query) {
            $query->orderBy('interaccion_id', 'desc');
        }])->findOrFail($id);
        
        // Retorna la vista donde podrás presionar "Aprobar" o "Rechazar"
        return view('Eventos.Interacciones', compact('evento'));
    }

    public function aprobarInteraccion($id)
    {
        $interaccion = \App\Models\Interaccion::findOrFail($id);
        $interaccion->aprobado = 1;
        $interaccion->save();

        return back()->with('exito', 'La dedicatoria ha sido aprobada y publicada en el muro.');
    }

    // 👇 AGREGA ESTA NUEVA FUNCIÓN AQUÍ 👇
    public function desaprobarInteraccion($id)
    {
        $interaccion = \App\Models\Interaccion::findOrFail($id);
        $interaccion->aprobado = 0; // Lo pasamos a estado 0 (oculto)
        $interaccion->save();

        return back()->with('exito', 'El mensaje ha sido ocultado del muro exitosamente.');
    }

    public function gestionTrivia($id)
    {
        $evento = Evento::with('juegoPreguntas')->findOrFail($id);
        
        if(strtolower($evento->tipo->nombre) === 'memorial'){
            return redirect()->route('eventos.index')->with('error', 'La gestión de trivia no está disponible para eventos de tipo Memorial.');
        }

        return view('Eventos.Trivia', compact('evento'));
    }

    public function guardarTrivia(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        // Limpiamos las preguntas actuales para insertar las nuevas
        $evento->juegoPreguntas()->delete();

        if ($request->has('pregunta') && is_array($request->pregunta)){
            foreach ($request->pregunta as $key => $preguntaTexto){
                if (!empty($preguntaTexto)) {
                    $evento->juegoPreguntas()->create([
                        'pregunta'           => trim($preguntaTexto),
                        'opcion_a'           => trim($request->opcion_a[$key] ?? ''),
                        'opcion_b'           => trim($request->opcion_b[$key] ?? ''),
                        'opcion_c'           => trim($request->opcion_c[$key] ?? ''),
                        'opcion_d'           => trim($request->opcion_d[$key] ?? ''),
                        'respuesta_correcta' => $request->respuesta_correcta[$key] ?? 'a',
                        'puntos'             => (int) ($request->puntos[$key] ?? 10),
                    ]);
                }
            }
        }

        return back()->with('exito', 'Pregunta de trivia agregada correctamente.');
    }

    public function obtenerRanking($evento_id)
    {
        // Usamos el nuevo modelo apuntando a la tabla 'juego_participaciones'
        $ranking = \App\Models\JuegoParticipacion::where('evento_id', $evento_id)
                    ->orderBy('puntaje_total', 'desc')   // Columna correcta según tu BD
                    ->orderBy('tiempo_empleado', 'asc')  // Columna correcta según tu BD
                    ->take(10)
                    ->get();

        return response()->json([
            'success' => true,
            'ranking' => $ranking
        ]);
    }

    public function recordarClave($id)
    {
        try {
            $invitado = Invitado::with('evento')->findOrFail($id);

            if ($invitado->email) {
                Mail::to($invitado->email)->send(new RecordatorioClaveMail($invitado));
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'El invitado no tiene correo registrado'], 400);

        } catch (\Exception $e) {
            // AGREGAMOS ESTO: Si falla, nos enviará el error exacto de Gmail
            return response()->json([
                'success' => false, 
                'message' => 'Error de correo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function recordarClavesMasivo($id)
    {
        try {
            // 1. Buscamos el evento y a todos sus invitados
            $evento = Evento::with('invitados')->findOrFail($id);
            $enviados = 0;

            // 2. Recorremos a todos los invitados uno por uno
            foreach ($evento->invitados as $invitado) {
                // Solo enviamos si el invitado tiene un correo guardado
                if (!empty($invitado->email)) {
                    Mail::to($invitado->email)->send(new RecordatorioClaveMail($invitado));
                    $enviados++;
                }
            }

            // 3. Devolvemos la respuesta al botón
            return response()->json([
                'success' => true,
                'message' => "Se enviaron {$enviados} correos con éxito"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error masivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function solicitarPlan(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'plan' => 'required',
            'fecha_evento' => 'required'
        ]);

        // 1. Asignamos el precio correcto según el plan
        $precios = [
            'Matrimonio' => 30000,
            'Corporativo' => 20000,
            'Memorial' => 10000
        ];
        
        $precioFinal = $precios[$request->plan] ?? 30000;

        try {
            MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
            $client = new PreferenceClient();

            $preference = $client->create([
                "items" => [
                    [
                        "title" => "Plan " . $request->plan . " - Eventify",
                        "quantity" => 1,
                        "unit_price" => $precioFinal 
                    ]
                ],
                "payer" => [
                    "name" => $request->nombre,
                    "email" => $request->email,
                ],
                // 👇 Forzamos el uso de APP_URL para garantizar el HTTPS que exige MercadoPago
                "back_urls" => [
                    "success" => env('APP_URL') . '/pago/exito',
                    "failure" => env('APP_URL') . '/pago/fallo',
                    "pending" => env('APP_URL') . '/pago/fallo'
                ],
                "auto_return" => "approved",
                "external_reference" => json_encode([
                    'nombre' => $request->nombre,
                    'email' => $request->email,
                    'fecha_evento' => $request->fecha_evento,
                    'plan' => $request->plan
                ]),
            ]);

            return redirect($preference->init_point);

        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            dd("ERROR DE MERCADOPAGO:", $e->getApiResponse()->getContent());
        } catch (\Exception $e) {
            dd("ERROR DE SISTEMA:", $e->getMessage());
        }
    }

    public function pagoExitoso(Request $request)
    {
        // 👇 1. EVITAMOS QUE EL SERVIDOR CORTE EL PROCESO A LOS 30 SEGUNDOS 👇
        set_time_limit(120);

        $status = $request->get('status');
        $external_reference = $request->get('external_reference'); 

        if ($status === 'approved' && $external_reference) {
            
            $datosCliente = json_decode($external_reference, true);
            $planComprado = $datosCliente['plan'];

            // 1. Configuramos el tipo de evento y plantilla por defecto
            $tipoEventoId = 1; // Asumiendo que 1 = Matrimonio
            $plantillaDefecto = 'Matrimonio'; 

            if ($planComprado === 'Memorial') {
                $tipoEventoId = 2; 
                $plantillaDefecto = 'Memorial'; 
            } elseif ($planComprado === 'Corporativo') {
                $tipoEventoId = 3; 
                $plantillaDefecto = 'Corporativo'; 
            }

            // 2. CREAMOS EL USUARIO (Si no existe)
            $usuario = User::where('email', $datosCliente['email'])->first();
            $passwordAleatoria = null;

            if (!$usuario) {
                $passwordAleatoria = Str::random(8); // Genera una clave de 8 caracteres
                
                $usuario = User::create([
                    'nombre' => $datosCliente['nombre'],
                    'email' => $datosCliente['email'],
                    'password' => Hash::make($passwordAleatoria),
                    'rol_id' => 2, // 2 = Anfitrión
                    'estado' => 1
                ]);
            }

            // 3. --- LÓGICA CLOUD: CARPETA AUTOMÁTICA EN ONEDRIVE ---
            $nombreNuevoEvento = 'Mi ' . $planComprado . ' #' . strtoupper(Str::random(4));
            $tokenEspecial = bin2hex(random_bytes(4)); 
            $folderIdOneDrive = null;

            try {
                $oneDrive = new \App\Services\OneDriveService();
                $folderIdOneDrive = $oneDrive->crearCarpetaRaizEvento($nombreNuevoEvento, $tokenEspecial);
                
                if (!$folderIdOneDrive) {
                    \Illuminate\Support\Facades\Log::warning('OneDrive: No se pudo crear la carpeta automática para la compra: ' . $nombreNuevoEvento);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('OneDrive Exception (Pago Automático): ' . $e->getMessage());
            }

            // 4. CREAMOS EL EVENTO EN LA BASE DE DATOS
            $evento = Evento::create([
                'anfitrion_id' => $usuario->usuario_id,
                'tipo_evento_id' => $tipoEventoId,
                'nombre_evento' => $nombreNuevoEvento, 
                'fecha_principal' => $datosCliente['fecha_evento'],
                'ubicacion_texto' => 'Ubicación por definir',
                'id_plantilla' => $plantillaDefecto,
                'activo' => 1,
                'onedrive_folder_id' => $folderIdOneDrive, 
            ]);

            // 👇 5. ENVÍO DE CORREOS CON TRAMPA DE ERROR 👇
            try {
                if ($passwordAleatoria) {
                    Mail::to($usuario->email)->send(new CredencialesAnfitrionMail($usuario, $passwordAleatoria, $evento));
                }

                $admin = \App\Models\User::where('rol_id', 1)->first();
                if ($admin) {
                    \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\NuevoEventoAdminMail($usuario, $evento, $planComprado));
                }
            } catch (\Exception $e) {
                // SI ALGO SALE MAL CON EL CORREO, LA PANTALLA SE DETENDRÁ AQUÍ Y TE DIRÁ EL POR QUÉ EXACTO
                dd("ERROR EXACTO DE GMAIL: " . $e->getMessage());
            }
            // 👆 FIN DE LA TRAMPA 👆

            // 6. REDIRIGIMOS SEGÚN EL TIPO DE CLIENTE
            if ($passwordAleatoria) {
                return view('pago-exito', [
                    'email' => $usuario->email, 
                    'plan' => $planComprado
                ]);
            } else {
                return redirect()->route('eventos.index')->with('exito', '¡Felicidades! Tu nuevo plan de ' . $planComprado . ' ha sido añadido a tu cuenta y tu espacio en la nube está listo.');
            }
        }

        return redirect('/')->with('error', 'El pago no pudo ser procesado correctamente.');
    }

    public function pagoFallido(Request $request)
    {
        return redirect('/')->with('error', 'El pago fue cancelado o rechazado.');
    }

    public function subirFotoOneDrive(Request $request, $id) 
    {
        // 1. Validamos que venga un arreglo de fotos/videos y el peso máximo
        $request->validate([
            'fotos' => 'required|array',
            'fotos.*' => 'file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,webm|max:51200', // max 50MB por archivo
        ]);

        if ($request->hasFile('fotos')) {
            $evento = \App\Models\Evento::findOrFail($id);

            if (!$evento->onedrive_folder_id) {
                return back()->with('error', 'Este evento aún no tiene una carpeta de OneDrive asignada.');
            }

            try {
                $oneDrive = new \App\Services\OneDriveService();
                $archivosSubidos = 0;
                $archivosTotales = count($request->file('fotos'));

                // 2. Recorremos cada archivo seleccionado por el usuario
                foreach ($request->file('fotos') as $file) {
                    $nombreOriginal = str_replace(' ', '_', $file->getClientOriginalName());
                    $nombreArchivo = time() . '_' . $nombreOriginal;
                    
                    // Empujamos el archivo a Microsoft
                    $respuestaOneDrive = $oneDrive->subirArchivo(
                        $evento->onedrive_folder_id, 
                        $nombreArchivo, 
                        $file->getRealPath()
                    );

                    if ($respuestaOneDrive) {
                        // ¡AQUÍ ESTÁ EL CAMBIO! 
                        // Ya no llamamos a EventoGaleria::create(). 
                        // Solo sumamos el contador, dejando la base de datos local limpia.
                        $archivosSubidos++;
                    }
                }

                return back()->with('exito', "¡Despliegue completado! Se subieron {$archivosSubidos} de {$archivosTotales} archivos a la Nube.");

            } catch (\Exception $e) {
                // Silenciamos el error visual si la API de OneDrive retrasa la respuesta
                \Illuminate\Support\Facades\Log::error('OneDrive (Log Interno Múltiple): ' . $e->getMessage());
                return back()->with('exito', '¡Archivos enviados a la Nube! Puede que tarden un minuto en reflejarse.');
            }
        }

        return back()->with('error', 'No se detectó ningún archivo válido.');
    }

}