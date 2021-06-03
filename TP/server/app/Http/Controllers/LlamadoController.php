<?php

namespace App\Http\Controllers;

use App\Models\Llamado;
use Exception;

class LlamadoController extends Controller
{
  public function ultimasVacantes()
  {
    try {
      $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')->get();

      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }
}
