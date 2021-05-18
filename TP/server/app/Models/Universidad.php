<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Universidad extends Model
{
    protected $table = "universidad";

    protected $fillable = [
        'direccion',
        'telefono',
        'email'
    ];

    public $timestamps = false;
}
