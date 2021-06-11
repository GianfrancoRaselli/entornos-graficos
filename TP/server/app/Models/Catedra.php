<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catedra extends Model
{
    protected $table = "catedras";

    protected $fillable = [
        'descripcion',
        'definicion',
        'id_jefe_catedra'
    ];

    public $timestamps = false;

    public function jefeCatedra()
    {
        return $this->belongsTo('App\Models\Persona', 'id_jefe_catedra');
    }

    public function trabajan()
    {
        return $this->hasMany('App\Models\Trabajan', 'id_catedra');
    }

    public function llamados()
    {
        return $this->hasMany('App\Models\Llamado', 'id_llamado');
    }
}
