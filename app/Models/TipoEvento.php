<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    protected $table = "tipos_evento";
    protected $primaryKey = "tipo_evento_id";
    public $timestamps = false;

    // Agrega esto para permitir que Laravel guarde el campo 'nombre'
    protected $fillable = ['nombre']; 
}