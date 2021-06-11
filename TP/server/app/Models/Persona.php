<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Persona extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = "personas";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni',
        'nombre_usuario',
        'clave',
        'nombre_apellido',
        'email',
        'telefono',
        'api_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'clave',
    ];

    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany('App\Models\Rol', 'personas_roles', 'id_persona', 'id_rol');
    }

    public function postulaciones()
    {
        return $this->hasMany('App\Models\Postulacion', 'id_postulacion');
    }

    public function trabajos()
    {
        return $this->hasMany('App\Models\Trabajan', 'id_persona');
    }
}
