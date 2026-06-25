<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoItinerario extends Model
{
    // Nombre exacto de la tabla que creaste por SQL
    protected $table = 'eventos_itinerarios';

    // Nombre exacto de la llave primaria
    protected $primaryKey = 'itinerario_id';

    // Campos que permitimos llenar
    protected $fillable = [
        'evento_id',
        'hora',
        'actividad',
        'descripcion',
        'orden'
    ];

    // Relación inversa (opcional, pero buena práctica)
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id', 'evento_id');
    }
}