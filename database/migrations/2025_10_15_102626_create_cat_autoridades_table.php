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
        if(!Schema::hasTable('cat_autoridades')){
            ############### Tabla con datos de autoridades taxonómicas, de colecta o de lengua.
            ############### Debe tener una autoridad por default para la digitalización
            Schema::create('cat_autoridades', function (Blueprint $table) {
                $table->id('aut_id');
                $table->string('aut_ap1');              ##### Primer apellido de la autoridad
                $table->string('aut_ap2')->nullable();  ##### Segundo apellido de la autoridad
                $table->string('aut_nombre');           ##### Nombre(s) de la autoridad
                $table->string('aut_inst')->nullable(); ##### Nombre de la institución en la que labora o pertenece
                $table->string('aut_mail')->nullable(); ##### Correo electrónico de la autoridad
                $table->string('aut_tel')->nullable();  ##### Teléfono de la autoridad
                $table->string('aut_tipo');  ##### Área en el que es autoridad.
                $table->string('aut_tema')->nullable(); ##### Array; de temas en los que es autoridad ej (colecta;Agavaceae, Burseraseae, Fungi)
                $table->string('aut_usrid');            ##### (id de tabla user) id del usuario que registró a la autoridad
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_autoridades');
    }
};
