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
        if(!Schema::hasTable('imagenes')){
            Schema::create('imagenes', function (Blueprint $table) {
                $table->id('img_id');

                $table->integer('img_ejmid')->nullable(); ##### (ejm_id de tabla ejemplares) id de la planta a la que pertenece la imagen or null (cuando la info. es de especie)
                $table->integer('img_spid')->nullable();  ##### (sp_id de tabla especies) id de la especie, cuando img_ejmid es null.

                $table->enum('img_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
                $table->enum('img_del',['0','1'])->default('0');  ##### Binario de borrado lógico
                $table->string('img_cimgtipo');  ##### (cimg_tipo de cat_tipoimagenes) Texto con tipo de imagen
                $table->string('img_tipo2')->nullable();  ##### Texto por si se requiere diferenciar el tipo de imagen

                $table->string('img_titulo')->nullable(); ##### Texto del título de la imagen
                $table->string('img_ubica')->nullable(); ##### Texto indicador de la ubicación de la imagen
                $table->longText('img_explica')->nullable(); ##### Texto de explicación de la imágen
                $table->string('img_autor')->nullable(); ##### Texto con nombre de autor de imágen
                $table->date('img_fecha')->nullable(); ##### Fecha de toma de la imágen
                $table->decimal('img_y',13,10)->nullable(); ##### Coordenadas decimales de latitud y en las que se tomó la imagen
                $table->decimal('img_x',13,10)->nullable(); ##### Coordenadas decimales de latitud y en las que se tomó la imagen

                $table->enum('img_media',['img','vid','aud'])->default('img'); ##### Indicador del tipo de objeto: imagen, video, audio.
                $table->string('img_ruta')->nullable(); ##### Texto con la ruta a la imagen (desde /public/img)

                // $table->string('img_component')->nullable(); ##### Texto indicando el componente laravel desde el que se generó la imagen
                $table->integer('img_usrid'); ##### (id de user) responsable de subir imagen
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
