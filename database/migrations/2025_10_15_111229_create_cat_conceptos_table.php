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
        if(!Schema::hasTable('cat_conceptos')){
            Schema::create('cat_conceptos', function (Blueprint $table) {
                $table->id('con_id');
                $table->string('con_tema');  ##### Tema: forma_colecta, pedregrosidad_suelo, etcc
                $table->string('con_txt');   ##### conceptos o definiciones del tema.
                $table->longText('con_explica')->nullable();  ###### Explicación de cada concepto o null
                $table->string('con_imgid')->nullable();  ##### (img_id  de tabla imagenes) id de la imágen que explica este concetpto o null
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_conceptos');
    }
};
