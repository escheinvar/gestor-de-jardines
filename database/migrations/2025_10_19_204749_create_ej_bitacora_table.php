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
        if(!Schema::hasTable('ej_bitacora1')){
            Schema::create('ej_bitacora1', function (Blueprint $table) {
                $table->id('bit_id');
                // $table->enum('bit_act',['0','1'])->default('1');  ##### Binario de inactivación temporal lógica
                $table->enum('bit_del',['0','1'])->default('0');   ##### Binario de borrado lógico
                $table->integer('bit_ejmid_prop')->nullable();     ##### Número de ejm_id (de tabla ejemplar) con el id del propietario de la bitácora
                $table->date('bit_colectadate')->nullable();       ##### Fecha de colecta del ejemplar
                $table->string('bit_origen')->nullable();          ##### Tipo de origen del ejemplar: colecta, recuperación, donación, compra,
                $table->string('bit_origen_explica')->nullable();  ##### Explicación del tipo de origen (nombre de donante, datos de recuperación, etc...)
                $table->string('bit_forma_colecta')->nullable();   ##### (forma_colecta de tabla cat_conceptos) Parte que origina la colecta: estaca, artejo, ejemplar completo, semilla, etc..
                $table->string('bit_etiqueta_colecta')->nullable();##### En caso de haber, etiqueta del colector
                $table->foreignId('bit_autid')->constrained('cat_autoridades','aut_id');  #->onDelete('cascade'); ##### (aut_id de tabla autoridades) Id de persona colectora

                $table->string('bit_edo')->nullable();             ##### Estado de la colecta
                $table->string('bit_mpio')->nullable();            ##### Municipio de la colecta
                $table->string('bit_localidad')->nullable();       ##### Localidad de la colecta
                $table->string('bit_paraje')->nullable();          ##### Paraje de la colecta
                $table->decimal('bit_x',13,10)->nullable();        ##### Coordenadas longitud X en sist. decimal
                $table->decimal('bit_y',13,10)->nullable();        ##### Coordenadas latitud Y en sist. decimal
                $table->decimal('bit_altitud',7,3)->nullable();    ##### Altitud de la localidad
                $table->longText('bit_obs_colecta')->nullable();   ##### Observaciones a la colecta
                $table->string('bit_usrid');                       ##### (id de tabla user) Id de quien crea la bitácora
                $table->string('bit_alias')->nullable();           ##### Array; de nombres o alias que recibe la bitácora
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('ej_bitacora2')){
            Schema::create('ej_bitacora2', function (Blueprint $table) {
                // $table->id('bit_id2');
                $table->foreignId('bit_bitid')->constrained('ej_bitacora1','bit_id')->key(); #->onDelete('cascade')->key();
                $table->longText('bit_descrsitiocolecta')->nullable();          ##### Descripción del sitio de colecta
                $table->decimal('bit_suelo_textura_arena',5,2)->nullable();     #####
                $table->decimal('bit_suelo_textura_arcilla',5,2)->nullable();   #####
                $table->decimal('bit_suelo_textura_limo',5,2)->nullable();      #####
                $table->decimal('bit_suelo_ph',5,2)->nullable();                #####
                $table->text('bit_suelo_peregosidad')->nullable();              ##### (tabla cat_conceptos)
                $table->text('bit_suelo_pendiente')->nullable();                ##### (tabla cat_conceptos)
                $table->text('bit_vegetacion')->nullable();                     ##### (tabla cat_conceptos)
                $table->text('bit_abundancia')->nullable();                     ##### (tabla cat_conceptos)
                $table->text('bit_iluminacion')->nullable();                    ##### (tabla cat_conceptos)
                $table->longText('bit_plantasasociadas')->nullable();           ##### Array; de palantas
                $table->text('bit_ejemplar_tiporaiz')->nullable();              ##### (tabla cat_conceptos)
                $table->text('bit_ejemplar_formabiologica')->nullable();        ##### (tabla cat_conceptos)
                $table->decimal('bit_ejemplar_altura_cm',5,2)->nullable();      #####
                $table->decimal('bit_ejemplar_diam_altpecho_cm',7,2)->nullable();#####
                $table->decimal('bit_ejemplar_diam_suelo_cm',7,2)->nullable();  #####
                $table->decimal('bit_ejemplar_cobertura_cm',7,2)->nullable();   #####
                $table->longText('bit_notas_colecta')->nullable();              ##### Notas

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ej_bitacora2');
        Schema::dropIfExists('ej_bitacora1');
    }

};
