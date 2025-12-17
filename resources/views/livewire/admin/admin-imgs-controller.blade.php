{{-- @extends('plantillas.base') --}}

@section('title') Administrador de Imágenes @endsection
@section('meta-description') Administrador de Imágenes del sistema gestor de Jardines @endsection
@section('cintillo-ubica') -> Administrador de Imágenes @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div>
    <h2>Administrador de objetos (imágen, audio o video)</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>admin-campus</b> (y al campus sobre el que tenga privilegio)
        <br>OJO: falta incorporar a admin-colviva, curador-colviva y curador-cientifico (y a los campus sobre los que tengan privilegio)
        {{-- @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif --}}
    </div>
    <div class="row">
        Hay un total de {{ $Nimags }} imágenes.
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-3 my-3">
            <div class="form-check">
                <input wire:model.live="tipoBusqueda" wire:click="CambiaTipoBusqueda()" value="ejemplar" class="form-check-input" type="radio" name="tipoBusqueda" id="tipoBusquedaEjemplar">
                <label class="form-check-label" for="tipoBusquedaEjemplar">Buscar por ID de ejemplar</label>
            </div>
            <div class="form-check">
                <input wire:model.live="tipoBusqueda" wire:click="CambiaTipoBusqueda()" value="modulo" class="form-check-input" type="radio" name="tipoBusqueda" id="tipoBusquedaModulo">
                <label class="form-check-label" for="tipoBusquedaModulo"> Explorar por módulo/Tipo</label>
            </div>
            <div class="form-check">
                <input wire:model.live="tipoBusqueda" wire:click="CambiaTipoBusqueda()" value="especie" class="form-check-input" type="radio" name="tipoBusqueda" id="tipoBusquedaEspecie">
                <label class="form-check-label" for="tipoBusquedaEspecie"> Explorar por especie</label>
            </div>
        </div>
    </div>


    <!-- ---------------------------------------------------------------------------------- -->
    <!-- -------------------------- BUSCAR POR ID DEL EJEMPLAR  ------------------- -->
    @if($tipoBusqueda=="ejemplar")
        <div class="row">
            <!-- ------------ campo de búsqueda de id -------- -->
            <div class="col-sm-6 col-md-3 form-group">
                <label for="Idejemplar" class="form-label">Id del ejemplar:</label>
                <input wire:model="Idejemplar" type="text" class="@error('Idejemplar') error @enderror form-control">
                <div class="form-text"></div>
                @error('Idejemplar')<error>{{ $message }}</error>@enderror
            </div>

            <!-- ------------ selector de video y audio por TIPO -------- -->
            <div class="col-sm-6 col-md-3 form-group">
                <div class="form-check">
                    <input wire:model="IncluirVideo" class="form-check-input" value="video" type="checkbox" id="checkDefault">
                    <label class="form-check-label" for="checkDefault"> Incluir video</label>
                </div>
                <div class="form-check">
                    <input wire:model="IncluirAudio" class="form-check-input" value="audio" type="checkbox" id="checkChecked">
                    <label class="form-check-label" for="checkChecked"> Incluir audios</label>
                </div>
                <div class="form-check">
                    <input wire:model="IncluirImagen" class="form-check-input" value="imagen" type="checkbox" id="checkChecked" checked>
                    <label class="form-check-label" for="checkChecked"> Incluir imágenes</label>
                </div>
                <div class="form-text">Los audios y los videos retardan la búsqueda</div>
                @error('IncluirElementos')<error>{{ $message }}</error>@enderror
            </div>


            <!-- ------------ botón de búsqueda de id -------- -->
            <div class="col-sm-6 col-md-3 form-group">
                <label class="form-label"> &nbsp; </label><br>
                <button wire:click="buscarPorEjemplar()" wire:loadding.attr="disabled" type="button" class="btn btn-primary">Buscar</button>
            </div>
        </div>
        @if($Idejemplar > '0')
            <div class="row">
                <!-- ------------------------ Botón nuevo por id de ejemplar --------------------- -->
                <div class="col-sm-8 col-md-10">
                </div>
                <div class="col-sm-4 col-md-2">
                    <label class="form-label"> &nbsp; </label><br>
                    <button wire:click="NuevaImg('0', '', '', 'ej', '{{ $Idejemplar }}')" class="btn btn-secondary btn-sm"><i class="bi bi-plus-square"></i> Subir nuevo objeto</button>
                </div>
            </div>
        @endif
    @endif

    <!-- ---------------------------------------------------------------------------------- -->
    <!-- -----------------------------  BUSCAR POR MÓDULO / TIPO  ------------------------- -->
    @if($tipoBusqueda=='modulo')
        <div class="row">
            <!-- ------------------------ Select Módulo --------------------- -->
            <div class="col-sm-6 col-md-3 form-group">
                <label for="" class="form-label">Módulo <red>*</red>:</label>
                <select wire:model.live="modulo" wire:change="cambiaModulo()" id="modulo" class="@error('modulo') error @enderror form-select">
                    <option value="">Selecciona un módulo</option>
                    @foreach ($modulos as $m)
                        <option value="{{ $m->cimg_modulo }}">{{ $m->cimg_modulo }}</option>
                    @endforeach
                </select>
                <div class="form-text">Indica el módulo del que quieres observar las imágenes</div>
                @error('modulo')<error>{{ $message }}</error>@enderror
            </div>


            <!-- ------------------------ Select Tipo --------------------- -->
            <div class="col-sm-6 col-md-3 form-group">
                <label for="tipo" class="form-label">Tipo<red>*</red>:</label>
                <select wire:model.live="tipo" wire:change="cambiaTipo()" id="tipo" class="@error('tipo') error @enderror form-select">
                    @if($modulo == '')
                        <option value="">Selecciona primero un módulo </option>
                    @else
                        <option value="">Selecciona el tipo específico </option>
                        @if($tipos->count() > 0)
                            @foreach ($tipos as $t)
                                <option value="{{ $t->cimg_tipo }}">{{ $t->cimg_tipo }}: {{ $t->cimg_explica }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
                <div class="form-text">Indica el tipo de imagen  que quieres ver</div>
                @error('tipo')<error>{{ $message }}</error>@enderror
            </div>

            <!-- ------------ selector de video y audio por TIPO -------- -->
            <div class="col-sm-6 col-md-3 form-group">
                <div class="form-check">
                    <input wire:model="IncluirVideo" class="form-check-input" value="video" type="checkbox" id="checkDefault">
                    <label class="form-check-label" for="checkDefault"> Incluir video</label>
                </div>
                <div class="form-check">
                    <input wire:model="IncluirAudio" class="form-check-input" value="audio" type="checkbox" id="checkChecked">
                    <label class="form-check-label" for="checkChecked"> Incluir audios</label>
                </div>
                <div class="form-check">
                    <input wire:model="IncluirImagen" class="form-check-input" value="imagen" type="checkbox" id="checkChecked" checked>
                    <label class="form-check-label" for="checkChecked"> Incluir imágenes</label>
                </div>
                <div class="form-text">Los audios y los videos retardan la búsqueda</div>
                @error('IncluirElementos')<error>{{ $message }}</error>@enderror
            </div>

            <!-- ------------ botón de búsqueda por tipo -------- -->
            <div class="col-sm-6 col-md-3 form-group">
                @if($tipo != '')
                    @if($totalesPorTipo->where('img_cimgtipo',$tipo)->value('total') != '')
                        Hay {{ $totalesPorTipo->where('img_cimgtipo',$tipo)->value('total') }} objetos
                    @else
                        Hay 0 objetos
                    @endif
                @endif

                <label class="form-label"> &nbsp; </label><br>
                <button wire:click="buscarPorTipo()" wire:loadding.attr="disabled" type="button" class="btn btn-primary">Buscar</button>
                <span style="display:none" wire:loadding> <error> Cargando ...</error>
            </div>
        </div>
        @if($tipo != '')
            <div class="row">
                <!-- ------------------------ Botón nuevo por id de ejemplar --------------------- -->
                <div class="col-sm-8 col-md-10">
                </div>
                <div class="col-sm-4 col-md-2">
                    <label class="form-label"> &nbsp; </label><br>
                    <button wire:click="NuevaImg('0', '{{ $modulo }}', '{{ $tipo }}', '', '')" class="btn btn-secondary btn-sm"><i class="bi bi-plus-square"></i> Subir nuevo objeto</button>
                </div>
            </div>
        @endif
    @endif





    <!-- ------------------------ Muestra Imágenes --------------------- -->
    <div class="row my-2">
        <div class="col-12">
            <?php // $imags=$imags; ?>
            @if($imags->count() == 0)
                <center>
                    -- No hay objetos seleccionados  --
                </center>
            @endif
            @include('plantillas.imagenes')

        </div>
    </div>
</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection
