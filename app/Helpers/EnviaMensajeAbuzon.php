<?php

use App\Mail\CorreoPorAvisoDeBuzon;
use App\Models\buzon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;


if(!function_exists('EnviaMensajeAbuzon')){

    ###### Función que recibe variables y envía mensaje a buzón de sistema.
    ###### to=id usr al que se envía el mensaje, from=Id usr del remitente
    /* ############################ Ejemplo (8 variables)
    EnviaMensajeAbuzon(
      'to',         ### to: id usr del destinatario
      'from',       ### from: id usr del remitente
      'asunto',     ### asunto: texto del asunto
      'mensaje,     ### mensje: <html> del mensaje
      'notas',      ### notas: <html> de las notas
      'comp',       ### comp: nombre del componente desde el que se genera el mensaje
      'ifReply'     ### if_reply: msj_id del mensaje al que se responde (o vacío para mensajes nuevos)
      ['1','2'],    ### array de mails a enviar ó vacío ''
    );
    */ ############################## Fin del ejemplo

    ##################################################################
    ########## NOTA: Esta función gneral usa la extensión Mailgun y sus
    ##########       archs /App/Mail/CorreoPorAvisoDeBuzon.php
    ##################################################################
    function EnviaMensajeAbuzon($to,$from,$asunto,$mensaje,$notas,$comp,$ifReply,$mails){
        #dd(['1_to*'=>$to,'2_from*'=>$from,'3_asunto*'=>$asunto,'4_mensaje*'=>$mensaje,'5_notas'=>$notas,'6_comp*'=>$comp,'7_ifReply'=>$ifReply,      '8_mails'=>$mails]);

        ##### Prepara variable mail (por si viene vacía)
        if($mails==''){$mails=[];}
        if($to==''){$to=null;}
        if($from==''){$from=null;}
        if($ifReply==''){$ifReply=null;}
        ##### Guarda Base de datos
        buzon::create([
            'buz_to'=>$to,
            'buz_from'=>$from,
            'buz_asunto'=>$asunto,
            'buz_mensaje'=>$mensaje,
            'buz_notas'=>$notas,
            'buz_comp'=>$comp,
            'buz_replyTo'=>$ifReply,
            'buz_date'=>date('Y-m-d'),
            'buz_hora'=>date('H:i:s'),
        ]);
        ##### Prepara variables:
        if($from=='0'){
            $MyFrom="Mensaje del Sistema";
        }else{
            $MyFrom=User::where('id',$from)->value('usrname');
        }
        ##### Envía correo
        if(count($mails) > '0'){
            foreach($mails as $m){
                $envio=User::where('id',$m)->value('mensajes');
                if($envio=='1'){
                    $correo=User::where('id',$m)->value('email');
                    $Datos=['from'=>$MyFrom,'asunto'=>$asunto,'mensaje'=>$mensaje];
                    Mail::to($correo)->send(new CorreoPorAvisoDeBuzon($Datos));
                }
            }
        }
    }
}
