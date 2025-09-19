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
        // --------------- En producción
        if(!Schema::hasTable('usr_roles')){
            Schema::create('usr_roles', function (Blueprint $table) {
                $table->id('rol_id');
                $table->enum('rol_del',['0','1'])->default('0');  ##### Borrado lógico
                $table->enum('rol_act',['0','1'])->default('1');  ##### Binario de inactivación lógico
                $table->foreignId('rol_usrid')->constrained('users','id'); #### número id del usuario (de table users)

                $table->string('rol_ccamsiglas');    #### Siglas del campus al que accede
                // $table->foreign('rol_ccamsiglas')->references('ccam_siglas')->on('cat_campus')->onDelete('cascade')->constrained('cat_campus','ccam_siglas');

                $table->string('rol_crolrol')->default('amigo');  ##### rol al que accede
                $table->foreign('rol_crolrol')->references('crol_rol')->on('cat_roles')->onDelete('cascade')->constrained('cat_roles','crol_rol');

                $table->string('rol_tipo1')->nullable();  ##### En caso de requerirse, descriptor del rol (x ej, con admin-jardin: "JebOax")
                $table->string('rol_tipo2')->nullable();  ##### En caso de requerirse, descriptor del rol (x ej, con admin-jardin: "animales")
                $table->string('rol_describe')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_roles');
    }
};
