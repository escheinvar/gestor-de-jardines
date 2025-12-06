<?php

namespace App\Livewire\Coleccion;

use App\Models\bibliografia;
use App\Models\cat_lenguas;
use App\Models\ej_nombres_comunes;
use App\Models\ejemplares;
use App\Models\estados;
use App\Models\municipios;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalNombresComunesController extends Component
{
    use WithFileUploads;

    public $ejId,$conId;  #### Variables que recibe desde controlador que dispara (Id del ejemplar e Id de la CitaBibliográfica)
    public $edit_curcient, $edit_adcolviva;  ##### Flag de permisos de edición
    public $modnomcom_activo,$modnomcom_origen, $modnomcom_nombre, $modnomcom_lengua, $modnomcom_buscaBiblio, $modnomcom_ubicaciones, $modnomcom_estado, $modnomcom_municipios, $modnomcom_mpio;
    public $modnomcom_notas, $modnomcom_fileNvo, $modnomcom_file1, $modnomcom_file2, $modnomcom_file3, $modnomcom_file4;

    #####################################################
    ##### Recibe variables desde el controlador que invoca
    #[On('abreModalDeNombreComun')]
    public function recibeVariables($datos){
        $this->ejId=$datos['ejId'];
        $this->conId=$datos['conId'];
        $this->modnomcom_municipios=[];

        ###### Carga valores de cuestionario
        if($this->conId=='0'){
            $this->borrarTodo();
            $this->modnomcom_ubicaciones=[];


        }elseif($this->conId > '0'){
            $data=ej_nombres_comunes::where('con_id',$this->conId)
                ->where('con_del','0')
                ->first();

            if($data->con_act=='1'){$this->modnomcom_activo=TRUE;}elseif($data->con_act=='0'){$this->modnomcom_activo=FALSE;}else{$data->con_act='0';}

            if($data->con_origen=='1'){$this->modnomcom_origen=TRUE;}else{$this->modnomcom_origen=FALSE;}

            $this->modnomcom_nombre = $data->con_nombre;
            $this->modnomcom_lengua = $data->con_clencode;
            $this->modnomcom_buscaBiblio  = $data->con_bibid;
            if($data->con_ubica != ''){
                $this->modnomcom_ubicaciones=explode(';',$data->con_ubica);
            }else{$this->modnomcom_ubicaciones=[];}
            $this->modnomcom_notas = $data->con_notas;
            $this->modnomcom_file1 = $data->con_file1;
            $this->modnomcom_file2 = $data->con_file2;
            $this->modnomcom_file3 = $data->con_file3;
            $this->modnomcom_file4 = $data->con_file4;
        }
        // dd($data, $this->modnomcom_ubicaciones);

    }

    public function borrarTodo(){
        $this->modnomcom_buscaBiblio='';
        $this->modnomcom_origen='';
        $this->modnomcom_activo='';
        $this->modnomcom_origen='';
        $this->modnomcom_nombre='';
        $this->modnomcom_lengua='';
        $this->modnomcom_buscaBiblio='';
        $this->modnomcom_ubicaciones='';
        $this->modnomcom_estado='';
        $this->modnomcom_mpio='';
        $this->modnomcom_notas='';
        $this->modnomcom_fileNvo='';
        $this->modnomcom_file1='';
        $this->modnomcom_file2='';
        $this->modnomcom_file3='';
        $this->modnomcom_file4='';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function cerrarModal($modo){
        $this->borrarTodo();
        redirect()->back();
        if($modo=='1'){
            $this->dispatch('cierraModalDeNombreComun', reload:'1');
        }else{
            $this->dispatch('cierraModalDeNombreComun', reload:'0');
        }

    }

    public function AbrirModalBibliografia($par1){
        $data=['bibId'=>$par1];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        $this->dispatch('cierraModalDeNombreComun', reload:'0');
        $this->dispatch('abreModalDeBibliogfafia',$data);
    }

    public function CargaMunicipios(){
        $this->modnomcom_municipios=municipios::where('cmun_edoname',$this->modnomcom_estado)->select('cmun_mpioname')->get();
        $this->modnomcom_mpio='';
        $this->resetErrorBag();
    }

    public function AgregarMunicipio(){
        $this->validate([
            'modnomcom_estado'=>'required',
            'modnomcom_mpio'=>'required',
        ],[
            'modnomcom_estado'=>'Debes indicar un estado',
            'modnomcom_mpio'=>'Debes indicar un municipio',
        ]);
        $this->modnomcom_ubicaciones[]=$this->modnomcom_estado.", ".$this->modnomcom_mpio;
        $this->modnomcom_estado='';
    }

    public function borraArchivo($num){
        if($num=='1'){
            $ganon=ej_nombres_comunes::where('con_id',$this->conId)->value('con_file1');
            $valor=['con_file1'=>null];
            $this->modnomcom_file1='';
        }elseif($num=='2'){
            $ganon=ej_nombres_comunes::where('con_id',$this->conId)->value('con_file2');
            $valor=['con_file2'=>null];
            $this->modnomcom_file2='';
        }elseif($num=='3'){
            $ganon=ej_nombres_comunes::where('con_id',$this->conId)->value('con_file3');
            $valor=['con_file3'=>null];
            $this->modnomcom_file3='';
        }elseif($num=='4'){
            $ganon=ej_nombres_comunes::where('con_id',$this->conId)->value('con_file4');
            $valor=['con_file4'=>null];
            $this->modnomcom_file4='';
        }
        Storage::delete($ganon);
        ej_nombres_comunes::where('con_id',$this->conId)->update($valor);
    }

    public function subirArchivo(){
        $this->validate(['modnomcom_fileNvo'=>'required',]);
        if($this->modnomcom_file1==''){
            $numeral='file1';  ### uso el nombre para definir la coolumna abajo
        }elseif($this->modnomcom_file2==''){
            $numeral='file2';
        }elseif($this->modnomcom_file3==''){
            $numeral='file3';
        }elseif($this->modnomcom_file4==''){
            $numeral='file4';
        }

        $nombre="nombre".$this->conId."_ejem".$this->ejId."_".$numeral.".".$this->modnomcom_fileNvo->getClientOriginalExtension();
        $ruta='/nombres/';
        $this->modnomcom_fileNvo->storeAs(path:$ruta, name:$nombre);
        ej_nombres_comunes::where('con_id',$this->conId)->update([
            'con_'.$numeral=>$ruta.$nombre
        ]);
        $this->modnomcom_fileNvo='';
        $this->modnomcom_file1 = ej_nombres_comunes::where('con_id',$this->conId)->value('con_file1');
        $this->modnomcom_file2 = ej_nombres_comunes::where('con_id',$this->conId)->value('con_file2');
        $this->modnomcom_file3 = ej_nombres_comunes::where('con_id',$this->conId)->value('con_file3');
        $this->modnomcom_file4 = ej_nombres_comunes::where('con_id',$this->conId)->value('con_file4');
        // $this->dispatch('AvisoExito',msj:'Archivo guardado exitosamente');
    }

    public function BorrarNombre(){
        ej_nombres_comunes::where('con_id',$this->conId)->update(['con_del'=>'1']);
        $this->cerrarModal('1');
        redirect('/ejem_nombres/'.$this->ejId);
    }

    public function GuardarDatosDeNombre(){
        // @if(in_array(request()->path(),['recorridos','mapa']))
        ##### Valida cuestionario
        $this->validate([
            'modnomcom_buscaBiblio'=>'required',
            'modnomcom_nombre'=>'required',
            'modnomcom_lengua'=>'required',
        ],[
            'modnomcom_buscaBiblio'=>'Se requiere cuando menos una cita bibliográfica o de comunicación personal',
            'modnomcom_nombre'=>'Debes indicar el texto del nombre',
            'modnomcom_lengua'=>'Debes indicar la lengua en la que está el nombre',
        ]);
        ##### Revisa si hay mpio y edo cargado pero sin guardar para guardarlo
        // if($this->modnomcom_estado != '' AND $this->modnomcom_mpio != ''){
        //     $this->modnomcom_ubicaciones[]=$this->modnomcom_estado.", ".$this->modnomcom_mpio;
        // }
        ##### Revisa si hay archivo nuevo cargado pero sin guardar

        ####### procesa algunos datos
        if($this->modnomcom_activo==TRUE){$act='1';}else{$act='0';}
        if($this->modnomcom_origen==TRUE){$orig='1';}else{$orig='0';}
        if($this->conId=='0'){$act='1';}
        $datos=[
            'con_ejmid'=>$this->ejId,
            'con_act'=>$act,
            'con_origen'=>$orig,
            'con_nombre'=>$this->modnomcom_nombre,
            'con_clencode'=>$this->modnomcom_lengua,
            'con_bibid'=>$this->modnomcom_buscaBiblio,
            'con_ubica'=>implode(';',$this->modnomcom_ubicaciones),
            'con_notas'=>$this->modnomcom_notas,
            'con_file1'=>$this->modnomcom_file1,
            'con_file2'=>$this->modnomcom_file2,
            'con_file3'=>$this->modnomcom_file3,
            'con_file4'=>$this->modnomcom_file4,
        ];
        if($this->conId =='0'){
            $datos['con_id']=ej_nombres_comunes::max('con_id')+1;
            $nvo=ej_nombres_comunes::create($datos);
            $this->conId=$nvo->con_id;
        }else{
            ej_nombres_comunes::where('con_id',$this->conId)->update($datos);
        }

        if($this->modnomcom_fileNvo != ''){
            $this->subirArchivo();
        }

        $this->cerrarModal('1');

        // return redirect('/ejem_nombres/1');
    }

    public function render() {
        #################################################
        ##################### Asigna permisos de edición
        $CampusDelEjemplar=ejemplares::where('ejm_id',$this->ejId)->value('ejm_ccamsiglas');

        ##### Permisos curador-científico,
        $this->edit_curcient='0';
        if(array_intersect(['curador-cientifico'],session('rol'))){
            $CampusAutorizados1=usr_roles::where('rol_crolrol','curador-cientifico')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')->where('rol_act','1')
                ->pluck('rol_ccamsiglas')
                ->toArray();
            if(in_array($CampusDelEjemplar, $CampusAutorizados1) OR  in_array('todos',$CampusAutorizados1) ){
                $this->edit_curcient='1';
            }
        }

        ##### Permisos admin-colviva,
        $this->edit_adcolviva='0';
        if(array_intersect(['admin-colviva'],session('rol'))){
            $CampusAutorizados2=usr_roles::where('rol_crolrol','admin-colviva')
                ->where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')->where('rol_act','1')
                ->pluck('rol_ccamsiglas')
                ->toArray();
            if(in_array($CampusDelEjemplar, $CampusAutorizados2) OR  in_array('todos',$CampusAutorizados2) ){
                $this->edit_adcolviva='1';
            }
        }

        ################## Carga catálogos
        $modnomcom_lenguas=cat_lenguas::select('clen_lengua','clen_code')->where('clen_id','!=','1')->orderBy('clen_lengua')->get();
        $modnomcom_estados=estados::select('cedo_nombre')->get();
        // $modnomcom_municipios=municipios::where('')
        $modnomcom_citas=bibliografia::orderBy('bib_autores')->with('autores')->get();

        return view('livewire.coleccion.modal-nombres-comunes-controller',[
            'modnomcom_lenguas'=>$modnomcom_lenguas,
            'modnomcom_estados'=>$modnomcom_estados,
            'modnomcom_citas'=>$modnomcom_citas,
        ]);
    }
}
