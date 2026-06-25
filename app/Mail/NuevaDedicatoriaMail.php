<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaDedicatoriaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $interaccion;

    public function __construct($evento, $interaccion)
    {
        $this->evento = $evento;
        $this->interaccion = $interaccion;
    }

    public function build()
    {
        return $this->subject('🔔 Nueva dedicatoria pendiente en ' . $this->evento->nombre_evento)
                    ->view('emails.nueva_dedicatoria');
    }
}