<?php

namespace App\Http\Controllers;

use Exception;

class DateController extends Controller
{
  public function fechaDeHoy()
  {
    return response()->json(date('Y-m-d'));
  }
}
