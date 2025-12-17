<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cat_subcolecciones', function (Blueprint $table) {
            $table->id('ccol_id');
            $table->enum('ccol_del',['0','1'])->default('0');  ##### Borrado lógico
            $table->enum('ccol_act',['0','1'])->default('1');  ##### Binario de inactivación lógico
            $table->string('ccol_coleccion')->unique(); ##### Nombre de la colección
            $table->string('ccol_explica')->nullable(); ##### Explicación de la colección
            $table->string('ccol_icono')->nullable();   ##### ícono de la colección
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_subcolecciones');
    }
};
