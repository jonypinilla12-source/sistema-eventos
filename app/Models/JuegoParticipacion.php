<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuegoParticipacion extends Model
{
    // Vinculamos exactamente a la tabla que me mostraste en tu diagrama
    protected $table = "juego_participaciones";
    protected $primaryKey = "participacion_id";
    public $timestamps = false; // No veo created_at ni updated_at en el diagrama

    protected $fillable = [
        "evento_id",
        "invitado_id",
        "nombre_jugador",
        "puntaje_total",
        "tiempo_empleado",
        "finalizado",
        "fecha_participacion"
    ];

    public function evento(){
        return $this->belongsTo(Evento::class, 'evento_id', 'evento_id');
    }
}