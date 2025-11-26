<?php

namespace Database\Seeders;

use App\Models\bitacora1;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BitacoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (bitacora1::count() == 0 ) {
            // foreach ($events as $event){
            //     bitacora1::create($event);
            // }
            $events=bitacora1::create([
                'bit_id'=>'0',
                'bit_ejmid_prop'=>'0',
                'bit_colectadate'=>null,
                'bit_origen'=>'digitalización',
                'bit_origen_explica'=>null,
                'bit_forma_colecta'=>null,
                'bit_etiqueta_colecta'=>null,
                'bit_autid'=>'0',
                'bit_edo'=>null,
                'bit_mpio'=>null,
                'bit_localidad'=>null,
                'bit_paraje'=>null,
                'bit_x'=>null,
                'bit_y'=>null,
                'bit_altitud'=>null,
                'bit_obs_colecta'=>null,
                'bit_usrid'=>'0',
            ]);
        }
    }
}
