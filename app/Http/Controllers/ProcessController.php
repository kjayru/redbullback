<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Models\Register;
use App\Models\Registro;
use GuzzleHttp\Client;
use App\Models\CarrosLocos;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function index()
    {
        dd("sistema de registro");
    }

    public function registro(Request $request){

        // $request->validate([
        //     'g-recaptcha-response' => 'required',
        // ]);


        // $client = new Client();
        // $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'form_params' => [
        //         'secret' => env('CAPTCHA_SECRET'),
        //         'response' => $request->input('g-recaptcha-response'),
        //     ],
        // ]);

        // $body = json_decode((string)$response->getBody());


        // if (!isset($body->success) || !$body->success || !isset($body->score)) {
        //     return response()->json(['error' => 'La verificación de reCAPTCHA falló.'], 400);
        // }


        // if ($body->score < 0.7) {
        //     return response()->json(['error' => 'La puntuación de reCAPTCHA es insuficiente.'], 400);
        // }

        $registro = [];
        $registro2 = [];

        $registro['nombres_y_apellidos'] = $request->nombres_y_apellidos;
        $registro['codigo_c'] = $request->codigo_c;
        if ($request->hasFile('subir_imagen')) {
            $imagen = Storage::disk('public')->putFile('uploads', $request->file('subir_imagen'));
            $registro['subir_imagen']= env('HOST_HUESPED').$imagen;
        }
        $registro['ciudad_donde_trabajas'] = $request->ciudad_donde_trabajas;
        $registro['region_donde_trabajas'] = $request->region_donde_trabajas;
        $registro['acepto_los_terminos_y_condiciones'] = $request->acepto_los_terminos_y_condiciones;
        $registro['autorizo_el_tratamiento_de_mis_datos_personales_e_imagen'] = $request->autorizo_el_tratamiento_de_mis_datos_personales_e_imagen;
        $registro['created_at']= Carbon::now();
        $registro['updated_at']= Carbon::now();
       // DB::table("registers")->insert($registro);

        $datos = Registro::create($registro);

        DB::setDefaultConnection("mysql");


        $registro2['nombres_y_apellidos'] = $request->nombres_y_apellidos;
        $registro2['codigo_c'] = $request->codigo_c;
        $registro2['subir_imagen']= $datos->subir_imagen;
        $registro2['ciudad_donde_trabajas'] = $request->ciudad_donde_trabajas;
        $registro2['region_donde_trabajas'] = $request->region_donde_trabajas;
        $registro2['acepto_los_terminos_y_condiciones'] = $request->acepto_los_terminos_y_condiciones;
        $registro2['autorizo_el_tratamiento_de_mis_datos_personales_e_imagen'] = $request->autorizo_el_tratamiento_de_mis_datos_personales_e_imagen;
        $registro2['created_at']= $datos->created_at;
        $registro2['updated_at']= $datos->updated_at;

      $guest_id = DB::table("carros_locos_boceto_claro_245")->insertGetId($registro2);

        $basepath = "https://www.claro.com.pe/gracias-crm";
        $form_id = '245';

        $cadena = $form_id."_".$guest_id;
        $variable_de_envio =  Crypt::encryptString($cadena);
        $path = $basepath."?op=".$variable_de_envio;


       return response()->json(['success'=>200,'url_redirect'=>$path]);
    }
}
