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
        Schema::create('kobo2', function (Blueprint $table) {
            $table->id('kobo2_id');
            $table->enum('kobo2_del',['0','1'])->default('0');

            $table->bigInteger('kobo2_koboid')->foreignId('kobo1','kobo1_koboid')->onDelete('cascade'); #####
            $table->string('kobo2_parentindex')->nullable();   #####

            $table->string('kobo2_nombreejemplar')->nullable();   #####
            $table->string('kobo2_clavo')->nullable();   #####
            // $table->string('kobo2_tipoejem')->nullable();   #####
            // $table->string('kobo2_numcols')->nullable();   #####
            $table->integer('kobo2_numinds')->nullable();   #####
            $table->decimal('kobo2_numext',5,2)->nullable();   #####
            $table->string('kobo2_fotoejemplar')->nullable();   #####
            $table->string('kobo2_fotoejemplar2')->nullable();   #####
            $table->string('kobo2_fotoflor')->nullable();   #####
            $table->string('kobo2_fotohoja')->nullable();   #####
            $table->string('kobo2_fotofrutos')->nullable();   #####
            $table->string('kobo2_nombrecient')->nullable();   #####
            $table->string('kobo2_nombrecom')->nullable();   #####

            #####################################################
            ##################################### Datos de kobo1
            $table->string('kobo2_ccamsiglas')->nullable();

            $table->string('kobo2_username')->nullable();   #####
            $table->timestamp('kobo2_date')->nullable();      #####

            $table->string('kobo2_camellon')->nullable();   #####
            $table->string('kobo2_fotoubica')->nullable();   #####
            $table->decimal('kobo2_x',13,10)->nullable();   #####
            $table->decimal('kobo2_y',13,10)->nullable();   #####
            $table->string('kobo2_nombrecuadr')->nullable();   #####
            $table->string('kobo2_notasubica')->nullable();   #####

            $table->integer('kobo2_saved')->default('0');  ##### Indica el número de revisión


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kobo2');
    }
};
