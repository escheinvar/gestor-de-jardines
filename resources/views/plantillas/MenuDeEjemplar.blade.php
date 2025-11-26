{{--
    <!-- Antes de poner en el view: @ include('plantillas.MenuDeEjemplar'),
    el controlador debe definir public $MenuDeEjemplares='bitacora'; y también
    el controlador debe definir public $idEjem con el número de ejemplar-->
--}}

<div class="p-3" style="background-color:#efebe8;" wire:ignore>
    @if(!isset($MenuDeEjemplares))
        {{ $MenuDeEjemplares='' }} <div class="alert alert-danger"> Debes definir variable $MenúDeEjemplares desde controller </div>
    @endif
    @if(!isset($idEjem))
        {{ $idEjem='' }} <div class="alert alert-danger"> Debes definir variable $idEjem desde controller </div>
    @endif
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link nolink  @if($MenuDeEjemplares == 'fichainicio') active @endif" href="#" style="border:1px solid #CDC6B9;">Inicio</a>
        </li>
        <li class="nav-item dropdown" >
            <a class="nav-link dropdown-toggle nolink @if($MenuDeEjemplares == 'bitacora') active @endif" data-bs-toggle="dropdown" href="" role="button" aria-expanded="false" style="border:1px solid #CDC6B9;">Bitácora</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora/{{ $idEjem }}" >Datos generales</a></li>
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora/{{ $idEjem }}#sitiodecolecta" >Sitio de colecta</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora2/{{ $idEjem }}#ambientedeorigen" >Datos ambientales de origen</a></li>
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_bitacora2/{{ $idEjem }}#ejemplardeorigen" >Datos del ejemplar de origen</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nolink @if($MenuDeEjemplares == 'nombres') active @endif" data-bs-toggle="dropdown" href="/nombres/{{ $idEjem }}" role="button" aria-expanded="false" style="border:1px solid #CDC6B9;">Nombres</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_nombres/{{ $idEjem }}">Nombre científico</a></li>
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="/ejem_nombres/{{ $idEjem }}#nombres comunes">Nombres comunes</a></li>
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="#">Alias del ejemplar</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item nolink @if($MenuDeEjemplares == '') active @endif" href="#">Herbario</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link nolink  @if($MenuDeEjemplares == 'ubicacion') active @endif" href="#"  style="border:1px solid #CDC6B9;">Ubicación</a>
        </li>
        <li class="nav-item">
            <a class="nav-link nolink  @if($MenuDeEjemplares == 'expediente') active @endif" href="#"  style="border:1px solid #CDC6B9;">Expediente</a>
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
    </ul>
</div>

