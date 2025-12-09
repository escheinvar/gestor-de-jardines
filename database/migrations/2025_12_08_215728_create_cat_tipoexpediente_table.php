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
        Schema::create('cat_tipoexpediente', function (Blueprint $table) {
            $table->id('cexp_id');
            $table->string('cexp_name')->unique(); ##### Nombre de la categoría de expediente
            $table->enum('cexp_alarma',['1','0'])->default('0'); ##### Flag de existe(1) o no (0) alarma (email) para esta categoría
            $table->string('cexp_asunto')->nullable(); #### Texto del asunto que que lleva el email
            $table->longText('cexp_txt1')->nullable(); ##### Texto previo a la descripción del expediente que llevará el email
            $table->longText('cexp_txt2')->nullable(); ##### Texto posterior a la descripción del expediente que llevará el email
            $table->string('cexp_explica')->nullable(); ##### Explicación de la categoría
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_tipoexpediente');
    }
};
