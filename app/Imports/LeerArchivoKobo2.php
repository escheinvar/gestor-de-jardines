<?php

namespace App\Imports;

use App\Models\kobo2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeerArchivoKobo2 implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows){
        foreach($rows as $row){
            // dd($row);
            kobo2::create([
                'kobo2_koboid'=>$row['submission_id'],
                'kobo2_parentindex'=>$row['parent_index'],

                'kobo2_nombreejemplar'=>$row['ejemplaralias_ejemplar'],
                'kobo2_clavo'=>$row['ejemplarclavo'],
                // 'kobo2_tipoejem'=>$row['ejemplarnum_colonias'],
                // 'kobo2_numcols'=>$row['ejemplarnum_inds'],
                'kobo2_numext'=>$row['ejemplarnum_extension'],
                'kobo2_numinds'=>$row['ejemplarnum_inds'],
                'kobo2_fotoejemplar'=>$row['ejemplarfoto_ejemplar_url'],
                'kobo2_fotoejemplar2'=>$row['ejemplarfoto_ejemplar2_url'],
                'kobo2_fotoflor'=>$row['ejemplarfoto_flor_url'],
                'kobo2_fotohoja'=>$row['ejemplarfoto_hoja_url'],
                'kobo2_fotofrutos'=>$row['ejemplarfoto_frutos_url'],
                'kobo2_nombrecient'=>$row['ejemplarsc_name'],
                'kobo2_nombrecom'=>$row['ejemplarcom_name'],
            ]);
        }
    }
}
