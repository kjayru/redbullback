<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $table="registros";

    protected $fillable = [
        'nombres_y_apellidos',
        'codigo_c',
        'subir_imagen',
        'ciudad_donde_trabajas',
        'region_donde_trabajas',
        'acepto_los_terminos_y_condiciones',
        'autorizo_el_tratamiento_de_mis_datos_personales_e_imagen',
    ];
}
