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
        Schema::create('ej_alias', function (Blueprint $table) {
            $table->id('alias_id');
            $table->enum('alias_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
            $table->enum('alias_del',['0','1'])->default('0');  ##### Binario de borrado lógico
            $table->integer('alias_ejmid')->nullable(); ##### Id del ejemplar
            $table->integer('alias_bitid')->nullable(); ##### Id de la bitácora
            $table->string('alias_nombre'); ###### Texto con el nombre
            $table->longText('alias_explica')->nullable(); #### texto con explicación
            $table->integer('alias_usrid'); #### Id del usuario que lo ingresó
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_alias');
    }
};
