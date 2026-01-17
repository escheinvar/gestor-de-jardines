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
