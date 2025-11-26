<?php

namespace Database\Seeders;

use App\Models\cat_tipoimg;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatTipoimgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['cimg_modulo'=>'colecta',  'cimg_tipo'=>'colecta_paisaje',       'cimg_explica'=>'Paisaje del sitio de colecta'],
            ['cimg_modulo'=>'colecta',  'cimg_tipo'=>'colecta_ejemplar',      'cimg_explica'=>'Ejemplar en el sitio de colecta'],
            ['cimg_modulo'=>'colecta',  'cimg_tipo'=>'colecta_ambiente',      'cimg_explica'=>'Ambiente del ejemplar en el sitio de colecta'],
            ['cimg_modulo'=>'colecta',  'cimg_tipo'=>'colecta_suelo',         'cimg_explica'=>'Suelo en el sitio de colecta'],
            ['cimg_modulo'=>'colecta',  'cimg_tipo'=>'colecta_vegetacion',    'cimg_explica'=>'Vegetación del sitio de colecta'],
            ['cimg_modulo'=>'herbario', 'cimg_tipo'=>'herbario_propio',       'cimg_explica'=>'Ejemplar de herbario propio'],
            ['cimg_modulo'=>'herbario', 'cimg_tipo'=>'herbario_externo',      'cimg_explica'=>'Ejemplar de herbario externo'],
            ['cimg_modulo'=>'jardin',   'cimg_tipo'=>'jardin_ubicacion',      'cimg_explica'=>'Ubicación del ejemplar en el jardín'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_ejemplar',     'cimg_explica'=>'Ejemplar en el jardín'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_flor',         'cimg_explica'=>'Flor del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_fruto',        'cimg_explica'=>'Fruto del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_hoja',         'cimg_explica'=>'Hoja del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_raíz',         'cimg_explica'=>'Raíz del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_cepellon',     'cimg_explica'=>'Cepellón del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_tronco',       'cimg_explica'=>'Tronco del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_tallo',        'cimg_explica'=>'Tallo del ejemplar'],
            ['cimg_modulo'=>'ejemplar', 'cimg_tipo'=>'ejemplar_semillas',     'cimg_explica'=>'Semillas del ejemplar'],
            ['cimg_modulo'=>'uso',      'cimg_tipo'=>'uso',                    'cimg_explica'=>'Uso que se le da al ejemplar'],
        ];
         if (cat_tipoimg::count() == 0 ) {
            foreach ($events as $event){
                cat_tipoimg::create($event);
            }
        }
    }
}
