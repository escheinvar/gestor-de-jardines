<?php

namespace Database\Seeders;

use App\Models\cat_conceptos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatConceptosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['con_tema'=>'forma_obtención',    'con_txt'=>'colecta',        'con_explica'=>''],
            ['con_tema'=>'forma_obtención',    'con_txt'=>'recuperación',   'con_explica'=>''],
            ['con_tema'=>'forma_obtención',    'con_txt'=>'donación',       'con_explica'=>''],
            ['con_tema'=>'forma_obtención',    'con_txt'=>'compra',         'con_explica'=>''],
            ['con_tema'=>'forma_obtención',    'con_txt'=>'comodato',       'con_explica'=>''],

            ['con_tema'=>'forma_colecta', 'con_txt'=>'digitalización',    'con_explica'=>'Ejemplar en proceso de captura para su incorporación al sistema.'],
            ['con_tema'=>'forma_colecta', 'con_txt'=>'estaca',            'con_explica'=>'Colecta mediante estaca'],
            ['con_tema'=>'forma_colecta', 'con_txt'=>'artejo',            'con_explica'=>'Colecta de algún segmento de la planta'],
            ['con_tema'=>'forma_colecta', 'con_txt'=>'ejemplar completo', 'con_explica'=>'Colecta mediante la extracción completa del ejemplar incluyendo raíces'],
            ['con_tema'=>'forma_colecta', 'con_txt'=>'semilla',           'con_explica'=>'Colecta de semilla'],
            ['con_tema'=>'forma_colecta', 'con_txt'=>'espora',            'con_explica'=>'Colecta de espora'],
            ['con_tema'=>'forma_colecta', 'con_txt'=>'geófito',           'con_explica'=>'Colecta de estructura subterránea de resitencia (bulbo, rizoma, tubérculo)'],

            ['con_tema'=>'pedregosidad', 'con_txt'=>'0%',     'con_explica'=>'Suelo con roca madre sin pedregrosidad'],
            ['con_tema'=>'pedregosidad', 'con_txt'=>'<=20%',  'con_explica'=>'Suelo con menos del 20% de rocas'],
            ['con_tema'=>'pedregosidad', 'con_txt'=>'20-80%', 'con_explica'=>'Suelo con entre 20 y 80% de rocas'],
            ['con_tema'=>'pedregosidad', 'con_txt'=>'>=80%',  'con_explica'=>'Suelo con más de 80% de rocas'],

            ['con_tema'=>'pendiente', 'con_txt'=>'0-20%',   'con_explica'=>''],
            ['con_tema'=>'pendiente', 'con_txt'=>'21-45%',  'con_explica'=>''],
            ['con_tema'=>'pendiente', 'con_txt'=>'45-80%',  'con_explica'=>''],
            ['con_tema'=>'pendiente', 'con_txt'=>'> 80%',   'con_explica'=>''],
            ['con_tema'=>'pendiente', 'con_txt'=>'compleja','con_explica'=>''],

            ['con_tema'=>'vegetación', 'con_txt'=>'selva alta',            'con_explica'=>'Bosque troipical perennifolio sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'selva mediana',         'con_explica'=>'Bosque tropical subcaducifolio sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'selva baja',            'con_explica'=>'Bosque tropical caducifolio sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'matorral xerófilo',     'con_explica'=>'Sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'bosque espinoso',       'con_explica'=>'Sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'pastizal',              'con_explica'=>'Sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'bosque de pino',        'con_explica'=>'Pinar sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'bosque de encino',      'con_explica'=>'Pinar sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'bosque de pino-encino', 'con_explica'=>'Bosque de abetos u oyameles sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'bosque mesófilo',       'con_explica'=>'Sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'manglar',               'con_explica'=>'Sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'popal',                 'con_explica'=>'Sensu Rzedowski, 1981. Vegetación de México'],
            ['con_tema'=>'vegetación', 'con_txt'=>'izotal',                'con_explica'=>'Vegetación de una sola especie.'],
            ['con_tema'=>'vegetación', 'con_txt'=>'acuático',              'con_explica'=>'dentro de un cuerpo de agua'],
            ['con_tema'=>'vegetación', 'con_txt'=>'agrosistema',           'con_explica'=>'área de cultivo'],

            ['con_tema'=>'abundancia', 'con_txt'=>'menos de 5', 'con_explica'=>''],
            ['con_tema'=>'abundancia', 'con_txt'=>'5-15',       'con_explica'=>''],
            ['con_tema'=>'abundancia', 'con_txt'=>'15-30',      'con_explica'=>''],
            ['con_tema'=>'abundancia', 'con_txt'=>'>30',        'con_explica'=>''],

            ['con_tema'=>'iluminación', 'con_txt'=>'expuesto total al sol','con_explica'=>''],
            ['con_tema'=>'iluminación', 'con_txt'=>'sombra parcial',       'con_explica'=>''],
            ['con_tema'=>'iluminación', 'con_txt'=>'sombra total',         'con_explica'=>''],

            ['con_tema'=>'forma biológica', 'con_txt'=>'arbol',        'con_explica'=>''],
            ['con_tema'=>'forma biológica', 'con_txt'=>'arbusto',      'con_explica'=>''],
            ['con_tema'=>'forma biológica', 'con_txt'=>'bejuco-liana', 'con_explica'=>''],
            ['con_tema'=>'forma biológica', 'con_txt'=>'enredadera',   'con_explica'=>''],
            ['con_tema'=>'forma biológica', 'con_txt'=>'epífita',      'con_explica'=>''],
            ['con_tema'=>'forma biológica', 'con_txt'=>'hierba',       'con_explica'=>''],
            ['con_tema'=>'forma biológica', 'con_txt'=>'suculenta',    'con_explica'=>''],

            ['con_tema'=>'tipo-raíz', 'con_txt'=>'pivotante', 'con_explica'=>'Una raíz principal que crece verticalmente hacia a bajo y de la que se desprewnden raíces secundarias'],
            ['con_tema'=>'tipo.raíz', 'con_txt'=>'ramificada', 'con_explica'=>'Tipo de raíz donde no hay una raíz principal'],
            //  ['con_tema'=>'tipo-raíz', 'con_txt'=>'inclinada', 'con_explica'=>''],

            ['con_tema'=>'tipo-raíz', 'con_txt'=>'lateral', 'con_explica'=>'Raíz secundaria'],
            ['con_tema'=>'tipo-raíz', 'con_txt'=>'tuberosa', 'con_explica'=>'Raíz modificada que se engrosa para almacenar nutrientes'],
            ['con_tema'=>'tipo-raíz', 'con_txt'=>'adventicia', 'con_explica'=>'Raíz que crece a partir de un tejido de la planta que no es la raíz principal'],

             ['con_tema'=>'tipo-publicacion', 'con_txt'=>'artículo',                'con_explica'=>'Cíta de un artículo de revista'],
             ['con_tema'=>'tipo-publicacion', 'con_txt'=>'libro',                   'con_explica'=>'Cíta de un libro completo'],
             ['con_tema'=>'tipo-publicacion', 'con_txt'=>'capítulo de libro',       'con_explica'=>'Cíta de un capítulo de libro'],
             ['con_tema'=>'tipo-publicacion', 'con_txt'=>'tesis',                   'con_explica'=>'Cíta de una tesis profesional'],
             ['con_tema'=>'tipo-publicacion', 'con_txt'=>'comunicación personal',   'con_explica'=>'Cíta por comunicacion personal'],

             ['con_tema'=>'tipo-crecimiento', 'con_txt'=>'individual distinguible', 'con_explica'=>'Módulo de ubicación, tipo de crecimeinto del ejemplar'],
             ['con_tema'=>'tipo-crecimiento', 'con_txt'=>'individual en colonia',   'con_explica'=>'Módulo de ubicación, tipo de crecimeinto del ejemplar'],
             ['con_tema'=>'tipo-crecimiento', 'con_txt'=>'colonial',                'con_explica'=>'Módulo de ubicación, tipo de crecimeinto del ejemplar'],
             ['con_tema'=>'tipo-crecimiento', 'con_txt'=>'indistinguible',          'con_explica'=>'Módulo de ubicación, tipo de crecimeinto del ejemplar'],

            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
            //  ['con_tema'=>'', 'con_txt'=>'', 'con_explica'=>''],
        ];
        if(cat_conceptos::count()=='0'){
            foreach ($events as $event){
                cat_conceptos::create($event);
            }
        }
    }
}
