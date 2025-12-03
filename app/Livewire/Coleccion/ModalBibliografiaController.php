<?php

namespace App\Livewire\Coleccion;

use App\Models\bibliografia;
use App\Models\bibliografia_autores;
use App\Models\cat_campus;
use App\Models\cat_conceptos;
use App\Models\cat_lenguas;
use App\Models\estados;
use App\Models\municipios;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalBibliografiaController extends Component
{
    use WithFileUploads;

    public $bibId;    ##### Id del registro biblio. o 0 para nuevos
    public $bimodal_edit; ###### flag 0=no edita 1=si edita
    public $bibmodal_campus, $bibmodal_autores, $bibmodal_editores, $bibmodal_ap, $bibmodal_nombre, $bibmodal_orcid, $bibmodal_isni, $bibmodal_tipoAutor;
    public $bibmodal_tipo, $bibmodal_anio, $bibmodal_titulo, $bibmodal_nombrePub, $bibmodal_RevNum, $bibmodal_RevVol;
    public $bibmodal_tipoTesis, $bibmodal_pags, $bibmodal_lengua, $bibmodal_doi, $bibmodal_editorial, $bibmodal_isbn, $bibmodal_issn;
    public $bibmodal_ocupa, $bibmodal_edad, $bibmodal_Edo, $bibmodal_mpio, $bibmodal_localidad, $bibmodal_tags, $bibmodal_notasPub, $bibmodal_notasUbica;
    public $bibmodal_url, $bibmodal_priv, $bibmodal_pdf, $bibmodal_archivo;

    #[On('abreModalDeBibliogfafia')]
    public function recibeValoresDeFuera($data){
        $this->bibId=$data['bibId'];

        ###### Carga datos
        if($this->bibId=='0'){
            $this->BorrarTodo();

        }elseif($this->bibId > '0'){
            $data=bibliografia::where('bib_id',$this->bibId)->first();
            $this->bibmodal_autores=bibliografia_autores::where('bibaut_bibid',$this->bibId)->where('bibaut_del','0')->where('bibaut_tipo','autor')->get()->toArray();
            $this->bibmodal_editores=bibliografia_autores::where('bibaut_bibid',$this->bibId)->where('bibaut_del','0')->where('bibaut_tipo','editor')->get()->toArray();
            $this->bibmodal_campus=$data->bib_ccamsiglas;
            $this->bibmodal_ap='';
            $this->bibmodal_nombre='';
            $this->bibmodal_orcid='';
            $this->bibmodal_tipoAutor='autor';
            $this->bibmodal_tipo=$data->bib_tipo;
            $this->bibmodal_anio=$data->bib_anio;
            $this->bibmodal_titulo=$data->bib_titulo;
            $this->bibmodal_nombrePub=$data->bib_nombre;
            $this->bibmodal_RevNum=$data->bib_numero;
            $this->bibmodal_RevVol=$data->bib_volumen;
            $this->bibmodal_pags=$data->bib_pp;
            $this->bibmodal_editorial=$data->bib_editorial;
            $this->bibmodal_lengua=$data->bib_lengua;
            $this->bibmodal_tags=$data->bib_tags    ;
            $this->bibmodal_notasUbica=$data->bib_notasubica;
            $this->bibmodal_Edo=$data->bib_edo;
            $this->bibmodal_mpio=$data->bib_mpio;
            $this->bibmodal_localidad=$data->bib_localidad;
            $this->bibmodal_notasPub=$data->bib_notaspublica;
            $this->bibmodal_tipoTesis=$data->bib_tipotesis;
            $this->bibmodal_ocupa=$data->bib_ocupa;
            $this->bibmodal_edad=$data->bib_edad;
            $this->bibmodal_doi=$data->bib_doi;
            $this->bibmodal_isbn=$data->bib_isbn;
            $this->bibmodal_issn=$data->bib_issn;
            $this->bibmodal_url=$data->bib_url;
            $this->bibmodal_pdf=$data->bib_pdf;
            $this->bibmodal_priv=$data->bib_priv;
        }
    }

    public function mount(){
        $this->bibmodal_autores=bibliografia_autores::where('bibaut_bibid',$this->bibId)
            ->where('bibaut_tipo','autor')
            ->where('bibaut_del','0')
            ->get()
            ->toArray();
        $this->bibmodal_editores=bibliografia_autores::where('bibaut_bibid',$this->bibId)
            ->where('bibaut_tipo','autor')
            ->where('bibaut_del','0')
            ->get()
            ->toArray();
        $this->bibmodal_tipoAutor='autor';
        $this->bibmodal_priv='0';


    }

    public function AgregarAutor(){
        ##### Valida datos
        $this->validate([
            'bibmodal_ap'=>'required',
            'bibmodal_nombre'=>'required',
        ]);
        if($this->bibId=='0'){
            ##### Si es nuevo registro (no hay bibId), guarda
            ##### los nuevos autores introducidos en un array temporal
            if($this->bibmodal_tipoAutor == 'autor'){
                array_push($this->bibmodal_autores,[
                    'bibaut_id'=>'0',
                    'bibaut_bibid'=>'1',
                    'bibaut_nombre'=>$this->bibmodal_nombre,
                    'bibaut_ap'=>$this->bibmodal_ap,
                    'bibaut_orcid'=>$this->bibmodal_orcid,
                    'bibaut_isni'=>$this->bibmodal_isni,
                    'bibaut_tipo'=>'autor',
                ]);
            }else{
                array_push($this->bibmodal_editores,[
                    'bibaut_id'=>'0',
                    'bibaut_bibid'=>'1',
                    'bibaut_nombre'=>$this->bibmodal_nombre,
                    'bibaut_ap'=>$this->bibmodal_ap,
                    'bibaut_orcid'=>$this->bibmodal_orcid,
                    'bibaut_isni'=>$this->bibmodal_isni,
                    'bibaut_tipo'=>'editor',
                ]);
            }

        }else{
            ##### Si no es nuevo registro (ya hay bibId), guarda
            ##### los nuevos autores introducidos en Base de datos
            bibliografia_autores::create([
                'bibaut_bibid'=>$this->bibId,
                'bibaut_nombre'=>$this->bibmodal_nombre,
                'bibaut_ap'=>$this->bibmodal_ap,
                'bibaut_orcid'=>$this->bibmodal_orcid,
                'bibaut_isni'=>$this->bibmodal_isni,
                'bibaut_tipo'=>$this->bibmodal_tipoAutor,
            ]);
            $this->mount();
        }
        ##### Pone  en blanco el formulario
        $this->bibmodal_nombre='';
        $this->bibmodal_ap='';
        $this->bibmodal_orcid='';
    }

    public function BorrarAutor($idAutor){
        if($this->bibId=='0'){
            //
        }elseif($this->bibId > '0'){
            bibliografia_autores::where('bibaut_id',$idAutor)->update([
                'bibaut_del'=>'1',
            ]);
            $this->mount();
        }
    }

    public function cerrarModal(){
        $this->BorrarTodo();
        $this->dispatch('cierraModalDeBibliogfafia');
        redirect('/bibliografía');
    }

    public function BorrarTodo(){
        $this->bibmodal_ap='';
        $this->bibmodal_nombre='';
        $this->bibmodal_orcid='';
        $this->bibmodal_tipoAutor='autor';
        $this->bibmodal_autores=[];
        $this->bibmodal_editores=[];

        $this->bibmodal_tipo='';
        $this->bibmodal_anio='';
        $this->bibmodal_titulo='';
        $this->bibmodal_nombrePub='';
        $this->bibmodal_RevNum='';
        $this->bibmodal_RevVol='';
        $this->bibmodal_pags='';
        $this->bibmodal_editorial='';
        $this->bibmodal_tipoTesis='';
        $this->bibmodal_lengua='';
        $this->bibmodal_doi='';
        $this->bibmodal_isbn='';
        $this->bibmodal_issn='';
        $this->bibmodal_ocupa='';
        $this->bibmodal_edad='';
        $this->bibmodal_Edo='';
        $this->bibmodal_mpio='';
        $this->bibmodal_localidad='';
        $this->bibmodal_tags='';
        $this->bibmodal_notasPub='';
        $this->bibmodal_notasUbica='';
        $this->bibmodal_url='';
        $this->bibmodal_priv='0';
        $this->bibmodal_archivo='';
        $this->bibmodal_pdf='';

        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function BorrarArchivo(){
        bibliografia::where('bib_id',$this->bibId)->update([
            'bib_pdf'=>null,
        ]);
        $this->bibmodal_pdf='';
        $this->mount();
    }

    public function CrearRegistro($tipo){
        ##### Valida campus y tipo
        $this->validate([
            'bibmodal_campus'=>'required',
            'bibmodal_tipo'=>'required',
        ]);

        ##### Valida que haya cuando menos un autor
        if(count($this->bibmodal_autores) =='0'){
            $this->addError('bibmodal_nombre','Debes registrar cuando menos un autor');
            $this->addError('bibmodal_tipoAutor','Debes registrar cuando menos un autor');
            return;
        }

        ######### Valida campos de artículo
        if($this->bibmodal_tipo=='artículo'){
            $this->validate([
                'bibmodal_campus'=>'required',
                'bibmodal_tipo'=>'required',
                'bibmodal_anio'=>'required',
                'bibmodal_lengua'=>'required',
                'bibmodal_titulo'=>'required',
                'bibmodal_nombrePub'=>'required',
                'bibmodal_RevNum'=>'required',
                'bibmodal_pags'=>'required',
            ]);

        ######### Valida campos de libro
        }elseif($this->bibmodal_tipo=='libro'){
            $this->validate([
                'bibmodal_campus'=>'required',
                'bibmodal_tipo'=>'required',
                'bibmodal_anio'=>'required',
                'bibmodal_lengua'=>'required',
                'bibmodal_nombrePub'=>'required',
                'bibmodal_pags'=>'required',
                'bibmodal_editorial'=>'required',
            ]);

        ###### Valida campos de Capítulo de libro
        }elseif($this->bibmodal_tipo=='capítulo de libro'){
            if(count($this->bibmodal_editores) =='0'){
                $this->addError('bibmodal_nombre','Debes registrar cuando menos un editor');
                $this->addError('bibmodal_tipoAutor','Debes registrar cuando menos un editor');
                return;
            }
            $this->validate([
                'bibmodal_campus'=>'required',
                'bibmodal_tipo'=>'required',
                'bibmodal_anio'=>'required',
                'bibmodal_lengua'=>'required',
                'bibmodal_titulo'=>'required',
                'bibmodal_nombrePub'=>'required',
                'bibmodal_pags'=>'required',
                'bibmodal_editorial'=>'required',
            ]);

        ##### Valida campos de tesis
        }elseif($this->bibmodal_tipo=='tesis'){
             $this->validate([
                'bibmodal_campus'=>'required',
                'bibmodal_tipo'=>'required',
                'bibmodal_anio'=>'required',
                'bibmodal_lengua'=>'required',
                'bibmodal_titulo'=>'required',
                'bibmodal_tipoTesis'=>'required',
                'bibmodal_pags'=>'required',
                'bibmodal_editorial'=>'required',
            ]);

        ##### Valida campos de comunicación personal
        }elseif($this->bibmodal_tipo=='comunicación personal'){
            $this->validate([
                'bibmodal_campus'=>'required',
                'bibmodal_tipo'=>'required',
                'bibmodal_anio'=>'required',
                'bibmodal_lengua'=>'required',
            ]);
        }

        #######################################
        ##### Genera datos
        $data=[
            'bib_act'=>'1',
            'bib_del'=>'0',
            'bib_ccamsiglas'=>$this->bibmodal_campus,
            'bib_tipo'=>$this->bibmodal_tipo,
            'bib_anio'=>$this->bibmodal_anio,
            'bib_titulo'=>$this->bibmodal_titulo,
            'bib_nombre'=>$this->bibmodal_nombrePub,
            'bib_numero'=>$this->bibmodal_RevNum,
            'bib_volumen'=>$this->bibmodal_RevVol,
            'bib_pp'=>$this->bibmodal_pags,
            'bib_editorial'=>$this->bibmodal_editorial,
            'bib_lengua'=>$this->bibmodal_lengua,
            'bib_tags'=>$this->bibmodal_tags,
            'bib_notasubica'=>$this->bibmodal_notasUbica,
            'bib_edo'=>$this->bibmodal_Edo,
            'bib_mpio'=>$this->bibmodal_mpio,
            'bib_localidad'=>$this->bibmodal_localidad,
            'bib_notapublica'=>$this->bibmodal_notasPub,
            'bib_tipotesis'=>$this->bibmodal_tipoTesis,
            'bib_ocupa'=>$this->bibmodal_ocupa,
            'bib_edad'=>$this->bibmodal_edad,
            'bib_doi'=>$this->bibmodal_doi,
            'bib_isbn'=>$this->bibmodal_isbn,
            'bib_issn'=>$this->bibmodal_issn,
            'bib_url'=>$this->bibmodal_url,
            'bib_priv'=>$this->bibmodal_priv,
        ];

        if($this->bibId=='0'){
            ##### Guarda cita de bibliografía
            $data['bib_id']=bibliografia::max('bib_id')+1;
            $biblio=bibliografia::create($data);
            ###### Guarda autores
            foreach($this->bibmodal_autores as $a){
                bibliografia_autores::create([
                    'bibaut_bibid'=>$biblio->bib_id,
                    'bibaut_ap'=>$a['bibaut_ap'],
                    'bibaut_nombre'=>$a['bibaut_nombre'],
                    'bibaut_orcid'=>$a['bibaut_orcid'],
                    'bibaut_isni'=>$a['bibaut_isni'],
                    'bibaut_tipo'=>$a['bibaut_tipo'],
                ]);
            }
        }elseif($this->bibId > '0'){
            bibliografia::where('bib_id',$this->bibId)->update($data);
            $biblio=bibliografia::where('bib_id',$this->bibId)->first();
            $data['bib_id']=$this->bibId;
        }

        ##### Genera el nombre del pdf y lo guarda
        if($this->bibmodal_archivo != ''){
            $exten=$this->bibmodal_archivo->getClientOriginalExtension();
            $nombre=$biblio->bib_id."_".preg_replace("/ /","", $this->bibmodal_autores[0]['bibaut_ap'])."_".$this->bibmodal_anio.".".$exten;
            $ruta='/biblio/';
            $this->bibmodal_archivo->storeAs(path:$ruta, name:$nombre);
            bibliografia::where('bib_id',$data['bib_id'])->update(['bib_pdf'=>$ruta.$nombre]);
        }
        ###### MANDA AVISSO
        $this->cerrarModal();
        $this->dispatch('AvisoExito', $msj='Registro bibligráficos generado con éxito');
    }


    public function render(){
        #####################################################
        #################################### Obtiene permisos
        ################################ y campus autorizados
        $autorizados=['admin-colviva','curador-cientifico'];
        if(array_intersect($autorizados,session('rol'))){
            $this->bimodal_edit='1';
            $roles=array_intersect($autorizados,session('rol'));
            $bimodal_campuses=usr_roles::where('rol_usrid',Auth::user()->id)
                ->where('rol_del','0')
                ->where('rol_act','1')
                ->whereIn('rol_crolrol',$autorizados)
                ->select('rol_ccamsiglas as campus')
                ->get();
            if($bimodal_campuses->where('campus','todos')->count() > 0){
                $bimodal_campuses=cat_campus::where('ccam_act','1')
                    ->select('ccam_siglas as campus')
                    ->get();
            }
        }else{
            $this->bimodal_edit='0';
            $bimodal_campuses= collect();
        }
        ################################################
        ############################### Obtiene catálogos
        $bibmodal_lenguas=cat_lenguas::select('clen_code','clen_lengua')
            ->orderBy('clen_lengua')
            ->get();

        $bibmodal_tipos=cat_conceptos::where('con_tema','tipo-publicacion')
            ->get('con_txt');

        $bimodal_estados=estados::select('cedo_nombre')
            ->orderBy('cedo_nombre')
            ->get();

        if($this->bibmodal_Edo != ''){
            $bimodal_municipios=municipios::where('cmun_edoname',$this->bibmodal_Edo)
                ->select('cmun_mpioname')
                ->orderBy('cmun_mpioname')
                ->get();
        }else{
            $bimodal_municipios=collect();
        }

        return view('livewire.coleccion.modal-bibliografia-controller',[
            'bimodal_campuses'=>$bimodal_campuses,
            'bibmodal_tipos'=>$bibmodal_tipos,
            'bibmodal_lenguas'=>$bibmodal_lenguas,
            'bimodal_estados'=>$bimodal_estados,
            'bimodal_municipios'=>$bimodal_municipios,
        ]);
    }
}
