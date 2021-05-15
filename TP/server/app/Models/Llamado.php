<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Llamado extends Model
{
    protected $table = "llamados";

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'vacantes',
        'id_catedra'
    ];

    public $timestamps = false;

    public function catedra()
    {
        return $this->belongsTo('App\Models\Catedra', 'id_catedra');
    }

    public function postulaciones()
    {
        return $this->hasMany('App\Models\Postulacion', 'id_postulacion');
    }
}
