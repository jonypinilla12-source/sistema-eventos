<?php

namespace App\Mail;

use App\Models\Invitado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioClaveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitado;

    // Recibimos al invitado cuando llamamos al correo desde el controlador
    public function __construct(Invitado $invitado)
    {
        $this->invitado = $invitado;
    }

    public function build()
    {
        return $this->subject('Tu código de acceso para ' . $this->invitado->evento->nombre_evento)
                    ->view('emails.recordatorio_clave'); // Esta es la vista HTML que crearemos ahora
    }
}