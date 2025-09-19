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
        if(!Schema::hasTable('cat_campus')){
            Schema::create('cat_campus', function (Blueprint $table) {
                $table->id('ccam_id');
                $table->enum('ccam_act',['0','1'])->default('1');  ##### borrado lógico
                $table->foreignId('ccam_cjarid')->constrained('cat_jardines','cjar_id'); ##### Id del jardín al que  pertenece
                $table->string('ccam_siglas')->unique(); ##### Siglas del campus
                $table->string('ccam_name');  ##### Nombre corto del campus (ej: Jardín ó Canteras)
                $table->string('ccam_nombre');  ##### Nombre completo del campus (ej: Jardín Etnobotánico ó Parque de Canteras en Archivo)
                $table->string('ccam_direccion')->nullable();  ##### Dirección del jardín
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_campus');
    }
};
