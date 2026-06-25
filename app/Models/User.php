<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Tu tabla según el diagrama
    protected $primaryKey = 'usuario_id';
    public $timestamps = false; // Tu tabla usa created_at pero no updated_at por defecto

    protected $fillable = [
        'rol_id', 'nombre', 'email', 'password', 'estado'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relación: Un usuario pertenece a un Rol
    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id', 'rol_id');
    }

    public function sendPasswordResetNotification($token)
    {
        \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\RecuperarClaveMail($token, $this->email));
    }
}
