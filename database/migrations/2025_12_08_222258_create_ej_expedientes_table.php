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
        Schema::create('ej_expedientes', function (Blueprint $table) {
            $table->id('exp_id');
            $table->foreignId('exp_ejmid')->constrained('ejemplares','ejm_id');
            $table->enum('exp_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
            $table->enum('exp_del',['0','1'])->default('0');  ##### Binario de borrado lógico
            $table->string('exp_cexpname'); #### Categoría de expediente según
            $table->foreign('exp_cexpname')->references('cexp_name')->on('cat_tipoexpediente')->constrained('cat_tipoexpediente','cexp_name');
            $table->longText('exp_txt'); ##### Texto de descripcion
            $table->string('exp_file1')->nullable();  ##### Archivo
            $table->string('exp_file2')->nullable();  ##### Archivo
            $table->string('exp_file3')->nullable();  ##### Archivo
            $table->string('exp_file4')->nullable();  ##### Archivo
            $table->string('exp_file5')->nullable();  ##### Archivo
            $table->longText('exp_logmail')->nullable();  ##### Correos a los que se envió el equipo
            $table->date('exp_fecha'); ##### Fecha en la que se realizó
            $table->dateTime('exp_hora'); ##### Hora en la que se realizó
            $table->integer('exp_usrid'); #### usuario id

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_expedientes');
    }
};
