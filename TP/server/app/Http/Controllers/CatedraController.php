<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catedra;
use Exception;

class CatedraController extends Controller
{
  public function buscarCatedras()
  {
    try {
      $catedras = Catedra::all();

      return response()->json($catedras);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }
}
