<?php

namespace App\Livewire\Kobo;

use App\Imports\LeerArchivoKobo;
use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\kobo1;
use App\Models\kobo2;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CargaArchivo1Controller extends Component
{
    use WithFileUploads;

    public  $edit, $campus, $excel, $token, $rutaImg, $ejemplares;

    public function mount(){
        $this->ejemplares=kobo2::where('kobo2_del','0')
            ->orderBy('kobo2_id')
            ->get();
        $this->token='a3df265eabca7ec99e284bda96b581d5e562db3b';

        if($this->ejemplares->count() > '0'){
            $this->campus=kobo2::pluck('kobo2_ccamsiglas')->first();
        }
        session(['tokenKobo'=>$this->token]);
    }

    public function Cargarfile(){
        $this->validate([
            'campus'=>'required',
            'excel'=>'required'
        ]);

        ##### Carga archivo excel (las dos sheets)
        Excel::import(new LeerArchivoKobo, $this->excel);

        ##### Pone el campus
        kobo2::whereNull('kobo2_ccamsiglas')->update(['kobo2_ccamsiglas'=>$this->campus]);

        ##### Copia los datos de kobo1 en kobo2:
        $kobo1=kobo1::where('kobo1_del','0')->get();
        foreach($kobo1 as $k){
            kobo2::where('kobo2_parentindex',$k->kobo1_id)
                ->where('kobo2_del','0')
                ->update([
                    'kobo2_username'=> $k->kobo1_username,
                    'kobo2_date'=> $k->kobo1_date,
                    'kobo2_camellon'=> $k->kobo1_camellon,
                    'kobo2_fotoubica'=> $k->kobo1_fotoubica,
                    'kobo2_x'=> $k->kobo1_x,
                    'kobo2_y'=> $k->kobo1_y,
                    'kobo2_nombrecuadr'=> $k->kobo1_nombrecuadr,
                    'kobo2_notasubica'=> $k->kobo1_notasubica,
            ]);
        }

        ##### carga datos de los ejemplares
        $this->ejemplares=kobo2::where('kobo2_del','0')->get();

        ##### Finaliza
        $this->excel='';
        $this->dispatch('AvisoExitoKobo', msj:'Se cargaron correctamente los ejemplares');
    }

    public function DescargaImagen($http){        // Realizar la solicitud HTTP con autenticación (si es necesaria)

        $token=$this->token;
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $token,
        ])->get($http);


        if($response->successful()){
            // Storage::disk('public')->put('kobotmp/va.jpg', $response->body());
            Storage::put('kobotmp/va.jpg', $response->body());
        }else{
            dd('error al descargar');
        }
    }

    public function BorrarTabla(){
        kobo1::truncate();
        kobo2::truncate();
        $condenados=Storage::allFiles('/kobotmp/');
        Storage::delete($condenados);
        $this->ejemplares=collect();
    }

    public function render() {
        ##### Verifica acceso
        if(array_intersect(session('rol'), ['admin-campus','admin-colviva','curador-cientifico'])){
            $this->edit='1';
        }else{
            $this->edit='0';
            redirect('/noauth/-- solicita acceso --');
        }

        $campuses=cat_campus::orderBy('ccam_siglas')->get();

        $camellones=cat_camellones::where('cam_del','0')
            ->leftJoin('cat_campus','cam_ccamid','=','ccam_id')
            ->where('cam_act','1')
            ->select('cam_camellon','ccam_siglas')
            ->get();

        return view('livewire.kobo.carga-archivo1-controller',[
            'campuses'=>$campuses,
            'camellones'=>$camellones,
        ]);
    }
}
