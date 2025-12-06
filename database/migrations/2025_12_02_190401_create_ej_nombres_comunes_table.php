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
        Schema::create('ej_nombres_comunes', function (Blueprint $table) {
            $table->id('con_id');
            $table->foreignId('con_ejmid')->constrained('ejemplares','ejm_id');  ##### Id del ejemplar al que pertenece el nombre
            $table->enum('con_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
            $table->enum('con_del',['0','1'])->default('0');  ##### Binario de borrado lógico
            $table->enum('con_origen',['0','1'])->default('0');  ##### Flag que indica si el nombre (1) es del sitio de colecta o (0) no es del sitio de colecta
            // $table->integer('con_edo')->default('0');  ##### Estado: 0=Si cita; 1=CitaComPers; 2=CitaAcademica;
            $table->string('con_nombre'); ##### Texto con el nombre
            $table->string('con_clencode'); ##### código de 3 letras de ethnologue del nombre
            $table->foreign('con_clencode')->references('clen_code')->on('cat_lenguas')->constrained('cat_lenguas','clen_code'); ##### código de la lengua

            $table->integer('con_bibid')->constrained('bibliografias','bib_id')->nullable();##### Id de la cita bibliográfica
            $table->longText('con_ubica')->nullable(); ##### Array; con Estado,Mpio; del nombre
            // $table->string('con_estado')->nullable(); ##### Estado de la república de origen del nombre
            // $table->string('con_mpio')->nullable(); ##### Municipio en el que se aplica el nombre
            $table->longText('con_notas')->nullable(); ##### Notas sobre el nombre


            $table->string('con_file1')->nullable(); ##### Ruta al audio con la pronunciación
            $table->string('con_file2')->nullable(); ##### Ruta al audio con la pronunciación
            $table->string('con_file3')->nullable(); ##### Ruta al archivo de imagen del nombre
            $table->string('con_file4')->nullable(); ##### Ruta al archivo de imagen del nombre

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_nombres_comunes');
    }
};
