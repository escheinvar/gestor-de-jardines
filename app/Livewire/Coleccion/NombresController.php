<?php

namespace App\Livewire\Coleccion;

use App\Models\ej_alias;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\ejemplares;
use App\Models\imagenes;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NombresController extends Component
{

    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='nombres', $ejemplar, $ejemplar_ScName, $ejemplar_CoName;  ##### Variables solicitadas por la plantilla del menú del ejemplar
    public $edit_curcient, $edit_adcolviva, $CampusAutorizados;     ##### Variable solicitadas por front-end para entrar en modo edición
    public $HayNomCien;                ##### Flag que vale 0 cuando no hay ni un nombre cient. y 1 cuando sí hay.
    public $nuevoAlias;


    public function mount($id){
        ######################################################
        ####################### Validaciones de permisos y URL
        ##### Revisa que el id sea sólo numérico
        if( !preg_match('/^\d+$/',$id)){
            return redirect()->route('error',["Error en el número de ejemplar"]);
        }

        ##### Confirma id correcto y carga datos
        if($id == '0'){
            $this->idEjem='0';
        }else{
            if(ejemplares::where('ejm_id',$id)->where('ejm_act','1')->where('ejm_del','0')->count() != '1'){
                return redirect()->route('error',["El número de ejemplar no existe"]);
            }
            $this->idEjem=$id;

        #############################################################
        ###### Carga los datos para la plantilla del menú de ejemplar
        $this->ejemplar=ejemplares::where('ejm_id',$this->idEjem)
            ->join('ej_bitacora1','ejm_bitid','=','bit_id')
            ->where('ejm_act','1')
            ->where('ejm_del','0')
            ->where('bit_del','0')
            ->first();

        $this->ejemplar_ScName=ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)
            ->where('scn_act','1')
            ->where('scn_del','0')
            ->first();

        $this->ejemplar_CoName = ej_nombres_comunes::where('con_ejmid',$this->idEjem)
            ->where('con_act','1')
            ->where('con_del','0')
            ->orderBy('con_origen','desc')
            ->orderBy('con_bibid','asc')
            ->take(3)
            ->get();

        }
    }

    public function BorraNombre($id){
        ej_nombres_cientificos::where('scn_id',$id)->update([
            'scn_act'=>'0',
        ]);
        return redirect('/ejem_nombres/'.$this->idEjem);
    }

    public function abreModalDeNombreCientifico(){
        $this->dispatch('abreModalDeNombreCientifico',$this->idEjem);
    }

    public function AbrirModalBibliografia($par1){
        $data=['bibId'=>$par1];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        $this->dispatch('abreModalDeBibliogfafia',$data);
    }

    public function AbrirModalNombreComun($par1, $par2){
        $data=['ejId'=>$par1,'conId'=>$par2];  ### donde $par1 tiene el Id del registro bibliográfico a editar ó 0 para nuevo
        $this->dispatch('abreModalDeNombreComun',$data);
    }

    public function AbrirModalAlias (){
        $data=['ejmId'=>$this->idEjem, 'tipo'=>'ubicacion'];
        $this->dispatch('abreModalDeAlias', $data);
    }

    public function BorrarAlias($id){
        ej_alias::where('alias_id',$id)->update(['alias_act'=>'0']);
    }

    public function AbreModalObjeto($par1,$par2, $par3, $par4, $par5){
        $data=['ImgId'=>$par1, 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
        $this->dispatch('abreModalDeImagen', $data);
        ######   $data[
        ######         'ImgId',      (img_id de tabla imagenes) para editar ó 0 para nuevo
        ######         'ImgModulo',  (cimg_modulo de tabla cat_tipoimgs)
        ######         'ImgTipo',    (cimg_tipo de tabla cat_tipoimgs)
        ######         'Clase',      [ej,es] indica si es para ejemplar o para especie
        ######         'IdClase',    (img_ejmid ó img_spid de tabla imagenes)
    }

    public function render() {
        ###################################################################
        ##################################### Prepara autorizaciones
        $CampusDelEjemplar=$this->ejemplar->ejm_ccamsiglas;
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

        ##### Busca nombres científicos del ejemplar
        $nomcien=ej_nombres_cientificos::where('scn_ejmid',$this->idEjem)
            ->leftJoin('cat_autoridades','scn_colid','=','aut_id')
            ->where('scn_act','1')
            ->where('scn_del','0')
            ->first();

        ##### Determina flag $nomcien de si hay (1) o no (0) nombre científico
        if(isset($nomcien)){
            if($nomcien->count() >'0'){
                $this->HayNomCien='1';
            }else{
                $this->HayNomCien='0';
            }
        }else{
            $this->HayNomCien='0';
        }

        ##### Obtiene nombres comunes
        if($this->edit_curcient=='1'){$opera='<=';}else{$opera='=';}
        $nomcoms=ej_nombres_comunes::where('con_ejmid',$this->idEjem)
            ->leftJoin('bibliografias','con_bibid','=','bib_id')
            ->leftJoin('cat_lenguas','clen_code','=','con_clencode')
            ->where('con_act',$opera,'1')
            ->where('con_del','0')
            ->orderBy('con_origen','desc')
            ->orderBy('con_bibid')
            ->orderBy('con_nombre')
            ->get();

        $alias=ej_alias::where('alias_ejmid',$this->idEjem)
            ->where('alias_act','1')
            ->where('alias_del','0')
            ->whereIn('alias_tipo',['ejemplar','nombre científico','nombre común'])
            ->get();

        $herbario=imagenes::where('img_cimgtipo','herbario_propio')
            // ->orWhere('img_cimgtipo','herbario_externo')
            ->where('img_ejmid',$this->idEjem)
            ->where('img_act','1')
            ->where('img_del','0')
            ->get();


        return view('livewire.coleccion.nombres-controller',[
            'nomcien'=>$nomcien,
            'nomcoms'=>$nomcoms,
            'alias'=>$alias,
            'herbario'=>$herbario,
        ]);
    }
}
