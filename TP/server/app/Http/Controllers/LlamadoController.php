<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Llamado;
use App\Models\Postulacion;
use App\Models\Catedra;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Exception;

class LlamadoController extends Controller
{
  public function buscarLlamado($id_llamado)
  {
    $fechaDeHoy = strtotime(date('Y-m-d'));

    try {
      $llamado = Llamado::find($id_llamado);

      if ($llamado) {
        if (strtotime($llamado->fecha_fin) < $fechaDeHoy) {
          $llamado->finalizado = true;
        } else {
          $llamado->finalizado = false;
        }
  
        $llamado->catedra;

        foreach ($llamado->postulaciones as $postulacion) {
          $persona = Persona::find($postulacion->id_persona);

          $postulacion->dni = $persona->dni;
          $postulacion->nombre_apellido = $persona->nombre_apellido;
          $postulacion->email = $persona->email;
          $postulacion->telefono = $persona->telefono;
          $postulacion->curriculum_vitae = $persona->curriculum_vitae;
        }
      }
      
      return response()->json($llamado);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarLlamadoCalificado($id_llamado)
  {
    $fechaDeHoy = strtotime(date('Y-m-d'));

    try {
      $llamado = Llamado::where([['id', '=', $id_llamado], ['calificado', '=', true]])->first();

      if ($llamado) {
        if (strtotime($llamado->fecha_fin) < $fechaDeHoy) {
          $llamado->finalizado = true;
        } else {
          $llamado->finalizado = false;
        }
  
        $llamado->catedra;

        foreach ($llamado->postulaciones as $postulacion) {
          $persona = Persona::find($postulacion->id_persona);

          $postulacion->dni = $persona->dni;
          $postulacion->nombre_apellido = $persona->nombre_apellido;
        }  
      }

      return response()->json($llamado);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarLlamados()
  {
    $fechaDeHoy = date('Y-m-d');
    try {
      $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
      ->leftJoin('postulaciones', 'postulaciones.id_llamado', '=', 'llamados.id')
      ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes',
      DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'),
      'llamados.requisitos', 'catedras.descripcion', 'catedras.definicion')
      ->where([['fecha_inicio', '<=', $fechaDeHoy], ['fecha_fin', '>=', $fechaDeHoy]])
      ->groupBy('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', 'llamados.requisitos', 
      'catedras.descripcion', 'catedras.definicion')->get();

      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarUltimasVacantes()
  {
    $fechaDeHoy = date('Y-m-d');
    try {
      // puse 3 como numero de pocas vacantes (se puede cambiar)
      $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
      ->leftJoin('postulaciones', 'postulaciones.id_llamado', '=', 'llamados.id')
      ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes',
      DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'),
      'llamados.requisitos', 'catedras.descripcion', 'catedras.definicion')
      ->where([['fecha_inicio', '<=', $fechaDeHoy], ['fecha_fin', '>=', $fechaDeHoy]])
      ->groupBy('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', 'llamados.requisitos', 
      'catedras.descripcion', 'catedras.definicion')->having(DB::raw('llamados.vacantes - count(postulaciones.id_llamado)'), '<=', 3)
      ->get();

      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarLlamadosCalificados()
  {
    try {
      $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
      ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes',
      'llamados.requisitos', 'catedras.descripcion', 'catedras.definicion')
      ->where('calificado', '=', true)->get();
    
      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarLlamadosAAdministrar()
  {
    $roles = auth()->user()->roles;

    foreach ($roles as $rol) {
      if ($rol->descripcion == 'Administrador') {
        try {
          $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
          ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes',
          'llamados.requisitos', 'catedras.descripcion', 'catedras.definicion')->get();
    
          return response()->json($llamados);
        } catch (Exception $e) {
          return response()->json(['error' => $e->getMessage()], 406, []);
        }
      }
    }

    foreach ($roles as $rol) {
      if ($rol->descripcion == 'Jefe Catedra') {
        try {
          $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
          ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes',
          'llamados.requisitos', 'catedras.descripcion', 'catedras.definicion')
          ->where('catedras.id_jefe_catedra', '=', auth()->user()->id)->get();
    
          return response()->json($llamados);
        } catch (Exception $e) {
          return response()->json(['error' => $e->getMessage()], 406, []);
        }
      }
    }
  }

  public function calificarLlamado(Request $request)
  {
    if ($request->llamado) {
      $llamado = Llamado::find($request->llamado["id"]);
      if ($llamado->fecha_fin < strtotime(date('Y-m-d'))) {
        try {
          DB::beginTransaction();

          foreach ($request->llamado["postulaciones"] as $postulacion) {
            $postulacionAEditar = Postulacion::find($postulacion["id"]);

            if ($postulacion["estadoEditado"] == "Aceptar") {
              $postulacionAEditar->estado = "Elegido";
            } else if ($postulacion["estadoEditado"] == "Rechazar") {
              $postulacionAEditar->estado = "No elegido";
            }
            $postulacionAEditar->puntaje = $postulacion["puntajeEditado"];
            $postulacionAEditar->comentarios = $postulacion["comentariosEditado"];

            $postulacionAEditar->save();
          }

          $llamado->calificado = true;
          $llamado->save();

          DB::commit();
        } catch (Exception $e) {
          DB::rollback();

          return response()->json(['error' => $e->getMessage()], 406, []);
        }
      } else {
        return response()->json(['error' => 'No se puede calificar el llamado en esta fecha'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Envie un llamado'], 406, []);
    }
  }

  public function agregarLlamado(Request $request)
  {
    if ($request->llamado) {
      if (strtotime($request->llamado["fecha_inicio"]) >= strtotime(date('Y-m-d'))) {
        if (strtotime($request->llamado["fecha_inicio"]) <= strtotime($request->llamado["fecha_fin"])) {
          if ($request->llamado["requisitos"]) {
            if ($request->llamado["vacantes"] && is_int((int) $request->llamado["vacantes"]) && $request->llamado["vacantes"] > 0) {
              try {
                if (Catedra::find($request->llamado["id_catedra"])) {
                  $llamado = new Llamado();
                  
                  $llamado->fecha_inicio = $request->llamado["fecha_inicio"];
                  $llamado->fecha_fin = $request->llamado["fecha_fin"];
                  $llamado->requisitos = $request->llamado["requisitos"];
                  $llamado->vacantes = $request->llamado["vacantes"];
                  $llamado->calificado = false;
                  $llamado->id_catedra = $request->llamado["id_catedra"];

                  $llamado->save();
                } else {
                  return response()->json(['error' => 'La cátedra no existe'], 406, []);
                }
              } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
            }
            } else {
              return response()->json(['error' => 'Las vacantes disponibles deben ser mayor a cero'], 406, []);
            }
          } else {
            return response()->json(['error' => 'Ingrese los requisitos'], 406, []);
          }
        } else {
          return response()->json(['error' => 'La fecha de cierre no puede ser menor a la fecha de inicio'], 406, []);
        }
      } else {
        return response()->json(['error' => 'La fecha de inicio no puede ser menor a la fecha actual'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese un llamado'], 406, []);
    }
  }

  public function eliminarLlamado($id_llamado)
  {
    if ($id_llamado) {
      $llamado = Llamado::find($id_llamado);
      if ($llamado) {
        $llamado->postulaciones()->delete();
        $llamado->delete();
      } else {
        return response()->json(['error' => 'No existe el llamado'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese el id del llamado a eliminar'], 406, []);
    }
  }
}
