<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioEventoMail;

class EnviarRecordatorios extends Command
{
    // Este es el nombre del comando que ejecutará Laravel
    protected $signature = 'eventos:recordatorios';
    protected $description = 'Envía recordatorios 1 día y 1 hora antes del evento';

    public function handle()
    {
        $ahora = Carbon::now();

        // Variables de tiempo objetivo
        $fechaManana = $ahora->copy()->addDay()->format('Y-m-d');
        $fechaHoy = $ahora->format('Y-m-d');
        $horaEnUnaHora = $ahora->copy()->addHour()->format('H:i');
        $horaActual = $ahora->format('H:i');

        // Buscamos todos los eventos, EXCLUYENDO los de tipo "Memorial"
        $eventos = Evento::with(['invitados', 'tipo'])
            ->whereHas('tipo', function ($query) {
                $query->where('nombre', '!=', 'Memorial');
                $query->where('nombre', '!=', 'memorial');
            })->get();

        foreach ($eventos as $evento) {
            
            // CASO 1: Un día antes (Se enviará justo a las 10:00 AM del día anterior)
            if ($evento->fecha_principal === $fechaManana && $horaActual === '10:00') {
                $this->enviarCorreosMasivos($evento, '1_dia');
            }

            // CASO 2: Exactamente 1 hora antes del evento
            if ($evento->fecha_principal === $fechaHoy && $evento->hora) {
                $horaDelEvento = Carbon::parse($evento->hora)->format('H:i');
                
                if ($horaDelEvento === $horaEnUnaHora) {
                    $this->enviarCorreosMasivos($evento, '1_hora');
                }
            }
        }

        $this->info('Revisión de recordatorios completada.');
    }

    private function enviarCorreosMasivos($evento, $tipoRecordatorio)
    {
        foreach ($evento->invitados as $invitado) {
            if (!empty($invitado->email)) {
                try {
                    Mail::to($invitado->email)->send(new RecordatorioEventoMail($invitado, $tipoRecordatorio));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Fallo envío automático: " . $e->getMessage());
                }
            }
        }
    }
}