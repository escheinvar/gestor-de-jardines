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
        Schema::create('ej_ubicaciones', function (Blueprint $table) {
            $table->id('sig_id');
            $table->foreignId('sig_ejmid')->constrained('ejemplares','ejm_id');  ##### Id del ejemplar al que pertenece el nombre
            $table->enum('sig_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
            $table->enum('sig_del',['0','1'])->default('0');  ##### Binario de borrado lógico

            $table->string('sig_ccamsiglas'); ##### Siglas del campus al que pertenece el ejemplar
            // $table->foreign('sig_ccamsiglas')->references('ccam_siglas')->on('cat_campus')->constrained('cat_campus','ccam_siglas'); ##### Siglas del campus al que pertenece el ejemplar

            $table->foreignId('sig_camid')->constrained('cat_camellones','cam_id'); ##### Id del camellón en el que está el ejemplar
            $table->string('sig_camcamellon');  #### Nombre del camellón en el que está el ejemplar
            // $table->foreign('sig_camcamellon')->references('cam_camellon')->on('cat_camellones')->constrained('cat_camellones','cam_camellon'); #### Nombre del camellón en el que está el ejemplar
            $table->decimal('sig_x',12,9);  #### Longitud de la ubicación
            $table->decimal('sig_y',12,9);  #### Latitud de la ubicación

            $table->enum('sig_restriccion',['0','1'])->default('0');  ##### Binario de restricción: 0=público, 1=restringido
            $table->string('sig_tipocrecim')->nullable(); #### indica el tipo de crecimiento según cat_conceptos: tipo-crecimiento (individual distinguible, individal en colonia, colonial, indistinguible)
            $table->string('sig_icono')->nullable();  #### Nombre icon_name de tabla cat_iconos
            $table->integer('sig_usrid'); #### Id usr de quien captura la ubicación
            $table->longText('sig_notas')->nullable(); ##### notas sobre la ubicación

            $table->string('flag1')->nullable(); ##### Flag de apoyo para digitalización con kobo
            $table->string('flag2')->nullable(); ##### Flag de apoyo para digitalización con kobo
            $table->string('flag3')->nullable(); ##### Flag de apoyo para digitalización con kobo
            $table->string('flag4')->nullable(); ##### Flag de apoyo para digitalización con kobo
            $table->string('flag5')->nullable(); ##### Flag de apoyo para digitalización con kobo


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_ubicaciones');
    }
};
