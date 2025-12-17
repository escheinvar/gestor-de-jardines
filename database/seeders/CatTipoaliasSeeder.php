<?php

namespace Database\Seeders;

use App\Models\cat_tipoalias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatTipoaliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['calias_name'=>'ejemplar',         'calias_explica'=>'Alias de nombre del ejemplar'],
            ['calias_name'=>'nombre científico','calias_explica'=>'Alias de nombre científico de un ejemplar'],
            ['calias_name'=>'nombre común',     'calias_explica'=>'Alias de nombre común de un ejemplar'],
            ['calias_name'=>'ubicación',        'calias_explica'=>'Alias de la ubicación de un ejemplar'],
            ['calias_name'=>'bitácora',            'calias_explica'=>'Alias de nombre del ejemplar denominado clavo'],
            ['calias_name'=>'clavo',            'calias_explica'=>'Alias de nombre del ejemplar denominado clavo'],
            // ['cexp_name'=>'', 'cexp_explica'=>'', 'cexp_alarma'=>'0', 'cexp_asunto'=>'', 'cexp_txt1'=>'', 'cexp_txt2'=>''],
        ];
        if (cat_tipoalias::count() == 0 ) {
            foreach ($events as $event){
                cat_tipoalias::create($event);
            }
        }
    }
}
