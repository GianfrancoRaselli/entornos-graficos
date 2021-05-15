<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "roles";

    protected $fillable = [
        'descripcion'
    ];

    public $timestamps = false;

    public function personas()
    {
        return $this->belongsToMany('App\Models\Persona', 'personas_roles', 'id_rol', 'id_persona');
    }
}
