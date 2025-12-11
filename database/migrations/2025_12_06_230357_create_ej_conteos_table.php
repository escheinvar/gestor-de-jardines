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
        Schema::create('ej_conteos', function (Blueprint $table) {
            $table->id('cant_id');
            $table->foreignId('cant_ejmid')->constrained('ejemplares','ejm_id');  ##### Id del ejemplar al que pertenece el conteo
            $table->foreignId('cant_ubicaid')->constrained('ej_ubicaciones','sig_id'); #### Id de la ubicación en la que se hizo el conteo
            $table->enum('cant_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
            $table->enum('cant_del',['0','1'])->default('0');  ##### Binario de borrado lógico

            $table->string('cant_tipo')->nullable(); ##### algún tipo-crecimiento de tabla cat_conceptos: (incividual distinguible, individual en colonia, colonial, indistinguible)
            $table->integer('cant_inds')->default('0'); #### Número de individuos o área en todas las colonias (0 para incontable)
            $table->decimal('cant_cols',5,2)->default('1');   ##### Extensión del ejemplar a nivel de piso en metros cuadrados
            $table->date('cant_fecha'); ##### Fecha de toma de dato
            $table->integer('cant_usrid'); ##### Id del usuario que registra
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_conteos');
    }
};
