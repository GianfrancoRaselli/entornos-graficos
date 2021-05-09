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
        return $this->hasMany('App\Models\Persona');
    }
}
