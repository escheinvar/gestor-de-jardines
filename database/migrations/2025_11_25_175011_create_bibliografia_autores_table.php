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
        if (!Schema::hasTable('bibliografia_autores')) {
            Schema::create('bibliografia_autores', function (Blueprint $table) {
                $table->id('bibaut_id');
                $table->enum('bibaut_del',['0','1'])->default('0');  ##### Binario de borrado lógico
                $table->foreignId('bibaut_bibid')->constrained('bibliografias','bib_id')->onDelete('cascade');
                $table->string('bibaut_nombre')->nullable(); ##### Nombre del autor
                $table->string('bibaut_ap')->nullable(); ##### Apellido(s) del autor
                $table->string('bibaut_orcid')->nullable(); ##### Orcid ID (Identificador universal de autores científicos)
                $table->string('bibaut_isni')->nullable(); ##### ISNI (Identificador universal de autores)
                $table->enum('bibaut_tipo',['autor','editor'])->default('autor'); ###### Indica si los datos son de un autor o de un editor de libro
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibliografia_autores');
    }
};
