<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LeerArchivoKobo implements WithMultipleSheets
{

    public function sheets(): array
    {
        return[
            'GestordeJardines' => new LeerArchivoKobo1(),
            'ejemplar' => new LeerArchivoKobo2(),
        ];
    }
}
