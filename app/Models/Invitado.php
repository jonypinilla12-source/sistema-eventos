<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;

    // Indicamos el nombre exacto de la tabla según tu base de datos
    protected $table = 'invitados';
    // Indicamos la clave primaria personalizada
    protected $primaryKey = 'invitado_id';
    // Desactivamos los timestamps si tu tabla no tiene 'created_at' y 'updated_at'
    public $timestamps = false;

    // Permitimos la asignación masiva de los campos
    protected $fillable = [
        'evento_id',
        'nombre_invitado',
        'email',
        'confirmado',
        'fecha_confirmacion',
        'numero_invitado',
        'mesa_asignada',
        'token_acceso'
    ];

    // Relación inversa con Evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id', 'evento_id');
    }
}