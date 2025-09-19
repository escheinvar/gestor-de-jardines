<?php

namespace Database\Seeders;

use App\Models\usr_roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsrRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            [
                'rol_id'=>'1',
                'rol_usrid'=>'1',
                'rol_ccamsiglas'=>'todos',
                'rol_crolrol'=>'admin',
                'rol_describe'=>'Administrador del sistema',
            ] , [
                'rol_id'=>'2',
                'rol_usrid'=>'2',
                'rol_ccamsiglas'=>'JebOax',
                'rol_crolrol'=>'admin',
                'rol_describe'=>'Administrador del sistema',
            ] ,[
                'rol_id'=>'3',
                'rol_usrid'=>'2',
                'rol_ccamsiglas'=>'JebOax',
                'rol_crolrol'=>'webmaster',
                'rol_describe'=>'Web mastter',
            ],[
                'rol_id'=>'4',
                'rol_usrid'=>'2',
                'rol_ccamsiglas'=>'JebOax',
                'rol_crolrol'=>'curador-colviva',
                'rol_describe'=>'Curador de Colección Viva del JebOax',
            ],[
                'rol_id'=>'5',
                'rol_usrid'=>'2',
                'rol_ccamsiglas'=>'JebOax',
                'rol_crolrol'=>'curador-semillas',
                'rol_describe'=>'Curador de Semillas del JebOax',
            ]
        ];

        if(usr_roles::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                usr_roles::create($event);
            }
        }
    }
}
