<?php

namespace Database\Seeders;

use App\Models\ej_ubicaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeloDeKoboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events=[
            []
        ];

        foreach ($events as $event){
                ej_ubicaciones::create($event);
            }

    }
}
