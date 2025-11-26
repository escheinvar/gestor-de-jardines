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
        if(!Schema::hasTable('cat_tipoimgs')){
            Schema::create('cat_tipoimgs', function (Blueprint $table) {
                $table->id('cimg_id');
                $table->string('cimg_modulo');  ##### Módulo al que refiere: colecta, herbario, ejemplar, etc...
                $table->string('cimg_tipo')->unique();    ##### Nombre del tipo
                $table->string('cimg_explica')->nullable();
                // $table->unique(['cimg_modulo','cimg_tipo']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_tipoimgs');
    }
};
