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
        Schema::create('kobo1', function (Blueprint $table) {
            $table->id('kobo1_id');
            $table->enum('kobo1_del',['0','1'])->default('0');
            $table->string('kobo1_ccamsiglas')->nullable();

            $table->bigInteger('kobo1_koboid')->unique(); #####
            $table->string('kobo1_index')->nullable();   #####
            $table->string('kobo1_username')->nullable();   #####
            $table->timestamp('kobo1_date')->nullable();      #####

            $table->string('kobo1_camellon')->nullable();   #####
            $table->string('kobo1_fotoubica')->nullable();   #####
            $table->decimal('kobo1_x',13,10)->nullable();   #####
            $table->decimal('kobo1_y',13,10)->nullable();   #####
            $table->string('kobo1_nombrecuadr')->nullable();   #####
            $table->string('kobo1_notasubica')->nullable();   #####

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kobo1');
    }
};
