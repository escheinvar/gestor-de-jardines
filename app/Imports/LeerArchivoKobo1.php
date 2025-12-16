<?php

namespace App\Imports;

use App\Models\kobo1;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeerArchivoKobo1 implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows){
        // $IdsExisten=kobo1::get()->pluck('kobo1_koboid')->toArray();
        // $IdsNuevos=$rows->pluck('id')->toArray();

        foreach($rows as $row){
            // dd($row['coords_xprecisa']);
            if( $row['coords_xprecis'] != '' ){$corX=$row['coords_xprecis'];}else{$corX=$row['coords_cel_longitude'];}
            if( $row['coords_yprecis'] != '' ){$corY=$row['coords_yprecis'];}else{$corY=$row['coords_cel_latitude'];}


            kobo1::create([
                'kobo1_koboid'=> $row['id'],
                'kobo1_index'=> $row['index'],
                'kobo1_username'=>$row['username'],
                'kobo1_date'=>$row['end'],

                'kobo1_camellon'=>$row['camellon'],
                'kobo1_fotoubica'=>$row['foto_ubica_url'],
                'kobo1_x'=>$corX, #$row['coords_cel'],
                'kobo1_y'=>$corY, #$row['coords_cel'],
                'kobo1_nombrecuadr'=>$row['nombre_ubicacion'],
                'kobo1_notasubica'=>$row['notas_ubicacion'],
            ]);
        }
    }
}
