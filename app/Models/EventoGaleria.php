<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoGaleria extends Model
{
    // Ajustado según tu imagen: evento_galeria_fija
    protected $table = 'evento_galeria_fija'; 
    protected $primaryKey = 'galeria_fija_id';
    public $timestamps = false;

    protected $fillable = [
        'evento_id',
        'url_recurso',
        'orden',
        'titulo',
        'descripcion'
    ];

    public function evento() {
        return $this->belongsTo(Evento::class, 'evento_id', 'evento_id');
    }
    
}