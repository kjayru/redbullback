<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Register;
use App\Models\CarrosLocos;

class ProcessController extends Controller
{
    public function index(){
        dd("sistema de registro");
    }
    public function registro(Request $request){


        $registro = [];
      
        $registro['nombres_y_apellidos'] = $request->nombres_y_apellidos;
        $registro['codigo_c'] = $request->codigo_c;
        if ($request->hasFile('subir_video')) {
            $video = Storage::disk('public')->putFile('uploads', $request->file('subir_video'));
            $registro['subir_video']= env('HOST_HUESPED').$video;
        }
        $registro['ciudad_donde_trabajas'] = $request->ciudad_donde_trabajas;
        $registro['acepto_los_terminos_y_condiciones'] = $request->acepto_los_terminos_y_condiciones;
        $registro['autorizo_el_tratamiento_de_mis_datos_personales_e_imagen'] = $request->autorizo_el_tratamiento_de_mis_datos_personales_e_imagen;

       // DB::table("registers")->insert($registro);
     
        Register::create($registro);

        DB::setDefaultConnection("mysql");

        DB::table("carros_locos_233")->insert($registro);
    
       return response()->json(['success'=>200]);
    }
}
