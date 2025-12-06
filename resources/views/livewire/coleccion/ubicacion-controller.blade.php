@section('title')  @endsection
@section('meta-description') Datos de la bitácora de colecta de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejemplares" class="nolink">Ejemplares</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    @include('plantillas.MenuDeEjemplar')
    <!-- -------------------- TERMINA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- aviso de privilegios -->
    <div style="font-size: 80%;color:grey;">
        Ubicación: Sección administrada por <b>admin-colviva</b>
        @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
        @if($edit_curcient=='0') <error style="font-size: 90%;"> (No autorizado)</error> @else <span style="font-size:90%;color:green;"> (Autorizado) </span>@endif <br>
    </div>


    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- SECCIÓN DE UBICACIÓN Y MAPA  -------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->
    <div>
        <!-- -------- Acciones ---------------- -->
        <div class="row">
            <div class="col-2 col-md-1" style="font-size:70%;center">
                <center>
                    <a href="#" class="nolink">
                        <img src="" style="width:50px;height:50px;border:1px solid black;" class="mx-2">
                        Mover
                    </a>
                </center>
            </div>
            <div class="col-2 col-md-1" style="font-size:70%;center">
                <center>
                    <a href="#" class="nolink">
                        <img src="" style="width:50px;height:50px;border:1px solid black;" class="mx-2">
                        Retirar
                    </a>
                </center>
            </div>
            <div class="col-2 col-md-1" style="font-size:70%;center">
                <center>
                    <a href="#" class="nolink">
                        <img src="" style="width:50px;height:50px;border:1px solid black;" class="mx-2">
                        Transferir
                    </a>
                </center>
            </div>
        </div>

        <!-- -------- MAPA ----------------- -->
        <div class="row">
            <!-- Mapa  -->
            <div class="col-sm-12 col-md-8 p-3">
                <div wire:ignore>
                    <div id="map"></div>
                    <!-- borrar polígono -->
                    <button type="button" wire:click="BorrarPoligono()" class="my-2" wire:confirm="">
                        <i class="bi bi-trash">Eliminar</i>
                    </button>
                    @error('geojson')<error>{{ $message }}</error>@enderror
                </div>
            </div>

            <!-- -------- CUESTIONARIO ----------------- -->
            <div class="col-sm-12 col-md-4">
                <div class="row">
                    <!-- campus -->
                    <div class="col-12 form-group">
                        <label for="campus">Campus<red>*</red></label>
                        <select wire:model="campus" type="text" disabled class="@error('campus') is-invalid @enderror form-select">
                            <option value="">{{ $ejemplar->ejm_ccamsiglas }}</option>
                        </select>
                        <div class="form-text"></div>
                        @error('campus')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Camellón -->
                    <div class="col-12 form-group">
                        <label for="camellon">Camellón<red>*</red></label>
                        <select wire:model="camellon" type="text" class="@error('camellon') is-invalid @enderror form-select">
                            @foreach ($camellones as $c)
                                <option value="{{ $c->cam_id }}">{{ $c->cam_camellon }}</option>
                            @endforeach
                        </select>
                        <div class="form-text"></div>
                        @error('camellon')<error>{{ $message }}</error>@enderror
                    </div>

                    <div class="col-12">
                        <!-- latitud, longitud y botón coordenadas -->
                        <div class="row">
                            <div class="col-9 form-group">
                                <div class="row">
                                    <!-- latitud -->
                                    <div class="col-12 form-group">
                                        <label for="latitud">Latitud (X)<red>*</red></label>
                                        <input wire:model="latitud" type="text" class="@error('latitud') is-invalid @enderror form-control">
                                        <div class="form-text"></div>
                                        @error('latitud')<error>{{ $message }}</error>@enderror
                                    </div>
                                    <!-- longitud -->
                                    <div class="col-12 form-group">
                                        <label for="longitud">Longitud (Y)<red>*</red></label>
                                        <input wire:model="longitud" type="text" class="@error('longitud') is-invalid @enderror form-control">
                                        <div class="form-text"></div>
                                        @error('longitud')<error>{{ $message }}</error>@enderror
                                    </div>
                                </div>
                            </div>
                            <!-- botón de coordenadas -->
                            <div class="col-3 form-group" style="vertical-align: middle;"><br><br>
                                <button wire:click="SeleccionaCoords()" class="btn btn-secondary">Seleccionar<br>en mapa</button>
                            </div>
                        </div>
                    </div>

                    <!-- Restricción -->
                    <div class="col-12 form-group">
                        <label for="restriccion">Restriccion<red>*</red></label>
                        <select wire:model="restriccion" type="text" class="@error('restriccion') is-invalid @enderror form-select">
                            <option value="0">Público</option>
                            <option value="1">Privado</option>
                        </select>
                        <div class="form-text"></div>
                        @error('restriccion')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Notas -->
                    <div class="col-12 form-group">
                        <label for="notas">Notas</label>
                        <textarea wire:model="notas" type="text" class="@error('notas') is-invalid @enderror form-control"></textarea>
                        <div class="form-text"></div>
                        @error('notas')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Tipo de crecimiento -->
                    <div class="col-6 form-group">
                        <label for="tipocrecim">Tipo de crecimiento<red>*</red></label>
                        <select wire:model="tipocrecim" type="text" class="@error('tipocrecim') is-invalid @enderror form-select">
                            <option value="">Indica uno</option>
                            @foreach ($tiposcrecimiento as $t)
                                <option value="{{ $t->con_txt }}">{{ $t->con_txt }}</option>
                            @endforeach
                        </select>
                        <div class="form-text"></div>
                        @error('tipocrecim')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Tipo de crecim: Número de individuos -->
                    <div class="col-4 form-group">
                        <label for="cantidad">
                            @if($tipocrecim=='individual distinguible')No. individuos:
                            @elseif($tipocrecim=='individual en colonia')No. inds. por colonia:
                            @elseif($tipocrecim=='colonial')No. de colonias:
                            @elseif($tipocrecim=='indistinguible')Extensión en m<sup>2</sup>:
                            @endif
                        </label>
                        <input wire:model="cantidad" type="text" class="@error('cantidad') is-invalid @enderror form-control">
                        <div class="form-text"></div>
                        @error('cantidad')<error>{{ $message }}</error>@enderror
                    </div>

                    <!--  ícono -->
                    <div class="col-12 form-group">
                        <label for="icono">Ícono<red></red></label>
                        <select wire:model="icono" type="text" class="@error('icono') is-invalid @enderror form-select">

                        </select>
                        <div class="form-text"></div>
                        @error('icono')<error>{{ $message }}</error>@enderror
                    </div>

                    <div class="col-12 form-group my-3">
                        <button class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                A
            </div>
        </div>
    </div>
</div>
