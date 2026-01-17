<?php

namespace App\Livewire\Sistema;

use App\Models\buzon;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BuzonController extends Component
{
    use WithPagination;

    public $buzon,$verLeidos,$verEnviados, $VerEnviarMsj, $MsjA, $MsjAsunto, $RepplyTo, $Msj;
    public $ganonesLee, $ganonesBorra,$SelectTodo;
    public $msjTo, $msjToName,$asunto, $mensaje,$msjNuevo, $replyTo;

    ##################################################################
    ########## NOTA: Este buzón utiliza la función gneneral /App/Helpers/EnviaMensajeAbuzon.php
    ##########       el cual usa la extensión Mailgun y sus archs /App/Mail/CorreoPorAvisoDeBuzon.php
    ##################################################################
    public function mount(){
        $this->verLeidos=FALSE;
        $this->verEnviados=FALSE;
        $this->ganonesLee=[];
        $this->ganonesBorra=[];
        $this->SelectTodo=FALSE;


    }

    public function LeerMensajes(){
        foreach($this->ganonesLee as $i){
            $estado=buzon::where('buz_id',$i)->value('buz_act');
            if($estado=='1'){
                $nuevo='0';
            }else{
                $nuevo='1';
            }
            buzon::where('buz_id',$i)->update([
                'buz_act'=>$nuevo,
            ]);
        }
        $this->ganonesLee=[];
        redirect('/buzon');
    }

    public function BorrarMensajes(){
        #foreach($this->ganonesBorra as $i){
        foreach($this->ganonesLee as $i){
            buzon::where('buz_id',$i)->update([
                'buz_del'=>'1',
                'buz_date_borrado'=>date('Y-m-d H:i:s'),
            ]);
        }
        #$this->ganonesBorra=[];
        $this->ganonesLee=[];
        redirect('/buzon');
    }

    public function MarcaDesmarcaTodo(){
        if($this->SelectTodo==TRUE){
            $this->ganonesLee=$this->buzon->pluck('buz_id');
        }else{
            $this->ganonesLee=[];
        }
    }

    ###########################################################
    ##################################### Inicia zona de modal
    public function AbreModal($buzId){
        $this->msjNuevo=$buzId;
        if($this->msjNuevo=='nvo'){
            $this->msjTo='';
            $this->msjToName='';
            $this->replyTo='';
        }else{
            $this->msjTo=buzon::where('buz_id',$buzId)->value('buz_from');
            $this->msjToName=buzon::where('buz_id',$buzId)->join('users','buz_from','=','id')->value('usrname');
            $this->replyTo=$buzId;
        }

        #### Abre modal
        $this->dispatch('AbreMiModal');
    }

    public function CierraModal(){
        $this->reset(['msjTo','msjToName','mensaje','asunto']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('CierraMiModal');
    }

    public function EnviarMensaje(){
        $this->validate([
            'msjTo'=>'required',
            'asunto'=>'required',
            'mensaje'=>'required'
        ]);
        if($this->msjNuevo=='nvo'){
            $MiNota='';
        }else{
            $MiNota='<nota>Respuesta a: '.buzon::where('buz_id',$this->replyTo)->value('buz_mensaje').buzon::where('buz_id',$this->replyTo)->value('buz_notas').'</nota>';
        }
        $correos=[$this->msjTo];

        ##### Envía mensaje
        EnviaMensajeAbuzon(
            $this->msjTo,      ### id usr del destinatario
            Auth::user()->id,  ### id usr del remitente
            $this->asunto,     ### texto del asunto
            $this->mensaje,    ### <html> del mensaje
            $MiNota,           ### <html> de las notas
            'buzon',           ### nombre del componente desde el que se genera el mensaje
            $this->replyTo,    ### msj_id del mensaje al que se responde (o vacío para mensajes nuevos)
            $correos,         ### array de id usr para enviar mails ó vacío ''
        );

        $this->CierraModal();
    }


    ###########################################################
    ########################################### Inicia render
    public function render(){
        $buzonSesion= buzon::where('buz_act','1')
            ->where('buz_del','0')
            ->where('buz_to',Auth::user()->id)
            ->count();
        session([
            'buzon'=>$buzonSesion,
        ]);

        $paginas='5';
        if($this->verLeidos==TRUE){$leidos='<=';}else{$leidos='=';}
        if($this->verEnviados==TRUE){
            $this->buzon= buzon::where('buz_del','0')
            ->where('buz_act',$leidos,'1')
            ->where('buz_to',Auth::user()->id)
            ->orWhere('buz_from',Auth::user()->id)
            ->leftJoin('users','buz_from','=','id')
            ->orderBy('buz_date','desc')
            ->orderBy('buz_hora','desc')
            // ->paginate($paginas);
            ->get();
        }else{
            $this->buzon= buzon::where('buz_del','0')
                ->where('buz_act',$leidos,'1')
                ->where('buz_to',Auth::user()->id)
                ->leftJoin('users','buz_from','=','id')
                ->orderBy('buz_date','desc')
                ->orderBy('buz_hora','desc')
                // ->paginate($paginas);
                ->get();
        }

        ##### Lista de destinatarios en "enviar mensaje a..."
        $destinatarios=usr_roles::where('rol_del','0')
            ->where('rol_act','1')
            ->select('rol_usrid','rol_ccamsiglas','rol_crolrol','usrname')
            ->where('rol_usrid','!=',Auth::user()->id)
            ->leftJoin('users','rol_usrid','=','id')
            ->orderBy('rol_ccamsiglas','asc')
            ->orderBy('rol_crolrol','asc')
            ->get();

        return view('livewire.sistema.buzon-controller',[
            // 'buzon'=>$buzon,
            'destinatarios'=>$destinatarios,
        ]);
    }
}
