<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Rol;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../../../config/PHPMailer/Exception.php';
require __DIR__ . '/../../../config/PHPMailer/PHPMailer.php';
require __DIR__ . '/../../../config/PHPMailer/SMTP.php';


class PersonaController extends Controller
{
    function signUp(Request $request)
    {
        if (
            $request->dni
            && strlen($request->dni) <= 30
            && is_numeric($request->dni)
            && $request->imagen_dni
            && $request->hasFile('imagen_dni')
            && $request->nombre_usuario
            && strlen($request->nombre_usuario) >= 6
            && strlen($request->nombre_usuario) <= 30
            && $request->clave
            && strlen($request->clave) >= 8
            && strlen($request->clave) <= 40
            && $request->nombre_apellido
            && strlen($request->nombre_apellido) <= 60
            && $request->email
            && strlen($request->email) <= 60
            && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $request->email)
            && $request->telefono
            && strlen($request->telefono) <= 60
            && is_numeric($request->telefono)
            && $request->curriculum_vitae
            && $request->hasFile('curriculum_vitae')
        ) {
            try {
                if (!Persona::where('dni', $request->dni)->first()) {
                    if (!Persona::where('nombre_usuario', $request->nombre_usuario)->first()) {
                        DB::beginTransaction();

                        $persona = new Persona();

                        $persona->dni = $request->dni;
                        $persona->nombre_usuario = $request->nombre_usuario;
                        $persona->clave = Hash::make($request->clave);
                        $persona->nombre_apellido = $request->nombre_apellido;
                        $persona->email = $request->email;
                        $persona->telefono = $request->telefono;
                        $persona->verificada = false;

                        $persona->save();

                        $fileDNI = $request->file('imagen_dni');
                        $nameDNI = 'DNI_' . Str::random(5) . $persona->id . Str::random(5) . '.pdf';
                        $fileDNI->move(base_path('public') . '/DNIs/', $nameDNI);
                        $persona->imagen_dni = $nameDNI;

                        $fileCV = $request->file('curriculum_vitae');
                        $nameCV = 'CV_' . Str::random(5) . $persona->id . Str::random(5) . '.pdf';
                        $fileCV->move(base_path('public') . '/CVs/', $nameCV);
                        $persona->curriculum_vitae = $nameCV;

                        $persona->api_token = Str::random(30) . $persona->id . Str::random(30);

                        $persona->save();

                        $persona->roles()->attach(Rol::where('descripcion', 'Usuario')->first()->id);

                        DB::commit();
                    } else {
                        return response()->json(['error' => 'El nombre de usuario ya se encuentra registrado'], 406, []);
                    }
                } else {
                    return response()->json(['error' => 'El DNI ya se encuentra registrado'], 406, []);
                }
            } catch (Exception $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()], 406, []);
            }
        } else {
            return response()->json(['error' => 'Ingrese todos los datos de la persona en el formato correcto'], 406, []);
        }
    }

    function signIn(Request $request)
    {
        if (
            $request->nombre_usuario
            && strlen($request->nombre_usuario) >= 6
            && strlen($request->nombre_usuario) <= 30
            && $request->clave
            && strlen($request->clave) >= 8
            && strlen($request->clave) <= 40
        ) {
            try {
                $persona = Persona::where('nombre_usuario', $request->nombre_usuario)->first();

                if ($persona) {
                    if ($persona->verificada) {
                        if (Hash::check($request->clave, $persona->clave)) {
                            $persona->roles;

                            return response()->json($persona, 200);
                        } else {
                            return response()->json(['error' => 'Clave incorrecta'], 406, []);
                        }
                    } else {
                        return response()->json(['error' => 'Persona pendiente de verificación'], 406, []);
                    }
                } else {
                    return response()->json(['error' => 'Persona no encontrada'], 406, []);
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
            }
        } else {
            return response()->json(['error' => 'Ingrese el nombre de usuario y la clave en el formato correcto'], 406, []);
        }
    }

    public function perfil()
    {
        try {
            $persona = Persona::find(auth()->user()->id);

            return response()->json($persona);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 406, []);
        }
    }

    public function editarPerfil(Request $request)
    {
        if (
            $request->nombre_usuario
            && strlen($request->nombre_usuario) >= 6
            && strlen($request->nombre_usuario) <= 30
            && $request->clave
            && strlen($request->clave) >= 8
            && strlen($request->clave) <= 40
            && $request->cambiar_clave !== null
            && $request->email
            && strlen($request->email) <= 60
            && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $request->email)
            && $request->telefono
            && strlen($request->telefono) <= 60
            && (!$request->cambiar_clave ||
                ($request->cambiar_clave
                    && $request->nueva_clave
                    && strlen($request->nueva_clave) >= 8
                    && strlen($request->nueva_clave) <= 40))
        ) {
            try {
                $persona = Persona::find(auth()->user()->id);

                if (Hash::check($request->clave, $persona->clave)) {
                    if (!Persona::where([['nombre_usuario', $request->nombre_usuario], ['id', '<>', auth()->user()->id]])->first()) {
                        $persona->nombre_usuario = $request->nombre_usuario;
                        $persona->email = $request->email;
                        $persona->telefono = $request->telefono;
                        if ($request->cambiar_clave) {
                            $persona->clave = Hash::make($request->nueva_clave);
                        }

                        $persona->save();

                        $persona->roles;

                        return response()->json($persona);
                    } else {
                        return response()->json(['error' => 'El nombre de usuario ya se encuentra registrado'], 406, []);
                    }
                } else {
                    return response()->json(['error' => 'Clave incorrecta'], 406, []);
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
            }
        } else {
            return response()->json(['error' => 'Ingrese todos los datos requeridos en el formato correcto'], 406, []);
        }
    }

    public function actualizarCV(Request $request)
    {
        if ($request->curriculum_vitae && $request->hasFile('curriculum_vitae')) {
            try {
                $file = $request->file('curriculum_vitae');
                $name = 'CV_' . Str::random(5) . auth()->user()->id . Str::random(5) . '.pdf';
                $file->move(base_path('public') . '/CVs/', $name);

                $persona = Persona::find(auth()->user()->id);
                $persona->curriculum_vitae = $name;
                $persona->save();

                return response()->json($persona->curriculum_vitae);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
            }
        } else {
            return response()->json(['error' => 'Envie su curriculum vitae'], 406, []);
        }
    }

    public function buscarPersonasNoVerificadas()
    {
        try {
            $personas = Persona::where('verificada', false)->get();

            return response()->json($personas);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 406, []);
        }
    }

    public function aceptarPersona(Request $request)
    {
        if ($request->id_persona) {
            try {
                $persona = Persona::find($request->id_persona);

                if ($persona) {
                    $persona->verificada = true;
                    $persona->save();
                    $this->enviarMailVerificacionIdentidad($persona, true);
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
            }
        } else {
            return response()->json(['error' => 'Ingrese el ID de la persona a aceptar'], 406, []);
        }
    }

    public function rechazarPersona(Request $request)
    {
        if ($request->id_persona) {
            try {
                $persona = Persona::find($request->id_persona);

                if ($persona) {
                    $persona->delete();
                    $this->enviarMailVerificacionIdentidad($persona, false);
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
            }
        } else {
            return response()->json(['error' => 'Ingrese el ID de la persona a rechazar'], 406, []);
        }
    }

    private function enviarMailVerificacionIdentidad($persona, $aceptada)
    {
        if ($persona) {
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
            $mail->AddAddress($persona->email);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Verificación Identidad';
            if ($aceptada) {
                $mail->Body = '
            <div style="font-size: large;">
              <p>¡Buen día!</p>
              <p>La identidad de <strong>' . $persona->nombre_apellido . '</strong> con DNI N° <strong>' .
                    $persona->dni . '</strong> fue verificada exitosamente.</p>
              <p>Ya puede ingresar al sistema con el usuario: ' . $persona->nombre_usuario . '</p>
              <p><a href="http://localhost:8080/" target="_blank">UTN - Facultad Regional Rosario</a></p>
            </div>
            ';
            } else {
                $mail->Body = '
            <div style="font-size: large;">
              <p>¡Buen día!</p>
              <p>No se ha podido verificar la identidad de <strong>' . $persona->nombre_apellido . '</strong> con DNI N° <strong>' .
                    $persona->dni . '</strong> del usuario: ' . $persona->nombre_usuario . '.</p>
              <p>Si considera que es un error contáctese directamente con la facultad.</p>
            </div>
            ';
            }

            $mail->send();
        }
    }

    public function buscarPersonas()
    {
        try {
            $personas = Persona::all();

            return response()->json($personas);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 406, []);
        }
    }
}
