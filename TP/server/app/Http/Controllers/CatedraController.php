<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catedra;
use App\Models\Persona;
use App\Models\Trabajo;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use Exception;

class CatedraController extends Controller
{
  public function buscarCatedra($id_catedra)
  {
    try {
      $catedra = Catedra::find($id_catedra);

      return response()->json($catedra);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarCatedras()
  {
    try {
      $catedras = Catedra::all();

      return response()->json($catedras);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function agregarCatedra(Request $request)
  {
    if (
      $request->catedra
      && $request->catedra["descripcion"]
      && $request->catedra["definicion"]
      && $request->catedra["id_jefe_catedra"]
    ) {
      try {
        if (!Catedra::where('descripcion', trim($request->catedra["descripcion"]))->first()) {
          if (
            is_numeric($request->catedra["id_jefe_catedra"])
            && (int) $request->catedra["id_jefe_catedra"] > 0
            && $jefeCatedra = Persona::find($request->catedra["id_jefe_catedra"])
          ) {
            DB::beginTransaction();

            $isJefeCatedra = false;
            foreach ($jefeCatedra->roles as $rol) {
              if ($rol->descripcion == "Jefe Catedra") $isJefeCatedra = true;
            }
            if (!$isJefeCatedra) {
              $jefeCatedra->roles()->attach(Rol::where('descripcion', 'Jefe Catedra')->first()->id);
            }

            $catedra = new Catedra();
            $catedra->descripcion = trim($request->catedra["descripcion"]);
            $catedra->definicion = $request->catedra["definicion"];
            $catedra->id_jefe_catedra = $request->catedra["id_jefe_catedra"];
            $catedra->save();

            $trabajo = new Trabajo();
            $trabajo->id_persona = $jefeCatedra->id;
            $trabajo->id_catedra = $catedra->id;
            $trabajo->save();

            DB::commit();
          } else {
            return response()->json(['error' => 'El ID del jefe de cátedra ingresado no pertenece a una persona'], 406, []);
          }
        } else {
          return response()->json(['error' => 'La cátedra ya se encuentra registrada'], 406, []);
        }
      } catch (Exception $e) {
        DB::rollback();

        return response()->json(['error' => $e->getMessage()], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese una cátedra con todos sus datos'], 406, []);
    }
  }

  public function editarCatedra(Request $request)
  {
    if (
      $request->catedra
      && $request->catedra["id"]
      && $request->catedra["descripcion"]
      && $request->catedra["definicion"]
      && $request->catedra["id_jefe_catedra"]
    ) {
      try {
        if (
          is_numeric($request->catedra["id"])
          && (int) $request->catedra["id"] > 0
          && $catedra = Catedra::find($request->catedra["id"])
        ) {
          if (strtoupper(trim($catedra->descripcion)) == strtoupper(trim($request->catedra["descripcion"])) || !Catedra::where('descripcion', trim($request->catedra["descripcion"]))->first()) {
            if (
              is_numeric($request->catedra["id_jefe_catedra"])
              && (int) $request->catedra["id_jefe_catedra"] > 0
              && $jefeCatedraNuevo = Persona::find($request->catedra["id_jefe_catedra"])
            ) {

              DB::beginTransaction();

              $jefeCatedraAnterior = null;
              if ($catedra->id_jefe_catedra != $jefeCatedraNuevo->id) {
                $jefeCatedraAnterior = Persona::find($catedra->id_jefe_catedra);

                $isJefeCatedra = false;
                foreach ($jefeCatedraNuevo->roles as $rol) {
                  if ($rol->descripcion == "Jefe Catedra") $isJefeCatedra = true;
                }
                if (!$isJefeCatedra) {
                  $jefeCatedraNuevo->roles()->attach(Rol::where('descripcion', 'Jefe Catedra')->first()->id);
                }
              }

              $catedra->descripcion = trim($request->catedra["descripcion"]);
              $catedra->definicion = $request->catedra["definicion"];
              $catedra->id_jefe_catedra = $request->catedra["id_jefe_catedra"];
              $catedra->save();

              if ($jefeCatedraAnterior) {
                if (!Trabajo::where([['id_persona', $jefeCatedraNuevo->id], ['id_catedra', $catedra->id]])->first()) {
                  $trabajo = new Trabajo();
                  $trabajo->id_persona = $jefeCatedraNuevo->id;
                  $trabajo->id_catedra = $catedra->id;
                  $trabajo->save();
                }

                Trabajo::where([['id_persona', $jefeCatedraAnterior->id], ['id_catedra', $catedra->id]])->first()->delete();

                if (!Catedra::where('id_jefe_catedra', $catedra->id_jefe_catedra)->first()) {
                  $jefeCatedraAnterior->roles()->detach(Rol::where('descripcion', 'Jefe Catedra')->first()->id);
                }
              }

              DB::commit();
            } else {
              return response()->json(['error' => 'El ID del jefe de cátedra ingresado no pertenece a una persona'], 406, []);
            }
          } else {
            return response()->json(['error' => 'La cátedra ya se encuentra registrada'], 406, []);
          }
        } else {
          return response()->json(['error' => 'El ID ingresado no pertenece a una cátedra'], 406, []);
        }
      } catch (Exception $e) {
        DB::rollback();

        return response()->json(['error' => $e->getMessage()], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese una cátedra con todos sus datos'], 406, []);
    }
  }

  public function eliminarCatedra($id_catedra)
  {
    if ($id_catedra) {
      $catedra = Catedra::find($id_catedra);
      if ($catedra) {
        try {
          DB::beginTransaction();

          $catedra->llamados()->delete();
          $catedra->trabajos()->delete();
          $catedra->delete();

          if (!Catedra::where('id_jefe_catedra', $catedra->id_jefe_catedra)->first()) {
            $persona = Persona::find($catedra->id_jefe_catedra);
            $persona->roles()->detach(Rol::where('descripcion', 'Jefe Catedra')->first()->id);
          }

          DB::commit();
        } catch (Exception $e) {
          DB::rollback();

          return response()->json(['error' => $e->getMessage()], 406, []);
        }
      } else {
        return response()->json(['error' => 'No existe la cátedra'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese el id de la cátedra a eliminar'], 406, []);
    }
  }
}
