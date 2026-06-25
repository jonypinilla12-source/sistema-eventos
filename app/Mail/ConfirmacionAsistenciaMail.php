<?php

namespace App\Mail;

use App\Models\Invitado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionAsistenciaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitado;
    public $codigos;

    public function __construct(Invitado $invitado, $codigos)
    {
        $this->invitado = $invitado;
        $this->codigos = $codigos; // Array con los nombres y códigos generados
    }

    public function build()
    {
        return $this->subject('¡Asistencia Confirmada! - ' . $this->invitado->evento->nombre_evento)
                    ->view('emails.confirmacion_asistencia');
    }
}