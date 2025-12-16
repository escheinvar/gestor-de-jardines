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
        Schema::create('cat_gridas', function (Blueprint $table) {
            $table->id('gri_id');
            $table->enum('gri_del',['0','1'])->default('0');  ##### Borrado lógico
            $table->enum('gri_act',['0','1'])->default('1');  ##### Binario de inactivación lógico
            $table->string('gri_name');         ##### Nombre de la grida
            $table->longText('gri_explica')->nullable(); ##### Explicación de la grida
            $table->string('gri_ccamsiglas');   ##### Campus al que pertenece
            $table->foreign('gri_ccamsiglas')->references('ccam_siglas')->on('cat_campus')->constrained('cat_campus','ccam_siglas'); ### Id del campus al que pertenece el camellón
            $table->decimal('gri_resx')->nullable();  ##### Resolución en metros de la longitud x
            $table->decimal('gri_resy')->nullable();  ##### Resolución en metros de la latitud y
            $table->json('gri_mapa')->nullable();     #### Json del polígono del camellón
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_gridas');
    }
};
