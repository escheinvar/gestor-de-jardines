<?php

namespace App\Livewire\Admin;

use App\Models\cat_campus;
use App\Models\cat_jardines;
use App\Models\estados;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CampusYjardinesController extends Component
{
    use WithFileUploads;

    public function mount(){
        $this->NvoLogo='';
    }
    ###############################################
    ############# Inicia sección de modal de Campus
    public $tipoModalCampus,$jardinCampus,$NombreCortoCampus,$NombreCompletoCampus,$SiglasCampus;
    public $EstadoCampus, $MunicipioCampus, $DireccionCampus,$CampusInactivo;

    public function AbreElModalCampus($tipo){
        if($tipo=='nuevo'){
            $this-> tipoModalCampus = 'Nuevo';
            $this->reset('jardinCampus','NombreCompletoCampus','NombreCortoCampus','SiglasCampus','DireccionCampus','CampusInactivo');

        }else{
            $this-> tipoModalCampus = $tipo; //contiene ccam_id
            $this->jardinCampus=cat_campus::where('ccam_id',$tipo)->value('ccam_cjarid');
            $this->NombreCompletoCampus=cat_campus::where('ccam_id',$tipo)->value('ccam_nombre');
            $this->NombreCortoCampus=cat_campus::where('ccam_id',$tipo)->value('ccam_name');
            $this->SiglasCampus=cat_campus::where('ccam_id',$tipo)->value('ccam_siglas');
            $this->DireccionCampus=cat_campus::where('ccam_id',$tipo)->value('ccam_direccion');
            $ActivoCampus=cat_campus::where('ccam_id',$tipo)->value('ccam_act');
            if($ActivoCampus=='1'){$this->CampusInactivo=FALSE;}else{$this->CampusInactivo=TRUE;}

        }
        $this->dispatch('AbreMiModalCampus');
    }

    public function CierraElModalCampus(){
        $this->reset('jardinCampus','NombreCompletoCampus','NombreCortoCampus','SiglasCampus','DireccionCampus','CampusInactivo');
        $this->resetValidation();
        $this->dispatch('CierraMiModalCampus');
    }

    public function GuardaElModalCampus(){
        if($this->tipoModalCampus=='Nuevo'){$ElId='0';}else{$ElId=$this->tipoModalCampus;}//TipoModalCampus trae ccam_id
        ##### Valida
        $this->validate([
            'jardinCampus'=>'required|not_in:Nvo',
            'NombreCompletoCampus'=>'required',
            'NombreCortoCampus'=>'required',
            'SiglasCampus'=>'required|unique:cat_campus,ccam_siglas,'.$ElId.',ccam_id',
        ]);
        ##### Prepara variables
        if($this->CampusInactivo==TRUE){$act='0';}else{$act='1';}
        ##### Guarda base
        cat_campus::updateOrCreate(['ccam_id'=>$ElId],[
            'ccam_act'=>$act,
            'ccam_cjarid'=>$this->jardinCampus,
            'ccam_siglas'=>$this->SiglasCampus,
            'ccam_name'=>$this->NombreCortoCampus,
            'ccam_nombre'=>$this->NombreCompletoCampus,
            'ccam_direccion'=>$this->DireccionCampus,
        ]);
        ##### Cierra modal
        $this->CierraElModalCampus();
        redirect('/campus');
    }
    ############ Termina sección de modal de Campus
    ###############################################

    ###############################################
    ########## Inicia sección de modal de Jardines
    public $tipoModalJardin, $NombreCompletoJardin, $NombreCortoJardin,$SiglasJardin, $TipoJardin;
    public $DireccionJardin, $TelefonoJardin,$CorreoJardin,$EstadoJardin, $LogoJardin, $NvoLogo;

    public function AbreElModalJardines($tipo){
         if($tipo=='Nuevo'){
            $this-> tipoModalJardin = '0';
            $this->reset('NombreCompletoJardin','NombreCortoJardin','SiglasJardin','TipoJardin','DireccionJardin','TelefonoJardin','CorreoJardin','EstadoJardin','LogoJardin');
        }else {
            $this->tipoModalJardin = $tipo; ##### $tipo tiene cjar_id
            $this->NombreCompletoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_nombre');
            $this->NombreCortoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_name');
            $this->SiglasJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_siglas');
            $this->TipoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_tipo');
            $this->DireccionJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_direccion');
            $this->TelefonoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_tel');
            $this->CorreoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_mail');
            $this->EstadoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_edo');
            $this->LogoJardin=cat_jardines::where('cjar_id',$tipo)->value('cjar_logo');
        }
        $this->dispatch('AbreMiModalJardines');
    }

    public function CierraElModalJardines(){
        $this->reset(['NombreCompletoJardin','NombreCortoJardin','SiglasJardin','TipoJardin','DireccionJardin','TelefonoJardin','CorreoJardin','EstadoJardin','LogoJardin','NvoLogo']);
        $this->dispatch('CierraMiModalJardines');
    }

    public function GuardaElModalJardines(){
        $this->validate([
            'NombreCompletoJardin'=>'required',
            'NombreCortoJardin'=>'required',
            'SiglasJardin'=>'required|unique:cat_jardines,cjar_siglas,'.$this->tipoModalJardin.',cjar_id',
            'TipoJardin'=>'required',
            'EstadoJardin'=>'required',
        ]);
        ##### Guarda base
        cat_jardines::updateOrCreate(['cjar_id'=>$this->tipoModalJardin],[
            'cjar_siglas'=>$this->SiglasJardin,
            'cjar_name'=>$this->NombreCortoJardin,
            'cjar_nombre'=>$this->NombreCompletoJardin,
            'cjar_tipo'=>$this->TipoJardin,
            'cjar_direccion'=>$this->DireccionJardin,
            'cjar_tel'=>$this->TelefonoJardin,
            'cjar_mail'=>$this->CorreoJardin,
            'cjar_edo'=>$this->EstadoJardin,
        ]);

        if($this->NvoLogo != ''){
            $nombre=$this->SiglasJardin.".".$this->NvoLogo->getClientOriginalExtension();
            $this->NvoLogo->storeAs(path:'/avatar/jardines/',name:$nombre);
            cat_jardines::where('cjar_id',$this->tipoModalJardin)->update([
                'cjar_logo'=>$nombre
            ]);
        }
        $this->CierraElModalJardines();
    }

    ########## Termina sección de modal de Jardines
    ###############################################

    public function render() {
        $campus=cat_campus::join('cat_jardines','ccam_cjarid','=','cjar_id')
            ->orderBy('ccam_name','asc')
            ->get();

        $jardines=cat_jardines::all();

        return view('livewire.admin.campus-yjardines-controller',[
            'campus'=>$campus,
            'jardines'=>$jardines,
            'estados'=>estados::all(),
        ]);
    }
}
