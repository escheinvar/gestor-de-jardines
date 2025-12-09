<?php

namespace Database\Seeders;

use App\Models\cat_tipoexpediente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatTipoExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $events=[
            ['cexp_name'=>'flor',           'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de floración',               'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'visitante',      'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de visitante floral',        'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'fruto',          'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de presencia de fruto',      'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'propagulos',     'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de presencia de propágulos', 'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'semillas',       'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de presencia de semillas',   'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'enfermedad',     'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de posible enfermedad',      'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'plaga',          'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta de posible plaga',           'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'aplicación',     'cexp_alarma'=>'1', 'cexp_asunto'=>'Aviso de aplicación fito-sanitaria','cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'daño',           'cexp_alarma'=>'1', 'cexp_asunto'=>'Aviso de daño a ejemplar',          'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'reproducción',   'cexp_alarma'=>'0', 'cexp_asunto'=>'',                                  'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'muerte',         'cexp_alarma'=>'1', 'cexp_asunto'=>'Aviso de muerte de ejemplar',       'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            // ['cexp_name'=>'', 'cexp_explica'=>'', 'cexp_alarma'=>'0', 'cexp_asunto'=>'', 'cexp_txt1'=>'', 'cexp_txt2'=>''],
        ];
        if (cat_tipoexpediente::count() == 0 ) {
            foreach ($events as $event){
                cat_tipoexpediente::create($event);
            }
        }

    }
}
