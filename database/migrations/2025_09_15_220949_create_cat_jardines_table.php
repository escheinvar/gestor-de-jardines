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
        if(!Schema::hasTable('cat_jardines')){
            Schema::create('cat_jardines', function (Blueprint $table) {
                $table->id('cjar_id');
                $table->string('cjar_siglas')->unique();    ##### siglas del jardín (ej. JebOax)
                $table->string('cjar_name');                ##### nombre corto del jardín (ej. Etnobotánico de Oaxaca)
                $table->string('cjar_nombre');              ##### nombre completo del jardín (ej. Jardín Etnobotánico de Oaxaca)
                $table->string('cjar_tipo')->nullable();    ##### tipo de jardín (ej. Etnobiológico, Comunitario, Escolar)
                $table->string('cjar_direccion')->nullable();##### Dirección del jardín
                $table->string('cjar_tel')->nullable();     ###### Teléfono del jardín
                $table->string('cjar_mail')->nullable();    ###### Correo electrónico del jardín
                $table->string('cjar_edo')->nullable();     ##### Estado de la república en el que está el jardín
                $table->string('cjar_logo')->nullable();     ##### Ubicación del archivo con el logo del jardín
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_jardines');
    }
};
