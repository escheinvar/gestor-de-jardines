{{--
Para mostrar, se requiere invocar la plantilla desde el view :    @ include('plantillas.MenuDeEjemplar'),
Y desde el controlador que invoca al view, se deben definir y mandar a $this, seis variables:

$this->idEjem='#'  ##### donde se indica el número del ejemplar

$this->MenuDeEjemplares='texto'; ##### donde texto=palabra que enciende como activo el menú específico

$this->ejemplar=ejemplares::where('ejm_id',$id)
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
$this->ejemplar_ubica = ej_ubicaciones::where('sig_ejmid',$this->idEjem)
    ->where('sig_act','1')
    ->where('sig_del','0')
    ->first();
--}}

<div class="p-2" style="background-color:#efebe8;" wire:ignore>
    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    <!-- -------------- VERIFICA QUE EXISTAN LAS VARIABLES NECESARIAS ------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    @if(!isset($idEjem))
        {{ $idEjem='' }}
        <div class="alert alert-danger"> Debes definir variable $idEjem desde el controlador para ejecutar correctamente el MenúDeEjemplar </div>
    @endif
    @if(!isset($MenuDeEjemplares))
        {{ $MenuDeEjemplares='' }}
        <div class="alert alert-danger"> Debes definir variable $MenúDeEjemplares desde el controlador para ejecutar correctamente el MenúDeEjemplar </div>
    @endif
    @if(!isset($ejemplar))
        {{-- {{ $ejemplar='' }} --}}
        <div class="alert alert-danger"> Debes definir variable $ejemplar desde el controlador para ejecutar correctamente el MenúDeEjemplar </div>
    @endif
    @if(!isset($ejemplar_ScName))
        {{-- {{ $ejemplar_ScName='' }} --}}
        {{-- <div class="alert alert-danger"> Debes definir variable $ejemplar_ScName desde el controlador para ejecutar correctamente el MenúDeEjemplar </div> --}}
    @endif
    @if(!isset($ejemplar_CoName))
        {{-- {{ $ejemplar_CoName='' }} --}}
        {{-- <div class="alert alert-danger"> Debes definir variable $ejemplar_CoName desde el controlador para ejecutar correctamente el MenúDeEjemplar </div> --}}
    @endif

    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    <!-- ---------------------------------------------- INICIA EL MENÚ ------------------------------------------------------------ -->
    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    <ul class="nav nav-tabs">
        @if($idEjem > '0')
            <li class="nav-item">
                <a class="nav-link nolink  @if($MenuDeEjemplares == 'inicio') active @endif" href="/ejem_inicio/{{ $idEjem }}" style="border:1px solid #CDC6B9;">Inicio</a>
            </li>
            {{-- <li class="nav-item dropdown" >
                <a class="nav-link dropdown-toggle nolink @if($MenuDeEjemplares == 'bitacora') active @endif" data-bs-toggle="dropdown" href="" role="button" aria-expanded="false" style="border:1px solid #CDC6B9;">Bitácora</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora/{{ $idEjem }}" >Datos generales</a></li>
                    <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora/{{ $idEjem }}#sitiodecolecta" >Sitio de colecta</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora2/{{ $idEjem }}#ambientedeorigen" >Datos ambientales de origen</a></li>
                    <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora2/{{ $idEjem }}#ejemplardeorigen" >Datos del ejemplar de origen</a></li>
                </ul>
            </li> --}}
        @endif
        <li class="nav-item">
            <a class="nav-link nolink  @if($MenuDeEjemplares == 'bitacora') active @endif" href="/ejem_bitacora/{{ $idEjem }}"  style="border:1px solid #CDC6B9;">Bitácora</a>
        </li>
        @if($idEjem > '0')
            <li class="nav-item">
                <a class="nav-link nolink  @if($MenuDeEjemplares == 'nombres') active @endif" href="/ejem_nombres/{{ $idEjem }}"  style="border:1px solid #CDC6B9;">Nombres</a>
            </li>

            <li class="nav-item">
                <a class="nav-link nolink  @if($MenuDeEjemplares == 'ubicacion') active @endif" href="/ejem_ubica/{{ $idEjem }}"  style="border:1px solid #CDC6B9;">Ubicación</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nolink  @if($MenuDeEjemplares == 'expediente') active @endif" href="/ejem_expediente/{{ $idEjem }}"  style="border:1px solid #CDC6B9;">Expediente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nolink  @if($MenuDeEjemplares == 'usos') active @endif" href="#"  style="border:1px solid #CDC6B9;">Usos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled  @if($MenuDeEjemplares == 'floracion') active @endif"  style="border:1px solid #CDC6B9;">Floración</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled  @if($MenuDeEjemplares == 'propagacion') active @endif"  style="border:1px solid #CDC6B9;">Propagación</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled  @if($MenuDeEjemplares == 'cuidados') active @endif"  style="border:1px solid #CDC6B9;">Cuidados</a>
            </li>
        @endif
    </ul>




    <!-- -------------------------------------------------------------------------------------------------------------------------- -->
    <!-- ---------------------------------------------- INICIA DATOS GENERALES DEL EJEMPLAR ...---------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
    @if($idEjem > '0' and $MenuDeEjemplares != 'inicio')
        <div class="row my-1" style="">
            <div class="col-sm-6 col-md-3" style="vertical-align: top;">
                <div style="font-size: 150%;">
                    <div>
                        <b>Ejemplar ID  {{ $idEjem }} </b>
                    </div>
                    <div class="@if($ejemplar->ejm_bitid =='0') error2 @endif">
                        @if($ejemplar->ejm_bitid=='0')
                            <b>Bitácora pendiente</b>
                        @else
                            <b>Bitácora ID {{ $ejemplar->ejm_bitid }}</b>
                        @endif
                    </div>

                </div>
            </div>

            <div class="col-sm-5 col-md-4">
                <div>
                    <b>Nombre científico</b>:
                        @if(is_null($ejemplar_ScName))
                            <error>--Sin definir--</error>
                        @else
                            {{ $ejemplar_ScName->scn_name }}
                            <span style="font-size: 60%;">
                                @if($ejemplar_ScName->scn_edo=='0')<i class="bi bi-0-circle" style="color:red;">Sin validar</i>
                                @elseif($ejemplar_ScName->scn_edo=='1')<i class="bi bi-1-circle" style="color:orange;">Técnico</i>
                                @elseif($ejemplar_ScName->scn_edo=='2')<i class="bi bi-2-circle" style="color:green;">Autoridad</i>
                                @endif
                            </span>
                        @endif
                </div>
                <div>
                    <b>Nombre común</b>:
                    @if($ejemplar_CoName->count() > 0)
                        @foreach ($ejemplar_CoName as $c)
                            {{ $c->con_nombre }}
                            <span style="font-size: 60%;">
                                @if($c->con_origen=='1')
                                    <i class="bi bi-2-circle-fill" style="color:#CD7B34;">Origen</i>
                                @elseif($c->con_origen=='0' and $c->con_bibid > '0')
                                    <i class="bi bi-1-circle-fill" style="color:#919C1B;">Bibliografía</i>
                                @elseif($c->con_origen=='0' and $c->con_bibid == '' )
                                    <i class="bi bi-0-circle-fill" style="color:#87796d;">Nada</i>
                                @endif
                            </span>
                        @endforeach
                    @else
                        <error> --Sin definir--</error>
                    @endif
                </div>
                <div>
                    <b>Campus</b>:  {{ $ejemplar->ejm_ccamsiglas}}
                </div>
                <div>
                    <b>Ubicación</b>:
                    @if(isset($ejemplar_ubica))
                        {{ $ejemplar_ubica->sig_camcamellon }}
                    @else
                        <error> --Sin definir--</error>
                    @endif
                </div>
            </div>
            <div class="col-sm-5 col-md-4">
                <div>
                <b>Dueño de bitacora</b>:
                    @if($ejemplar->bit_ejmid_prop > '0')
                        <a href="/ejem_bitacora/{{ $ejemplar->bit_ejmid_prop }}" class="nolink">Ejemplar ID {{ $ejemplar->bit_ejmid_prop }}</a>
                    @else
                        Sin Bitácora
                    @endif

                </div>
                <b>ID de Madre</b>: @if($ejemplar->ejm_madreid != '') <a href="/ejem_bitacora/{{ $ejemplar->ejm_madreid }}"> Ejm. {{ $ejemplar->ejm_madreid }} </a> @endif <br>
                <b>ID de Padre</b>: @if($ejemplar->ejm_padreid != '') <a href="/ejem_bitacora/{{ $ejemplar->ejm_padreid }}">Ejm. {{ $ejemplar->ejm_padreid }} </a> @endif <br>
                <b>ID de Lote</b>: @if($ejemplar->ejm_loteid != '') <a href="/lote/{{ $ejemplar->ejem_loteid }}">Ejm. {{ $ejemplar->ejm_loteid }} </a> @endif <br>
            </div>

        </div>
    @endif
    @if ($idEjem=='0')
        <div style="font-size: 150%;">
            <b>Nuevo ejemplar, nueva bitácora</b>
            <div class="form-text" style="font-size:60%;">
                Para ingresar un nuevo ejemplar, primero guarda los datos de la bitácora
                y una vez el sistema te haya asignado número de bitácora, entonces ingresa los nombres e imágenes
            </div>
        </div>
    @endif
</div>




