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
            ['cexp_name'=>'sistema',        'cexp_alarma'=>'0', 'cexp_asunto'=>'',                                           'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Nuevo Ejemplar', 'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de nuevo ejemplar',          'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Nomenclatura',   'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de nomenclatura',            'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Ubicación',      'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de ubicación',               'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'B.reproduciva',  'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de floración',               'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Visita floral',  'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de visitante floral',        'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Fructificación', 'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de presencia de fruto',      'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Propagulos',     'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de presencia de propágulos', 'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Semillas',       'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de presencia de semillas',   'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Enfermedad',     'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de posible enfermedad',      'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Plaga',          'cexp_alarma'=>'1', 'cexp_asunto'=>'Alerta SiGesJar de posible plaga',           'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Aplicación',     'cexp_alarma'=>'1', 'cexp_asunto'=>'Aviso de aplicación fito-sanitaria','cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Daño',           'cexp_alarma'=>'1', 'cexp_asunto'=>'Aviso de daño a ejemplar',          'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Reproducción',   'cexp_alarma'=>'0', 'cexp_asunto'=>'',                                  'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            ['cexp_name'=>'Muerte',         'cexp_alarma'=>'1', 'cexp_asunto'=>'Aviso de muerte de ejemplar',       'cexp_txt1'=>'', 'cexp_txt2'=>'','cexp_explica'=>'' ],
            // ['cexp_name'=>'', 'cexp_explica'=>'', 'cexp_alarma'=>'0', 'cexp_asunto'=>'', 'cexp_txt1'=>'', 'cexp_txt2'=>''],
        ];
        if (cat_tipoexpediente::count() == 0 ) {
            foreach ($events as $event){
                cat_tipoexpediente::create($event);
            }
        }

    }
}
