<?php

namespace App\Livewire\Coleccion;

use App\Models\bitacora1;
use App\Models\cat_autoridades;
use App\Models\cat_campus;
use App\Models\cat_conceptos;
use App\Models\ej_nombres_cientificos;
use App\Models\ej_nombres_comunes;
use App\Models\ejemplares;
use App\Models\estados;
use App\Models\imagenes;
use App\Models\municipios;
use App\Models\usr_roles;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BitcoraController extends Component
{
    #######################################################################
    ##### bitácora solo existe para ejemplares.
    ##### Requiere variable desde URL: $id (ej_id)
    ##### Utiliza el flag $edit_adcolviva que si =1 pone modo edicion
    ##### Si el $id corresponde a una bitácora idBit=0, quiere decir que el
    ##### individuo no tiene bitácora asignada por lo    que solicita asignación
    #######################################################################

    public $idEjem;                      ##### Variables recibidas desde URL (Id del ejemplar)
    public $MenuDeEjemplares='bitacora', $ejemplar, $ejemplar_ScName, $ejemplar_CoName;  ##### Variables solicitadas por la plantilla del menú del ejemplar
    public $edit_adcolviva, $CampusAutorizados;   ##### Variable solicitadas por front-end para entrar en modo edición
    public $bitacoraPendiente;           ##### Flag que indica si el ejemplar tiene (1) o no (0) la bitácora pendiente.
    public $idEjmVincula, $campus, $colectadate, $etiqueta_colecta, $origen, $origen_explica,$forma_colecta, $campusEjem;
    public $autid, $alias, $autoridadescolecta;
    public $edo, $mpio, $localidad, $paraje, $x, $y, $altitud, $obs_colecta, $TipoDeVinculacion;

    public function mount($id){
        ######################################################
        ####################### Validaciones de permisos y URL

        ##### Genera array de campus permitidos para el usuario
        $this->CampusAutorizados=usr_roles::where('rol_del','0')
            ->where('rol_act','1')
            ->where('rol_usrid',Auth::user()->id)
            ->where('rol_crolrol','admin-colviva')
            ->pluck('rol_ccamsiglas')
            ->toArray();
        if(in_array('todos',$this->CampusAutorizados)){
            $this->CampusAutorizados=cat_campus::where('ccam_act','1')->pluck('ccam_siglas')->toArray();
        }

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
            $this->bitacoraPendiente='0';
            #######################################################
            ########################## Carga los datos del ejemplar
            $ejemplar=ejemplares::where('ejm_id',$id)
                ->join('ej_bitacora1','ejm_bitid','=','bit_id')
                ->where('ejm_act','1')
                ->where('ejm_del','0')
                ->where('bit_del','0')
                ->first();

            $this->idEjmVincula='';
            ###### Carga datos iniciales de formulario
            $this->campusEjem = $ejemplar->ejm_ccamsiglas;
            $this->colectadate = $ejemplar->bit_colectadate;
            $this->etiqueta_colecta = $ejemplar->bit_etiqueta_colecta;
            $this->origen = $ejemplar->bit_origen;
            $this->origen_explica = $ejemplar->bit_origen_explica;
            $this->forma_colecta = $ejemplar->bit_forma_colecta;
            $this->autid = $ejemplar->bit_autid;
            $this->alias = $ejemplar->bit_alias;
            $this->edo = $ejemplar->bit_edo;
            $this->mpio = $ejemplar->bit_mpio;
            $this->localidad = $ejemplar->bit_localidad;
            $this->paraje = $ejemplar->bit_paraje;
            $this->x = $ejemplar->bit_x;
            $this->y = $ejemplar->bit_y;
            $this->altitud = $ejemplar->bit_altitud;
            $this->obs_colecta = $ejemplar->bit_obs_colecta;
            $this->TipoDeVinculacion='ejemplar';

            ##################### Verifica si tiene bitácora pendiente
            if($ejemplar->ejm_bitid=='0'){
                $this->bitacoraPendiente='1';
            }else{
                $this->bitacoraPendiente='0';
            }
        }
    }


    public function ActivarNuevaBitacora($tipo){
        ###### Genera un id de bitácora temporal para activar el ingreso de datos
        if($tipo=='nva'){
            #####################################################
            ##### genera vínculo id-ejemplar con id-bitacora nueva
            ##### y luego redirecciona a editar la nueva bitácora
            $this->bitacoraPendiente='0';
            // ##### Guarda en base de datos de bitácora
            $bit=bitacora1::create([
                'bit_id'=>bitacora1::max('bit_id')+1,
                'bit_ejmid_prop'=>$this->idEjem,  #####id del ejeemplar propietario de la bitácora
                'bit_autid'=>'0',
                'bit_usrid'=>Auth::user()->id,
            ]);

            // ##### Guarda ejemplar en base de datos
            $ejemplar=ejemplares::where('ejm_id',$this->idEjem)->update([
                'ejm_bitid'=>$bit->bit_id,
            ]);
            ##### Emite alerta de éxito
            $this->dispatch('AvisoExito', msj:'Se registró generó correctamente la nueva bitácora');
            ##### Redirecciona al nuevo ejemplar
            redirect('/ejem_bitacora/'.$this->idEjem);

        }elseif($tipo=="existe" AND $this->TipoDeVinculacion=='ejemplar'){
            dd('vincular a ejemplar');
            $this->validate([
                'idEjmVincula'=>'required|exists:ejemplares,ejm_id',
            ]);
            $ganon=ejemplares::where('ejm_id',$this->idEjmVincula)->value('ejm_bitid');

            if($this->idEjmVincula == $this->idEjem){
                $this->addError('idEjmVincula','No puedes vincular a este mismo ejemplar');
                return;
            }
            if($ganon =='0'){
                $this->addError('idEjmVincula','Este ejemplar no cuenta con bitácora válida');
                return;
            }

            // ##### Guarda ejemplar en base de datos
            $ejemplar=ejemplares::where('ejm_id',$this->idEjem)->update([
                // 'ejm_bitid'=>$this->idEjmVincula,
                'ejm_bitid'=>$ganon,
            ]);
            ##### Emite alerta de éxito
            $this->dispatch('AvisoExito', msj:'Se vinculó al ejemplar correctamente a la bitácora');
            ##### Redirecciona al nuevo ejemplar
            redirect('/ejem_bitacora/'.$this->idEjem);

        }elseif($tipo=="existe" AND $this->TipoDeVinculacion=='bitacora'){
            dd('vincular a bitácora');
        }

    }

    public function AbrirModalAutoridades($par1){
        $data=['autId'=>$par1];
        $this->dispatch('abreModalDeAutoridades',$data);
    }

    public function GuardarCambios($idGuardar){
        ##### Valida formulario
        $this->validate([
            'campusEjem'=>'required',
            'colectadate'=>'required|before_or_equal:today',
            'origen'=>'required',
            'forma_colecta'=>'required',
            'autid'=>'required',
            'edo'=>'required',
            'mpio'=>'required',
        ]);

        ##### Guarda en base de datos de bitácora
        $bit=bitacora1::where('bit_id',$idGuardar)->update([
            'bit_ejmid_prop'=>'0',#$ejemplar->ejm_id, #####id del ejeemplar propietario de la bitácora
            'bit_colectadate'=>$this->colectadate,
            'bit_origen'=>$this->origen,
            'bit_origen_explica'=>$this->origen_explica,
            'bit_forma_colecta'=>$this->forma_colecta,
            'bit_etiqueta_colecta'=>$this->etiqueta_colecta,
            'bit_autid'=>$this->autid,
            'bit_edo'=>$this->edo,
            'bit_mpio'=>$this->mpio,
            'bit_localidad'=>$this->localidad,
            'bit_paraje'=>$this->paraje,
            'bit_x'=>$this->x,
            'bit_y'=>$this->y,
            'bit_altitud'=>$this->altitud,
            'bit_obs_colecta'=>$this->obs_colecta,
            'bit_usrid'=>Auth::user()->id,
            'bit_alias'=>$this->alias,
        ]);

        ##### Emite alerta de éxito
        $this->dispatch('AvisoExito', msj:'La bitácora se actualizó correctamente');
        ##### Redirecciona al nuevo ejemplar
        redirect('/ejem_bitacora/'.$idGuardar);


        // verificar los dos modos de guardar cuando la bitácora el id=0. Ver desde
        // crear nueva bitácora, pero sobre todo desde Vincular a bitácora
        // ver que si mande el id

    }

    public function CrearBitacora(){
        ##### Valida formulario
        $this->validate([
            'campusEjem'=>'required',
            'colectadate'=>'required|before_or_equal:today',
            'origen'=>'required',
            'forma_colecta'=>'required',
            'autid'=>'required',
            'edo'=>'required',
            'mpio'=>'required',
        ]);

        ##### Guarda en base de datos de bitácora
        $bit=bitacora1::create([
            'bit_id'=>bitacora1::max('bit_id')+1,
            'bit_ejmid_prop'=>'0',#$ejemplar->ejm_id, #####id del ejeemplar propietario de la bitácora
            'bit_colectadate'=>$this->colectadate,
            'bit_origen'=>$this->origen,
            'bit_origen_explica'=>$this->origen_explica,
            'bit_forma_colecta'=>$this->forma_colecta,
            'bit_etiqueta_colecta'=>$this->etiqueta_colecta,
            'bit_autid'=>$this->autid,
            'bit_edo'=>$this->edo,
            'bit_mpio'=>$this->mpio,
            'bit_localidad'=>$this->localidad,
            'bit_paraje'=>$this->paraje,
            'bit_x'=>$this->x,
            'bit_y'=>$this->y,
            'bit_altitud'=>$this->altitud,
            'bit_obs_colecta'=>$this->obs_colecta,
            'bit_usrid'=>Auth::user()->id,
            'bit_alias'=>$this->alias,
        ]);

        ##### Guarda ejemplar en base de datos
        $ejemplar=ejemplares::create([
            'ejm_id'=>ejemplares::max('ejm_id')+1,
            'ejm_act'=>'1',
            'ejm_del'=>'0',
            'ejm_ubica'=>'0',
            'ejm_scname'=>'0',
            'ejm_name'=>'0',
            'ejm_edo_uso'=>'0',
            'ejm_ccamsiglas'=> $this->campusEjem,
            'ejm_bitid'=>$bit->bit_id,

        ]);
        ##### Actualiza la bitácora con el id del ejemplar
        bitacora1::where('bit_id',$bit->bit_id)->update([
            'bit_ejmid_prop'=>$ejemplar->ejm_id,
        ]);
        ##### Emite alerta de éxito
        $this->dispatch('AvisoExito', msj:'Se registró correctamente el nuevo ejemplar con id '.$ejemplar->ejm_id.' y bajo la bitácora id '.$bit->bit_id);
        ##### Redirecciona al nuevo ejemplar
        redirect('/ejem_bitacora/'.$ejemplar->ejm_id);
    }

    public function AbreModalObjeto($par1,$par2, $par3, $par4, $par5){
        ##### $par1=[0,img_id]     $par2=alguno de cimg_modulo,
        ##### $par3=alguno de cimg_tipod
        ##### $par4=[ej,es] si es ejemplar o especie
        ##### $par5=[$ejm_id, sp_id] id del ejemplar o de la especie
        if(array_intersect(['admin-colviva'], Session('rol')) and $this->edit_adcolviva=='1'){
            $data=['ImgId'=>$par1, 'ImgModulo'=>$par2, 'ImgTipo'=>$par3, 'Clase'=>$par4, 'IdClase'=>$par5];
            $this->dispatch('abreModalDeImagen', $data);
        }
    }

    public function abreModalDeNombreCientifico(){
        $this->dispatch('abreModalDeNombreCientifico',$this->idEjem);
    }

    public function abreModalDeNombreComun(){
        $datos=['ejId'=>$this->idEjem,'conId'=>'0'];
        $this->dispatch('abreModalDeNombreComun',$datos);
    }


    public function render() {
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
        $this->ejemplar_CoName=ej_nombres_comunes::where('con_ejmid',$this->idEjem)
            ->where('con_act','1')
            ->where('con_del','0')
            ->orderBy('con_origen','desc')
            ->orderBy('con_bibid','asc')
            ->take(3)
            ->get();

        ##################### Asigna permisos de edición
        $this->edit_adcolviva='0'; #### Inicia sin permiso
        ##### Si es nuevo individuo, revisa que tenga privilegios
        ##### y si está editando, revisa que tenga privilegios de edición
        if($this->idEjem=='0'){
            if(array_intersect(['admin-colviva'], Session('rol')) ){
                $this->edit_adcolviva='1';
            }else{
                $this->edit_adcolviva='0';
                redirect('/noauth/No cuentas con los privilegios correctos');
            }
        }else{
            if(array_intersect([$this->ejemplar->ejm_ccamsiglas], $this->CampusAutorizados)
            OR in_array('todos',$this->CampusAutorizados)){
                $this->edit_adcolviva='1';
            }else{
                $this->edit_adcolviva='0';
                #redirect('/noauth/No cuentas con los privilegios correctos');
            }
        }

        ##################### Carga datos de catálogos para formulario
        $campuses=cat_campus::whereIn('ccam_siglas',$this->CampusAutorizados)->get();
        $formasobtencion=cat_conceptos::where('con_tema','forma_obtención')->get();
        $formascolecta=cat_conceptos::where('con_tema','forma_colecta')->where('con_txt','!=','digitalización')->get();
        $this->autoridadescolecta=cat_autoridades::where('aut_tipo','colecta')->where('aut_id','!=','0')->get();
        $estados=estados::select('cedo_nombre')->get();
        $municipios=municipios::where('cmun_edoname',$this->edo)->select('cmun_mpioname')->get();
        $img_colecta_ejemplar=imagenes::where('img_ejmid',$this->idEjem)
            ->where('img_act','1')
            ->where('img_del','0')
            ->where('img_cimgtipo','colecta_ejemplar')
            ->get();
        $img_colecta_paisaje=imagenes::where('img_ejmid',$this->idEjem)
            ->where('img_act','1')
            ->where('img_del','0')
            ->where('img_cimgtipo','colecta_paisaje')
            ->get();

        ##### Manda a front
        return view('livewire.coleccion.bitcora-controller',[
            'campuses'=>$campuses,
            'formasobtencion'=>$formasobtencion,
            'formascolecta'=>$formascolecta,
            'estados'=>$estados,
            'municipios'=>$municipios,
            'img_colecta_ejemplar'=>$img_colecta_ejemplar,
            'img_colecta_paisaje'=>$img_colecta_paisaje,
        ]);
    }
}
