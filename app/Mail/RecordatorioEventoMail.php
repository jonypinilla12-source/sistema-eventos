<?php

namespace App\Mail;

use App\Models\Invitado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioEventoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitado;
    public $tipoRecordatorio;

    public function __construct(Invitado $invitado, $tipoRecordatorio)
    {
        $this->invitado = $invitado;
        $this->tipoRecordatorio = $tipoRecordatorio; // Será '1_dia' o '1_hora'
    }

    public function build()
    {
        $asunto = $this->tipoRecordatorio === '1_dia' 
            ? '¡Es mañana! Recordatorio de ' . $this->invitado->evento->nombre_evento 
            : '¡Comenzamos en 1 HORA! - ' . $this->invitado->evento->nombre_evento;

        return $this->subject($asunto)->view('emails.recordatorio_evento');
    }
}