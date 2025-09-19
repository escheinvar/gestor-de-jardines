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
        if(!Schema::hasTable('buzon')){
            Schema::create('buzon', function (Blueprint $table) {
                $table->id('buz_id');
                $table->enum('buz_act',['0','1'])->default('1');  ##### borrado lógico
                $table->enum('buz_del',['0','1'])->default('0'); ##### flag de mensaje leído

                $table->integer('buz_to');      ##### Id del usr receptor del mensaje
                $table->integer('buz_from');    #### Número id del usr que genera el mensaje
                $table->string('buz_asunto');   #### Asunto del mensaje
                $table->longText('buz_mensaje');#### texto del mensaje
                $table->longText('buz_notas')->nullable();  ### Notas del mensaje
                $table->string('buz_comp');   ##### Controlador desde el que se generó el mensaje)

                $table->date('buz_date'); ### Fecha en la que se envió
                $table->time('buz_hora'); ### Hora en la que se envió
                $table->dateTime('buz_date_borrado')->nullable(); ### Fecha en la que se borra el mensaje (o null)
                $table->string('buz_mailed')->nullable(); ### lista de emails a los que se envió (o null),
                $table->integer('buz_replyTo')->nullable(); ### cuando es respuesta a: buz_id del mensaje al que se está respondiendo

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buzon');
    }
};
