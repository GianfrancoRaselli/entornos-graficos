<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Llamado;
use App\Models\Postulacion;
use App\Models\Catedra;
use App\Models\Persona;
use App\Models\Trabajo;
use Illuminate\Support\Facades\DB;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../../../config/paths.php';

require __DIR__ . '/../../../config/PHPMailer/Exception.php';
require __DIR__ . '/../../../config/PHPMailer/PHPMailer.php';
require __DIR__ . '/../../../config/PHPMailer/SMTP.php';

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

        foreach ($llamado->postulaciones as $key => $postulacion) {
          if (!($llamado->calificado) && Trabajo::where([['id_persona', $postulacion->persona->id], ['id_catedra', $llamado->catedra->id]])->first()) {
            $postulacion->delete();
            unset($llamado->postulaciones, $key);
          }
        }

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
        ->select(
          'llamados.id',
          'llamados.fecha_inicio',
          'llamados.fecha_fin',
          'llamados.vacantes',
          DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'),
          'llamados.requisitos',
          'catedras.id as id_catedra',
          'catedras.descripcion',
          'catedras.definicion'
        )
        ->where([['fecha_inicio', '<=', $fechaDeHoy], ['fecha_fin', '>=', $fechaDeHoy]])
        ->groupBy(
          'llamados.id',
          'llamados.fecha_inicio',
          'llamados.fecha_fin',
          'llamados.vacantes',
          'llamados.requisitos',
          'catedras.id',
          'catedras.descripcion',
          'catedras.definicion'
        )
        ->orderBy('llamados.fecha_fin', 'ASC')->get();

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
        ->select(
          'llamados.id',
          'llamados.fecha_inicio',
          'llamados.fecha_fin',
          'llamados.vacantes',
          DB::raw('(llamados.vacantes - count(postulaciones.id_llamado)) as vacantes_disponibles'),
          'llamados.requisitos',
          'catedras.id as id_catedra',
          'catedras.descripcion',
          'catedras.definicion'
        )
        ->where([['fecha_inicio', '<=', $fechaDeHoy], ['fecha_fin', '>=', $fechaDeHoy]])
        ->groupBy(
          'llamados.id',
          'llamados.fecha_inicio',
          'llamados.fecha_fin',
          'llamados.vacantes',
          'llamados.requisitos',
          'catedras.id',
          'catedras.descripcion',
          'catedras.definicion'
        )->having(DB::raw('llamados.vacantes - count(postulaciones.id_llamado)'), '<=', 3)
        ->orderBy('llamados.fecha_fin', 'ASC')->get();

      return response()->json($llamados);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function buscarLlamadosCalificados()
  {
    try {
      $llamados = Llamado::join('catedras', 'catedras.id', '=', 'llamados.id_catedra')
        ->select(
          'llamados.id',
          'llamados.fecha_inicio',
          'llamados.fecha_fin',
          'llamados.vacantes',
          'llamados.requisitos',
          'catedras.id as id_catedra',
          'catedras.descripcion',
          'catedras.definicion'
        )
        ->where('calificado', '=', true)->orderBy('llamados.fecha_fin', 'ASC')->get();

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
            ->select(
              'llamados.id',
              'llamados.fecha_inicio',
              'llamados.fecha_fin',
              'llamados.vacantes',
              'llamados.requisitos',
              'llamados.calificado',
              'catedras.descripcion',
              'catedras.definicion'
            )
            ->orderBy('llamados.fecha_fin', 'ASC')->get();

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
            ->select(
              'llamados.id',
              'llamados.fecha_inicio',
              'llamados.fecha_fin',
              'llamados.vacantes',
              'llamados.requisitos',
              'llamados.calificado',
              'catedras.descripcion',
              'catedras.definicion'
            )
            ->where('catedras.id_jefe_catedra', '=', auth()->user()->id)
            ->orderBy('llamados.fecha_fin', 'ASC')->get();

          return response()->json($llamados);
        } catch (Exception $e) {
          return response()->json(['error' => $e->getMessage()], 406, []);
        }
      }
    }
  }

  public function calificarLlamado(Request $request)
  {
    if (
      $request->llamado
      && $request->llamado["id"]
      && $request->llamado["postulaciones"]
      && count($request->llamado["postulaciones"]) >= 1
    ) {
      $llamado = Llamado::find($request->llamado["id"]);
      if (!$llamado->calificado) {
        if (strtotime($llamado->fecha_fin) < strtotime(date('Y-m-d'))) {
          $postulacionesAEnviarCorreo = [];

          try {
            DB::beginTransaction();

            foreach ($request->llamado["postulaciones"] as $postulacion) {
              $postulacionAEditar = Postulacion::find($postulacion["id"]);

              if (Trabajo::where([['id_persona', $postulacionAEditar->persona->id], ['id_catedra', $llamado->catedra->id]])->first()) {
                $postulacionAEditar->delete();
              } else {
                if ($postulacion["estadoEditado"] == "Aceptar") {
                  $postulacionAEditar->estado = "Elegido";

                  $trabajo = new Trabajo();
                  $trabajo->id_persona = $postulacionAEditar->persona->id;
                  $trabajo->id_catedra = $llamado->catedra->id;
                  $trabajo->save();
                } else if ($postulacion["estadoEditado"] == "Rechazar") {
                  $postulacionAEditar->estado = "No elegido";
                }
                $postulacionAEditar->puntaje = (int) $postulacion["puntajeEditado"];
                $postulacionAEditar->comentarios = $postulacion["comentariosEditado"];

                $postulacionAEditar->save();

                $postulacionesAEnviarCorreo[] = $postulacionAEditar;
              }
            }

            $llamado->calificado = true;
            $llamado->save();

            DB::commit();
          } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 406, []);
          }

          if (count($postulacionesAEnviarCorreo) > 0) {
            try {
              $this->enviarMailCalificacionLlamado($llamado, $postulacionesAEnviarCorreo);
            } catch (Exception $e) {
              return response()->json(['error' => 'Error al enviar correos electrónicos'], 406, []);
            }
          }
        } else {
          return response()->json(['error' => 'No se puede calificar el llamado en esta fecha'], 406, []);
        }
      } else {
        return response()->json(['error' => 'El llamado ya fue calificado'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Envie un llamado para calificar con al menos una postulación'], 406, []);
    }
  }

  private function enviarMailCalificacionLlamado($llamado, $postulacionesAEnviarCorreo)
  {
    if (count($postulacionesAEnviarCorreo) > 0) {
      $mail = new PHPMailer(true);

      $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'utn.facultad.regional.rosario@gmail.com';
      $mail->Password = env('MAIL_PASSWORD');
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );
      $mail->setFrom('utn.facultad.regional.rosario@gmail.com', 'UTN - FRRO');
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Subject = 'Orden de mérito - ' . $llamado->catedra->descripcion;
      $mail->Body = '
                    <div style="font-size: large;">
                      <p>¡Buen día!</p>
                      <p>Ya puede ver los resultados del llamado a cubir vacantes de la cátedra de ' .
        $llamado->catedra->descripcion . ' del ' . $llamado->fecha_inicio . ' en: <a href="' . frontPath . 'ordenesMerito" target="_blank">calificaciones</a></p>
                    </div>
                    ';

      foreach ($postulacionesAEnviarCorreo as $postulacion) {
        $mail->AddAddress($postulacion->persona->email);
      }

      $mail->send();
    }
  }

  public function agregarLlamado(Request $request)
  {
    if (
      $request->llamado
      && $request->llamado["fecha_inicio"]
      && $request->llamado["fecha_fin"]
      && $request->llamado["requisitos"]
      && $request->llamado["vacantes"]
      && $request->llamado["id_catedra"]
    ) {
      if (strtotime($request->llamado["fecha_inicio"]) >= strtotime(date('Y-m-d'))) {
        if (strtotime($request->llamado["fecha_inicio"]) <= strtotime($request->llamado["fecha_fin"])) {
          if ($request->llamado["requisitos"]) {
            if (
              is_numeric($request->llamado["vacantes"])
              && (int) $request->llamado["vacantes"] >= 1
              && (int) $request->llamado["vacantes"] <= 100
            ) {
              try {
                if (
                  is_numeric($request->llamado["id_catedra"])
                  && (int) $request->llamado["id_catedra"] > 0
                  && Catedra::find($request->llamado["id_catedra"])
                ) {
                  $llamado = new Llamado();

                  $llamado->fecha_inicio = $request->llamado["fecha_inicio"];
                  $llamado->fecha_fin = $request->llamado["fecha_fin"];
                  $llamado->requisitos = $request->llamado["requisitos"];
                  $llamado->vacantes = $request->llamado["vacantes"];
                  $llamado->calificado = false;
                  $llamado->id_catedra = $request->llamado["id_catedra"];

                  $llamado->save();
                } else {
                  return response()->json(['error' => 'El ID de cátedra ingresado no pertenece a una cátedra'], 406, []);
                }
              } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
              }
            } else {
              return response()->json(['error' => 'El número de personas que se pueden postular debe estar entre 1 y 100'], 406, []);
            }
          } else {
            return response()->json(['error' => 'Ingrese los requisitos'], 406, []);
          }
        } else {
          return response()->json(['error' => 'La fecha de cierre debe ser mayor o igual a la fecha de inicio'], 406, []);
        }
      } else {
        return response()->json(['error' => 'La fecha de inicio debe ser mayor o igual a la fecha actual'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese un llamado con todos sus datos'], 406, []);
    }
  }

  public function eliminarLlamado($id_llamado)
  {
    if ($id_llamado) {
      $llamado = Llamado::find($id_llamado);
      if ($llamado) {
        try {
          DB::beginTransaction();

          $llamado->postulaciones()->delete();
          $llamado->delete();

          DB::commit();
        } catch (Exception $e) {
          DB::rollback();

          return response()->json(['error' => $e->getMessage()], 406, []);
        }
      } else {
        return response()->json(['error' => 'No existe el llamado'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese el id del llamado a eliminar'], 406, []);
    }
  }
}
