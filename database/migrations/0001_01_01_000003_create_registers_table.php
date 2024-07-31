<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('nombres_y_apellidos');
            $table->string('codigo_c');
            $table->string('subir_video');
            $table->string('ciudad_donde_trabajas');
            $table->string('acepto_los_terminos_y_condiciones');
            $table->string('autorizo_el_tratamiento_de_mis_datos_personales_e_imagen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
