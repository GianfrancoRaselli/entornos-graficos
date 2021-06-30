<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = "personas_catedras";

    protected $fillable = [
        'id_persona',
        'id_catedra'
    ];

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'id_persona');
    }

    public function catedra()
    {
        return $this->belongsTo('App\Models\Catedra', 'id_catedra');
    }
}
