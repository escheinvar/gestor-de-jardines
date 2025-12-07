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
            ['icon_name'=>'ArbolBlanco',        'icon_file'=>'/iconos/ArbolBlanco.png'],
            ['icon_name'=>'ArbustoBlanco',      'icon_file'=>'/iconos/ArbustoBlanco.png'],
            ['icon_name'=>'ArbustoVaraBlanco',  'icon_file'=>'/iconos/ArbustoVaraBlanco.png'],
            ['icon_name'=>'CicadaBlanca',       'icon_file'=>'/iconos/CicadaBlanca.png'],
            ['icon_name'=>'Columnar1Blanco',    'icon_file'=>'/iconos/Columnar1Blanco.png'],
            ['icon_name'=>'GlobosaBlanco',      'icon_file'=>'/iconos/GlobosaBlanco.png'],
            ['icon_name'=>'HelechoBlanco',      'icon_file'=>'/iconos/HelechoBlanco.png'],
            ['icon_name'=>'HerbaceaBlanca1',    'icon_file'=>'/iconos/HerbaceaBlanca1.png'],
            ['icon_name'=>'HerbaceaBlanca',     'icon_file'=>'/iconos/HerbaceaBlanca.png'],
            ['icon_name'=>'Hojitas',            'icon_file'=>'/iconos/Hojitas.png'],
            ['icon_name'=>'MagueyBlanco',       'icon_file'=>'/iconos/MagueyBlanco.png'],
            ['icon_name'=>'NopalBlanco',        'icon_file'=>'/iconos/NopalBlanco.png'],
            ['icon_name'=>'OrquideaBlanca',     'icon_file'=>'/iconos/OrquideaBlanca.png'],
            ['icon_name'=>'PalmaBlanca',        'icon_file'=>'/iconos/PalmaBlanca.png'],
            ['icon_name'=>'PuntoBlanco',        'icon_file'=>'/iconos/PuntoBlanco.png'],
            ['icon_name'=>'PuntoNegro',         'icon_file'=>'/iconos/PuntoNegro.png'],
            ['icon_name'=>'PuntoRojo',          'icon_file'=>'/iconos/PuntoRojo.png'],
            ['icon_name'=>'PuntoTransparente',  'icon_file'=>'/iconos/PuntoTransparente.png'],
            ['icon_name'=>'PuntoVerde',         'icon_file'=>'/iconos/PuntoVerde.png'],

        ];

        if(cat_iconos::count()=='0'){
            foreach ($events as $event){
                cat_iconos::create($event);
            }
        }
    }
}
