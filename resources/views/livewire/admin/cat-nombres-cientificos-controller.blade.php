{{-- @extends('plantillas.base') --}}

@section('title') Autoridades  @endsection
@section('meta-description') Catálogo de autoridades del Sistema Gestor de Jardines @endsection
<!-- silenciar cintillo-ubica if required -->
@section('cintillo-ubica') -> Catálogo de Autoridades @endsection
@section('cintillo') &nbsp; @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div>
    <h2>Catálogo de Nombres Científicos</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>curador-cientifico</b> (y al campus sobre el que tenga privilegio)
        <br>OJO: falta ver si es necesario incorporar a admin-jardin, admin-colviva y curador-colviva (y a los campus sobre los que tengan privilegio)
        {{-- @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif --}}
    </div>

    <div class="row">
        <div class="col-sm-8 col-md-10">
        </div>
        <div class="col-sm-4 col-md-2">
            <label class="form-label"> &nbsp;</label><br>
            <button wire:click="LanzarModalDeNuevaEspecie('0')" class="btn btn-primary"><i class="bi bi-plus-square"></i> Nueva especie</button>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-sm-6 col-md-3">
            <label class="form-label" for="BuscaFam">Familia</label><br>
            <input wire:model.live="BuscaFam" type="text" id="BuscaFam" class="form-control @error('BuscaFam') is-invalid @enderror" style="width:90%; display:inline-block;">
            @if($BuscaFam != '')
                <i class="bi bi-x-square PaClick" wire:click="Borrar('familia')" style="margin-left:5px; color:#87796d;"></i>
            @endif
            <div class="form-text"></div>
            @error('BuscaFam')<error>{{ $message }}</error>@enderror
        </div>

        <div class="col-sm-6 col-md-3">
            <label class="form-label" for="BuscaGen">Genero</label><br>
            <input wire:model.live="BuscaGen" type="text" id="BuscaGen" class="form-control @error('BuscaGen') is-invalid @enderror" style="width:90%; display:inline-block;">
            @if($BuscaGen != '')
                <i class="bi bi-x-square PaClick" wire:click="Borrar('genero')" style="margin-left:5px; color:#87796d;"></i>
            @endif
            <div class="form-text"></div>
            @error('BuscaGen')<error>{{ $message }}</error>@enderror
        </div>

        <div class="col-sm-6 col-md-3">
            <label class="form-label" for="BuscaEsp">Especie</label><br>
            <input wire:model.live="BuscaEsp" id="BuscaEsp" type="text" class="form-control @error('BuscaEsp') is-invalid @enderror" style="width:90%; display:inline-block;">
            @if($BuscaEsp != '')
                <i class="bi bi-x-square PaClick" wire:click="Borrar('especie')" style="margin-left:5px; color:#87796d;"></i>
            @endif
            <div class="form-text"></div>
            @error('BuscaEsp')<error>{{ $message }}</error>@enderror
        </div>

        <div class="col-sm-6 col-md-3">
            <label class="form-label"> &nbsp;</label> <br>
            <button type="button" class="btn btn-primary">Buscar</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($especies->hasPages()) <div class="form-text">Página {{ $especies->currentPage() }} de {{ $especies->lastPage() }}</div> @endif
            <div class="table table-responsive">

                @if($especies->count() > 0)
                    <table class="table table-striped table-sm">
                        <thead>
                            <th>Id</th>
                            <th>Familia</th>
                            <th>Género</th>
                            <th>Especie</th>
                            <th>Cat. infra sp</th>
                            <th>Origen del nombre</th>
                            <th> &nbsp; </th>
                        </thead>
                        <tbody>
                            @foreach ($especies as $s)
                                <tr>
                                    <td>
                                        {{-- <a href="#"><span wire:click="LanzarModalDeNuevaEspecie('{{ $s->sp_id }}')"> --}}
                                        {{ $s->sp_id }}
                                        </span></a>
                                    </td>
                                    <td>{{ $s->sp_familia }}</td>
                                    <td>{{ $s->sp_genero }}</td>
                                    <td>{{ $s->sp_sp }}</td>
                                    <td>{{ $s->sp_ssp }}</td>
                                    <td>
                                        @if($s->sp_catorigin == 'User') Usuario  id {{ $s->sp_catid }}  @endif
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    -- aún no hay especies registradas --
                @endif
            </div>
        </div>
    </div>
    <!-- tabla de paginación -->
    <div class="row">
        @if($especies->hasPages())
                <div class="paginador">
                    @if($especies->onFirstPage())
                        <div class="boton" style="display: inline-block;" disabled></div>
                    @else
                        <a href="{{$especies->previousPageurl()}}">
                            <div class="boton abajo" style="display: inline-block;" ></div>
                        </a>
                    @endif

                    @foreach (range(1,$especies->lastPage()) as $page)
                        <a href="{{$especies->url($page)}}">
                            <div class="boton @if($especies->currentPage() == $page) paginaActiva @else pagina @endif" style="display: inline-block;">
                                {{$page}}
                            </div>
                        </a>
                    @endforeach

                    @if($especies->onLastPage())
                        <div class="boton" style="display: inline-block;" disabled></div>
                    @else
                        <a href="{{$especies->nextPageurl()}}">
                            <div class="boton arriba" style="display: inline-block;"> </div>
                        </a>
                    @endif
                </div>
            @endif
    </div>

    <!-- ----------------------------- Agrega modal -------------------------------- -->
    <livewire:coleccion.modal-nueva-especie-controller>
</div>
