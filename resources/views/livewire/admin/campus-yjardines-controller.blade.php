{{-- @extends('plantillas.base') --}}

@section('title')  @endsection
@section('meta-description') Meta @endsection
<!-- silenciar cintillo-ubica if required -->
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div>
    <h2>Administración de campus y jardines</h2>

    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre corto del campus </th>
                    <th>Siglas del campus</th>
                    <th>Nombre completo del campus</th>
                    <th>Nombre del jardín (Siglas jardín) [tipo]</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campus as $c)
                    <tr wire:click="AbreElModalCampus('{{ $c->ccam_id }}')" class="PaClick @if($c->ccam_act=='0') inact @endif">
                        <td>
                            @if( $c->cjar_logo =='')
                                <img src="/avatar/jardines/default.png" style="width:30px; margin-right:5px;">
                            @else
                                <img src="/avatar/jardines/{{ $c->cjar_logo }}" style="width:30px; margin-right:5px;">
                            @endif
                            {{ $c->ccam_name }}

                        </td>
                        <td>
                            {{ $c->ccam_siglas }}
                        </td>
                        <td>
                            {{ $c->ccam_nombre }}
                        </td>
                        <td>
                            {{ $c->cjar_name }}
                            ({{ $c->cjar_siglas }})
                            [{{ $c->cjar_tipo }}]

                        </td>
                        <td>

                            <i class="bi bi-pencil-square"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <button type="button" wire:click="AbreElModalCampus('nuevo')"> <i class="bi bi-plus"></i> campus</button>
    </div>


    <!-- -------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------- -->
    <!-- ----------------------------- INICIA MODAL DE CAMPUS --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalDeCampus" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        @if($tipoModalCampus=='Nuevo')
                            Ingresando nuevo campus
                        @else
                            Editando campus {{ $campus->where('ccam_id',$tipoModalCampus)->value('ccam_name')}}
                        @endif
                    </h2>
                    <button type="button" wire:click="CierraElModalCampus()" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">
                    <div class="row">
                        <!-- mobre completo del campus-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="NombreCompletoCampus" class="form-label">Nombre completo del campus:</label>
                            <input wire:model="NombreCompletoCampus" type="email" class="form-control" id="NombreCompletoCampus">
                            <div class="form-text">Indica el nombre completo oficial del Campus</div>
                            @error('NombreCompletoCampus')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- Jardín al que pertenece -->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="jardin" class="form-label">Jardin al que pertenece:</label>
                            <select wire:model.live="jardinCampus" class="form-select" style="width:93%;display:inline-block;margin-right:3px;" id="jardinCampus">
                                <option value="">Indica un jardin</option>
                                @foreach ($jardines as $j)
                                    <option value="{{ $j->cjar_id }}">{{ $j->cjar_name }} ({{ $j->cjar_siglas }})</option>
                                @endforeach
                                <option value="Nvo">Ingresa un nuevo jardín</option>
                            </select>
                            <!-- botón de nuevo/edición -->
                            @if($jardinCampus == 'Nvo')
                                <span wire:click="AbreElModalJardines('Nuevo')" class="PaClick" style="vertical-align: bottom;">
                                    <i class="bi bi-plus-square"></i>
                                </span>
                            @elseif($jardinCampus != '')
                                <span wire:click="AbreElModalJardines('{{ $jardinCampus }}')" class="PaClick" style="vertical-align: bottom;">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                            @endif
                            <div class="form-text">{{ $c->cjar_logo }}Indica el Jardín al que pertenece el nuevo campus</div>
                            @error('jardinCampus')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- nombre corto del campus-->
                        <div class="col-sm-12 col-md-6 form-group" >
                            <label for="NombreCortoCampus" class="form-label">Nombre Corto del campus:</label>
                            <input wire:model="NombreCortoCampus" type="email" class="form-control" id="NombreCortoCampus">
                            <div class="form-text">Indica un nombre corto con el que se identificará al campus en el sistema</div>
                            @error('NombreCortoCampus')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- nombre corto del campus-->
                        <div class="col-sm-12 col-md-6 form-group" >
                            <label for="SiglasCampus" class="form-label">Siglas del campus:</label>
                            <input wire:model="SiglasCampus" type="email" class="form-control" id="SiglasCampus">
                            <div class="form-text">Siglas que identifican al campus (no puede haber dos campus con las mismas siglas en el sistema)</div>
                            @error('SiglasCampus')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- dirección del campus -->
                        <div class="col-12 col-md-6 form-group">
                            <label for="DireccionCampus" class="form-label">Dirección del campus:</label>
                            <textarea wire:model="DireccionCampus" class="form-control" id="DireccionCampus"></textarea>
                            <div class="form-text">Dirección en la que se encuentra el campus</div>
                            @error('DireccionCampus')<error>{{ $message }}</error>@enderror
                        </div>
                        <!-- desactivar campus -->
                        <div class="col-12 col-md-6 form-check">
                            <input class="form-check-input" wire:model.live="CampusInactivo" type="checkbox" id="checkDefault">
                            <label class="form-check-label" for="checkDefault">
                                Inactivar campus
                            </label>
                            @if($CampusInactivo==TRUE)
                                <div style="color:#CD7B34;">
                                    Si esta casilla está marcada, el campus y sus colecciones
                                    no aparecerán ni estarán disponibless en el sistema
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span wire:loading wire:target="GuardaElModalCampus"> Guardar </span>

                    <button wire:click="GuardaElModalCampus()" class="btn btn-primary">
                        Guardar
                    </button>

                    <button wire:click="CierraElModalCampus()" class="btn btn-secondary">
                        Cerrar
                    </button>


                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL DE CAMPUS --------------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->



    <!-- -------------------------------------------------------------------------------- -->
    <!-- ----------------------------- INICIA MODAL DE JARDIN --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalDeJardines" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        @if($tipoModalJardin=='0')
                            Registrando nuevo jardín
                        @else
                            Editando Jardín {{ $jardines->where('cjar_id', $tipoModalJardin)->value('cjar_name') }}
                        @endif
                    </h2>
                    <button type="button" wire:click="CierraElModalJardines()" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Logo -->
                        <div class="col-sm-12 col-md-6 form-group" style="">
                            <label class="form-label">Logo del Jardín</label><br>
                            @if($this->LogoJardin =='')
                                <img src="@if($NvoLogo=='') /avatar/jardines/default.png @else {{ $NvoLogo->temporaryUrl() }} @endif" style="max-width:100px; max-height:150px; border:1px solid #64383E;">
                            @else
                                <img src="@if($NvoLogo=='') /avatar/jardines/{{ $this->LogoJardin }} @else {{ $NvoLogo->temporaryUrl() }} @endif" style="max-width:100px; max-height:150px; border:1px solid #64383E;">
                            @endif
                            <button type="button" class="btn btn-secondary btn-sm m-2" id="MiBotonPersonalizado">
                                <i class="bi bi-card-image"></i> Buscar archivo
                            </button>
                            <input wire:model.live="NvoLogo" type="file" id="MiInputFile" style="display: none;">

                        </div>
                        <!-- Nombre completo Jardín-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="NombreCompletoJardin" class="form-label">Nombre completo del Jardín: <red>*</red></label>
                            <input wire:model="NombreCompletoJardin" type="email" class="form-control" id="NombreCompletoJardin">
                            <div class="form-text">Indica el nombre oficial completo del Jardín.</div>
                            @error('NombreCompletoJardin')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Nombre corto del Jardín-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="NombreCortoJardin" class="form-label">Nombre corto del Jardín: <red>*</red></label>
                            <input wire:model="NombreCortoJardin" type="email" class="form-control" id="NombreCortoJardin">
                            <div class="form-text">Indica un nombre corto del Jardín para que use el sistema.</div>
                            @error('NombreCortoJardin')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Siglas del Jardín -->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="SiglasJardin" class="form-label">Siglas del Jardín: <red>*</red></label>
                            <input wire:model="SiglasJardin" type="email" class="form-control" id="SiglasJardin">
                            <div class="form-text">Indica las siglas del jardín (deben ser únicas en el sistema)</div>
                            @error('SiglasJardin')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Tipo de Jardín-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="TipoJardin" class="form-label">Tipo de Jardín: <red>*</red></label>
                            <input wire:model="TipoJardin" type="email" class="form-control" id="TipoJardin">
                            <div class="form-text">Indica el tipo de jardín (Etnobiológico, Comunitario, Escolar, Botánico, Científico,)</div>
                            @error('TipoJardin')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Dirección del Jardín-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="DireccionJardin" class="form-label">Dirección:</label>
                            <input wire:model="" type="email" class="form-control" id="">
                            <div class="form-text">Indica la dirección postal del Jardín</div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Teléfono del jardín-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="TelefonoJardin" class="form-label">Teléfono:</label>
                            <input wire:model="TelefonoJardin" type="email" class="form-control" id="TelefonoJardin">
                            <div class="form-text">Indica la dirección oficial del Jardín</div>
                            @error('TelefonoJardin')<error>{{ $message }}</error>@enderror
                        </div>

                        <!--Correo electrónico del Jardín -->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="CorreoJardin" class="form-label">Correo electrónico:</label>
                            <input wire:model="CorreoJardin" type="email" class="form-control" id="CorreoJardin">
                            <div class="form-text">Indica un correo electrónico de contacto para el jardín.</div>
                            @error('CorreoJardin')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Estado del Jardín-->
                        <div class="col-sm-12 col-md-6 form-group">
                            <label for="EstadoJardin" class="form-label">Estado: <red>*</red></label>
                            <select wire:model="EstadoJardin" class="form-select" aria-label="Default select example" id="EstadoJardin">
                                <option value="">Indica un estado</option>
                                @foreach ($estados as $e)
                                    <option value="{{ $e->cedo_nombre }}">{{ $e->cedo_nombre }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Estado de la República en el que se encuentra el Jardín.</div>
                            @error('EstadoJardin')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span wire:loading wire:target="GuardaElModalJardines"> Guardar </span>

                    <button wire:click="GuardaElModalJardines()" class="btn btn-primary">
                        Guardar
                    </button>

                    <button wire:click="CierraElModalJardines()" class="btn btn-secondary">
                        Cerrar
                    </button>


                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL DE JARDÍN --------------------------- -->
    <!-- --------------------------------------------------------------------------------------- -->




    <script>
        // document.addEventListener('Livewire:initialized',()=>{
            Livewire.on('AbreMiModalCampus', () => {
                $('#ModalDeCampus').modal('show');
            });

            Livewire.on('CierraMiModalCampus', () => {
                $('#ModalDeCampus').modal('hide');
            });

            Livewire.on('AbreMiModalJardines', () => {
                $('#ModalDeJardines').modal('show');
            });

            Livewire.on('CierraMiModalJardines', () => {
                $('#ModalDeJardines').modal('hide');
            });

            /* ### Script para mostrar botón personalizado de input=file */
            document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
                document.getElementById('MiInputFile').click();
            });
        // });
    </script>
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')
@endsection
