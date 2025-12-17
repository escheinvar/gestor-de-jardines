<?php

namespace Database\Seeders;

use App\Models\cat_subcolecciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatSubcoleccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['ccol_coleccion'=>'Principal',     'ccol_explica'=>'Colección objeto del jardín'],
            ['ccol_coleccion'=>'Ornato',        'ccol_explica'=>'Plantas de ornato del jardín'],
            ['ccol_coleccion'=>'Orquídeas',     'ccol_explica'=>'Colección de orquídeas'],
            ['ccol_coleccion'=>'NOM SEM-059',   'ccol_explica'=>'Plantas incluidas en la Norma oficial SEMARNAT-059'],
            ['ccol_coleccion'=>'Escolar',       'ccol_explica'=>'Plantas temporales para uso en talleres y demostraciones'],
            ['ccol_coleccion'=>'Enteogénicas',  'ccol_explica'=>'Plantas psicoactivas utilizadas para alterar el estado de conciencia'],

        ];
        if (cat_subcolecciones::count() == 0 ) {
            foreach ($events as $event){
                cat_subcolecciones::create($event);
            }
        }

    }
}
