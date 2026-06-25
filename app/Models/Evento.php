<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'evento_id';
    public $timestamps = false; 

    protected $fillable = [
        'anfitrion_id',
        'tipo_evento_id',
        'nombre_evento',
        'slug',
        'fecha_principal',
        'fecha_nacimiento',
        'biografia_resumen',
        'ubicacion_texto',
        'google_maps_url',
        'id_plantilla',
        'onedrive_folder_id',
        'token_invitacion_general',
        'activo',
        'hora'
    ];

    // Relación con el Anfitrión (usuarios)
    public function usuario() {
        return $this->belongsTo(User::class, 'anfitrion_id', 'usuario_id');
    }

    // Relación con el Tipo de Evento
    public function tipo() {
        return $this->belongsTo(TipoEvento::class, 'tipo_evento_id', 'tipo_evento_id');
    }

    protected static function boot() {
        parent::boot();
        static::creating(function ($evento) {
            $evento->slug = Str::slug($evento->nombre_evento);
            $evento->activo = 1;
            $evento->token_invitacion_general = Str::random(30);
        });
    }

    public function fotosGaleria()
    {
        return $this->hasMany(EventoGaleria::class, 'evento_id', 'evento_id');
    }

    public function itinerarios()
    {
        return $this->hasMany(EventoItinerario::class, 'evento_id', 'evento_id')->orderBy('orden');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'evento_id', 'evento_id');
    }

    public function interacciones()
    {
        return $this->hasMany(Interaccion::class, 'evento_id', 'evento_id');
    }

    public function juegoPreguntas()
    {
        return $this->hasMany(JuegoPregunta::class, 'evento_id', 'evento_id');
    }

    // En App\Models\Evento.php (Añade esto dentro de la clase)
    public function getUrlInvitacionAttribute()
    {
        return route('eventos.show', $this->slug);
    }
}