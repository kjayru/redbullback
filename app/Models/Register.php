<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres_y_apellidos',
        'codigo_c',
        'subir_video',
        'ciudad_donde_trabajas',
        'acepto_los_terminos_y_condiciones',
        'autorizo_el_tratamiento_de_mis_datos_personales_e_imagen',
    ];
}

