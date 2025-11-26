<?php

namespace App\Livewire\Coleccion;

use App\Models\bibliografia_autores;
use App\Models\cat_conceptos;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalBibliografiaController extends Component
{
    public $bibId;
    public $autores,$bibmodal_ap, $bibmodal_nombre, $bibmodal_orcid;

    #[On('abreModalDeBibliogfafia')]
    public function recibeValoresDeFuera($data){
        $this->bibId=$data['bibId'];

    }

    public function mount(){
        $this->autores=bibliografia_autores::where('bibaut_bibid',$this->bibId)->get()->toArray();
    }

    public function AgregarAutor(){

        ##### Valida datos
        $this->validate([
            'bibmodal_ap'=>'required',
            'bibmodal_nombre'=>'required',
        ]);
        if($this->bibId=='0'){
            array_push($this->autores,[
                'bibaut_bibid'=>'1',
                'bibaut_nombre'=>$this->bibmodal_nombre,
                'bibaut_ap'=>$this->bibmodal_ap,
                'bibaut_orcid'=>$this->bibmodal_orcid,
            ]);

        }else{
            bibliografia_autores::create([
                'bibaut_bibid'=>$this->bibId,
                'bibaut_nombre'=>$this->bibmodal_nombre,
                'bibaut_ap'=>$this->bibmodal_ap,
                'bibaut_orcid'=>$this->bibmodal_orcid,
            ]);
        }
        $this->bibmodal_nombre='';
        $this->bibmodal_ap='';
        $this->bibmodal_orcid='';


    }
    public function render(){
        // $biblio=;

        $tipos=cat_conceptos::where('con_tema','tipo-publicacion')->get('con_txt');
        return view('livewire.coleccion.modal-bibliografia-controller',[
            // 'biblio'=>$biblio,
            // 'autores'=>$autores,
            'tipos'=>$tipos,
        ]);
    }
}
