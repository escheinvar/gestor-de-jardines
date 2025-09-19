<?php

namespace Database\Seeders;

use App\Models\cat_campus;
use App\Models\cat_jardines;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatJardinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            [
                'cjar_id'=>'1',
                'cjar_name'=>'Etnobiológico de Oaxaca',
                'cjar_nombre'=>'Jardín Etnobiológico de Oaxaca',
                'cjar_siglas'=>'JebOax',
                'cjar_tipo'=>'Etnobiológico',
                'cjar_direccion'=>'Reforma s/n, Independencia, Centro, Oaxaca de Juárez, Oaxaca. C.P. 68000 ',
                'cjar_tel'=>' 951 516 5325',
                'cjar_mail'=>'etnobotanico@infinitummail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'JebOax.png',
            ],[
                'cjar_id'=>'2',
                'cjar_name'=>'Matatlan',
                'cjar_nombre'=>'Jardín Comunitario de Matatlán',
                'cjar_siglas'=>'JM',
                'cjar_tipo'=>'Etnobotánico',
                'cjar_direccion'=>'Reforma s/n, Independencia, Centro, Oaxaca de Juárez, Oaxaca. C.P. 68000 ',
                'cjar_tel'=>' 951 516 5325',
                'cjar_mail'=>'etnobotanico@infinitummail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'Matatlan.png',
            ],[
                'cjar_id'=>'3',
                'cjar_name'=>'IxMx en JebOax',
                'cjar_nombre'=>'Investigadores por México en el Jardín Etnobiológico de Oaxaca',
                'cjar_siglas'=>'IxMxJebOax',
                'cjar_tipo'=>'Etnobiológico',
                'cjar_direccion'=>'SN',
                'cjar_tel'=>'5515139080',
                'cjar_mail'=>'jardinetnobiologicodeoaxaca@gmail.com',
                'cjar_edo'=>'Oaxaca',
                'cjar_logo'=>'IxMxJebOax.png',
            ]
        ];
        if(cat_jardines::count()=='0'){
            foreach ($events as $event){
                cat_jardines::create($event);
            }
        }

        $events=[
            [
                'ccam_id'=>'1',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'1',
                'ccam_siglas'=>'JebOax',
                'ccam_name'=>'Santo Domingo',
                'ccam_nombre'=>'Santo Domingo',
                'ccam_direccion'=>'Av. Reforma 501, esquina Constitución, Col. Centro, 68000 Oaxaca de Juárez, México.',
            ],[
                'ccam_id'=>'2',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'1',
                'ccam_siglas'=>'JebOax-Cant',
                'ccam_name'=>'Canteras',
                'ccam_nombre'=>'Canteras',
                'ccam_direccion'=>'',
            ],[
                'ccam_id'=>'3',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'2',
                'ccam_siglas'=>'JM',
                'ccam_name'=>'Presa',
                'ccam_nombre'=>'Presa',
                'ccam_direccion'=>'',
            ],[
                'ccam_id'=>'4',
                'ccam_act'=>'1',
                'ccam_cjarid'=>'3',
                'ccam_siglas'=>'Ixmx JebOax',
                'ccam_name'=>'IxMx JebOax',
                'ccam_nombre'=>'Investigadores por México en el Jardín Etnobiológico de Oaxaca',
                'ccam_direccion'=>'Av. Reforma 501, esquina Constitución, Col. Centro, 68000 Oaxaca de Juárez, México.',
            ]
        ];
        if(cat_campus::count()=='0'){
            foreach ($events as $event){
                cat_campus::create($event);
            }
        }
    }
}
