<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Llamado;
use App\Models\Postulacion;
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
          $postulacion->persona;
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
          ->where(['catedras.id_jefe_catedra', '=', auth()->user()->id])->get();
    
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
      if (Llamado::find($request->llamado->id)->fecha_fin < strtotime(date('Y-m-d'))) {
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
}
