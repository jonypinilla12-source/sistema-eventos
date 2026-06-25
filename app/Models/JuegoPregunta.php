<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuegoPregunta extends Model
{
    protected $table = "juego_preguntas";
    protected $primaryKey = "pregunta_id";
    public $timestamps = false;

    protected $fillable = [
        "evento_id",
        "pregunta",
        "opcion_a",
        "opcion_b",
        "opcion_c",
        "opcion_d",
        "respuesta_correcta",
        "puntos"
    ];

    public function evento(){
        return $this->belongsTo(Evento::class, 'evento_id', 'evento_id');
    }
}
