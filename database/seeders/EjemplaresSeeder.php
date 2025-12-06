<?php

namespace Database\Seeders;

use App\Models\bibliografia;
use App\Models\bitacora1;
use App\Models\cat_autoridades;
use App\Models\cat_campus;
use App\Models\cat_conceptos;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\ejemplares;
use App\Models\especies;
use App\Models\imagenes;
use App\Models\municipios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class EjemplaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ###################################################################
        ##### Para ejecutar: php artisan db:seed --class=EjemplaresBitacoraSeeder
        ##### Afecta 5 tablas: ejemplares, ej_bitacora1, imagenes,
        #####                  ej_nombres_cientificos, ej_nombres_comunes
        ##### (si se requiere, truncar las cuatro con cascada )
        ###################################################################
        $cantidad=10; ########### Indica la cantidad de ejemplares a ejecutar
        $cont=0;
        $forma=cat_conceptos::where('con_tema','forma_colecta')->pluck('con_txt')->toArray();
        $campus=cat_campus::where('ccam_act','1')->pluck('ccam_siglas')->toArray();
        $colectores=cat_autoridades::where('aut_tipo','colecta')->pluck('aut_id')->toArray();

        ################################ Si no tiene, genera bitácora 0
        if(bitacora1::where('bit_id','0')->count()=='0'){
                bitacora1::create([
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

        while($cont < $cantidad){
            $cont++;

            ########################################################
            ############################ crea datos en ej_bitacora1
            $bitacora=bitacora1::create([
                'bit_id'=>bitacora1::max('bit_id')+1,
                'bit_ejmid_prop'=>'0',
                'bit_colectadate'=>fake()->date(),
                'bit_origen'=>fake()->randomElement(['colecta','recuperación','donación','compra'],1),
                'bit_origen_explica'=>fake()->realText(100),
                'bit_forma_colecta'=>fake()->randomElement($forma,1),
                'bit_etiqueta_colecta'=>fake()->word(),
                'bit_autid'=>fake()->randomElement($colectores,1),
                'bit_edo'=>'Oaxaca',
                'bit_mpio'=>'Mpio Oax',
                'bit_localidad'=>'Localidad',
                'bit_paraje'=>'Paraje',
                'bit_x'=>null,
                'bit_y'=>null,
                'bit_altitud'=>null,
                'bit_obs_colecta'=>null,
                'bit_usrid'=>'1',
            ]);

            ########################################################
            ##### crea datos en ejemplares (requiere de ej_bitacora1)
            $ejemplar=ejemplares::create([
                'ejm_id'=>ejemplares::max('ejm_id')+1,
                'ejm_edo_ubica'=>'0',   ##### Estado de ubicacion: 0-en campo, 1:en registro, 2:ingresada, 3:egresada
                'ejm_edo_scname'=>'0',  ##### Estado de nombre científico: 0-sin nombre, 1-posible nombre, 2:nombre valida téncico, 3: nombre valida autoridad
                'ejm_edo_name'=>'0',    ##### Estado de nombre común: 0-sin nombre, 1-posible nombre, 2:nombre valida téncico, 3: nombre valida autoridad
                'ejm_edo_uso'=>'0',     ##### Estado de nombre común: 0-de escucha general;  1-registra informante local, 2:valida técnico, 3: valida autoridad o bibliografía,

                'ejm_ccamsiglas'=>fake()->randomElement($campus,1),       ##### ccam_id campus
                'ejm_bitid'=>$bitacora->bit_id,        ##### id de bitácora
                'ejm_madreid'=>null,
                'ejm_padreid'=>null,
                'ejm_loteid'=>null,

                // 'ejm_scnmid'=>null,
                // 'ejm_scnmnombre'=>null,
                'ejm_ripdate'=>null,
                'ejm_ripcausa'=>null,
                'ejm_notasingreso'=>null,
            ]);
            ###### Actualiza el id del ejemplar
            bitacora1::where('bit_id',$bitacora->bit_id)->update(['bit_ejmid_prop'=>$ejemplar->ejm_id]);

            ########################################################
            ############# crea datos de 3 imágenes pa cada categoria
            $categorias=['colecta_ejemplar','colecta_paisaje'];
            $imags=['aaa_default_audio.mp3',
                'aaa_default_imagen_vertical.jpg',
                'aaa_default_imagen_cuadrada.jpg',
                'aaa_default_QR.jpeg',
                'aaa_default_imagen_horizontal.jpg',
                'aaa_default_video_horizontal.mp4',
                'aaa_default_imagen.png',
                'aaa_default_video_vertical.mp4'
            ];
            foreach($categorias as $c){
                $imagenes=array_rand($imags,3);
                foreach($imagenes as $i){
                    if(preg_match('/.mp3/', $imags[$i])){$tipo='aud';
                    }elseif(preg_match('/.mp4/',$imags[$i])){$tipo='vid';
                    }else{$tipo='img';}
                    imagenes::create([
                        'img_ejmid'=>$ejemplar->ejm_id,
                        'img_cimgtipo'=>$c,
                        'img_titulo'=>'Titulo '.$ejemplar->ejm_id.'-'.$i,
                        'img_ubica'=>'Ubicación '.$ejemplar->ejm_id.'-'.$i,
                        'img_explica'=>'Explicación '.$ejemplar->ejm_id.'-'.$i,
                        'img_autor'=>'Enrique Scheinvar',
                        'img_fecha'=>date('Y-m-d'),
                        'img_media'=>$tipo,
                        'img_ruta'=>'/img/'.$imags[$i],
                        'img_usrid'=>'2',
                    ]);
                }
            }

            ########################################################
            ############# Asigna (o no) Nombre científico
            $ganon=especies::pluck('sp_id')->random(1);
            $especie=especies::where('sp_id',$ganon)->first();

            $nombreCientifico=ej_nombres_cientificos::create([
                'scn_ejmid'=>$ejemplar->ejm_id,
                'scn_spid'=>$especie->sp_id,
                'scn_edo'=>fake()->randomElement(['0','1','2'],1),
                'scn_reino'=>$especie->sp_reino,
                'scn_familia'=>$especie->sp_familia,
                'scn_genero'=>$especie->sp_genero,
                'scn_sp'=>$especie->sp_sp,
                'scn_ssp'=>$especie->sp_ssp,
                'scn_name'=>$especie->sp_name,

                'scn_colid'=>fake()->randomElement($colectores,1),
                'scn_fecha_determina'=>fake()->date(),
                'scn_usrid'=>'2',
            ]);

            ########################################################
            ############# Asigna Nombres comunes
            $faker = Factory::create('es_ES');
            $CantDeNombres=$faker->numberBetween(0,4);


            $num='0';
            while($num < $CantDeNombres){
                $num++;
                $citaSiOno=$faker->numberBetween(0,1);
                if($citaSiOno=='1'){
                    $biblio=bibliografia::inRandomOrder()->select('bib_id')->first()->bib_id;
                }else{
                    $biblio=null;
                }

                $nombreComun=ej_nombres_comunes::create([
                    'con_ejmid'=>$ejemplar->ejm_id,
                    'con_origen'=>$faker->numberBetween(0,1),
                    'con_nombre'=>$faker->sentence($nbWords = 1, $variableNbWords = true),
                    'con_clencode'=>'spa',
                    // 'con_estado'=>'Oaxaca',
                    'con_ubica'=>'Oaxaca, '.municipios::where('cmun_edoname','Oaxaca')->inRandomOrder()->select('cmun_mpioname')->first()->cmun_mpioname.';',
                    'con_bibid'=>$biblio,
                ]);
            }
        }

    }
}
