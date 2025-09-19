<?php

namespace Database\Seeders;

use App\Models\cat_roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            ['crol_rol'=>'admin',                   'crol_gps'=>'adminjardin',                      'crol_describe'=>'(Enrique) Administrador General del sistema'],
            ['crol_rol'=>'webmaster',               'crol_gps'=>'',                                 'crol_describe'=>'(Enrique) Web master'],
            ['crol_rol'=>'api-read',                'crol_gps'=>'',                                 'crol_describe'=>'Consumidor de API externo (lectura)'],
            ['crol_rol'=>'amigo',                   'crol_gps'=>'amigo',                            'crol_describe'=>'Persona del público general, Amigo del Jardín'],

            ['crol_rol'=>'curador-colviva',         'crol_gps'=>'adminjardin,jardin,colviva',       'crol_describe'=>'(Geovanny) Persona curadora de la Colección Viva'],
            ['crol_rol'=>'admin-colviva',           'crol_gps'=>'adminjardin,jardin,colviva',       'crol_describe'=>'(Vianney) Persona administradora de la Colección Viva'],
            ['crol_rol'=>'auxJefe-colviva',         'crol_gps'=>'jardin,colviva',                   'crol_describe'=>'(Mariela) Persona auxiliar en jefe de la Colección Viva'],
            ['crol_rol'=>'auxInvents-colviva',      'crol_gps'=>'jardin,colviva',                   'crol_describe'=>'(Gaby T.) Persona auxiliar de inventarios de la Colección Viva'],
            ['crol_rol'=>'auxGral-colviva',         'crol_gps'=>'jardin,colviva',                   'crol_describe'=>'(Jardineros) Persona auxiliar general de Colección Viva'],
            ['crol_rol'=>'capturista-colviva',      'crol_gps'=>'jardin,colviva,amigo',             'crol_describe'=>'(ServSoc) Persona capturista para colección viva'],

            ['crol_rol'=>'curador-semillas',        'crol_gps'=>'adminjardin,jardin,semillas',      'crol_describe'=>'(Niza) Persona curadora de la Colección de Semillas'],
            ['crol_rol'=>'auxGral-semillas',        'crol_gps'=>'jardin,semillas',                  'crol_describe'=>'(Paty) Persona auxiliar general de Colección de Semillas'],
            ['crol_rol'=>'capturista-semillas',     'crol_gps'=>'jardin,semillas,amigo',            'crol_describe'=>'(ServSoc) Persona capturista para colección de semillas'],

            ['crol_rol'=>'curador-plantulas',       'crol_gps'=>'adminjardin,jardin,plantulas',     'crol_describe'=>'(Niza) Persona curadora de la Colección de Plántulas'],
            ['crol_rol'=>'auxGral-plantulas',       'crol_gps'=>'jardin,plantulas',                 'crol_describe'=>'(Paty) Persona auxiliar general de Colección de Plántulas'],
            ['crol_rol'=>'capturista-plantulas',    'crol_gps'=>'jardin,plantulas,amigo',           'crol_describe'=>'(ServSoc) Persona capturista para colección de plántulas'],

            ['crol_rol'=>'curador-cientifico',      'crol_gps'=>'adminjardin,jardin,cientifico',    'crol_describe'=>'(IxMx) Persona curadora de datos científicos'],
            ['crol_rol'=>'auxGral-cientifico',      'crol_gps'=>'jardin,cientifico',                'crol_describe'=>'(PostDoc) Persona auxiliar general de datos científicos'],
            ['crol_rol'=>'capturista-científico',   'crol_gps'=>'jardin,cientifico,amigo',          'crol_describe'=>'(ServSoc) Persona capturista para colección científica'],

            ['crol_rol'=>'admin-sanidad',           'crol_gps'=>'jardin,sanidad',                   'crol_describe'=>'(Vianney) Persona administradora de la Colección Viva'],
            ['crol_rol'=>'auxJefe-sanidad',         'crol_gps'=>'jardin,sanidad',                   'crol_describe'=>'(Don Norber) Persona auxiliar en jefe de la Colección Viva'],
            ['crol_rol'=>'auxInvents-sanidad',      'crol_gps'=>'jardin,sanidad',                   'crol_describe'=>'(PrimCha) Persona auxiliar de inventarios de la Colección Viva'],
            ['crol_rol'=>'auxGral-sanidad',         'crol_gps'=>'jardin,sanidad',                   'crol_describe'=>'(PrimCha) Persona auxiliar general de Colección Viva'],
            ['crol_rol'=>'capturista-sanidad',      'crol_gps'=>'jardin,sanidad,amigo',             'crol_describe'=>'(ServSoc) Persona capturista para colección viva'],
        ];

        if (cat_roles::count() == 0 ) {
            foreach ($events as $event){
                cat_roles::create($event);
            }
        }
    }
}
