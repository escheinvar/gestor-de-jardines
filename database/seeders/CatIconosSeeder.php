<?php

namespace Database\Seeders;

use App\Models\cat_iconos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatIconosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['icon_name'=>'ArbolBlanco',        'icon_file'=>'ArbolBlanco.png'],
            ['icon_name'=>'ArbustoBlanco',      'icon_file'=>'ArbustoBlanco.png'],
            ['icon_name'=>'ArbustoVaraBlanco',  'icon_file'=>'ArbustoVaraBlanco.png'],
            ['icon_name'=>'CicadaBlanca',       'icon_file'=>'CicadaBlanca.png'],
            ['icon_name'=>'Columnar1Blanco',    'icon_file'=>'Columnar1Blanco.png'],
            ['icon_name'=>'GlobosaBlanco',      'icon_file'=>'GlobosaBlanco.png'],
            ['icon_name'=>'HelechoBlanco',      'icon_file'=>'HelechoBlanco.png'],
            ['icon_name'=>'HerbaceaBlanca1',    'icon_file'=>'HerbaceaBlanca1.png'],
            ['icon_name'=>'HerbaceaBlanca',     'icon_file'=>'HerbaceaBlanca.png'],
            ['icon_name'=>'HojasViento',        'icon_file'=>'HojasViento.png'],
            ['icon_name'=>'Hojitas',            'icon_file'=>'Hojitas.png'],
            ['icon_name'=>'IconoExpedientePlanta', 'icon_file'=>'IconoExpedientePlanta.png'],
            ['icon_name'=>'IconoMoverPlanta',   'icon_file'=>'IconoMoverPlanta.png'],
            ['icon_name'=>'IconoPlantaEnferma', 'icon_file'=>'IconoPlantaEnferma.png'],
            ['icon_name'=>'IconoPlantaMuerta',  'icon_file'=>'IconoPlantaMuerta.png'],
            ['icon_name'=>'IconoPlantaNueva',   'icon_file'=>'IconoPlantaNueva.png'],
            ['icon_name'=>'IconosPlanta',       'icon_file'=>'IconosPlanta.xcf'],
            ['icon_name'=>'MagueyBlanco',       'icon_file'=>'MagueyBlanco.png'],
            ['icon_name'=>'NopalBlanco',        'icon_file'=>'NopalBlanco.png'],
            ['icon_name'=>'OrquideaBlanca',     'icon_file'=>'OrquideaBlanca.png'],
            ['icon_name'=>'PalmaBlanca',        'icon_file'=>'PalmaBlanca.png'],
            ['icon_name'=>'PuntoBlanco',        'icon_file'=>'PuntoBlanco.png'],
            ['icon_name'=>'PuntoNegro',         'icon_file'=>'PuntoNegro.png'],
            ['icon_name'=>'PuntoRojo',          'icon_file'=>'PuntoRojo.png'],
            ['icon_name'=>'PuntoTransparente',  'icon_file'=>'PuntoTransparente.png'],
            ['icon_name'=>'PuntoVerde',         'icon_file'=>'PuntoVerde.png'],

        ];

        if(cat_iconos::count()=='0'){
            foreach ($events as $event){
                cat_iconos::create($event);
            }
        }
    }
}
