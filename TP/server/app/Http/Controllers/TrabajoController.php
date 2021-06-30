<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajo;
use Exception;

class TrabajoController extends Controller
{
  public function buscarTrabajosDelUsuario()
  {
    try {
      $trabajos = Trabajo::where('id_persona', auth()->user()->id)->get();

      return response()->json($trabajos);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }
}
