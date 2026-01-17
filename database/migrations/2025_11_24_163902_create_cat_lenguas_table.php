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
        if(!Schema::hasTable('cat_lenguas')){
            Schema::create('cat_lenguas', function (Blueprint $table) {
                $table->id('clen_id');
                $table->string('clen_lengua'); ##### Nombre de la lengua en español
                $table->string('clen_code')->unique()->key();  ##### Código usado por el sistema para identificar la lengua
                $table->longText('clen_localidad')->nullable();  ##### Nombre de localidad de referencia
                $table->string('clen_usuarios')->nullable();   ##### Número de usuarios que lo hablan
                $table->string('clen_status')->nullable();   ##### Status sensu etnolog
                $table->string('clen_altnames')->nullable(); ##### Nombres alternativos
                $table->string('clen_autonimias')->nullable(); ##### Nombre,de la lengua según la propia lengua
                $table->string('clen_clasifica')->nullable();
                $table->integer('clen_originario');    ##### Indica si es 1 o no 0 lengua de pueblo originario

                #$table->string('clen_alias')->nullable();  #### arreglo de alias separados por punto y coma
                #$table->string('clen_region')->nullable(); ##### Texto con la región geogràfica en la que se habla la lengua
                #$table->string('clen_observa')->nullable();  ##### En caso de haber, observaciones a la lengua
                #$table->string('clen_audio')->nullable(); ##### ubicación del archivo con el audio de la lengua
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_lenguas');
    }
};
