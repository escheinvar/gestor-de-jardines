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
        if (!Schema::hasTable('cat_tipoalias')) {
            Schema::create('cat_tipoalias', function (Blueprint $table) {
                $table->id('calias_id');
                $table->string('calias_name')->unique();    ###### Nombre del tipo de alias
                $table->string('calias_explica')->nullable();  ##### Explicación del tipo de alias
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_tipoalias');
    }
};
