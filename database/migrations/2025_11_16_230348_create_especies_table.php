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
        if (!Schema::hasTable('especies')) {
            Schema::create('especies', function (Blueprint $table) {
                $table->id('sp_id');
                $table->enum('sp_reino',['an','pl','ho','pr','ar','ba']); ##### Reino al que pertenece: an=animal, pl=Plantas, ho=hongos, pr=protistas, ar=arquea, ba=bacteria
                $table->string('sp_familia');   ##### Familia biológica
                $table->string('sp_genero');       ##### Texto con el género
                $table->string('sp_sp');           ##### texto de la especie
                $table->string('sp_ssp')->nullable();##### Texto con la categoría y nombre subespecífico (ej: subsp. bla ó var. ble)
                $table->string('sp_name')->unique();          ##### Texto con el nombre científico completo: Genero, especie ssp
                $table->string('sp_autor')->nullable(); ##### Texto con el nombre del autor de la especie
                $table->string('sp_reference')->nullable(); ##### Texto con la cita bibliográfica de la descripción de la especie
                $table->string('sp_catorigin');    ##### Texto con el nombre del catálogo de donde se tomó el nombre, x ej. kew o User (cuando lo ingresa el usuario)
                $table->string('sp_catid');        ##### Id del key del catálogo del que se tomó el nombre x ej. ckew_taxon para kew o ID para User (cuando lo ingresa el usuario)
                $table->timestamps();
                $table->unique(['sp_reino','sp_familia','sp_genero','sp_sp','sp_ssp']);


            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especies');
    }
};
