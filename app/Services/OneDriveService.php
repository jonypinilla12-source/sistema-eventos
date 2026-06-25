<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OneDriveService
{
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId = env('ONEDRIVE_CLIENT_ID');
        $this->clientSecret = env('ONEDRIVE_CLIENT_SECRET');
    }

    /**
     * Obtiene el token de acceso usando el refresh_token guardado físicamente
     */
    private function getAccessToken()
    {
        if (!Storage::exists('onedrive_refresh_token.txt')) {
            Log::error('OneDrive: No se encontró el archivo onedrive_refresh_token.txt. Debes ingresar primero a /onedrive/login');
            return null;
        }

        $refreshToken = Storage::get('onedrive_refresh_token.txt');
        $url = "https://login.microsoftonline.com/common/oauth2/v2.0/token";

        $response = Http::asForm()->post($url, [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'scope'         => 'https://graph.microsoft.com/Files.ReadWrite.All offline_access'
        ]);

        if ($response->failed()) {
            Log::error('Error renovando Token de OneDrive: ' . $response->body());
            return null;
        }

        $data = $response->json();

        if (isset($data['refresh_token'])) {
            Storage::put('onedrive_refresh_token.txt', $data['refresh_token']);
        }

        return $data['access_token'];
    }

    /**
     * PASO A: Crear la carpeta principal del evento en OneDrive
     */
    public function crearCarpetaRaizEvento($nombreEvento, $tokenEspecial)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreEvento) . '_' . $tokenEspecial;
        $url = "https://graph.microsoft.com/v1.0/me/drive/root/children";

        $response = Http::withToken($token)->post($url, [
            'name' => $nombreLimpio,
            'folder' => new \stdClass(),
            '@microsoft.graph.conflictBehavior' => 'rename'
        ]);

        if ($response->successful()) {
            return $response->json()['id'];
        }

        Log::error('Error OneDrive API (Crear Carpeta): ' . $response->body());
        return null;
    }

    /**
     * PASO B: Subir fotos DENTRO de la carpeta del evento (Usado por los invitados)
     */
    public function subirFotosEnCarpetaEvento($archivos, $folderIdEvento, $nombreInvitado)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $nombreSubCarpeta = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreInvitado) . '_' . time();
        $urlFinalImagen = null;

        foreach ($archivos as $archivo) {
            $nombreArchivo = time() . '_' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $archivo->getClientOriginalName());
            
            $uploadUrl = "https://graph.microsoft.com/v1.0/me/drive/items/{$folderIdEvento}:/{$nombreSubCarpeta}/{$nombreArchivo}:/content";

            $response = Http::withToken($token)
                ->withBody(file_get_contents($archivo->getRealPath()), $archivo->getClientMimeType())
                ->put($uploadUrl);

            if ($response->successful()) {
                $itemData = $response->json();
                $itemId = $itemData['id'];

                $thumbUrl = "https://graph.microsoft.com/v1.0/me/drive/items/{$itemId}/thumbnails";
                $thumbResponse = Http::withToken($token)->get($thumbUrl);

                if ($thumbResponse->successful()) {
                    $thumbData = $thumbResponse->json();
                    if (isset($thumbData['value'][0]['large']['url'])) {
                        $urlFinalImagen = $thumbData['value'][0]['large']['url'];
                    }
                }
            }
        }

        return $urlFinalImagen; 
    }


    /**
     * PASO C: Subir UN archivo a la subcarpeta "Fotos" (Atajo rápido)
     * Compatible con fotos y videos pesados.
     */
    public function subirArchivo($folderId, $nombreArchivo, $rutaFisicaArchivo)
    {
        $accessToken = $this->getAccessToken(); 

        if (!$accessToken) {
            Log::error('OneDrive: No hay token de acceso disponible para subir el archivo.');
            return false;
        }

        $contenido = file_get_contents($rutaFisicaArchivo);
        $mimeType = mime_content_type($rutaFisicaArchivo);
        
        // Agregamos /Fotos/ en la ruta. Microsoft creará la subcarpeta sola.
        $url = "https://graph.microsoft.com/v1.0/me/drive/items/{$folderId}:/Fotos/{$nombreArchivo}:/content";

        // Usamos withHeaders para forzar el tipo de archivo correcto (vital para videos)
        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => $mimeType])
            ->withBody($contenido, $mimeType)
            ->put($url);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Fallo al subir a OneDrive (Atajo): ' . $response->body());
        return false;
    }

    /**
     * 👇 NUEVA FUNCIÓN CLAVE: Lee la nube directamente en tiempo real sin importar cómo subieron la foto 👇
     */
    public function obtenerArchivosNubeTiempoReal($folderId, $token = null)
    {
        if (!$token) {
            $token = $this->getAccessToken();
        }
        if (!$token) return [];

        // Con $expand=thumbnails le pedimos a Microsoft que nos dé los links directos listos para HTML
        $url = "https://graph.microsoft.com/v1.0/me/drive/items/{$folderId}/children?\$expand=thumbnails";
        $response = Http::withToken($token)->get($url);
        
        $archivos = [];
        if ($response->successful()) {
            $items = $response->json()['value'] ?? [];
            foreach ($items as $item) {
                if (isset($item['file'])) {
                    // Detectamos inteligentemente si es un Video
                    $mimeType = $item['file']['mimeType'] ?? '';
                    $esVideo = str_starts_with($mimeType, 'video');

                    // URL principal de descarga
                    $urlDescarga = $item['@microsoft.graph.downloadUrl'] ?? ($item['thumbnails'][0]['large']['url'] ?? null);
                    
                    if ($urlDescarga) {
                        $archivos[] = [
                            'url' => $urlDescarga,
                            'esVideo' => $esVideo,
                            'etiqueta' => 'NUBE / MULTIVERSO'
                        ];
                    }
                } elseif (isset($item['folder'])) {
                    // Es una subcarpeta (La de un invitado), entramos recursivamente a buscar sus archivos
                    $archivosSubcarpeta = $this->obtenerArchivosNubeTiempoReal($item['id'], $token);
                    $archivos = array_merge($archivos, $archivosSubcarpeta);
                }
            }
        }
        return $archivos;
    }
}