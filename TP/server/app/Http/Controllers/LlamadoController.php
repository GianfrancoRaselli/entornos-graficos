<?php

namespace App\Http\Controllers;

use App\Models\Llamado;
use Illuminate\Support\Facades\DB;
use Exception;

class LlamadoController extends Controller
{
  public function ultimasVacantes()
  {
    try {
      // puse 3 como numero de pocas vacantes (se puede cambiar)
      $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
      ->leftJoin('postulaciones', 'postulaciones.id_llamado', '=', 'llamados.id')
      ->select('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'), 'llamados.requisitos', 
      'catedras.id', 'catedras.descripcion', 'catedras.definicion')
      ->groupBy('llamados.id', 'llamados.fecha_inicio', 'llamados.fecha_fin', 'llamados.vacantes', 'llamados.requisitos', 
      'catedras.id', 'catedras.descripcion', 'catedras.definicion')->having(DB::raw('llamados.vacantes - count(postulaciones.id_llamado)'), '<=', 3)
      ->get();

      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }
}
