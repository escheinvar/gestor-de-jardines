<?php

namespace App\Livewire\Coleccion;

use App\Models\cat_autoridades;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalAutoridadesController extends Component
{
    public $autId;
    public $ap1, $ap2, $nombre, $institu, $mail,$tel,$tipo, $tema;

    #[On('abreModalDeAutoridades')]
    public function recibeValoresDeFuera($data){
        $this->autId=$data['autId'];
        $this->mount();
    }

    public function mount(){
        if($this->autId == '0'){
            $this->reset('ap1', 'ap2', 'nombre', 'institu', 'mail','tel','tipo','tema');
        }else{
            $this->ap1= cat_autoridades::where('aut_id',$this->autId)->value('aut_ap1');
            $this->ap2= cat_autoridades::where('aut_id',$this->autId)->value('aut_ap2');
            $this->nombre= cat_autoridades::where('aut_id',$this->autId)->value('aut_nombre');
            $this->institu= cat_autoridades::where('aut_id',$this->autId)->value('aut_inst');
            $this->mail= cat_autoridades::where('aut_id',$this->autId)->value('aut_mail');
            $this->tel= cat_autoridades::where('aut_id',$this->autId)->value('aut_tel');
            $this->tipo= cat_autoridades::where('aut_id',$this->autId)->value('aut_tipo');
            $this->tema= cat_autoridades::where('aut_id',$this->autId)->value('aut_tema');
        }
    }

    public function Guardar(){
        $this->validate([
            'ap1'=>'required',
            'nombre'=>'required',
            'tipo'=>'required',
        ],[
            'ap1'=>'Se requiere cuando menos un apellido',
            'nombre'=>'Se requiere cuando menos un nombre',
        ]);
        ###### Valida que no exista ya el nombre (pero sin espacios y sin mayuscula/minuscula)
        $yaHay=cat_autoridades::whereRaw("REPLACE(aut_nombre,' ','') ILIKE ?", preg_replace('/ /','',$this->nombre) )
        ->whereRaw("REPLACE(aut_ap1,' ','') ILIKE ?", preg_replace('/ /','',$this->ap1) )
        ->whereRaw("REPLACE(aut_ap2,' ','') ILIKE ?", preg_replace('/ /','',$this->ap2) )
        ->count();
        if($yaHay > 0){
            $this->addError('nombre','Esta persona ya existe en el catálogo');
            $this->addError('ap1','Esta persona ya existe en el catálogo');
            $this->addError('ap2','Esta persona ya existe en el catálogo');
            return;
        }

        $tanda=[
            'aut_ap1'=>$this->ap1,
            'aut_ap2'=>$this->ap2,
            'aut_nombre'=>$this->nombre,
            'aut_inst'=>$this->institu,
            'aut_mail'=>$this->mail,
            'aut_tel'=>$this->tel,
            'aut_tipo'=>$this->tipo,
            'aut_tema'=>$this->tema,
            'aut_usrid'=>Auth::user()->id,
        ];
        if($this->autId=='0'){
            cat_autoridades::create($tanda);
            $this->dispatch('AvisoExitoAutoridades', msj:'Autoridad registrada correctamente');
        }else{
            cat_autoridades::where('aut_id',$this->autId)->update($tanda);
            $this->dispatch('AvisoExitoAutoridades', msj:'Cambios guardados con éxito');
        }
        $this->borrarTodo();
    }



    public function borrarTodo(){
        $this->reset('ap1', 'ap2', 'nombre', 'institu', 'mail','tel','tipo','tema');
        $this->resetErrorBag();
        $this->dispatch('cierraModalDeAutoridades');
    }

    public function render() {

        return view('livewire.coleccion.modal-autoridades-controller',[
            'tipos'=>['colecta','taxonomia','lengua'],
        ]);
    }
}
