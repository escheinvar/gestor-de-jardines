@section('title')  @endsection
@section('meta-description') Datos de la bitácora de colecta de los ejemplares @endsection
@section('cintillo-ubica') -> <a href="/ejem_ejemplares" class="nolink">Ejemplares</a> @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuEjemplar') &nbsp; @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
@section('main-Nolivewire')
@endsection
<div>
    @include('plantillas.MenuDeEjemplar')
    <!-- aviso de privilegios -->
    <div style="font-size: 80%;color:grey;">
        Bitácora: Sección administrada por <b>admin-colviva</b>
        @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif
        @if($edit_adcolviva=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif <br>
    </div>
    <!-- -------------------- TERMINA DATOS GENERALES DEL EJEMPLAR ------------------------------- -->
    <!------------------------------------------------------------------------------------------- -->

    <!-- Cuando no hay bitácora vinculada, solicita una -->
    @if($bitacoraPendiente=='1')
        @if($edit_adcolviva=='1')
            <div class="row my-2">
                @if($alias->count() > '0')
                    Se sugiere:
                    @foreach ($alias as $a)
                        {{ $a->alias_nombre }} ({{ $a->alias_tipo }})
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-2 my-4 form-group">
                    <label class="form-label">Vincular este ejemplar a:</label>
                    <div class="form-check">
                        <input class="form-check-input" wire:model.live="TipoDeVinculacion" value="ejemplar" type="radio" name="TipoDeVinculacion" id="TipoDeVinculacionEjm">
                        <label class="form-check-label" for="TipoDeVinculacion">Id de un ejemplar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" wire:model.live="TipoDeVinculacion" value="bitacora" type="radio" name="flexRadioDefault" id="TipoDeVinculacionBit">
                        <label class="form-check-label" for="flexRadioDefault2"> Id de una bitácora</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 my-3 form-group">
                    <label for="" class="form-label">Id de {{ $TipoDeVinculacion }} a vincular</label>
                    <input wire:model="idEjmVincula" type="number" class="form-control @error('idEjmVincula') is-invalid @enderror">
                    <div class="form-text">Indica el Id de {{ $TipoDeVinculacion }} al que pertenece la bitácora a la que quieres vincular</div>
                    @error('idEjmVincula')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-sm-6 col-md-6 my-4 form-group">
                    <label class="form-label"> &nbsp; </label><br>
                    <button wire:click="ActivarNuevaBitacora('existe')" wire:alert="Estás por vincular a este ejemplar con la bitácora del ejemplar que indicaste. ¿Ya revisaste que es el correcto? ¿Deseas continuar?" type="button" class="btn btn-primary mx-2">
                        Vincular a bitácora
                    </button>

                    <button wire:click="ActivarNuevaBitacora('nva')" type="button" class="btn btn-primary">
                        Crear nueva bitácora
                    </button>
                </div>

            </div>
        @endif
    @else
        <!-- DATOS GENERALES DE LA BITÁCORA -->
        <HR class="titulo">
        <h3>Datos generales</h3>
        <div class="row">
            <!-- Campus al que pertenece -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="campusEjem" class="form-label">Campus al que pertenece <red>*</red></label>
                <select wire:model="campusEjem" id="campusEjem" class="@error('campusEjem') is-invalid @enderror form-select" @if($idEjem != '0') disabled   @endif >
                    <option value=''>Indica el campus al que pertenece</option>
                    @foreach ($campuses as $c)
                        <option value="{{ $c->ccam_siglas }}">{{ $c->ccam_siglas }}</option>
                    @endforeach
                    @if($idEjem > '0' AND !in_array($ejemplar->ejm_ccamsiglas, $CampusAutorizados) )
                        <option value='{{ $ejemplar->ejm_ccamsiglas }}''>{{ $ejemplar->ejm_ccamsiglas }}</option>
                    @endif

                </select>
                <div class="form-text">Siglas del campus propietario del ejemplar</div>
                @error('campusEjem')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Fecha colecta -->
            <div class="col-sm-12 col-md-4 form-group ">
                <label for="colectadate" class="form-label">Fecha de colecta<red>*</red></label>
                <input wire:model="colectadate" id="colectadate" class="@error('colectadate') is-invalid @enderror form-control" type="date" >
                <div class="form-text">Fecha en la que se realizó la colecta</div>
                @error('colectadate')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Etiqueta de colecta -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="etiqueta_colecta" class="form-label">Etiqueta de colecta</label>
                <input wire:model="etiqueta_colecta" id="etiqueta_colecta" class="@error('etiqueta_colecta') is-invalid @enderror form-control" type="text" >
                <div class="form-text">Etiqueta asignada al ejemplar durante la colecta</div>
                @error('etiqueta_colecta')<error>{{ $message }}</error>@enderror
            </div>

            <!-- forma de la colecta-->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="origen" class="form-label">Forma de obtención la colecta<red>*</red></label>
                <select wire:model="origen" id="origen" class="@error('origen') is-invalid @enderror form-select" >
                    <option value="">Indica cómo se obtuvo el ejemplar</option>
                    @foreach ($formasobtencion as $f)
                        <option value="{{ $f->con_txt }}">{{ $f->con_txt }}</option>
                    @endforeach
                </select>
                <div class="form-text">Forma en la que se consiguió el ejemplar</div>
                @error('origen')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Explica forma de colecta -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="origen_explica" class="form-label">Detalles sobre obtención de la colecta</label>
                <textarea wire:model="origen_explica" id="origen_explica" class="@error('origen_explica') is-invalid @enderror form-control" type="text" ></textarea>
                {{-- <input wire:model="origen_explica" id="origen_explica" class="@error('origen_explica') is-invalid @enderror form-control" type="text" > --}}
                <div class="form-text">Detalles sobre la forma en que se consiguió el ejemplar</div>
                @error('origen_explica')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Forma de colecta-->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="forma_colecta" class="form-label">Parte colectada<red>*</red></label>
                <select wire:model="forma_colecta" id="forma_colecta" class="@error('forma_colecta') is-invalid @enderror form-select">
                    <option value="">Indica la parte colectada</option>
                    @foreach ($formascolecta as $f)
                        <option value="{{ $f->con_txt }}">{{ $f->con_txt }}</option>
                    @endforeach
                </select>
                <div class="form-text">Parte de la planta que fue colectada</div>
                @error('forma_colecta')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Nombre del colector -->
            <div wire:poll class="col-sm-12 col-md-4 form-group">
                <label for="autid" class="form-label">Nombre del colector<red>*</red> </label>
                <select wire:model.live="autid" id="autid" class="@error('autid') is-invalid @enderror form-select @if($edit_adcolviva=='1')agregar @endif" >
                    <option value=''>Indica la autoridad de colecta</option>
                    @foreach ($autoridadescolecta as $f)
                        <option value='{{ $f->aut_id }}'>{{ $f->aut_nombre }} {{ $f->aut_ap1 }} {{ $f->aut_ap2 }} ({{ $f->aut_inst }})</option>
                    @endforeach
                </select>
                <!-- botón para agregar colector -->
                @if($edit_adcolviva=='1')
                    {{-- <button wire:click="AbrirModalAutoridades('0')" type="buton" class="btn btn-sm"> --}}
                        <i wire:click="AbrirModalAutoridades('0')" class="bi bi-plus-square-fill agregar" style=""></i>
                    {{-- </button> --}}
                @endif
                <div class="form-text">Autoridad de colecta que colectó el ejemplar</div>
                @error('autid')<error>{{ $message }}</error>@enderror
            </div>



            @if($edit_adcolviva=='1')
                <div class="col-sm-6 col-md-4 form-group">
                    <!-- nombre común -->
                    <button wire:click="abreModalDeNombreComun()" class="btn">
                        <i wire:click="" class="bi bi-plus-square-fill agregar" style=""></i>  Nombre común
                    </button>
                    <!-- nombre científico: sólo si es edit_adcolviva y sólo si el tipo de nombre es 0 o no hay nombre y el idEjem no es 0 (nombre requiere idEjem)-->
                    @if( (is_null($ejemplar_ScName) OR $ejemplar_ScName->scn_edo =='0') AND $idEjem != '0')
                        @if($ejemplar_ScName != '')<b>Nombre científico</b>: {{ $ejemplar_ScName->scn_name }} @endif<br>
                        <button wire:click="abreModalDeNombreCientifico()" class="btn">
                            <i wire:click="" class="bi bi-plus-square-fill agregar" style=""></i>  @if($ejemplar_ScName != '')Cambiar @endif Nombre científico
                        </button>
                    @endif
                </div>
            @endif
            @if($idEjem=='0')
                <div class="col-sm-6 col-md-4 form-group">
                    <button class="btn"><i wire:click="" class="bi bi-plus-square-fill agregar" style=""></i> Alias del ejemplar</button>
                    <button class="btn"><i wire:click="" class="bi bi-plus-square-fill agregar" style=""></i> Nombre(s) común(es)</button>
                    <button class="btn"><i wire:click="" class="bi bi-plus-square-fill agregar" style=""></i> Usos</button>
                </div>
            @endif
            <!-- Alias de bitácora  -->
            <div class="col-sm-12 col-md-4 form-group">
                <i wire:click="abreModalAlias('{{ $idEjem }}', 'bitácora')" class="bi bi-plus-square-fill agregar"></i>
                <label for="alias" class="form-label">Alias de la bitácora</label><br>
                @if($alias->count() > '0')
                    @foreach($alias as $a)
                        <li>
                            {{ $a->alias_nombre }}
                            <i wire:click="BorrarAlias('{{ $a->alias_id }}')" wire:confirm="Estás por eliminar definitivamente este nombre. ¿Quieres continuar?" class="bi bi-trash agregar"></i>
                        </li>
                    @endforeach
                @else
                    -- ninguno --
                @endif
                @error('alias')<error>{{ $message }}</error>@enderror
            </div>
        </div>
        <!-- -------------------- IMÁGENES DE SITIO DE COLECTA --------------------- -->
        <div class="row">
            <div class="col-12 form-group">
                <label class="form-label">
                    Imágenes del ejemplar en el sitio de colecta (colecta_ejemplar)
                    @if($edit_adcolviva=='1' and $idEjem > '0')
                        <button wire:click="AbreModalObjeto('0','colecta','colecta_ejemplar','ej','{{ $idEjem }}')" type="buton" class="btn btn ">
                            <i class="bi bi-plus-square-fill agregar" style=""></i>
                        </button>
                    @endif
                    @if($idEjem=='0')
                        <div class="form-text">Primero genera la bitácora y luego cargas las imágnes</div>
                    @endif
                </label><br>
                <?php $imags=$img_colecta_ejemplar; ?>
                <div wire:ignore>
                    @include('plantillas.imagenes')
                </div>


            </div>
        </div>

        <!--------------------------------------------------------------------------------------------------------- -->
        <!-- --------------------------------------- DATOS DEL SITIO DE COLECTA ----------------------------------- -->
        <div class="row my-4">
            <hr class="titulo">
            <a name="sitiodecolecta">
                <h3>Datos del sitio de colecta</h3>
            </a>
            <!-- Estado de la República -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="edo" class="form-label">Estado de la República<red>*</red></label>
                <select wire:model="edo" id="edo" class="@error('edo') is-invalid @enderror form-select" >
                    <option value="">Indica el Estado de la República</option>
                    @foreach ($estados as $e)
                        <option value="{{ $e->cedo_nombre }}">{{ $e->cedo_nombre }}</option>
                    @endforeach
                </select>
                <div class="form-text"></div>
                @error('edo')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Municipio del Estado -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="mpio" class="form-label">Municipio del estado<red>*</red></label>
                <select wire:model.live="mpio" id="mpio" class="@error('mpio') is-invalid @enderror form-select" >
                    @if($edo == '')
                        <option value="">Indica primero el estado</option>
                    @else
                        <option value="">Indica el municipio de {{ $edo }}</option>
                        @foreach ($municipios as $e)
                            <option value="{{ $e->cmun_mpioname }}">{{ $e->cmun_mpioname }}</option>
                        @endforeach
                    @endif
                </select>
                <div class="form-text"></div>
                @error('mpio')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Localidad -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="localidad" class="form-label">Localidad</label>
                <input wire:model="localidad" id="localidad" class="@error('localidad') is-invalid @enderror form-control" type="text" >
                <div class="form-text"></div>
                @error('localidad')<error>{{ $message }}</error>@enderror
            </div>


            <!-- Paraje -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="paraje" class="form-label">Paraje</label>
                <input wire:model="paraje" id="paraje" class="@error('paraje') is-invalid @enderror form-control" type="text" >
                <div class="form-text"></div>
                @error('paraje')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Coordenadas X Longitud -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="x" class="form-label">Coordenadas X</label>
                <input wire:model="x" id="x" class="@error('x') is-invalid @enderror form-control" type="text" >
                <div class="form-text"></div>
                @error('x')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Coordenadas Y Latitud-->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="y" class="form-label">Coordenadas Y</label>
                <input wire:model="y" id="y" class="@error('y') is-invalid @enderror form-control" type="text" >
                <div class="form-text"></div>
                @error('y')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Altitud -->
            <div class="col-sm-12 col-md-4 form-group">
                <label for="altitud" class="form-label">Altitud</label>
                <input wire:model="altitud" id="altitud" class="@error('altitud') is-invalid @enderror form-control" type="text" >
                <div class="form-text"></div>
                @error('altitud')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Observaciones -->
            <div class="col-sm-12 col-md-8 form-group">
                <label for="obs_colecta" class="form-label">Observaciones al sitio de colecta</label>
                <textarea wire:model="obs_colecta" id="obs_colecta" class="@error('obs_colecta') is-invalid @enderror form-control" ></textarea>
                <div class="form-text"></div>
                @error('obs_colecta')<error>{{ $message }}</error>@enderror
            </div>

        </div>

        <!-- -------------------- IMÁGENES DE SITIO DE COLECTA --------------------- -->
        <div class="row my-4">
            <div class="col-12 form-group">
                <label class="form-label">
                    Imágenes del sitio de colecta (colecta_paisaje)
                    @if($edit_adcolviva=='1' and $idEjem >'0' )
                        <button wire:click="AbreModalObjeto('0','colecta','colecta_paisaje','ej','{{ $idEjem }}')" type="buton" class="btn">
                            <i class="bi bi-plus-square-fill agregar" style=""></i>
                        </button>
                    @endif
                    @if($idEjem=='0')
                        <div class="form-text">Primero genera la bitácora y luego cargas las imágnes</div>
                    @endif
                </label><br>
                <?php $imags=$img_colecta_paisaje; ?>
                <div wire:ignore>
                    @include('plantillas.imagenes')
                </div>
            </div>
        </div>


        <!-- -------------------- BOTONES DE GUARDAR O EDITAR --------------------- -->
        <div class="row">
            <div class="col-12 form-group">
                @if(array_intersect(['admin'], Session('rol')))
                    @if($edit_adcolviva=='1')
                        @if($idEjem=='0')
                            <button wire:click="CrearBitacora()" type="button" class="btn btn-primary">
                                Crear nueva bitácora
                            </button>
                        @elseif($idEjem > '0')
                            <button wire:click="GuardarCambios('{{ $ejemplar->bit_id }}')" type="button" class="btn btn-primary">
                                Guardar cambios
                            </button>
                        @endif
                        <button onclick="history.back()" type="button" class="btn btn-secondary">
                            Cancelar
                        </button>
                    @endif
                    @if( $errors->any() )
                        <div>
                            <error>Se detectaron {{ $errors->count() }} errores en el formulario</error>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endif



    <livewire:coleccion.modal-autoridades-controller />
    <livewire:coleccion.modal-asigna-especie-controller />
    <livewire:coleccion.modal-nombres-comunes-controller />
    <livewire:coleccion.ModalAliasController />

    <script>
        Livewire.on('AvisoExitoBitacora',()=>{
            alert(event.detail.msj);
            // console.log(event.detail.msj);
        })
    </script>
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection

