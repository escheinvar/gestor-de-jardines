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
        if(!Schema::hasTable('ejemplares')){
            Schema::create('ejemplares', function (Blueprint $table) {
                $table->id('ejm_id');
                $table->enum('ejm_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
                $table->enum('ejm_del',['0','1'])->default('0');  ##### Binario de borrado lógico

                $table->enum('ejm_edo_ubica', ['0','1','2','3'])->default('0'); ##### Estado de ubicacion: 0-en campo, 1:en registro, 2:ingresada, 3:egresada
                $table->enum('ejm_edo_scname',['0','1','2','3'])->default('0'); ##### Estado de nombre científico: 0-sin nombre, 1-posible nombre, 2:nombre valida téncico, 3: nombre valida autoridad
                $table->enum('ejm_edo_name',  ['0','1','2','3'])->default('0'); ##### Estado de nombre común: 0-sin nombre, 1-posible nombre, 2:nombre valida téncico, 3: nombre valida autoridad
                $table->enum('ejm_edo_uso',   ['0','1','2','3'])->default('0'); ##### Estado de nombre común: 0-de escucha general;  1-registra informante local, 2:valida técnico, 3: valida autoridad o bibliografía,

                // $table->foreignId('ejm_ccamsiglas')->constrained('cat_campus','ccam_siglas')->onDelete('cascade');   ##### (ccam_id de tabla cat_campus) siglas del campus al que pertenece
                $table->string('ejm_ccamsiglas');    #### Siglas del campus al que accede
                $table->foreign('ejm_ccamsiglas')->references('ccam_siglas')->on('cat_campus')->onDelete('cascade')->constrained('cat_campus','ccam_siglas');

                $table->foreignId('ejm_bitid')->constrained('ej_bitacora1','bit_id')->onDelete('cascade');    ##### (bit_id de tabla ejm_bitacora1) Id de la bitácora que le corresponde
                $table->string('ejm_madreid')->nullable();      ##### (ejm_id de esta tabla) de la madre del ejemplar or null en caso de nuevos ingresos
                $table->string('ejm_padreid')->nullable();      ##### (ejm_id de esta tabla) del padre del ejemplar or null en caso de desconocido.
                $table->string('ejm_loteid')->nullable();       ##### (id de tabla de lotes) id del lote del que proviene el ejemplar or null

                #$table->integer('ejm_scnmid')->nullable();       ##### (scnme_id de tabla ej_nombre_cient) con id del nombre científico or null
                #$table->string('ejm_scnmnombre')->nullable();    ##### (scnme_nombre de tabla ej_nombre_cient) n caso de haber nombre científico, or null
                $table->date('ejm_ripdate')->nullable();         ##### Fecha de muerte del ejemplar or null
                $table->string('ejm_ripcausa')->nullable();      ##### Texto explicando la causa de la muerte
                $table->longText('ejm_notasingreso')->nullable();##### Notas sobre el ingreso del ejemplar
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejemplares');
    }
};
