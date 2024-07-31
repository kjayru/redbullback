<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Register;
use App\Models\CarrosLocos;
use Carbon\Carbon;

class ProcessController extends Controller
{
    public function index(){
        dd("sistema de registro");
    }
    public function registro(Request $request){

        $registro = [];
        $registro2 = [];
      
        $registro['nombres_y_apellidos'] = $request->nombres_y_apellidos;
        $registro['codigo_c'] = $request->codigo_c;
        if ($request->hasFile('subir_video')) {
            $video = Storage::disk('public')->putFile('uploads', $request->file('subir_video'));
            $registro['subir_video']= env('HOST_HUESPED').$video;
        }
        $registro['ciudad_donde_trabajas'] = $request->ciudad_donde_trabajas;
        $registro['acepto_los_terminos_y_condiciones'] = $request->acepto_los_terminos_y_condiciones;
        $registro['autorizo_el_tratamiento_de_mis_datos_personales_e_imagen'] = $request->autorizo_el_tratamiento_de_mis_datos_personales_e_imagen;
        $registro['created_at']= Carbon::now();
        $registro['updated_at']= Carbon::now();
       // DB::table("registers")->insert($registro);
     
        $datos = Register::create($registro);

        DB::setDefaultConnection("mysql");


        $registro2['nombres_y_apellidos'] = $request->nombres_y_apellidos;
        $registro2['codigo_c'] = $request->codigo_c;
        if ($request->hasFile('subir_video')) {
            $video = Storage::disk('public')->putFile('uploads', $request->file('subir_video'));
            $registro2['subir_video']= env('HOST_HUESPED').$video;
        }
        $registro2['ciudad_donde_trabajas'] = $request->ciudad_donde_trabajas;
        $registro2['acepto_los_terminos_y_condiciones'] = $request->acepto_los_terminos_y_condiciones;
        $registro2['autorizo_el_tratamiento_de_mis_datos_personales_e_imagen'] = $request->autorizo_el_tratamiento_de_mis_datos_personales_e_imagen;
        $registro2['created_at']= $datos->created_at;
        $registro2['updated_at']= $datos->updated_at;

        DB::table("carros_locos_233")->insert($registro2);
    
       return response()->json(['success'=>200]);
    }
}
