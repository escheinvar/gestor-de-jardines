{{-- @extends('plantillas.base') --}}

@section('title')  @endsection
@section('meta-description') Meta @endsection
<!-- silenciar cintillo-ubica if required -->
@section('cintillo-ubica') -><a href="/home" class="nolink">home</a>-> Buzón @endsection
@section('cintillo') &nbsp; @endsection

<div>
    <h2><i class="bi bi-inbox"></i> Buzón de {{ Auth::user()->usrname }}</h2>

    <!-- ---------------------------------------------------------------------------------- -->
    <!-- ------------- INICIA BARRA SUPERIOR DE ACCIONES PARA BUZÓN  ---------------------- -->
    <div class="my-2" style="background-color:#CDC6B9; padding:5px;">
        <!-- mostrar leídos -->
        <div class="form-check mx-1" style="display:inline-block;">
            <input wire:model.live="verLeidos" class="form-check-input" type="checkbox" id="checkDefault">
            <label class="form-check-label" for="checkDefault">
                Mostrar leídos
            </label>
        </div>
        <!-- mostrar enviados -->
        <div class="form-check mx-1" style="display:inline-block;">
            <input wire:model.live="verEnviados" class="form-check-input" type="checkbox" id="checkDefault">
            <label class="form-check-label" for="checkDefault">
                Mostrar enviados
            </label>
        </div>
        <!-- indicador de número de  nuevos -->
        <span style="margin:5px; padding:1px; @if($buzon->where('buz_leido','0')->count() > 0)color:#CD7B34; font-weight:bold; @endif">
            {{ $buzon->where('buz_act','1')->where('buz_from','!=',Auth::user()->id)->count() }} <i class="bi bi-envelope-fill"></i>
            @if($buzon->where('buz_act','0')->where('buz_from','!=',Auth::user()->id)->count() =='1') nuevo @else nuevos @endif
        </span>
        <!-- indicador de número de leídos -->
        @if($verLeidos==TRUE)
            <span style="margin:5px; padding:1px; color:gray; @if($buzon->where('buz_leido','1')->count() > 0) font-weight:bold; @endif">
                {{ $buzon->where('buz_act','0')->where('buz_from','!=',Auth::user()->id)->count() }} <i class="bi bi-envelope-open"></i>
                @if($buzon->where('buz_act','0')->where('buz_from','!=',Auth::user()->id)->count() =='1') leído @else leídos @endif
            </span>
        @endif

        <span style="margin:5px; padding:1px;" >
            <span style="float: right;">
                <button wire:click="LeerMensajes()" type="button" class="btn btn-sm btn-primary mx-2" style="display:inline-block" @if(count($ganonesLee)==0) disabled @endif)>
                    <i class="bi bi-envelope-open"></i> Leer <sub> {{ count($ganonesLee) }}</sub>
                </button>

                <button wire:click="BorrarMensajes()" type="button" class="btn btn-sm btn-primary mx-2" style="display:inline-block" @if(count($ganonesLee)==0) disabled @endif wire:confirm="Estás por eliminar definitivamente este mensaje. Esta acción no puede ser revertida. ¿Deseas continuar?">
                    <i class="bi bi-trash"></i> Borrar <sub>{{ count($ganonesLee) }}</sub>
                </button>
            </span>
        </span>
    </div>
    <!-- ------------------------------------------------------------------- -->
    <!-- ------- TERMINA BARRA SUPERIOR DE ACCIONES PARA BUZÓN  ------------ -->

    <!-- ------------------------------------------------------------------- -->
    <!-- ----------------- INICIA BUZÓN DE MENSAJES ------------------------ -->
    @if($buzon->count() > 0)
        <div class="table-responsive-sm">
            <table class="table table-striped table-responsive-sm" style="width:100%; ">
                <tbody>
                    @foreach ($buzon as $b)
                        <tr style="border:1px solid #CDC6B9;">
                            <td class="p-3 m-2" style="@if($b->buz_act=='0')color:gray; @endif">
                                <!-- cabecera del mensaje -->
                                <div style="">
                                    @if($b->buz_to==Auth::user()->id)<!-- solo muestra si son recibidos (no enviados) -->
                                        <div style="display: inline-block;" class="m-1 p-1" >
                                            <input type="checkbox" wire:model.live="ganonesLee" id="ch{{ $b->buz_id }}" value="{{ $b->buz_id }}">
                                            @if( $b->buz_act == '1')
                                                <i class="bi bi-envelope-fill"></i>
                                            @else
                                                <i class="bi bi-envelope-open"></i>
                                            @endif
                                            <b>{{ $b->buz_asunto }}</b>
                                        </div>
                                    @else
                                        <i class="bi bi-arrow-up-circle"><sub>{{ $b->buz_id }}</sub></i> {{ $b->buz_asunto }}
                                    @endif

                                    <!-- muestra fecha -->
                                    <div class="m-1 p-1" style="float:right;">
                                        <span class="" style="color:gray; font-size:80%">
                                            {{ $b->buz_date }}
                                            {{ preg_replace('/:..$/','',$b->buz_hora) }}
                                        </span>
                                    </div>
                                </div>
                                <!-- cuerpo del mensaje -->
                                <div style="@if($b->buz_act =='0') color:gray; @endif display:block;" class="m-1 p-1">
                                    {!! $b->buz_mensaje !!}

                                    @if($b->buz_notas != '')
                                        <div style="font-size:80%; color:gray; margin-left:10px;" onclick="VerYocultar('nota','{{ $b->buz_id }}')" id="entra_nota{{ $b->buz_id }}" class="PaClick">
                                            <i class="bi bi-arrow-down-right-square"></i> Ver mensajes

                                        </div>
                                        <div style="font-size:80%; color:gray;display:none;" onclick="VerYocultar('nota','{{ $b->buz_id }}')" id="sale_nota{{ $b->buz_id }}" class="PaClick">
                                            {!! $b->buz_notas !!}
                                        </div>
                                    @endif
                                    </div>
                                </div>

                                <!-- responder a mensaje -->
                                <div style="color:gray; margin-top:10px;font-size:80%;">
                                    @if($b->buz_to == Auth::user()->id AND $b->buz_from != Auth::user()->id)
                                        @if($b->buz_from > '0')
                                            <span wire:click="AbreModal('{{ $b->buz_id }}')" class="PaClick">
                                                <i class="bi bi-reply"></i> a {{ $b->usrname }}
                                            </span>
                                        @else
                                            Mensaje de sistema
                                        @endif
                                    @else
                                        Enviado a {{ $b->usrname }}
                                    @endif
                                    </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        -- No tienes mensajes en tu buzón --
    @endif
    <!-- ----------------- TERMINA BUZÓN DE MENSAJES ------------------------ -->
    <!-- ------------------------------------------------------------------- -->
    <div>
        <button type="button" wire:click="AbreModal('nvo')">
            <i class="bi bi-envelope-at"></i> Nuevo mensaje
        </button>
    </div>




    <!-- --------------------------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->
    <!-- --------------------------- INICIA MODAL DE ENVÍO DE MENSAJE ------------------_------- -->
    <div wire:ignore.self class="modal fade" id="ModalEnviarMensaje" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($msjNuevo=='nvo')Enviar nuevo mensaje @else Responder mensaje a {{ $msjToName }} @endif
                    </h3>
                    <button wire:click="CierraModal()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>

                <!-- cuerpo del modal -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 form-group">
                            <label class="form-label">Destinatario:</label>
                            @if($msjNuevo=='nvo')
                                <select wire:model="msjTo" class="form-select" aria-label="Default select example">
                                    <option value=''>Selecciona una opción --- jardin: rol / usrname --- </option>
                                    @foreach ($destinatarios as $d)
                                        <option value="{{ $d->rol_usrid }}"> {{ $d->rol_ccamsiglas }}: {{ $d->rol_crolrol }} / {{ $d->usrname }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" wire:model="msjTo">
                                <input wire:model="msjToName" type="text" class="form-control" disabled>
                            @endif
                            @error('msjTo')<error>{{ $message }}</error>@enderror
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label class="form-label">Asunto:</label>
                            <input wire:model="asunto" type="text" class="form-control">
                            @error('asunto')<error>{{ $message }}</error>@enderror
                        </div>
                        <div class="col-sm-12  form-group">
                            <label class="form-label">Mensaje:</label>
                            <textarea wire:model="mensaje" class="form-control"></textarea>
                            @error('mensaje')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>

                <!-- Pie del modal -->
                <div class="modal-footer">
                    <span wire:loading wire:target="EnviarMensaje" style="display:none;color:#CD7B34;">
                        enviando mensaje, favor de esperar...
                    </span>
                    <button wire:click="EnviarMensaje()" wire:loading.attr="disabled" class="btn btn-primary">
                        Enviar mensaje
                    </button>

                    <button wire:click="CierraModal()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------------------- TERMINA  MODAL DE ENVÍO DE MENSAJE  ------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->

    <script>
        /* ### Script para abrir y cerrar modal */
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('AbreMiModal', () => {
                $('#ModalEnviarMensaje').modal('show');
           });
           Livewire.on('CierraMiModal', () => {
                $('#ModalEnviarMensaje').modal('hide');
           });
        });
    </script>
</div>

@section('scripts') @endsection
