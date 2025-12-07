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
        Schema::create('cat_iconos', function (Blueprint $table) {
            $table->id('icon_id');
            $table->string('icon_name')->unique(); ##### Nombre del ícono
            $table->string('icon_file');    ##### Nombre y del archivo en /public/iconos/
            $table->string('icon_ancho')->nullable(); #### ancho predeterminado en  px
            $table->string('icon_largo')->nullable(); #### largo predeterinado en px;
            $table->string('icon_col')->nullable(); ### color predeterminado
            $table->string('icon_bgcol')->nullable(); ### Background color predeterminado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_iconos');
    }
};
