<?php

namespace Database\Seeders;

use App\Models\cat_colec_ejemps;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatColecEjempsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'Colección viva',  'colsej_explica'=>'Colección principal del jardín y objeto del mismo'],
            ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'Orquídeas',  'colsej_explica'=>'Colección de orquídeas del jardín'],
            ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'Ornato',  'colsej_explica'=>'Plantas de ornato que no son parte central de la colección viva'],
            ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'Zona educativa',  'colsej_explica'=>'Plantas de la zona educativa'],
            ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'Zona de cultivo',  'colsej_explica'=>'Ejemplares de la zona de cultivo'],
            ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'Teita',  'colsej_explica'=>'Ejemplares de la zona de Teita'],
            // ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'',  'colsej_explica'=>''],
            // ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'',  'colsej_explica'=>''],
            // ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'',  'colsej_explica'=>''],
            // ['colsej_ccamsiglas'=>'JebOax',    'colsej_name'=>'',  'colsej_explica'=>''],
        ];

        if(cat_colec_ejemps::count()=='0'){
            foreach ($events as $event){
                cat_colec_ejemps::create($event);
            }
        }
    }
}
