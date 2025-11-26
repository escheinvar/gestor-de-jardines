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
        if (!Schema::hasTable('cat_kew_plantsoftheworld')) {
            Schema::create('cat_kew_plantsoftheworld', function (Blueprint $table) {
                $table->id('ckew_taxonid');
                $table->string('ckew_family')->nullable();
                $table->string('ckew_genus')->nullable();
                $table->string('ckew_specificepithet')->nullable();
                $table->string('ckew_infraspecificepithet')->nullable();
                $table->string('ckew_scientfiicname')->nullable();
                $table->string('ckew_scientfiicnameauthorship')->nullable();
                $table->string('ckew_taxonrank')->nullable();
                $table->string('ckew_taxonomicstatus')->nullable();
                $table->string('ckew_acceptednameusageid')->nullable();
                $table->string('ckew_parentnameusageid')->nullable();
                $table->string('ckew_originalnameusageid')->nullable();
                $table->string('ckew_namepublishedin')->nullable();
                $table->string('ckew_nomenclaturalstatus')->nullable();
                $table->string('ckew_taxonremarks')->nullable();
                $table->string('ckew_scientificnameid')->nullable();
                $table->string('ckew_dynamicproperties')->nullable();
                $table->string('ckew_references')->nullable();
                //$table->string('Version')->default('Kew_2024-06-12');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --- no borrar, porque cuesta mucho levantarla (está muy grande) y se carga desde archivo
        // Schema::dropIfExists('cat_kew_plantsoftheworld');
    }
};
