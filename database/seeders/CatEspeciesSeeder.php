<?php

namespace Database\Seeders;

use App\Models\cat_kew;
use App\Models\especies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatEspeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad=10; ########### Indica la cantidad de ejemplares a ejecutar
        $cont=0;

        while($cont < $cantidad){
            $cont++;
            // $ganon=fake()->randomElement(cat_kew::pluck('ckew_taxonid')->toArray(), 1);
            $ganon=cat_kew::pluck('ckew_taxonid')->random($cantidad);
            foreach($ganon as $i){
                $sp=cat_kew::where('ckew_taxonid',$i)->first();
                especies::create([
                    'sp_reino'=>'pl',
                    'sp_familia'=>$sp->ckew_family,
                    'sp_genero'=>$sp->ckew_genus,
                    'sp_sp'=>$sp->ckew_specificepithet,
                    'sp_ssp'=>$sp->ckew_infraspecificepithet,
                    'sp_name'=>$sp->ckew_scientfiicname,
                    'sp_autor'=>$sp->ckew_scientfiicnameautorship,
                    'sp_reference'=>$sp->ckew_namepublishedin,
                    'sp_catorigin'=>'kew',
                    'sp_catid'=>$i,
                ]);
            }
        }
    }
}
