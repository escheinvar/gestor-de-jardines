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
        if (!Schema::hasTable('ej_nombres_cientificos')) {
            Schema::create('ej_nombres_cientificos', function (Blueprint $table) {
                ######### Ojo: esta tabla tiene el campo scn_edo y además, cada que cambie,
                #########      debe afectar a la tabla ejemplares
                $table->id('scn_id');
                $table->foreignId('scn_ejmid')->constrained('ejemplares','ejm_id')->onDelete('cascade');
                $table->foreignId('scn_spid')->constrained('especies','sp_id')->onDelete('cascade');
                $table->enum('scn_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
                $table->enum('scn_del',['0','1'])->default('0');  ##### Binario de borrado lógico
                $table->integer('scn_edo')->default('0');         ##### Estado del nombre: 0:sin validar, 1=valida técnico, 2=valida autoridad
                $table->enum('scn_reino',['an','pl','ho','pr','ar','ba']); ##### Reino al que pertenece: an=animal, pl=Plantas, ho=hongos, pr=protistas, ar=arquea, ba=bacteria
                $table->string('scn_familia')->nullable();   ##### Familia biológica
                $table->string('scn_genero')->nullable();       ##### Texto con el género
                $table->string('scn_sp')->nullable();           ##### texto de la especie
                $table->string('scn_ssp')->nullable();##### Texto con la categoría y nombre subespecífico (ej: subsp. bla ó var. ble)
                $table->string('scn_name')->nullable();          ##### Texto con el nombre científico completo: Genero, especie ssp

                $table->foreignId('scn_colid')->constrained('cat_autoridades','aut_id')->onDelete('cascade')->nullable(); ##### ID de la autoridad que identificó
                $table->date('scn_fecha_determina')->nullable(); ##### Fecha en la que la autoridad determina
                $table->integer('scn_usrid'); ##### ID del usuario que registra
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_nombres_cientificos');
    }
};
