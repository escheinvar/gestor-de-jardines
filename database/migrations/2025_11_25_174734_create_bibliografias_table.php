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
        if (!Schema::hasTable('bibliografias')) {
            Schema::create('bibliografias', function (Blueprint $table) {
                $table->id('bib_id');
                $table->enum('bib_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
                $table->enum('bib_del',['0','1'])->default('0');  ##### Binario de borrado lógico
                $table->string('bib_ccamsiglas');
                $table->foreign('bib_ccamsiglas')->references('ccam_siglas')->on('cat_campus')->constrined('cat_campus','ccam_siglas'); ##### Siglas del campus propietario
                $table->string('bib_tipo');             ##### Tipo de publicación según el catálogo cat_conceptos "tipo-publicacion"
                $table->integer('bib_anio')->nullable();##### Año de la publicación
                $table->string('bib_nombre')->nullable(); ##### Nombre de la revista o título del libro
                $table->string('bib_titulo')->nullable(); ##### Título del artículo o título del capítulo
                $table->string('bib_numero')->nullable(); ##### Número de la revista
                $table->string('bib_volumen')->nullable(); ##### Volumen de la revista
                $table->string('bib_pp')->nullable();       ##### páginas (rango en revista o total en libro)
                $table->string('bib_editorial')->nullable(); ##### Editorial en libros
                $table->string('bib_pais')->nullable(); ###### país de publicación
                $table->string('bib_lengua')->nullable(); ##### lengua de la publicación
                $table->string('bib_tags')->nullable();
                $table->string('bib_notasubica')->nullable();
                $table->string('bib_notapublica')->nullable();

                $table->string('bib_doi')->nullable();
                $table->string('bib_isbn')->nullable();
                $table->string('bib_issn')->nullable();
                $table->string('bib_url')->nullable();
                $table->string('bib_pdf')->nullable();
                // $table->string('bib_')->nullable();
                // $table->string('bib_')->nullable();
                // $table->string('bib_')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliografias');
    }
};
