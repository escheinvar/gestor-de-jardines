<?php

namespace Database\Seeders;

use App\Models\cat_autoridades;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatAutoridadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
             [
                'aut_id'=>'0',
                'aut_ap1'=>'Digitalizador',
                'aut_ap2'=>'Digitalizador',
                'aut_nombre'=>'Digitalizador',
                'aut_inst'=>'Sistema Gestor de Jardines',
                'aut_mail'=>'',
                'aut_tel'=>'',
                'aut_tipo'=>'colecta',
                'aut_tema'=>'Digitalización',
                'aut_usrid'=>'0'
            ],[
                'aut_id'=>'1',
                'aut_ap1'=>'García',
                'aut_ap2'=>'Mendoza',
                'aut_nombre'=>'Abisaí',
                'aut_inst'=>'Jardín Botánico, UNAM',
                'aut_mail'=>'',
                'aut_tel'=>'',
                'aut_tipo'=>'taxonomia',
                'aut_tema'=>'Asparagaceae;Agavoideae;',
                'aut_usrid'=>'0'
            ],[
                'aut_id'=>'2',
                'aut_ap1'=>'Martínez',
                'aut_ap2'=>'Guerra',
                'aut_nombre'=>'Geovanni',
                'aut_inst'=>'Jardín Etnobiológico de Oaxaca',
                'aut_mail'=>'',
                'aut_tel'=>'',
                'aut_tipo'=>'colecta',
                'aut_tema'=>'',
                'aut_usrid'=>'0'
            ],[
                'aut_id'=>'3',
                'aut_ap1'=>'Hernández',
                'aut_ap2'=>'Gómez',
                'aut_nombre'=>'Vianney',
                'aut_inst'=>'Jardín Etnobiológico de Oaxaca',
                'aut_mail'=>'',
                'aut_tel'=>'',
                'aut_tipo'=>'colecta',
                'aut_tema'=>'',
                'aut_usrid'=>'0'
            ],[
                'aut_id'=>'4',
                'aut_ap1'=>'Scheinvar',
                'aut_ap2'=>'Gottdiener',
                'aut_nombre'=>'Enrique',
                'aut_inst'=>'Jardín Etnobiológico de Oaxaca',
                'aut_mail'=>'',
                'aut_tel'=>'',
                'aut_tipo'=>'colecta',
                'aut_tema'=>'',
                'aut_usrid'=>'2'
            ]
        ];
        if(cat_autoridades::count()=='0'){
            foreach ($events as $event){
                cat_autoridades::create($event);
            }
        }
    }
}
