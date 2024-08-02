<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Register;
use GuzzleHttp\Client;
use App\Models\CarrosLocos;

class ProcessController extends Controller
{
    public function index()
    {
        dd("sistema de registro");
    }

    public function registro(Request $request)
    {
        // Validar la respuesta del reCAPTCHA
        $request->validate([
            'g-recaptcha-response' => 'required',
        ]);

        // Verificar la puntuación del reCAPTCHA
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('CAPTCHA_SECRET'),
                'response' => $request->input('g-recaptcha-response'),
            ],
        ]);

        $body = json_decode((string)$response->getBody());

        // Asegurarse de que la respuesta contiene 'success' y 'score'
        if (!isset($body->success) || !$body->success || !isset($body->score)) {
            return response()->json(['error' => 'La verificación de reCAPTCHA falló.'], 400);
        }

        // Asegurarse de que la puntuación sea mayor a 0.7 (ajustando al rango 0.0 a 1.0 de reCAPTCHA v3)
        if ($body->score < 0.7) {
            return response()->json(['error' => 'La puntuación de reCAPTCHA es insuficiente.'], 400);
        }

        // Procesar el registro
        $registro = [];

        $registro['nombres_y_apellidos'] = $request->nombres_y_apellidos;
        $registro['codigo_c'] = $request->codigo_c;
        if ($request->hasFile('subir_video')) {
            $video = Storage::disk('public')->putFile('uploads', $request->file('subir_video'));
            $registro['subir_video'] = env('HOST_HUESPED') . $video;
        }
        $registro['ciudad_donde_trabajas'] = $request->ciudad_donde_trabajas;
        $registro['acepto_los_terminos_y_condiciones'] = $request->acepto_los_terminos_y_condiciones;
        $registro['autorizo_el_tratamiento_de_mis_datos_personales_e_imagen'] = $request->autorizo_el_tratamiento_de_mis_datos_personales_e_imagen;

        // Guardar en la base de datos
        Register::create($registro);

        DB::setDefaultConnection("mysql");

        DB::table("carros_locos_233")->insert($registro);

        return response()->json(['success' => 200]);
    }
}
