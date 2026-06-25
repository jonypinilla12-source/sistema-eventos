<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'rol_id';
    public $timestamps = false;
    protected $fillable = ['nombre_rol'];

    // Relación: Un rol tiene muchos usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id', 'rol_id');
    }
}