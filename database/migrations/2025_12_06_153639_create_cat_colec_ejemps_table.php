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
        Schema::create('cat_colec_ejemps', function (Blueprint $table) {
            $table->id('colsej_id');
            $table->string('colsej_ccamsiglas');    ##### Siglas del campus al que pertenece la colección
            $table->string('colsej_name')->unique(); ###### Nombre de la colección
            $table->string('colsej_explica')->nullable(); #### Explicación de en que consiste la colección
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_colec_ejemps');
    }
};
