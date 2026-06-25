<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InvitacionPublicaController;
use App\Models\Evento;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PasswordResetController;

// =========================================================
// --- RUTAS PÚBLICAS (Cualquiera puede entrar) ---
// =========================================================

// 1. TU NUEVA PÁGINA PRINCIPAL (LANDING PAGE)
Route::get('/', function () {
    return view('welcome'); 
})->name('inicio');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de compra y pasarela
Route::post('/solicitar-plan', [EventoController::class, 'solicitarPlan'])->name('solicitar.plan');
Route::get('/pago/exito', [EventoController::class, 'pagoExitoso'])->name('pago.exito');
Route::get('/pago/fallo', [EventoController::class, 'pagoFallido'])->name('pago.fallo');

// ESTA ES LA RUTA CLAVE: Debe estar fuera de cualquier middleware de auth
Route::get('/evento/{slug}', [EventoController::class, 'show'])->name('eventos.show');

// ESTA RUTA PERMITE VER LAS DEMOS EN VIVO DESDE LA LANDING PAGE
Route::get('/eventos/render-plantilla/{id}', [EventoController::class, 'renderPlantilla'])->name('eventos.renderPlantilla');

// Rutas públicas de interacción
Route::post('/invitacion/confirmar-asistencia', [InvitacionPublicaController::class, 'aceptarInvitacion'])->name('publico.confirmar');
Route::post('/invitacion/memorial/{evento_id}/recuerdo', [InvitacionPublicaController::class, 'registrarMemorial'])->name('publico.memorial.recuerdo');
Route::post('/invitacion/memorial/{evento_id}/firmar', [InvitacionPublicaController::class, 'registrarFirmaMemorial']);
Route::post('/invitacion/memorial/{evento_id}/registrar', [InvitacionPublicaController::class, 'registrarMemorial']);
Route::get('/eventos/{id}/trivia', [EventoController::class, 'gestionTrivia'])->name('eventos.trivia');
Route::post('/eventos/{id}/trivia', [EventoController::class, 'guardarTrivia'])->name('eventos.trivia.guardar');
Route::post('/invitacion/validar-pase-trivia', [InvitacionPublicaController::class, 'validarPaseTrivia']);
Route::get('/invitacion/evento/{id}/juego-trivia', [InvitacionPublicaController::class, 'pantallaTrivia'])->name('invitacion.trivia.juego');
Route::post('/invitacion/registrar-participacion-trivia', [InvitacionPublicaController::class, 'guardarParticipacionTrivia']);
Route::get('/invitacion/evento/{id}/ranking', [EventoController::class, 'obtenerRanking']);
Route::post('/invitados/{id}/recordar-clave', [EventoController::class, 'recordarClave']);
Route::post('/eventos/{id}/recordar-claves-masivo', [EventoController::class, 'recordarClavesMasivo']);

Route::get('/olvide-mi-contrasena', [PasswordResetController::class, 'request'])->middleware('guest')->name('password.request');
Route::post('/olvide-mi-contrasena', [PasswordResetController::class, 'email'])->middleware('guest')->name('password.email');
Route::get('/restablecer-contrasena/{token}', [PasswordResetController::class, 'reset'])->middleware('guest')->name('password.reset');
Route::post('/restablecer-contrasena', [PasswordResetController::class, 'update'])->middleware('guest')->name('password.update');


// =========================================================
// --- RUTAS PROTEGIDAS (Requieren estar logueado) ---
// =========================================================
Route::middleware(['auth'])->group(function () {

    // 2. EL PANEL DE CONTROL (Ahora vive en /home)
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // --- RUTAS COMPARTIDAS (Pueden acceder ADMIN y ANFITRIÓN) ---
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');

    Route::get('/mi-perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/mi-perfil/password', [PerfilController::class, 'updatePassword'])->name('perfil.password.update');
    
    
    // Gestión de Módulos
    Route::get('/eventos/{id}/galeria', [EventoController::class, 'galeria'])->name('eventos.galeria');
    Route::post('/eventos/{id}/galeria', [EventoController::class, 'subirFoto'])->name('eventos.galeria.store');
    Route::post('/eventos/{id}/galeria-onedrive', [EventoController::class, 'subirFotoOneDrive'])->name('eventos.onedrive.store');
    Route::get('/eventos/{id}/itinerario', [EventoController::class, 'gestionItinerario'])->name('eventos.itinerario');
    Route::post('/eventos/{id}/itinerario', [EventoController::class, 'guardarItinerario'])->name('eventos.itinerario.guardar');
    Route::get('/eventos/{id}/invitados', [EventoController::class, 'listarInvitados'])->name('eventos.invitados');
    Route::get('/eventos/{id}/interacciones', [EventoController::class, 'moderarInteracciones'])->name('eventos.interacciones');
    Route::post('/interacciones/{id}/aprobar', [EventoController::class, 'aprobarInteraccion'])->name('interacciones.aprobar');
    Route::post('/interacciones/{id}/desaprobar', [EventoController::class, 'desaprobarInteraccion'])->name('interacciones.desaprobar');    

    // 👇 AQUÍ ESTÁ EL CAMBIO: Las rutas de edición ahora están en la zona compartida 👇
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');

    // --- RUTAS EXCLUSIVAS DE ADMINISTRADOR (Solo rol_id = 1) ---
    Route::middleware(['can:admin-only'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('usuarios', UserController::class);
        Route::resource('tipos', TipoEventoController::class);
        
        // Creación y Borrado de Eventos (Solo el Admin puede crear manualmente o borrar todo)
        Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');
        Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
        Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');
        
        Route::get('/prueba-db', function () {
            return Evento::all();
        });
    });

});

// =========================================================
// --- RUTAS PARA ENLAZAR ONEDRIVE ---
// =========================================================
Route::get('/onedrive/login', function () {
    $clientId = env('ONEDRIVE_CLIENT_ID');
    $redirectUri = urlencode('http://localhost/sistema-eventos/public/onedrive/callback');
    
    $url = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize" .
           "?client_id={$clientId}" .
           "&response_type=code" .
           "&redirect_uri={$redirectUri}" .
           "&response_mode=query" .
           "&scope=https://graph.microsoft.com/Files.ReadWrite.All%20offline_access";
    
    return redirect($url);
})->name('onedrive.login');

Route::get('/onedrive/callback', function (\Illuminate\Http\Request $request) {
    $code = $request->query('code');
    
    if (!$code) {
        return "No se recibió el código de autorización de Microsoft.";
    }
    
    $response = Illuminate\Support\Facades\Http::asForm()->post("https://login.microsoftonline.com/common/oauth2/v2.0/token", [
        'client_id'     => env('ONEDRIVE_CLIENT_ID'),
        'client_secret' => env('ONEDRIVE_CLIENT_SECRET'),
        'code'          => $code,
        'redirect_uri'  => 'http://localhost/sistema-eventos/public/onedrive/callback',
        'grant_type'    => 'authorization_code',
    ]);

    if ($response->successful()) {
        $data = $response->json();
        Illuminate\Support\Facades\Storage::put('onedrive_refresh_token.txt', $data['refresh_token']);
        
        return "<h3>¡Conexión exitosa con tu OneDrive!</h3><p>El token permanente ha sido guardado. Ya puedes cerrar esta pestaña y crear eventos tranquilamente.</p>";
    }

    return "Error al conectar con OneDrive: " . $response->body();
});