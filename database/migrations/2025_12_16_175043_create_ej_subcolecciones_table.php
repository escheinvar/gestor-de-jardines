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
        Schema::create('ej_subcolecciones', function (Blueprint $table) {
            $table->id('col_id');
            $table->enum('col_del',['0','1'])->default('0');  ##### Borrado lógico
            $table->enum('col_act',['0','1'])->default('1');  ##### Binario de inactivación lógico
            $table->foreignId('col_ejmid')->constrained('ejemplares','ejm_id'); #### Id del ejemplar que pertenece a la subcolección
            $table->string('col_ccolcoleccion'); ##### nombre de la subcolección a la que pertenece
            $table->foreign('col_ccolcoleccion')->references('ccol_coleccion')->on('cat_subcolecciones')->constrained('cat_subcolecciones','ccol_coleccion');
            $table->integer('col_usrid'); #### Id del usuario que regisra
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_subcolecciones');
    }
};
