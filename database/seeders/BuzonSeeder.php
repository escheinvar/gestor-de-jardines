<?php

namespace Database\Seeders;

use App\Models\buzon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuzonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date=date("Y-m-d");
        $hora=date("H:i");
        $events=[
            [
                'buz_act'=>'1',
                'buz_to'=>'1',
                'buz_from'=>'0',
                'buz_asunto'=>'Bienvenida 1 del sistema',
                'buz_mensaje'=>'Hola Mundo!!<br>Mensaje del sistema como bienvenida',
                'buz_comp'=>'Seeder',
                'buz_date'=>$date,
                'buz_hora'=>$hora,
            ],[
                'buz_act'=>'1',
                'buz_to'=>'1',
                'buz_from'=>'2',
                'buz_asunto'=>'Bienvenida 1',
                'buz_mensaje'=>'El administrdor automático te manda saludos.',
                'buz_comp'=>'Seeder',
                'buz_date'=>$date,
                'buz_hora'=>$hora,
            ],[
                'buz_act'=>'1',
                'buz_to'=>'2',
                'buz_from'=>'0',
                'buz_asunto'=>'Bienvenida 2 del sistema',
                'buz_mensaje'=>'Hola Mundo!!<br>Mensaje del sistema como bienvenida',
                'buz_comp'=>'Seeder',
                'buz_date'=>$date,
                'buz_hora'=>$hora,
            ],[
                'buz_act'=>'1',
                'buz_to'=>'2',
                'buz_from'=>'1',
                'buz_asunto'=>'Bienvenida 2',
                'buz_mensaje'=>'El administrdor automático te manda saludos.',
                'buz_comp'=>'Seeder',
                'buz_date'=>$date,
                'buz_hora'=>$hora,
            ]
        ];
        if(buzon::count()=='0'){
            foreach ($events as $event){
                buzon::create($event);
            }
        }
    }
}
