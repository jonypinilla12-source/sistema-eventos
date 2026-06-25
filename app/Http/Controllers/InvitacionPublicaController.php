<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Invitado;
use App\Models\Interaccion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionAsistenciaMail;
use App\Mail\NuevaDedicatoriaMail;

class InvitacionPublicaController extends Controller
{
     //CASO 1: Registrar asistencia con bloqueo de duplicados por correo en el mismo evento
    public function aceptarInvitacion(Request $request)
    {
        $request->validate([
            'token_acceso'    => 'required|string',
            'nombre_invitado' => 'required|string|max:255',
            'email'           => 'nullable|email|max:255',
            'acompanantes'    => 'nullable|array',
            'acompanantes.*.nombre' => 'required|string|max:255',
            'acompanantes.*.email'  => 'nullable|email|max:255'
        ]);
        $evento = Evento::where('token_invitacion_general', $request->token_acceso)->first();
        if (!$evento) {
            return response()->json([
                'success' => false,
                'message' => 'Código de acceso al evento no válido.'
            ], 404);
        }

        // --- VALIDACIÓN DE DUPLICADOS ---
        if (!empty($request->email)) {
            $yaRegistrado = Invitado::where('evento_id', $evento->evento_id)
                                    ->where('email', trim($request->email))
                                    ->exists();

            if ($yaRegistrado) {
                return response()->json([
                    'success' => false,
                    'already_registered' => true,
                    'message' => 'Este correo electrónico ya se encuentra registrado y confirmado para este evento.'
                ], 422);
            }
        }

        $codigosGenerados = [];

        // Generamos el código personal único para el Invitado Principal
        $prefijoPrincipal = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $request->nombre_invitado), 0, 3));
        $codigoPersonalPrincipal = $prefijoPrincipal . '-' . rand(1000, 9999);
        
        // 1. Insertamos al Invitado Principal Y LO GUARDAMOS EN LA VARIABLE $invitadoPrincipal
        $invitadoPrincipal = Invitado::create([
            'evento_id'          => (int) $evento->evento_id,
            'nombre_invitado'    => trim($request->nombre_invitado),
            'email'              => $request->email ?? '', 
            'confirmado'         => 1, 
            'fecha_confirmacion' => now(),
            'numero_invitado'    => $codigoPersonalPrincipal, 
            'mesa_asignada'      => 'Por asignar', 
            'token_acceso'       => trim($request->token_acceso)
        ]);

        $codigosGenerados[] = [
            'nombre' => trim($request->nombre_invitado),
            'codigo' => $codigoPersonalPrincipal
        ];

        // 2. Insertamos a cada acompañante
        if ($request->has('acompanantes') && is_array($request->acompanantes)) {
            foreach ($request->acompanantes as $acomp) {
                $nombreLimpio = trim($acomp['nombre']);
                if (!empty($nombreLimpio)) {
                    
                    $prefijoAcomp = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $nombreLimpio), 0, 3));
                    $codigoPersonalAcomp = $prefijoAcomp . '-' . rand(1000, 9999);

                    Invitado::create([
                        'evento_id'          => (int) $evento->evento_id,
                        'nombre_invitado'    => $nombreLimpio,
                        'email'              => $acomp['email'] ?? '', 
                        'confirmado'         => 1, 
                        'fecha_confirmacion' => now(),
                        'numero_invitado'    => $codigoPersonalAcomp, 
                        'mesa_asignada'      => 'Por asignar', 
                        'token_acceso'       => trim($request->token_acceso)
                    ]);

                    $codigosGenerados[] = [
                        'nombre' => $nombreLimpio,
                        'codigo' => $codigoPersonalAcomp
                    ];
                }
            }
        }
        
        // 3. ENVIAMOS EL CORREO AHORA (Antes de retornar nada)
        if (!empty($request->email)) {
            try {
                // Usamos las variables correctas: $invitadoPrincipal y $codigosGenerados
                Mail::to($request->email)->send(new ConfirmacionAsistenciaMail($invitadoPrincipal, $codigosGenerados));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error al enviar correo de confirmación: ' . $e->getMessage());
            }
        }

        // 4. RETORNAMOS LA RESPUESTA FINAL UNA SOLA VEZ
        return response()->json([
            'success' => true,
            'message' => '¡Asistencia registrada exitosamente!',
            'codigos' => $codigosGenerados
        ]);
    }
      
    //CASO 2: Registrar dedicatoria con foto opcional enviada directamente a OneDrive
    public function registrarMemorial(Request $request, $evento_id)
    {
        $request->validate([
            'nombre_autor'        => 'required|string|max:255',
            'vinculo_autor'       => 'required|string|max:255', 
            'contenido'           => 'required|string',
            'codigo_verificacion' => 'required|string', 
            'archivo'             => 'nullable|image|max:10240', // 10MB Máximo
        ]);

        // 1. Cargamos el evento CON el tipo para poder diferenciar
        $evento = Evento::with(['usuario', 'tipo'])->findOrFail($evento_id);

        // 1. Buscamos al invitado usando el código de verificación
        $invitado = Invitado::where('evento_id', $evento->evento_id)
                            ->where('numero_invitado', trim(strtoupper($request->codigo_verificacion)))
                            ->first();

        if (!$invitado) {
            return response()->json([
                'success' => false,
                'message' => 'La clave de acceso ingresada no coincide con ningún registro autorizado para este memorial.'
            ], 403);
        }

        $urlFinalRecurso = null;

        // 2. CONEXIÓN DIRECTA A ONEDRIVE (Si hay archivo y el evento está enlazado)
        if ($request->hasFile('archivo') && $evento->onedrive_folder_id) {
            try {
                $oneDrive = new \App\Services\OneDriveService();
                
                // La API requiere un array de archivos, envolvemos el archivo único en un arreglo []
                $urlFinalRecurso = $oneDrive->subirFotosEnCarpetaEvento(
                    [$request->file('archivo')], 
                    $evento->onedrive_folder_id, 
                    $invitado->nombre_invitado
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error al subir foto de invitado a OneDrive: ' . $e->getMessage());
            }
        }

        // 3. Estructuramos la interacción con la URL devuelta por Microsoft
        $esMatrimonio = (strtolower($evento->tipo->nombre) === 'matrimonio');
        
        $tipoInteraccion = $esMatrimonio ? 'mensaje' : 'condolencia'; 

        $nuevaInteraccion = Interaccion::create([
            'evento_id'       => $evento->evento_id,
            'invitado_id'     => $invitado->invitado_id, 
            'nombre_autor'    => trim($request->nombre_autor),
            'vinculo_autor'   => trim($request->vinculo_autor), 
            'tipo'            => $tipoInteraccion,
            'contenido_texto' => trim($request->contenido),
            'url_onedrive'    => $urlFinalRecurso,
            'aprobado'        => $esMatrimonio ? 1 : 0, // 1 para matrimonio, 0 para memorial
            'created_at'      => now()
        ]);

        // 4. LÓGICA DE CORREO: Solo enviamos aviso si NO es matrimonio (es decir, si requiere moderación)
        if (!$esMatrimonio) {
            if ($evento->usuario && $evento->usuario->email) {
                try {
                    \Illuminate\Support\Facades\Log::info('Intentando enviar notificación de dedicatoria a: ' . $evento->usuario->email);
                    
                    Mail::to($evento->usuario->email)->send(new NuevaDedicatoriaMail($evento, $nuevaInteraccion));
                    
                    \Illuminate\Support\Facades\Log::info('Correo de dedicatoria enviado exitosamente.');
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error al enviar correo de dedicatoria: ' . $e->getMessage());
                }
            } else {
                \Illuminate\Support\Facades\Log::warning('No se pudo enviar correo: El evento no tiene anfitrión o el anfitrión no tiene email.');
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => $esMatrimonio 
                ? '¡Tu mensaje ha sido publicado en el muro!' 
                : 'Su dedicatoria ha sido registrada con éxito en el libro de recuerdos y pasará a revisión de la familia.'
        ]);
    }

    /**
     * CASO 3: Registrar firmas individuales para el Libro de Recuerdos de un Memorial
     */
    public function registrarFirmaMemorial(Request $request, $evento_id)
    {
        $request->validate([
            'nombre_invitado' => 'required|string|max:255',
            'email'           => 'required|email|max:255', // El correo es obligatorio aquí para el control de la crítica
        ]);

        $evento = Evento::findOrFail($evento_id);

        // --- VALIDACIÓN EXCLUSIVA DE DUPLICADOS EN MEMORIAL ---
        $yaRegistrado = Invitado::where('evento_id', $evento->evento_id)
                                ->where('email', trim($request->email))
                                ->first();

        // Si ya se registró en este memorial antes, le devolvemos de inmediato su código existente con tu mensaje personalizado
        if ($yaRegistrado) {
            return response()->json([
                'success' => true,
                'already_registered' => true,
                // --- TU NUEVO MENSAJE PERSONALIZADO ---
                'message' => 'Usted ya tiene un código de acceso registrado para este memorial. Su código es: ' . $yaRegistrado->numero_invitado,
                'codigos' => [
                    [
                        'nombre' => $yaRegistrado->nombre_invitado,
                        'codigo' => $yaRegistrado->numero_invitado
                    ]
                ]
            ]);
        }

        // Generamos el código personal único (Ej: JON-8241)
        $prefijo = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $request->nombre_invitado), 0, 3));
        $codigoPersonal = $prefijo . '-' . rand(1000, 9999);

        // Creamos la fila individual en la tabla invitados
        Invitado::create([
            'evento_id'          => (int) $evento->evento_id,
            'nombre_invitado'    => trim($request->nombre_invitado),
            'email'              => trim($request->email), 
            'confirmado'         => 1, 
            'fecha_confirmacion' => now(),
            'numero_invitado'    => $codigoPersonal, 
            'mesa_asignada'      => 'No aplica', 
            'token_acceso'       => 'MEMORIAL-GUEST'
        ]);

        return response()->json([
            'success' => true,
            'already_registered' => false,
            'message' => 'Firma registrada de manera correcta.',
            'codigos' => [
                [
                    'nombre' => trim($request->nombre_invitado),
                    'codigo' => $codigoPersonal
                ]
            ]
        ]);
    }

    public function validarPaseTrivia(Request $request)
    {
        $codigo = strtoupper(trim($request->input('codigo')));
        $eventoId = $request->input('evento_id');

        // Buscamos si existe un invitado con ese código exacto para este evento
        $invitado = \App\Models\Invitado::where('numero_invitado', $codigo)
            ->where('evento_id', $eventoId)
            ->first();

        if ($invitado) {

            //
            $yaParticipo = \DB::table('juego_participaciones')
                ->where('evento_id', $eventoId)
                ->where('invitado_id', $invitado->invitado_id)
                ->exists();
            
            if ($yaParticipo) {
                return response()->json([
                    'success' => false,
                    'already_played' => true, // Flag para atraparlo en el JS
                    'message' => 'Usted ya ha respondido el cuestionario de preguntas para este evento. Solo se permite un intento por invitado.'
                ], 422); // Código 422: Error de validación de negocio
            }
            
            $preguntas = \App\Models\JuegoPregunta::where('evento_id', $eventoId)->get();

            return response()->json([
                'success'         => true,
                'invitado_id'     => $invitado->invitado_id, // Pasamos la ID primaria para la inserción
                'nombre_invitado' => $invitado->nombre_invitado,
                'preguntas'       => $preguntas // Viajan las preguntas directo al JavaScript del modal
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Código de acceso inválido o no registrado para este evento.'
        ], 404);
    }

    public function pantallaTrivia(Request $request, $id)
    {
        // Cargamos el evento con sus preguntas de trivia asociadas
        $evento = \App\Models\Evento::with('juegoPreguntas')->findOrFail($id);
        
        // Rescatamos el código del jugador desde la URL
        $codigoJugador = strtoupper($request->query('player'));

        // Validamos por seguridad que el jugador realmente exista en este evento
        $invitado = \App\Models\Invitado::where('numero_invitado', $codigoJugador)
            ->where('evento_id', $id)
            ->first();

        if (!$invitado) {
            return redirect()->route('eventos.show', $evento->slug)
                ->with('error', 'Acceso denegado. Código de jugador inválido.');
        }

        // Retornamos la vista del juego pasándole el evento, las preguntas y el invitado
        return view('Invitaciones.JuegoTrivia', compact('evento', 'invitado'));
    }

    public function guardarParticipacionTrivia(Request $request)
    {
        $request->validate([
            'evento_id'       => 'required',
            'invitado_id'     => 'required',
            'nombre_jugador'  => 'required|string|max:255', // Lo validamos para guardarlo
            'puntaje'         => 'required|integer',
            'tiempo_segundos' => 'required|integer'
        ]);

        // Mapeo exacto adaptado a las columnas reales de tu esquema de BD
        \DB::table('juego_participaciones')->insert([
            'evento_id'           => $request->evento_id,
            'invitado_id'         => $request->invitado_id,
            'nombre_jugador'      => trim($request->nombre_jugador), // Campo real
            'puntaje_total'       => $request->puntaje,             // Campo real
            'tiempo_empleado'     => $request->tiempo_segundos,     // Campo real
            'finalizado'          => 1,                             // Campo real
            'fecha_participacion' => \Carbon\Carbon::now()          // Campo real
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Participación registrada correctamente en el ranking.'
        ]);
    }

}