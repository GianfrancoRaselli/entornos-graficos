<?php

namespace App\Http\Controllers;

use App\Models\Llamado;
use Illuminate\Support\Facades\DB;
use Exception;

class LlamadoController extends Controller
{
  public function buscarLlamado($id_llamado)
  {
    try {
      $llamado = Llamado::find($id_llamado);
      $llamado->catedra;
      foreach ($llamado->postulaciones as $postulacion) {
        $postulacion->persona;   
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
      ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'), 'llamados.requisitos', 
      'catedras.id', 'catedras.descripcion', 'catedras.definicion')
      ->where([['fecha_inicio', '<=', $fechaDeHoy], ['fecha_fin', '>=', $fechaDeHoy]])
      ->groupBy('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', 'llamados.requisitos', 
      'catedras.id', 'catedras.descripcion', 'catedras.definicion')->get();

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
      ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'), 'llamados.requisitos', 
      'catedras.id', 'catedras.descripcion', 'catedras.definicion')
      ->where([['fecha_inicio', '<=', $fechaDeHoy], ['fecha_fin', '>=', $fechaDeHoy]])
      ->groupBy('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', 'llamados.requisitos', 
      'catedras.id', 'catedras.descripcion', 'catedras.definicion')->having(DB::raw('llamados.vacantes - count(postulaciones.id_llamado)'), '<=', 3)
      ->get();

      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }
}
