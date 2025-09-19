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
        Schema::create('usr_tokens', function (Blueprint $table) {
           $table->id('tok_id');
            $table->enum('tok_act',['0','1'])->default('1');
            $table->string('tok_mail');
            $table->string('tok_token');
            $table->dateTime('tok_ini')->nullable();
            $table->dateTime('tok_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usr_tokens');
    }
};
