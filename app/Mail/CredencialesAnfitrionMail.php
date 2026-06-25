<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CredencialesAnfitrionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $password;
    public $evento;

    public function __construct($usuario, $password, $evento)
    {
        $this->usuario = $usuario;
        $this->password = $password;
        $this->evento = $evento;
    }

    public function build()
    {
        return $this->subject('¡Bienvenido a Eventify! Tus credenciales de acceso')
                    ->view('emails.credenciales');
    }
}