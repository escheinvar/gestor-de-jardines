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
        ######## crea catálogo de estados
        if(!Schema::hasTable('cat_estados')){
            Schema::create('cat_estados', function (Blueprint $table) {
                $table->id('cedo_id');
                $table->string('cedo_nombre');
                $table->string('cedo_abrevia');
                $table->timestamps();
            });
        }
        ######### Crea catálogo de municipios
        if(!Schema::hasTable('cat_municipios')){
        Schema::create('cat_municipios', function (Blueprint $table) {
            $table->id('cmun_id');
            $table->integer('cmun_cedoid');
            $table->string('cmun_edoname');
            $table->integer('cmun_mpioid');
            $table->string('cmun_mpioname');
            $table->integer('cmun_cabeceraid');
            $table->string('cmun_cabeceraname');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_estados');
        Schema::dropIfExists('cat_municipios');
    }
};
