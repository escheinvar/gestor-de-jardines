<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\Api\camellones;
use App\Models\cat_camellones;
use App\Models\cat_campus;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CamellonesController extends Component
{
    public $edit;
    public $orden, $sent, $CampusSelected;

    public function mount(){
        $this->orden='cam_id';
        $this->sent='asc';
        $this->CampusSelected='JebOax';
        // $this->CampusSelected=usr_roles::where('rol_usrid',Auth::user()->id)
        //     ->where('rol_crolrol','admin')
        //     ->where('rol_del','0')
        //     ->where('rol_act','1')
        //     ->select('rol_ccamsiglas as campus')
        //     ->first();
    }

    public function ordena($campo){
        $this->orden=$campo;
        if($this->sent=='asc'){
            $this->sent='desc';
        }else{
            $this->sent='asc';
        }
    }

    public function redirige($id){
        redirect('camellon/'.$id);
    }

    public function MapaCamellones($datos,$streetMap,$DestacaId){
        ##### Esta función requiere $datos, con la seleccion de cat_camellon a mapear
        ##### $streetMap=1 como binario 0, 1 indicando si aparece fondo de StreeMap (1) o no (0)
        ##### $DestacaId contiene 'null' ó cam_id. Cuando 'null', muestra todo $datos, pero cuando
        ##### es igial a cam_id, muestra $datos en gris y destaca y centra cam_id
        // $streetMap='1';
        // $datos=cat_camellones::join('cat_campus','cam_ccamid','=','ccam_id')
        //     ->where('ccam_siglas',$this->CampusSelected)
        //     ->get();
        // $DestacaId=30;

        ###### Calcula X y Y inicial (para visualizar el mapa)
        if($DestacaId=='null'){
            $centrar=$datos;
        }else{
            $centrar=$datos->where('cam_id',$DestacaId);
        }
        // dd('DestacaId',$DestacaId);
        $xmin = $centrar->min('cam_xmin');
        $ymin = $centrar->min('cam_ymin');
        $xmax = $centrar->max('cam_xmax');
        $ymax = $centrar->max('cam_ymax');
        $x= ($xmax+$xmin)/2;
        $y= ($ymax+$ymin)/2;
        ######## Calcula zoom
        $difx= $xmax - $xmin;
        $dify= $ymax - $ymin;
        $max=max(abs($difx),abs($dify));
        ###### calcula nivel de zoom
        if($max < 0.0000018){
            $zoom=24;
        }elseif($max >= 0.0000018 AND $max < 0.000018){
            $zoom=23;
        }elseif($max >= 0.000018 AND $max < 0.00018){
            $zoom=22;
        }elseif($max >= 0.00018 AND $max < 0.0018){ #### 0.00089gr=100 mts, 0.0018=200mts
            $zoom=19;  ### 19=máximo zoom (bien cerca)
        }elseif($max >= 0.0018 AND $max < 0.0127){  #### 0.0018=200m, 0.127=300mts
            $zoom=18;
        }elseif($max >= 0.0127 AND $max < 0.054){  ### 300 a 600 mts
            $zoom=17;
        }else{
            $zoom=16;  ### Vista lejana de una colonia
        }
        ##### Pasa lista de camellones a array y lo manda a java
        $mapas=$datos->toArray();
        $this->dispatch('CierraMapa');
        $this->dispatch('IniciaMapaCamellones', zoom:$zoom, streetmap:$streetMap, mapas:$mapas, x:$x, y:$y, DestacaId:$DestacaId);
    }


    public function render() {
        ###### Genera array con siglas de campus a los que
        ###### puede acceder el usr
        $campu=usr_roles::where('rol_usrid',Auth::user()->id)
            ->where('rol_crolrol','admin-campus')
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->select('rol_ccamsiglas as campus')
            ->get();
        ##### Si campus contiene 'todos', jala todos los campus
        if($campu->where('campus','todos')->count() > 0 ){
            $campu=cat_campus::where('ccam_act','1')
                ->select('ccam_siglas as campus')
                ->get();
        }
        ##### Obtiene lista de campus ( a partir de los autorizados)
        $campus=cat_campus::whereIn('ccam_siglas',$campu)
            ->leftJoin('cat_jardines','ccam_cjarid','=','cjar_id')
            ->get();

        ################################# Revisa permisos
        if(in_array('admin-campus',session('rol'))){
            $this->edit=TRUE;
        }else{
            $this->edit=FALSE;
        }

        ###### Carga los camellones
        if($this->CampusSelected != ''){
            $camellones=cat_camellones::where('cam_del','0')
                ->leftJoin('cat_campus','cam_ccamid','=','ccam_id')
                ->leftJoin('cat_jardines','ccam_cjarid','=','cjar_id')
                ->where('ccam_siglas',$this->CampusSelected)
                ->select('cam_id','cam_act','cam_camellon','cam_camellonname','cam_zona','cam_zonaname',
                    'cam_color','cam_notas','cam_mapa','cam_xmin','cam_xmax','cam_ymin','cam_ymax',
                    'cjar_siglas','ccam_siglas','ccam_name')
                ->orderBy($this->orden,$this->sent)
            ->get();
        }else{
            $camellones=collect();
        }

        if($camellones->count() > 0){
            $datos=cat_camellones::join('cat_campus','cam_ccamid','=','ccam_id')
                ->where('ccam_siglas',$this->CampusSelected)
                ->where('cam_del','0')
                ->where('cam_act','1')
                ->get();
            $this->MapaCamellones($datos,'1','null');
        }

        return view('livewire.admin.camellones-controller',[
            'campus'=>$campus,
            'camellones'=>$camellones,
        ]);
    }
}
