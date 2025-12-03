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
                $table->string('bib_titulo')->nullable(); ##### Título del artículo o título del capítulo
                $table->string('bib_nombre')->nullable(); ##### Nombre de la revista o título del libro
                $table->string('bib_numero')->nullable(); ##### Número de la revista
                $table->string('bib_volumen')->nullable(); ##### Volumen de la revista
                $table->string('bib_pp')->nullable();       ##### páginas (rango en revista o total en libro)
                $table->string('bib_editorial')->nullable(); ##### Editorial en libros o Institución en Tesis
                $table->string('bib_lengua');
                $table->foreign('bib_lengua')->references('clen_code')->on('cat_lenguas')->constrined('cat_lenguas','clen_code'); ##### Siglas del campus propietario
                $table->string('bib_tags')->nullable();     ###### array; de etiquetas
                $table->string('bib_notasubica')->nullable(); ##### Notas sobre la ubicación
                $table->string('bib_edo')->nullable(); ##### Estado en el que se dio la com.pers
                $table->string('bib_mpio')->nullable(); ##### Municipio  en el que se dio la com.pers
                $table->string('bib_localidad')->nullable(); ##### Localidad  en el que se dio la com.pers
                $table->string('bib_notapublica')->nullable();  #### Notas sobre la publicación
                $table->string('bib_tipotesis')->nullable();    #### Tipo de tesis (maestría, doctorado, licenciatura en carrera...)
                $table->string('bib_ocupa')->nullable(); ##### Ocupación del com-pers
                $table->string('bib_edad')->nullable(); ##### Edad del com-pers

                $table->string('bib_doi')->nullable(); ##### Número DOI para publicaciones en internet
                $table->string('bib_isbn')->nullable(); ##### Número isbn para publicaciones únicas
                $table->string('bib_issn')->nullable(); ##### Número issn para publicaciones periódicas
                $table->string('bib_url')->nullable();  ##### Página web donde se puede descargasr
                $table->string('bib_pdf')->nullable(); ##### Ruta (desde /public/biblio/ y nombre del archivo)
                $table->enum('bib_priv',['0','1'])->default('0');  ##### Binario: 1=archivo-privado y 0=archivo-público
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
