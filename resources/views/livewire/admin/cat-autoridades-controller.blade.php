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
    <h2>Catálogo de Autoridades</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>admin-campus</b> (y al campus sobre el que tenga privilegio)
        <br>OJO: falta incorporar a curador-cientifico (y a los campus sobre el que tenga privilegio)
        {{-- @if($idEjem > 0) de {{ $ejemplar->ejm_ccamsiglas }} @endif --}}
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-3 form-group">
            <label class="form-label" for="tipo">Tipo de autoridad</label>
            <select wire:model.live="tipoA" class="form-select" id="tipo">
                <option value="%">Ver todos</option>
                @foreach ($tipos as $t)
                    <option value="{{ $t->aut_tipo }}">{{ $t->aut_tipo }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-6 col-md-3 form-group">
            <label class="form-label" for="name">Nombre o apelllidos</label>
            <input wire:model.live="nameA" class="form-control" id="name">
        </div>

        <div class="col-sm-6 col-md-3 form-group">
            <label class="form-label"> &nbsp; </label><br>
            <button wire:click="AbrirModalAutoridades(0)" class="btn btn-sm btn-secondary">+ Agregar nuevo</button>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive my-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="PaClick"><span wire:click="ordenar('aut_ap1')">Primer Apellido</span></th>
                        <th class="PaClick"><span wire:click="ordenar('aut_ap2')">Segundo Apellido</span></th>
                        <th class="PaClick"><span wire:click="ordenar('aut_nombre')">Nombre</span></th>
                        <th class="PaClick"><span wire:click="ordenar('aut_tipo')">Tipo</span></th>
                        <th class="PaClick"><span wire:click="ordenar('aut_tema')">Tema</span></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Auts as $a)
                        <tr>
                            <td>{{ $a->aut_ap1 }}</td>
                            <td>{{ $a->aut_ap2 }}</td>
                            <td>{{ $a->aut_nombre }}</td>
                            <td>{{ $a->aut_tipo }}</td>
                            <td>{{ $a->aut_tema }}</td>
                            <td><span class="PaClick" wire:click="AbrirModalAutoridades('{{ $a->aut_id }}')"><i class="bi bi-pencil-square"></i></span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <livewire:coleccion.modal-autoridades-controller>

</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection


