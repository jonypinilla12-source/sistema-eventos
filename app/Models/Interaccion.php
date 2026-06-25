<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
    use HasFactory;

    // Nombre exacto de tu tabla de bitácora/muro
    protected $table = 'interacciones';

    protected $primaryKey = 'interaccion_id';

    // Si solo usas 'created_at' (como se ve en tu base de datos), desactivamos el manejo automático
    public $timestamps = false;

    protected $fillable = [
        'evento_id',
        'invitado_id',
        'nombre_autor',
        'vinculo_autor',
        'tipo',
        'contenido_texto',
        'url_onedrive',
        'aprobado',
        'created_at'
    ];

    // Evento al que pertenece la interacción
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id', 'evento_id');
    }
}