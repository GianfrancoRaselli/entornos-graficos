<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    protected $table = "postulaciones";

    protected $fillable = [
        'curriculum_vitae',
        'estado',
        'puntaje',
        'id_persona',
        'id_llamado'
    ];

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'id_persona');
    }

    public function llamado()
    {
        return $this->belongsTo('App\Models\Llamado', 'id_llamado');
    }
}
