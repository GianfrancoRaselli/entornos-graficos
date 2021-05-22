<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PersonaController extends Controller
{
    function signUp(Request $request)
    {
        if ($request->dni && $request->nombre_usuario && $request->clave && $request->nombre_apellido && $request->email && $request->telefono) {
            DB::beginTransaction();

            try {
                $persona = new Persona();

                $persona->dni = $request->dni;
                $persona->nombre_usuario = $request->nombre_usuario;
                $persona->clave = Hash::make($request->clave);
                $persona->nombre_apellido = $request->nombre_apellido;
                $persona->email = $request->email;
                $persona->telefono = $request->telefono;

                $persona->save();

                $persona->api_token = Str::random(30) . $persona->id . Str::random(30);
                
                $persona->save();

                DB::commit();

                return response()->json($persona, 200);
            } catch (Exception $e) {
                DB::rollback();

                return response()->json(['error' => $e], 406, []);
            }
        } else {
            return response()->json(['error' => 'Faltan datos de la persona'], 406, []);
        }
    }

    function signIn(Request $request)
    {
        if ($request->nombre_usuario && $request->clave) {
            try {
                $persona = Persona::where('nombre_usuario', $request->nombre_usuario)->first();

                if($persona) {
                    if (Hash::check($request->clave, $persona->clave)) {
                        return response()->json($persona, 200);
                    } else {
                        return response()->json(['error' => 'Clave incorrecta'], 406, []);
                    }
                } else {
                    return response()->json(['error' => 'Persona no encontrada'], 406, []);
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e], 406, []);
            }
        } else {
            return response()->json(['error' => 'Ingresa el nombre de usuario y la clave'], 406, []);
        }
    }

    public function perfil()
    {
        try {
            $persona = Persona::find(auth()->user()->id);

            return response()->json([$persona, $persona->roles]);
        } catch (Exception $e) {
            return response()->json(['error' => $e], 406, []);
        }
    }

    public function editarPerfil(Request $request)
    {
        try {
            $persona = Persona::find(auth()->user()->id);

            $persona->dni = $request->dni;
            $persona->nombre_usuario = $request->nombre_usuario;
            $persona->nombre_apellido = $request->nombre_apellido;
            $persona->email = $request->email;
            $persona->telefono = $request->telefono;

            $persona->save();

            return response()->json($persona);
        } catch (Exception $e) {
            return response()->json(['error' => $e], 406, []);
        }
    }
}
