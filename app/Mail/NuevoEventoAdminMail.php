<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevoEventoAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;
    public $evento;
    public $plan;

    public function __construct($cliente, $evento, $plan)
    {
        $this->cliente = $cliente;
        $this->evento = $evento;
        $this->plan = $plan;
    }

    public function build()
    {
        return $this->subject('💰 ¡NUEVA VENTA! Plan ' . $this->plan . ' Vendido')
                    ->view('emails.alerta_admin_nuevo_evento');
    }
}