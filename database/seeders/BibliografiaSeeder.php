<?php

namespace Database\Seeders;

use \Faker\Provider\Book;
use App\Models\bibliografia;
use App\Models\bibliografia_autores;
use App\Models\cat_conceptos;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class BibliografiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        require_once 'vendor/autoload.php';

        $numero='3';
        $faker = Factory::create('es_mx');
        $tipos=cat_conceptos::where('con_tema','tipo-publicacion')->select('con_txt')->get();

        foreach ($tipos as $tipo){
            $num='0';
            while($num < $numero){
                $num++;
                $bib=bibliografia::create([
                    'bib_ccamsiglas'=>'JebOax',
                    'bib_tipo'=>$tipo->con_txt,
                    'bib_anio'=>$faker->year,
                    'bib_titulo'=> $faker->sentence($nbWords = 3, $variableNbWords = true),
                    'bib_nombre'=> $faker->sentence($nbWords = 3, $variableNbWords = true),
                    'bib_numero'=>$faker->numberBetween(1,50),
                    'bib_volumen'=>$faker->numberBetween(100,500),
                    'bib_pp'=>$faker->numberBetween(1,1000),
                    'bib_editorial'=>$faker->company,
                    'bib_lengua'=>'spa',
                    'bib_edo'=>'Oaxaca',
                    'bib_mpio'=>'Oaxaca',
                    'bib_localidad'=>'Ixcotel',
                    'bib_tipotesis'=>$faker->randomElement(['Doctorado','Maestría','Licenciatura','Técnico'],1),
                    'bib_ocupa'=>$faker->jobTitle,
                    'bib_edad'=>$faker->numberBetween(16,90),
                ]);
                ###### Crea autor
                $numAuts=$faker->numberBetween(1,4);
                $num2='0'; $autortxt='';
                while($num2 < $numAuts){
                    $num2++;
                    $ape=$faker->lastName();
                    bibliografia_autores::create([
                        'bibaut_bibid'=>$bib->bib_id,
                        'bibaut_nombre'=>$faker->firstName(),
                        'bibaut_ap'=>$ape,
                        'bibaut_tipo'=>'autor',
                    ]);
                    if($num2=='1'){$autortxt=$ape;}else{$autortxt=$autortxt.", ".$ape;}
                }
                bibliografia::where('bib_id',$bib->bib_id)->update(['bib_autores'=>$autortxt]);
                ####### Crea editor
                if($bib->bib_tipo=='capítulo de libro'){
                    $numAuts=$faker->numberBetween(1,4);
                    $num2='0';
                    while($num2 < $numAuts){
                        $num2++;
                        bibliografia_autores::create([
                            'bibaut_bibid'=>$bib->bib_id,
                            'bibaut_nombre'=>$faker->firstName(),
                            'bibaut_ap'=>$faker->lastName(),
                            'bibaut_tipo'=>'editor',
                        ]);
                    }
                }
            }
        }
    }
}
